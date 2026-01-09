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
        $user = auth()->user();
        $query = CustomCake::query();

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        } elseif ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $customCakes = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($customCakes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
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

        $customCake = CustomCake::create(array_merge($validated, ['user_id' => auth()->id()]));

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
        if (auth()->id() !== $customCake->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'cake_name' => 'sometimes|string|max:255',
            'design_details' => 'nullable|string',
            'special_instructions' => 'nullable|string',
        ]);

        $customCake->update($request->only('cake_name', 'design_details', 'special_instructions'));

        return response()->json([
            'message' => 'Custom cake updated successfully',
            'custom_cake' => $customCake
        ]);
    }

    /**
     * Submit a custom cake request.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'size' => 'required|string',
            'size_price' => 'required|numeric',
            'flavor' => 'required|string',
            'flavor_price' => 'required|numeric',
            'frosting' => 'required|string',
            'frosting_price' => 'required|numeric',
            'decorations' => 'nullable|string', // JSON string from frontend
            'decorations_price' => 'required|numeric',
            'custom_message' => 'nullable|string',
            'delivery_date' => 'required|date|after_or_equal:today',
            'total_price' => 'required|numeric',
            'image' => 'nullable|image|max:5120', // Max 5MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('custom-cakes', 'public');
        }

        $referenceNumber = 'CC-' . strtoupper(uniqid());

        $customCake = CustomCake::create([
            'user_id' => auth()->id(),
            'reference_number' => $referenceNumber,
            'cake_name' => "Custom Cake ($referenceNumber)",
            'size' => $request->size,
            'size_price' => $request->size_price,
            'flavor' => $request->flavor,
            'flavor_price' => $request->flavor_price,
            'frosting' => $request->frosting,
            'frosting_price' => $request->frosting_price,
            'decorations' => json_decode($request->decorations, true),
            'decorations_price' => $request->decorations_price,
            'custom_message' => $request->custom_message,
            'image_path' => $imagePath,
            'total_price' => $request->total_price,
            'status' => 'pending',
            'delivery_date' => $request->delivery_date,
        ]);

        return response()->json([
            'message' => 'Custom cake request submitted successfully',
            'reference' => $referenceNumber,
            'custom_cake' => $customCake
        ], 201);
    }
}
