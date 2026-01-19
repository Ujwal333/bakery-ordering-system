<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Delivery;
use App\Services\GoogleMapsService;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    protected $mapsService;

    public function __construct(GoogleMapsService $mapsService)
    {
        $this->mapsService = $mapsService;
    }

    /**
     * Show tracking page for a specific order
     */
    public function show(Order $order)
    {
        // Security check: only owners can track
        // if ($order->user_id !== auth()->id()) {
        //    abort(403);
        // }

        $delivery = $order->delivery;
        
        // Define Restaurant Location (Fixed for this project)
        // Kathmandu Center Example: 27.7172, 85.3240
        $restaurant = [
            'name' => 'Cinnamon Bakery Kathmandu',
            'latitude' => 27.7172,
            'longitude' => 85.3240
        ];

        return view('tracking.show', compact('order', 'delivery', 'restaurant'));
    }

    /**
     * Get real-time tracking statistics for AJAX polling
     */
    public function getStatus(Order $order)
    {
        $delivery = $order->delivery;
        
        if (!$delivery || $delivery->status === 'pending') {
             return response()->json(['status' => 'waiting']);
        }

        // Customer Location
        $customerLat = $order->latitude;
        $customerLng = $order->longitude;

        // Rider Location
        $riderLat = $delivery->latitude;
        $riderLng = $delivery->longitude;

        $trackingData = [
            'order_status' => $order->status,
            'delivery_status' => $delivery->status,
            'rider_location' => [
                'lat' => (float)$riderLat,
                'lng' => (float)$riderLng,
            ],
            'customer_location' => [
                'lat' => (float)$customerLat,
                'lng' => (float)$customerLng,
            ],
            'eta' => null
        ];

        // Calculate ETA if rider is moveing
        if ($riderLat && $customerLat) {
            $etaData = $this->mapsService->getEta($riderLat, $riderLng, $customerLat, $customerLng);
            if ($etaData['status'] === 'success') {
                $trackingData['eta'] = [
                    'distance' => $etaData['distance'],
                    'remaining_time' => $etaData['duration_in_traffic'],
                    'arrival_time' => now()->addSeconds($etaData['duration_seconds'])->format('H:i')
                ];
            }
        }

        return response()->json($trackingData);
    }
}
