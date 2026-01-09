<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Create new order from cart
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
            'delivery_address' => 'required|string',
            'delivery_city' => 'nullable|string',
            'delivery_state' => 'nullable|string',
            'delivery_zip' => 'nullable|string',
            'delivery_type' => 'nullable|in:pickup,delivery',
            'delivery_date' => 'required|date|after_today',
            'delivery_time' => 'required|in:morning,afternoon,evening',
            'special_instructions' => 'nullable|string',
            'payment_method' => 'required|in:cod,card,khalti,esewa',
        ]);

        DB::beginTransaction();

        try {
            // Get user's cart
            $cart = Cart::getOrCreateCart();

            if ($cart->items->isEmpty()) {
                return response()->json(['message' => 'Cart is empty'], 400);
            }

            // Calculate delivery charge (Rs 10 for COD)
            $deliveryCharge = ($request->payment_method === 'cod') ? 10 : 0;

            // Calculate total amount
            $totalAmount = $cart->subtotal + $cart->tax + $cart->delivery + $deliveryCharge;

            // Parse delivery date and time
            $deliveryDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $request->delivery_date . ' ' . $this->parseTimeSlot($request->delivery_time));

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'delivery_address' => $request->delivery_address,
                'delivery_city' => $request->delivery_city,
                'delivery_state' => $request->delivery_state,
                'delivery_zip' => $request->delivery_zip,
                'delivery_type' => $request->delivery_type ?? 'delivery',
                'delivery_date' => $deliveryDateTime->toDateString(),
                'delivery_time' => $deliveryDateTime->toTimeString(),
                'special_instructions' => $request->special_instructions,
                'subtotal' => $cart->subtotal,
                'delivery_charge' => $deliveryCharge,
                'tax' => $cart->tax ?? 0,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'order_date' => now(),
                'estimated_delivery' => $deliveryDateTime,
            ]);

            // Create order items from cart items
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'item_name' => $cartItem->item_name,
                    'customizations' => $cartItem->customizations,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->unit_price,
                    'total_price' => $cartItem->total_price,
                ]);
            }

            // Clear the cart
            $cart->clear();

            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully',
                'order' => $order,
                'order_number' => $order->order_number,
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Order failed: ' . $e->getMessage()], 500);
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
}
