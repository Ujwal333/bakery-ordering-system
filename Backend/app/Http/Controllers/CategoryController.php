<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::active()
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show($identifier)
    {
        $category = Category::with('products')
            ->where('id', $identifier)
            ->orWhere('slug', $identifier)
            ->firstOrFail();

        return response()->json($category);
    }
}
