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
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'name' => 'required|max:255|unique:products',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
        ]);

        // 2. Create Instance
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->stock = $request->stock;

        // Optional Fields
        $product->size = $request->size;
        $product->flavor = $request->flavor;
        $product->serves = $request->serves;
        $product->ingredients = $request->ingredients;
        $product->allergens = $request->allergens;

        // Flags
        $product->is_available = $request->has('is_available');
        $product->is_featured = $request->has('is_featured');
        $product->is_popular = $request->has('is_popular');
        $product->is_special = $request->has('is_special');

        // 3. Handle Image
        if ($request->hasFile('image')) {
            // Save to storage/app/public/products
            $path = $request->file('image')->store('products', 'public');
            $product->image_url = $path; // or asset('storage/'.$path) if you prefer full URL in DB, but relative is better
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255|unique:products,name,' . $id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->name = $request->name;
        // Optional: Update slug or keep original? Let's update it.
        $product->slug = Str::slug($request->name);
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->stock = $request->stock;

        $product->size = $request->size;
        $product->flavor = $request->flavor;
        $product->serves = $request->serves;
        $product->ingredients = $request->ingredients;
        $product->allergens = $request->allergens;

        $product->is_available = $request->has('is_available');
        $product->is_featured = $request->has('is_featured');
        $product->is_popular = $request->has('is_popular');
        $product->is_special = $request->has('is_special');

        if ($request->hasFile('image')) {
            // Delete old image if exists?
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image_url = $path;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->is_available = !$product->is_available;
        $product->save();
        
        return redirect()->back()->with('success', 'Product availability updated.');
    }
}
