<?php

/**
 * Debug Order Creation
 * 
 * This script helps debug the "Array to string conversion" error
 * by showing what data types are being sent from the frontend.
 * 
 * Place this in Backend folder and access via:
 * http://127.0.0.1:8000/debug-order-data.php
 */

header('Content-Type: application/json');

// Simulate the request data that might be causing issues
$sampleData = [
    'phone' => '9841234567',
    'delivery_type' => 'delivery',
    'delivery_date' => '2026-01-20',
    'delivery_time' => '14:00',
    'payment_method' => 'cod',
    
    // These might be arrays causing the issue
    'delivery_address' => 'Thamel, Kathmandu',  // Should be string
    'delivery_city' => 'Kathmandu',              // Should be string
    'province' => 'Bagmati',                     // Should be string
    'district' => 'Kathmandu',                   // Should be string
    'area' => 'Thamel',                          // Should be string
    'street' => 'Chaksibari Marg',               // Should be string
    
    // Optional fields
    'delivery_state' => '',
    'delivery_zip' => '44600',
    'latitude' => 27.7172,
    'longitude' => 85.3240,
    'delivery_window' => 'afternoon',
    'special_instructions' => 'Please ring the doorbell twice',
];

echo json_encode([
    'message' => 'Sample Order Data Structure',
    'data' => $sampleData,
    'data_types' => array_map('gettype', $sampleData),
    'instructions' => [
        'Check your frontend checkout.js or similar file',
        'Ensure all address fields are strings, not arrays',
        'Common issue: FormData or nested objects being sent as arrays',
        'Use browser DevTools Network tab to inspect the actual request payload'
    ],
    'common_fixes' => [
        'If using FormData, ensure you are appending strings not objects',
        'If using JSON, ensure nested objects are properly stringified',
        'Check if any field is being sent as [object Object] or array',
    ]
], JSON_PRETTY_PRINT);
