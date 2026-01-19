<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CakeOption;
use Illuminate\Http\Request;

class CakeOptionController extends Controller
{
    public function index()
    {
        $options = CakeOption::orderBy('type')->orderBy('name')->get()->groupBy('type');
        return view('admin.cake-options.index', compact('options'));
    }

    public function create()
    {
        return view('admin.cake-options.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:cake_type,size,flavor,frosting,decoration',
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = [
            'type' => $request->type,
            'name' => $request->name,
            'price' => $request->price ?? 0,
            'stock' => $request->stock ?? 100,
            'is_active' => $request->has('is_active')
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('cake-options', 'public');
        }

        CakeOption::create($data);

        return redirect()->route('admin.cake-options.index')->with('success', 'Option created successfully.');
    }

    public function edit(CakeOption $cakeOption)
    {
        return view('admin.cake-options.edit', compact('cakeOption'));
    }

    public function update(Request $request, CakeOption $cakeOption)
    {
        $request->validate([
            'type' => 'required|in:cake_type,size,flavor,frosting,decoration',
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = [
            'type' => $request->type,
            'name' => $request->name,
            'price' => $request->price ?? 0,
            'stock' => $request->stock ?? 100,
            'is_active' => $request->has('is_active')
        ];

        if ($request->has('remove_image')) {
            if ($cakeOption->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($cakeOption->image_path);
            }
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($cakeOption->image_path && !$request->has('remove_image')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($cakeOption->image_path);
            }
            $data['image_path'] = $request->file('image')->store('cake-options', 'public');
        }

        $cakeOption->update($data);

        return redirect()->route('admin.cake-options.index')->with('success', 'Option updated successfully.');
    }

    public function destroy(CakeOption $cakeOption)
    {
        $cakeOption->delete();
        return back()->with('success', 'Option deleted successfully.');
    }
}
