<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Get all products with filtering and pagination
    public function index(Request $request)
    {
        $query = Product::with('category')->available();

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by category slug
        if ($request->has('category_slug')) {
            $category = Category::where('slug', $request->category_slug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by size
        if ($request->has('size')) {
            $query->where('size', $request->size);
        }

        // Filter by flavor
        if ($request->has('flavor')) {
            $query->where('flavor', $request->flavor);
        }

        // Filter popular items
        if ($request->boolean('popular')) {
            $query->popular();
        }

        // Filter featured items
        if ($request->boolean('featured')) {
            $query->featured();
        }

        // Filter special items
        if ($request->boolean('special')) {
            $query->special();
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function($cq) use ($search) {
                      $cq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Sort
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);

        // Paginate or get all
        if ($request->boolean('paginate')) {
            $products = $query->paginate($request->get('per_page', 12));
        } else {
            $products = $query->get();
        }

        return response()->json($products);
    }

    // Get product by ID or slug
    public function show($identifier)
    {
        $product = Product::with('category')
            ->where('id', $identifier)
            ->orWhere('slug', $identifier)
            ->firstOrFail();

        return response()->json($product);
    }

    // Get product categories
    public function categories()
    {
        $categories = Category::active()
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    // Get product flavors
    public function flavors()
    {
        $flavors = Product::select('flavor')->whereNotNull('flavor')->distinct()->pluck('flavor');
        return response()->json($flavors);
    }

    // Get custom cake options
    public function cakeOptions()
    {
        $sizes = [
            ['value' => '6 inch (Serves 4-6)', 'price' => 400],
            ['value' => '8 inch (Serves 8-10)', 'price' => 900],
            ['value' => '10 inch (Serves 12-15)', 'price' => 1100],
            ['value' => '12 inch (Serves 20-25)', 'price' => 1500],
        ];

        $flavors = [
            ['name' => 'Classic Vanilla', 'price' => 300],
            ['name' => 'Chocolate Fudge', 'price' => 500],
            ['name' => 'Red Velvet', 'price' => 500],
            ['name' => 'Lemon Zest', 'price' => 400],
            ['name' => 'Carrot Cake', 'price' => 600],
            ['name' => 'Coffee Crunch', 'price' => 400],
        ];

        $frostings = [
            ['name' => 'Classic Buttercream', 'price' => 300],
            ['name' => 'Cream Cheese', 'price' => 500],
            ['name' => 'Chocolate Ganache', 'price' => 500],
            ['name' => 'Premium Frosting', 'price' => 1000],
        ];

        $decorations = [
            ['name' => 'Fresh Berries', 'price' => 800, 'icon' => 'stroopwafel'],
            ['name' => 'Chocolate Drip', 'price' => 1200, 'icon' => 'candy-cane'],
            ['name' => 'Edible Flowers', 'price' => 1800, 'icon' => 'leaf'],
            ['name' => 'Gold Leaf Accent', 'price' => 2000, 'icon' => 'crown'],
            ['name' => 'French Macarons', 'price' => 1000, 'icon' => 'cookie'],
            ['name' => 'Custom Cake Topper', 'price' => 1500, 'icon' => 'star'],
        ];

        return response()->json([
            'sizes' => $sizes,
            'flavors' => $flavors,
            'frostings' => $frostings,
            'decorations' => $decorations,
        ]);
    }
}
