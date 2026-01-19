<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Initiate payment based on provider
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'provider' => 'required|in:esewa,khalti'
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->payment_status === 'paid') {
            return response()->json(['message' => 'Order is already paid'], 400);
        }

        if ($request->provider === 'esewa') {
            return $this->initiateEsewa($order);
        } else {
            return $this->initiateKhalti($order);
        }
    }

    /**
     * eSewa Initiation (EPAY 2.0)
     */
    private function initiateEsewa(Order $order)
    {
        $amount = $order->total_amount;
        $transaction_uuid = $order->order_number; // Using order number as UUID
        $product_code = env('ESEWA_PRODUCT_CODE', 'EPAYTEST');
        $secret_key = env('ESEWA_SECRET_KEY', '8g7h79abnd877shhd'); // Dummy for sandbox
        
        $success_url = route('payment.esewa.success');
        $failure_url = route('payment.esewa.failure');

        // Signature: total_amount,transaction_uuid,product_code
        // Important: Signature generation for eSewa v2
        $signature_string = "total_amount=$amount,transaction_uuid=$transaction_uuid,product_code=$product_code";
        $signature = base64_encode(hash_hmac('sha256', $signature_string, $secret_key, true));

        $formData = [
            'amount' => $amount,
            'tax_amount' => 0,
            'product_service_charge' => 0,
            'product_delivery_charge' => 0,
            'product_code' => $product_code,
            'total_amount' => $amount,
            'transaction_uuid' => $transaction_uuid,
            'success_url' => $success_url,
            'failure_url' => $failure_url,
            'signed_field_names' => 'total_amount,transaction_uuid,product_code',
            'signature' => $signature,
        ];

        return response()->json([
            'payment_url' => env('ESEWA_URL', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form'),
            'form_data' => $formData
        ]);
    }

    /**
     * Khalti Initiation
     */
    private function initiateKhalti(Order $order)
    {
        $secret_key = env('KHALTI_SECRET_KEY');
        $amount_in_paisa = $order->total_amount * 100;

        $response = Http::withHeaders([
            'Authorization' => "Key $secret_key"
        ])->post(env('KHALTI_INITIATE_URL', 'https://a.khalti.com/api/v2/epayment/initiate/'), [
            'return_url' => route('payment.khalti.callback'),
            'website_url' => config('app.url'),
            'amount' => $amount_in_paisa,
            'purchase_order_id' => $order->id,
            'purchase_order_name' => "Order #" . $order->order_number,
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Khalti initiation failed', 'error' => $response->json()], 500);
    }

    /**
     * eSewa Success Callback
     */
    public function esewaSuccess(Request $request)
    {
        $encoded_data = $request->data;
        if (!$encoded_data) {
            return redirect()->route('home')->with('error', 'Payment verification failed: No data.');
        }

        $decoded_data = json_decode(base64_decode($encoded_data), true);
        
        // Verify Signature
        $secret_key = env('ESEWA_SECRET_KEY', '8g7h79abnd877shhd');
        $expected_signature_string = "transaction_code={$decoded_data['transaction_code']},status={$decoded_data['status']},total_amount={$decoded_data['total_amount']},transaction_uuid={$decoded_data['transaction_uuid']},product_code={$decoded_data['product_code']}";
        $expected_signature = base64_encode(hash_hmac('sha256', $expected_signature_string, $secret_key, true));

        if ($expected_signature !== $decoded_data['signature']) {
             Log::error('eSewa Signature mismatch', ['received' => $decoded_data['signature'], 'expected' => $expected_signature]);
             return redirect()->route('home')->with('error', 'Payment verification failed: Invalid Signature.');
        }

        if ($decoded_data['status'] !== 'COMPLETE') {
             return redirect()->route('home')->with('error', 'Payment status: ' . $decoded_data['status']);
        }

        $transaction_uuid = $decoded_data['transaction_uuid'] ?? null;
        $order = Order::where('order_number', $transaction_uuid)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        // Final verification check (recommended by eSewa)
        // For simplicity in this demo, we verify the signature manually
        // In production, you would call eSewa verification endpoint.

        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed'
        ]);

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => $order->user_id,
                'amount' => $order->total_amount,
                'provider' => 'esewa',
                'transaction_id' => $decoded_data['transaction_code'] ?? null,
                'status' => 'completed',
                'response_data' => json_encode($decoded_data)
            ]
        );

        return redirect()->route('order-tracking', ['order_id' => $order->order_number])
            ->with('success', 'Payment Successful! Your order is confirmed.');
    }

    /**
     * eSewa Failure Callback
     */
    public function esewaFailure(Request $request)
    {
        return redirect()->route('home')->with('error', 'Payment failed or cancelled.');
    }

    /**
     * Khalti Callback
     */
    public function khaltiCallback(Request $request)
    {
        $pidx = $request->pidx;
        $order_id = $request->purchase_order_id;
        
        if (!$pidx) {
            return redirect()->route('home')->with('error', 'Khalti verification failed.');
        }

        $order = Order::findOrFail($order_id);
        $secret_key = env('KHALTI_SECRET_KEY');

        // Verify with Khalti API
        $response = Http::withHeaders([
            'Authorization' => "Key $secret_key"
        ])->post(env('KHALTI_VERIFY_URL', 'https://a.khalti.com/api/v2/epayment/lookup/'), [
            'pidx' => $pidx
        ]);

        $status = $response->json()['status'] ?? null;

        if ($status === 'Completed') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'confirmed'
            ]);

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'user_id' => $order->user_id,
                    'amount' => $order->total_amount,
                    'provider' => 'khalti',
                    'transaction_id' => $pidx,
                    'status' => 'completed',
                    'response_data' => json_encode($response->json())
                ]
            );

            return redirect()->route('order-tracking', ['order_id' => $order->order_number])
                ->with('success', 'Payment Successful! Your order is confirmed.');
        }

        return redirect()->route('home')->with('error', 'Khalti Payment failed.');
    }
}
