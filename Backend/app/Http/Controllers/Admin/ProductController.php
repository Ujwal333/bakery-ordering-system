<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imageUrl = null;
        if ($request->hasFile('main_image')) {
            $imageUrl = $request->file('main_image')->store('products', 'public');
        }

        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('products/gallery', 'public');
            }
        }

        // Generate unique slug
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'image_url' => $imageUrl,
            'gallery' => $gallery,
            'is_available' => $request->has('is_available'),
            'is_featured' => $request->has('is_featured'),
            'is_popular' => $request->has('is_popular'),
            'is_special' => $request->has('is_special'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Generate unique slug if name changed
        $slug = Str::slug($request->name);
        if ($slug !== $product->slug) {
            $originalSlug = $slug;
            $counter = 1;
            
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        } else {
            $slug = $product->slug; // Keep existing slug
        }

        $data = [
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'is_available' => $request->has('is_available'),
            'is_featured' => $request->has('is_featured'),
            'is_popular' => $request->has('is_popular'),
            'is_special' => $request->has('is_special'),
            'is_active' => $request->has('is_active'),
        ];

        if ($request->has('remove_main_image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $data['image_url'] = null;
        }

        if ($request->hasFile('main_image')) {
            // Delete old image if exists and wasn't just removed (though deleting twice is safe-ish, better logic is cleaner)
            if ($product->image_url && !$request->has('remove_main_image')) {
                Storage::disk('public')->delete($product->image_url);
            }
            $data['image_url'] = $request->file('main_image')->store('products', 'public');
        }

        // Handle Gallery
        $gallery = $product->gallery ?? [];
        
        // Remove selected gallery images
        if ($request->has('remove_gallery') && is_array($request->remove_gallery)) {
            $gallery = array_filter($gallery, function($image) use ($request) {
                if (in_array($image, $request->remove_gallery)) {
                    Storage::disk('public')->delete($image);
                    return false; // Remove from array
                }
                return true; // Keep in array
            });
        }

        // Add new gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('products/gallery', 'public');
            }
        }
        
        $data['gallery'] = array_values($gallery); // Re-index array

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product moved to trash.');
    }
}
