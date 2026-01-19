<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleMapsService
{
    protected $apiKey;

    public function __construct()
    {
        // For production, this should be in .env
        $this->apiKey = config('services.google.maps_api_key');
    }

    /**
     * Get ETA and distance between two points using Google Distance Matrix API
     */
    public function getEta($originLat, $originLng, $destLat, $destLng)
    {
        if (!$this->apiKey) {
            return [
                'status' => 'error',
                'message' => 'Google Maps API Key not configured'
            ];
        }

        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
                'origins' => "{$originLat},{$originLng}",
                'destinations' => "{$destLat},{$destLng}",
                'mode' => 'driving',
                'traffic_model' => 'best_guess',
                'departure_time' => 'now',
                'key' => $this->apiKey
            ]);

            $data = $response->json();

            if ($data['status'] === 'OK') {
                $element = $data['rows'][0]['elements'][0];
                
                if ($element['status'] === 'OK') {
                    return [
                        'status' => 'success',
                        'distance' => $element['distance']['text'],
                        'duration' => $element['duration']['text'],
                        'duration_in_traffic' => $element['duration_in_traffic']['text'] ?? $element['duration']['text'],
                        'duration_seconds' => $element['duration']['value']
                    ];
                }
            }

            return ['status' => 'error', 'message' => $data['error_message'] ?? 'Unable to fetch ETA'];

        } catch (\Exception $e) {
            Log::error("Google Maps API Error: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Service error'];
        }
    }
}
