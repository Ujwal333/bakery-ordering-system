<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $query = Order::query()->with(['user', 'items']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search by Order ID or Name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'tracking'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,out_for_delivery,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        if ($oldStatus !== $newStatus) {
            $order->updateStatus($newStatus);

            if ($newStatus === 'cancelled' && $request->has('cancellation_reason')) {
                $order->cancellation_reason = $request->cancellation_reason;
                $order->save();
            }

            return redirect()->back()->with('success', "Order status updated to " . ucfirst(str_replace('_', ' ', $newStatus)));
        }

        return redirect()->back()->with('info', 'Status remains unchanged.');
    }
    
    /**
     * Update payment status manually.
     */
    public function updatePaymentStatus(Request $request, $id)
    {
         $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);
        
        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->save();
        
        return redirect()->back()->with('success', 'Payment status updated to ' . ucfirst($order->payment_status));
    }
}
