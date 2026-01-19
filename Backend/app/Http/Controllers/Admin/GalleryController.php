<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery images.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new gallery image.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created gallery image.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        Gallery::create($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery image uploaded successfully.');
    }

    /**
     * Show the form for editing the specified gallery image.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified gallery image.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->has('remove_image')) {
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $validated['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image_path && !$request->has('remove_image')) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery image updated successfully.');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Gallery $gallery)
    {
        $gallery->update([
            'is_featured' => !$gallery->is_featured
        ]);

        return back()->with('success', 'Featured status updated.');
    }

    /**
     * Remove the specified gallery image.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete image file
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery image deleted successfully.');
    }
}
