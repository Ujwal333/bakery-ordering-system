<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class PageController extends Controller
{
    public function home()
    {
        // Fetch popular/featured products
        $popularProducts = Product::where('is_featured', true)->take(3)->get();
        // Fetch specials (assuming logic, e.g., category 'specials' or recent)
        // For now, let's take latest 3
        $specialProducts = Product::latest()->take(3)->get();
        
        return view('home', compact('popularProducts', 'specialProducts'));
    }

    public function browseMenu($categorySlug = null)
    {
        $categories = Category::all();
        
        if ($categorySlug && $categorySlug !== 'all') {
            $displayCategories = Category::where('slug', $categorySlug)->with('products')->get();
            if ($displayCategories->isEmpty()) {
                return redirect()->route('browse-menu');
            }
        } else {
            $displayCategories = Category::with('products')->get();
        }
        
        return view('browse-menu', [
            'categories' => $categories,
            'displayCategories' => $displayCategories,
            'activeCategory' => $categorySlug ?: 'all'
        ]);
    }

    public function customCake()
    {
        return view('custom-cake');
    }

    public function cart()
    {
        return view('cart');
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function orderTracking()
    {
        return view('order-tracking');
    }

    public function about()
    {
        $events = \App\Models\Event::where('is_active', true)
            ->orderBy('event_date', 'asc')
            ->get();
        return view('about', compact('events'));
    }

    public function features()
    {
        return view('features');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }
}
