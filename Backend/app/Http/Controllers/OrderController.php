<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // Create new order from cart
    // Create new order from cart
    public function store(Request $request)
    {
        Log::info('New Order Attempt', ['user' => Auth::id(), 'ip' => $request->ip(), 'data' => $request->all()]);

        // Validate request first - let Laravel handle ValidationException automatically (422 response)
        $request->validate([
            'phone' => 'nullable|string', 
            'delivery_type' => 'required|in:delivery,pickup,dine-in',
            'delivery_date' => 'required|date',
            'delivery_time' => 'required|string',
            'payment_method' => 'required|in:cod,khalti,esewa',
            'delivery_address' => 'required_if:delivery_type,delivery|string',
            'delivery_city' => 'required_if:delivery_type,delivery|string',
            'table_number' => 'required_if:delivery_type,dine-in|nullable|integer|min:1|max:20',
            'payment_transaction_id' => 'required_if:payment_method,esewa,khalti',
            'payment_sender_name' => 'required_if:payment_method,esewa,khalti',
            'payment_sender_phone' => 'required_if:payment_method,esewa,khalti',
        ], [
            'table_number.required_if' => 'Please select a table number (1-20) for your dine-in order.',
            'table_number.integer' => 'Invalid table selected. Please pick a number from the list.',
            'table_number.min' => 'Please select a valid table number (1-20).',
            'table_number.max' => 'Please select a valid table number (1-20).',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Please login to place an order'], 401);
            }

            $cart = Cart::getOrCreateCart();

            if ($cart->items->isEmpty()) {
                return response()->json(['message' => 'Cart is empty'], 400);
            }

            // Calculate charges
            $subtotal = $cart->subtotal;
            
            // Delivery Charge: 50 for Valley (KTM, Lalitpur, Bhaktapur), 100 for Others
            $deliveryCharge = 0;
            if ($request->delivery_type === 'delivery') {
                $valleyCities = ['Kathmandu', 'Lalitpur', 'Bhaktapur'];
                $deliveryCharge = in_array($request->delivery_city, $valleyCities) ? 50 : 100;
            }
            
            // COD Surcharge matches frontend logic
            if ($request->payment_method === 'cod' && $request->delivery_type !== 'dine-in') {
                $deliveryCharge += 10;
            }

            $tax = 0; // Tax is currently included in price or not displayed on checkout, setting to 0 to match frontend total.
            $totalAmount = $subtotal + $deliveryCharge + $tax;

            // Create order
            // Handle potential array inputs and convert to strings
            $deliveryAddress = $request->delivery_address;
            if (is_array($deliveryAddress)) {
                $deliveryAddress = implode(', ', array_filter($deliveryAddress));
            }
            
            $province = $request->province;
            if (is_array($province)) {
                $province = implode(', ', array_filter($province));
            }
            
            $district = $request->district;
            if (is_array($district)) {
                $district = implode(', ', array_filter($district));
            }
            
            $area = $request->area;
            if (is_array($area)) {
                $area = implode(', ', array_filter($area));
            }
            
            $street = $request->street;
            if (is_array($street)) {
                $street = implode(', ', array_filter($street));
            }
            
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'CB-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6)),
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $request->phone ?? $user->phone ?? '',
                'delivery_address' => $deliveryAddress ?? '',
                'delivery_province' => $province ?? '',
                'delivery_district' => $district ?? '',
                'delivery_city' => $request->delivery_city ?? '',
                'delivery_area' => $area ?? '',
                'delivery_street' => $street ?? '',
                'delivery_state' => $request->delivery_state ?? '',
                'delivery_zip' => $request->delivery_zip ?? '',
                'latitude' => $request->latitude ?? null,
                'longitude' => $request->longitude ?? null,
                'delivery_type' => $request->delivery_type,
                'table_number' => $request->delivery_type === 'dine-in' ? $request->table_number : null,
                'order_source' => 'web',
                'delivery_date' => $request->delivery_date,
                'delivery_time' => $request->delivery_time,
                'delivery_window' => $request->delivery_window ?? '',
                'special_instructions' => $request->special_instructions ?? '',
                'subtotal' => $subtotal,
                'delivery_charge' => $deliveryCharge,
                'tax' => $tax,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            // If dine-in, occupy the table
            if ($request->delivery_type === 'dine-in') {
                $table = \App\Models\TableReservation::where('table_number', $request->table_number)->first();
                if ($table) {
                    $table->occupy($order->id);
                }
            }

            // Create payment record for manual verification
            if (in_array($request->payment_method, ['esewa', 'khalti'])) {
                try {
                    \App\Models\Payment::create([
                        'order_id' => $order->id,
                        'user_id' => $user->id,
                        'amount' => $totalAmount,
                        'provider' => $request->payment_method,
                        'transaction_id' => $request->payment_transaction_id,
                        'status' => 'pending', // Pending admin verification
                        'response_data' => json_encode([
                            'sender_name' => $request->payment_sender_name,
                            'sender_phone' => $request->payment_sender_phone,
                            'manual_entry' => true
                        ])
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to create payment record: ' . $e->getMessage());
                    // We don't fail the order, but we log the error. Admin might check specific order notes if needed.
                }
            }

            // Create order items from cart
            foreach ($cart->items as $cartItem) {
                $itemName = $cartItem->item_name;
                if (!$itemName && $cartItem->product) {
                    $itemName = $cartItem->product->name;
                }
                
                // Handle customizations - convert to JSON if it's an array
                $customizations = $cartItem->customizations;
                if (is_array($customizations)) {
                    $customizations = json_encode($customizations);
                } elseif (is_object($customizations)) {
                    $customizations = json_encode($customizations);
                }
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'item_name' => $itemName ?? 'Custom Item',
                    'customizations' => $customizations,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->unit_price,
                    'total_price' => $cartItem->total_price,
                ]);

                // Update product order count for "Best Seller" logic
                if ($cartItem->product_id) {
                    $product = \App\Models\Product::find($cartItem->product_id);
                    if ($product) {
                        // We'll use a dynamic way to calculate best sellers, 
                        // but let's also update the is_popular flag if it's popular enough
                        $orderCount = OrderItem::where('product_id', $product->id)->sum('quantity');
                        if ($orderCount >= 5) { // Threshold for best seller
                            $product->update(['is_popular' => true]);
                        }
                    }
                }
            }
            
            // Recalculate all best sellers occasionally or here
            $this->updateBestSellers();

            // Clear the cart
            $cart->clear();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order' => $order,
                'order_number' => $order->order_number,
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Order Creation Failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Order failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // Track order by order ID
    public function track(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $order = Order::where('order_number', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Check if user is authorized to view this order
        if (auth()->check() && auth()->id() !== $order->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Load items with product details
        $order->load('items.product');

        return response()->json([
            'order' => $order,
            'progress_percentage' => $order->progress_percentage,
            'progress_steps' => $order->progress_steps,
        ]);
    }

    // Track order by GET request (for frontend tracking page)
    public function trackByGet(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        // Remove any prefix like #, CB-, etc. and clean the order ID
        $orderId = $request->order_id;
        $orderId = str_replace(['#', ' '], '', $orderId);
        
        // Try to find order by order_number or id
        $order = Order::where('order_number', $orderId)
            ->orWhere('order_number', 'LIKE', '%' . $orderId . '%')
            ->orWhere('id', $orderId)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found. Please check your Order ID.'
            ], 404);
        }

        // Verify phone number if provided
        if ($request->filled('phone')) {
            $phone = preg_replace('/[^0-9]/', '', $request->phone);
            $orderPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
            
            if ($phone !== $orderPhone && !str_ends_with($orderPhone, $phone)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phone number does not match our records.'
                ], 403);
            }
        }

        // Load items with product details
        $order->load('orderItems.product');

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'total_amount' => $order->total_amount,
                'created_at' => $order->created_at,
                'delivery_date' => $order->delivery_date,
                'delivery_time' => $order->delivery_time,
                'items' => $order->orderItems,
            ]
        ]);
    }

    // Get user's orders
    public function userOrders(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $orders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($orders);
    }

    // Get all orders (admin only)
    public function index(Request $request)
    {
        // Add admin check here if needed

        $query = Order::query()->with('user', 'items');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('from_date')) {
            $query->whereDate('order_date', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('order_date', '<=', $request->to_date);
        }

        // Search by order ID or customer name/email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($orders);
    }

    // Update order status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,preparing,out_for_delivery,delivered',
        ]);

        $order = Order::findOrFail($id);

        // Update status using model method
        $order->updateStatus($request->status);

        return response()->json([
            'message' => 'Order status updated',
            'order' => $order,
        ]);
    }

    // Cancel order (User side)
    public function cancel(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Block cancellation if order is already being prepared or further
        $blockStatuses = ['preparing', 'out_for_delivery', 'delivered', 'with_logistic'];
        if (in_array($order->status, $blockStatuses)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot cancel order. It is already being prepared or is out for delivery.'
            ], 400);
        }

        $order->update(['status' => 'cancelled']);

        // If dine-in, free the table
        if ($order->delivery_type === 'dine-in') {
            $table = \App\Models\TableReservation::where('current_order_id', $order->id)->first();
            if ($table) {
                $table->free();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Order has been cancelled successfully.'
        ]);
    }

    // View Invoice (User side)
    public function invoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.invoice', compact('order'));
    }

    // Helper method to parse time slot
    private function parseTimeSlot($timeSlot)
    {
        switch ($timeSlot) {
            case 'morning':
                return '09:00';
            case 'afternoon':
                return '12:00';
            case 'evening':
                return '15:00';
            default:
                return '12:00'; // Default to noon
        }
    }

    /**
     * Update is_popular flag for top 5 most ordered products
     */
    private function updateBestSellers()
    {
        // Reset all popular flags first
        \App\Models\Product::where('is_popular', true)->update(['is_popular' => false]);
        
        // Get top 5 most ordered products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereNotNull('product_id')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();
            
        foreach ($topProducts as $p) {
            \App\Models\Product::where('id', $p->product_id)->update(['is_popular' => true]);
        }
    }
}
