<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomCake;
use Illuminate\Http\Request;

class CustomCakeController extends Controller
{
    public function index()
    {
        $cakes = CustomCake::with('user')->latest()->get();
        return view('admin.custom_cakes.index', compact('cakes'));
    }

    public function show(CustomCake $customCake)
    {
        return view('admin.custom_cakes.show', compact('customCake'));
    }

    public function updateStatus(Request $request, CustomCake $customCake)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed,delivered',
            'total_price' => 'nullable|numeric|min:0',
            'size' => 'sometimes|string',
            'flavor' => 'sometimes|string',
            'frosting' => 'sometimes|string',
            'cake_name' => 'sometimes|string',
            'custom_message' => 'nullable|string',
        ]);

        $updateData = ['status' => $request->status];
        
        $fields = ['total_price', 'size', 'flavor', 'frosting', 'cake_name', 'custom_message'];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $updateData[$field] = $request->$field;
            }
        }

        $customCake->update($updateData);

        return back()->with('success', 'Custom cake details updated.');
    }
}
