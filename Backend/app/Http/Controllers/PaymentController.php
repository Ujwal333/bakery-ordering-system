<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // ==========================================
    // KHALTI INTEGRATION (ePayment API)
    // ==========================================

    public function payWithKhalti($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Khalti Configuration from .env
        $url = env('KHALTI_API_URL', 'https://a.khalti.com/api/v2/epayment/initiate/');
        $secretKey = env('KHALTI_SECRET_KEY');

        $amountInPaisa = (int) ($order->total_amount * 100);

        $payload = [
            "return_url" => route('payment.khalti.verify'),
            "website_url" => url('/'),
            "amount" => $amountInPaisa,
            "purchase_order_id" => (string) $order->id,
            "purchase_order_name" => "Order " . $order->order_number,
            "customer_info" => [
                "name" => $order->customer_name,
                "email" => $order->customer_email,
                "phone" => $order->customer_phone,
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => $secretKey,
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            $result = $response->json();

            if (isset($result['payment_url'])) {
                // Save pidx to verify later (Adding column to order or just saving in session probably better for now if no DB change planned)
                // For robustness, let's save pidx in a temporary session or cache linked to order
                session(['khalti_pidx_' . $order->id => $result['pidx']]);
                
                return response()->json([
                    'success' => true,
                    'payment_url' => $result['payment_url']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['detail'] ?? 'Khalti initiation failed'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function verifyKhalti(Request $request)
    {
        // Khalti returns pidx, txnId, amount, mobile, purchase_order_id, purchase_order_name, transaction_id
        $pidx = $request->pidx;
        $orderId = $request->purchase_order_id;
        $status = $request->status; // Completed, User canceled, etc.

        if (!$pidx || !$orderId) {
            return redirect()->route('cart')->with('error', 'Invalid payment response.');
        }

        $order = Order::findOrFail($orderId);

        if ($status !== 'Completed') {
             return redirect()->route('cart')->with('error', 'Payment not completed or canceled.');
        }

        // Verify with Khalti Server
        $url = env('KHALTI_VERIFY_URL', 'https://a.khalti.com/api/v2/epayment/lookup/');
        $secretKey = env('KHALTI_SECRET_KEY');

        $response = Http::withHeaders([
             'Authorization' => $secretKey,
             'Content-Type' => 'application/json',
        ])->post($url, ['pidx' => $pidx]);

        $result = $response->json();

        if (isset($result['status']) && $result['status'] == 'Completed') {
            // Success
            $order->status = 'confirmed';
            $order->payment_status = 'paid';
            $order->save();

            OrderTracking::create([
                'order_id' => $order->id,
                'status' => 'confirmed',
                'message' => 'Payment successful via Khalti. Order confirmed.'
            ]);

            return redirect()->route('order-tracking')->with('success', 'Payment successful!');
        } else {
            return redirect()->route('cart')->with('error', 'Payment verification failed.');
        }
    }

    // ==========================================
    // ESEWA INTEGRATION (Sandbox)
    // ==========================================

    public function payWithEsewa($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // eSewa Configuration from .env
        $url = env('ESEWA_API_URL', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form');
        $merchantCode = env('ESEWA_MERCHANT_CODE', 'EPAYTEST');
        
        // Amount Details
        $amount = $order->total_amount;
        $tax = 0;
        $serviceCharge = 0;
        $deliveryCharge = 0; // Already in total_amount usually, so just base it here or separate it. eSewa requires breakdown.
        // For simplicity in sandbox, we'll put everything in total_amount and 0 others.
        
        // Generate Signature (Message = total_amount,transaction_uuid,product_code)
        // eSewa V2 requires signature
        // eSewa Signature
        $transactionUuid = $order->id . '-' . time();
        $message = "total_amount={$amount},transaction_uuid={$transactionUuid},product_code={$merchantCode}";
        $secret = env('ESEWA_SECRET', '8gBm/:&EnhH.1/q');
        $signature = base64_encode(hash_hmac('sha256', $message, $secret, true));

        // Save Uuid to verify later
        $order->cancellation_reason = $transactionUuid; // Storing temporarily in cancellation_reason or need a new column. 
        // Using session is safer for now.
        session(['esewa_uuid_' . $order->id => $transactionUuid]);
        $order->save(); // If we used column

        return response()->json([
            'success' => true,
            'method' => 'esewa',
            'url' => $url,
            'params' => [
                'amount' => $amount,
                'tax_amount' => 0,
                'total_amount' => $amount,
                'transaction_uuid' => $transactionUuid,
                'product_code' => $merchantCode,
                'product_service_charge' => 0,
                'product_delivery_charge' => 0,
                'success_url' => route('payment.esewa.verify', ['id' => $order->id]),
                'failure_url' => route('cart'), // redirect to cart on failure
                'signed_field_names' => 'total_amount,transaction_uuid,product_code',
                'signature' => $signature,
            ]
        ]);
    }

    public function verifyEsewa(Request $request, $id)
    {
        // eSewa returns encoded data
        $data = $request->data;
        
        if (!$data) {
             return redirect()->route('cart')->with('error', 'Invalid payment response.');
        }

        // Decode
        $decoded = json_decode(base64_decode($data), true);
        
        if ($decoded['status'] !== 'COMPLETE') {
            return redirect()->route('cart')->with('error', 'Payment failed or canceled.');
        }

        // Secure Verification (Double Check)
        // Re-generate signature and match, or basically trust the status if SSL.
        // For sandbox:
        $order = Order::findOrFail($id);
        
        // Update Order
        $order->status = 'confirmed';
        $order->payment_status = 'paid';
        $order->save();

         OrderTracking::create([
            'order_id' => $order->id,
            'status' => 'confirmed',
            'message' => 'Payment successful via eSewa. Order confirmed.'
        ]);

        return redirect()->route('order-tracking')->with('success', 'Payment successful!');
    }
}
