<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\DeliveryLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryTrackingController extends Controller
{
    /**
     * Update delivery person location
     * Expected coordinates: lat, lng
     */
    public function updateLocation(Request $request, Delivery $delivery)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'speed' => 'nullable|numeric',
            'heading' => 'nullable|numeric',
        ]);

        // Security: Ensure only the assigned rider can update (if auth is enabled)
        // if (auth()->id() !== $delivery->delivery_boy_id) {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        DB::beginTransaction();
        try {
            // Update current position in delivery table
            $delivery->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            // Save history for "bread crumbs"
            DeliveryLocation::create([
                'delivery_id' => $delivery->id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'speed' => $request->speed,
                'heading' => $request->heading,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Location updated successfully',
                'timestamp' => now()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update location'
            ], 500);
        }
    }

    /**
     * Start delivery (Mark Out for Delivery)
     */
    public function startDelivery(Delivery $delivery)
    {
        $delivery->update(['status' => Delivery::STATUS_OUT_FOR_DELIVERY]);
        
        // Also update the order status
        $delivery->order->update(['status' => 'out_for_delivery']);

        return response()->json(['message' => 'Order is now out for delivery']);
    }

    /**
     * Mark as delivered
     */
    public function completeDelivery(Delivery $delivery)
    {
        $delivery->update(['status' => Delivery::STATUS_DELIVERED]);
        $delivery->order->update(['status' => 'delivered']);

        return response()->json(['message' => 'Order delivered successfully']);
    }
}
