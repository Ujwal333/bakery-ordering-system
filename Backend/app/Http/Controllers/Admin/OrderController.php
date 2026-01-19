<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'payments', 'deliveries']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,with_logistic,out_for_delivery,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        // If dine-in order is delivered or cancelled, free the table
        if ($order->delivery_type === 'dine-in' && in_array($request->status, ['delivered', 'cancelled'])) {
            $table = \App\Models\TableReservation::where('current_order_id', $order->id)->first();
            if ($table) {
                $table->free();
            }
        }

        // Handle manual payment marking
        if ($request->has('mark_as_paid') && $request->mark_as_paid == '1') {
            $order->update(['payment_status' => 'paid']);
        }

        // Log activity or send notification here
        
        return back()->with('success', 'Order status updated to ' . ucfirst(str_replace('_', ' ', $request->status)));
    }

    public function invoice(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.invoice', compact('order'));
    }
}
