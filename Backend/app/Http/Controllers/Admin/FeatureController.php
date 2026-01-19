<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeatureController extends Controller
{
    /**
     * Display a listing of features.
     */
    public function index()
    {
        $features = Feature::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.features.index', compact('features'));
    }

    /**
     * Show the form for creating a new feature.
     */
    public function create()
    {
        return view('admin.features.create');
    }

    /**
     * Store a newly created feature.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('features', 'public');
        }

        // Convert benefits array to JSON
        if (isset($validated['benefits'])) {
            $validated['benefits'] = array_filter($validated['benefits']); // Remove empty values
        }

        $validated['is_active'] = $request->has('is_active');

        Feature::create($validated);

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature created successfully.');
    }

    /**
     * Show the form for editing the specified feature.
     */
    public function edit(Feature $feature)
    {
        return view('admin.features.edit', compact('feature'));
    }

    /**
     * Update the specified feature.
     */
    public function update(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->has('remove_image')) {
            if ($feature->image_path) {
                Storage::disk('public')->delete($feature->image_path);
            }
            $validated['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($feature->image_path && !$request->has('remove_image')) {
                Storage::disk('public')->delete($feature->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('features', 'public');
        }

        // Convert benefits array to JSON
        if (isset($validated['benefits'])) {
            $validated['benefits'] = array_filter($validated['benefits']); // Remove empty values
        }

        $validated['is_active'] = $request->has('is_active');

        $feature->update($validated);

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Feature $feature)
    {
        $feature->update([
            'is_active' => !$feature->is_active
        ]);

        return back()->with('success', 'Feature status updated.');
    }

    /**
     * Remove the specified feature.
     */
    public function destroy(Feature $feature)
    {
        // Delete image file
        if ($feature->image_path) {
            Storage::disk('public')->delete($feature->image_path);
        }

        $feature->delete();

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature deleted successfully.');
    }
}
