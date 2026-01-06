<?php

namespace App\Http\Controllers;

use App\Models\CustomCake;
use Illuminate\Http\Request;

class CustomCakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CustomCake::with('user');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user (for admin)
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $customCakes = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($customCakes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cake_name' => 'required|string|max:255',
            'size' => 'required|string',
            'flavor' => 'required|string',
            'frosting' => 'required|string',
            'filling' => 'nullable|string',
            'design_details' => 'nullable|string',
            'special_instructions' => 'nullable|string',
            'serves' => 'required|integer|min:1',
            'base_price' => 'required|numeric|min:0',
            'customization_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'estimated_completion' => 'nullable|date',
            'image_url' => 'nullable|url',
        ]);

        $customCake = CustomCake::create([
            'user_id' => auth()->id(),
            ...$request->all()
        ]);

        return response()->json([
            'message' => 'Custom cake order created successfully',
            'custom_cake' => $customCake
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomCake $customCake)
    {
        $customCake->load('user');

        return response()->json($customCake);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomCake $customCake)
    {
        $request->validate([
            'status' => 'sometimes|in:pending,in_progress,completed',
            'estimated_completion' => 'nullable|date',
            'completed_at' => 'nullable|date',
        ]);

        $customCake->update($request->all());

        return response()->json([
            'message' => 'Custom cake updated successfully',
            'custom_cake' => $customCake
        ]);
    }

    /**
     * Update status of custom cake.
     */
    public function updateStatus(Request $request, CustomCake $customCake)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $customCake->updateStatus($request->status);

        return response()->json([
            'message' => 'Custom cake status updated successfully',
            'custom_cake' => $customCake
        ]);
    }
}
