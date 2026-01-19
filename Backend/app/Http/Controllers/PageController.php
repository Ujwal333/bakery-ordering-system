<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class PageController extends Controller
{
    public function home()
    {
        // Fetch dynamic page content (Hero, etc)
        $pageContents = \App\Models\PageContent::where('page_key', 'home')->get()->keyBy('section_key');
        
        // Fetch active features for homepage (top 3)
        $features = \App\Models\Feature::where('is_active', true)->orderBy('sort_order')->take(3)->get();

        // Fetch popular products based on order counts (Best Sellers)
        $popularProducts = \App\Models\Product::active()->available()
            ->where('is_popular', true)
            ->take(3)
            ->get();
        // Fetch specials
        $specialProducts = \App\Models\Product::active()->available()->latest()->take(3)->get();
        
        // Fetch approved testimonials
        $testimonials = \App\Models\Testimonial::where('status', 'approved')->latest()->take(3)->get();
        
        return view('home', compact('popularProducts', 'specialProducts', 'testimonials', 'pageContents', 'features'));
    }

    public function browseMenu($categorySlug = null)
    {
        // Only show top-level categories in the navigation tabs
        $categories = Category::whereNull('parent_id')->active()->get();
        
        $displayCategories = collect();

        if ($categorySlug && $categorySlug !== 'all') {
            $parentCategory = Category::where('slug', $categorySlug)->active()->first();
            
            if ($parentCategory) {
                // Check if this category has children (Subcategories)
                $children = $parentCategory->children()->active()->with(['products' => function($q) {
                    $q->active()->available();
                }])->get();
                
                if ($children->isNotEmpty()) {
                    // If it has children (e.g. Cakes -> Wedding, Birthday), show them
                    $displayCategories = $children;
                } else {
                    // It's a leaf category or has no subcategories, show itself
                    $displayCategories = Category::where('id', $parentCategory->id)->with(['products' => function($q) {
                        $q->active()->available();
                    }])->get();
                }
            } else {
                 return redirect()->route('browse-menu');
            }
        } else {
            // Show all top-level categories
            $displayCategories = Category::whereNull('parent_id')->active()->with(['products' => function($q) {
                $q->active()->available();
            }, 'children' => function($q) {
                $q->active()->with(['products' => function($q2) {
                    $q2->active()->available();
                }]);
            }])->get();

            // For each top-level category, include products from its subcategories
            foreach ($displayCategories as $category) {
                foreach ($category->children as $child) {
                    $category->setRelation('products', $category->products->concat($child->products));
                }
            }
        }
        
        return view('browse-menu', [
            'categories' => $categories,
            'displayCategories' => $displayCategories,
            'activeCategory' => $categorySlug ?: 'all'
        ]);
    }

    public function customCake()
    {
        $options = \App\Models\CakeOption::where('is_active', true)->get()->groupBy('type');
        return view('custom-cake', compact('options'));
    }

    public function cart()
    {
        return view('cart');
    }

    public function checkout()
    {
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)
                            ->orderBy('sort_order')
                            ->get();
        return view('checkout', compact('paymentMethods'));
    }

    public function orderTracking()
    {
        return view('order-tracking');
    }

    public function orderConfirmation(Request $request)
    {
        // Get order details from query parameters
        $orderId = $request->query('order_id');
        $orderNumber = $request->query('order_number');
        $phone = $request->query('phone');
        $paymentMethod = $request->query('payment_method', 'COD');
        $deliveryDate = $request->query('delivery_date');
        $totalAmount = $request->query('total_amount', 0);

        return view('order-confirmation', compact(
            'orderId',
            'orderNumber',
            'phone',
            'paymentMethod',
            'deliveryDate',
            'totalAmount'
        ));
    }

    public function about()
    {
        $events = \App\Models\Event::where('is_active', true)
            ->orderBy('event_date', 'asc')
            ->get();
            
        $features = \App\Models\Feature::active()->orderBy('sort_order')->get();
        
        $galleries = \App\Models\Gallery::orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $faqs = \App\Models\HelpContent::where('is_active', true)
            ->where('type', 'faq')
            ->orderBy('sort_order')
            ->get();
            
        $pageContents = \App\Models\PageContent::where('page_key', 'about')->get()->keyBy('section_key');
        
        return view('about', compact('events', 'pageContents', 'features', 'galleries', 'faqs'));
    }

    public function events()
    {
        $events = \App\Models\Event::where('is_active', true)
            ->orderBy('event_date', 'asc')
            ->paginate(9);
        return view('events', compact('events'));
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }
    public function orders()
    {
        $user = auth()->user();
        $orders = \App\Models\Order::where('user_id', $user->id)
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);
        return view('orders', compact('orders'));
    }

    public function wishlist()
    {
        $user = auth()->user();
        $savedItems = \App\Models\SavedItem::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->get();
        return view('wishlist', compact('savedItems'));
    }

    public function addresses()
    {
        $user = auth()->user();
        $addresses = \App\Models\UserAddress::where('user_id', $user->id)->get();
        return view('addresses', compact('addresses'));
    }
}
