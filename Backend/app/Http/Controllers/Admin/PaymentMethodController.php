<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of payment methods.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('sort_order')->get();
        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new payment method.
     */
    public function create()
    {
        return view('admin.payment-methods.create');
    }

    /**
     * Store a newly created payment method.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:payment_methods,code',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
            'requires_verification' => 'boolean',
            'sort_order' => 'nullable|integer',
            'extra_charge' => 'nullable|numeric|min:0',
            'extra_charge_type' => 'nullable|in:fixed,percentage',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['requires_verification'] = $request->has('requires_verification');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo_url'] = $request->file('logo')->store('payment-logos', 'public');
        }

        // Handle QR code upload
        if ($request->hasFile('qr_code')) {
            $validated['qr_code_path'] = $request->file('qr_code')->store('payment-qr-codes', 'public');
        }

        PaymentMethod::create($validated);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    /**
     * Show the form for editing the specified payment method.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment-methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified payment method.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:payment_methods,code,' . $paymentMethod->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
            'requires_verification' => 'boolean',
            'sort_order' => 'nullable|integer',
            'extra_charge' => 'nullable|numeric|min:0',
            'extra_charge_type' => 'nullable|in:fixed,percentage',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['requires_verification'] = $request->has('requires_verification');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($paymentMethod->logo_url) {
                Storage::disk('public')->delete($paymentMethod->logo_url);
            }
            $validated['logo_url'] = $request->file('logo')->store('payment-logos', 'public');
        }

        // Handle QR code upload
        if ($request->hasFile('qr_code')) {
            // Delete old QR code if exists
            if ($paymentMethod->qr_code_path) {
                Storage::disk('public')->delete($paymentMethod->qr_code_path);
            }
            $validated['qr_code_path'] = $request->file('qr_code')->store('payment-qr-codes', 'public');
        }

        $paymentMethod->update($validated);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    /**
     * Toggle payment method status.
     */
    public function toggleStatus(PaymentMethod $paymentMethod)
    {
        $paymentMethod->update([
            'is_active' => !$paymentMethod->is_active
        ]);

        return back()->with('success', 'Payment method status updated.');
    }

    /**
     * Remove the specified payment method.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        // Delete associated files
        if ($paymentMethod->logo_url) {
            Storage::disk('public')->delete($paymentMethod->logo_url);
        }
        if ($paymentMethod->qr_code_path) {
            Storage::disk('public')->delete($paymentMethod->qr_code_path);
        }

        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}
