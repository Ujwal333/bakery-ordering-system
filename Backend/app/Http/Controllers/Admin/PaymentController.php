<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['order', 'order.user'])->latest();

        // Filters
        if ($request->has('provider') && $request->provider != 'all') {
            $query->where('provider', $request->provider);
        }

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $payments = $query->paginate(20);
        
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Display the specified payment.
     */
    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $payment->load(['order', 'order.user']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Update payment status (Manual Verification)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,failed,pending'
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update(['status' => $request->status]);

        if ($request->status === 'completed') {
            $payment->order->update([
                'payment_status' => 'completed',
                'status' => 'confirmed'
            ]);
        }

        return back()->with('success', 'Payment status updated successfully.');
    }
}
