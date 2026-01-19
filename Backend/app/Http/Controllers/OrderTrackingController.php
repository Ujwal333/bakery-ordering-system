<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Delivery;

class OrderTrackingController extends Controller
{
    /**
     * Get live tracking data for an order.
     */
    public function getTrackingData($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['delivery.deliveryBoy', 'tracking'])
            ->firstOrFail();

        // Check if user is authorized
        if (auth()->check() && auth()->id() !== $order->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $delivery = $order->delivery;
        
        $trackingData = [
            'order_number' => $order->order_number,
            'status' => $order->status,
            'customer_location' => [
                'lat' => $order->latitude,
                'lng' => $order->longitude,
            ],
            'delivery_location' => $delivery ? [
                'lat' => $delivery->latitude,
                'lng' => $delivery->longitude,
                'status' => $delivery->status
            ] : null,
            'estimated_time' => $order->estimated_delivery ? $order->estimated_delivery->diffForHumans() : 'N/A',
            'events' => $order->tracking->map(function($t) {
                return [
                    'status' => $t->status,
                    'message' => $t->message,
                    'time' => $t->created_at->format('H:i A'),
                ];
            })
        ];

        return response()->json($trackingData);
    }
}
