<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * Initial data for the chatbot
     */
    public function getInitData()
    {
        $categories = Category::whereNull('parent_id')->get(['id', 'name', 'slug']);
        
        return response()->json([
            'greeting' => "Hi there! Welcome to Cinnamon Bakery 🥐. How can I help you today?",
            'options' => [
                ['label' => '🎒 Order a Cake', 'value' => 'order_regular'],
                ['label' => '🎨 Custom Design Cake', 'value' => 'order_custom'],
                ['label' => '📜 View Full Menu', 'value' => 'view_menu'],
                ['label' => '🚚 Delivery Info', 'value' => 'delivery_info'],
                ['label' => '📞 Contact Support', 'value' => 'contact_support']
            ],
            'categories' => $categories
        ]);
    }

    /**
     * Get products by category for chatbot
     */
    public function getProducts(Request $request)
    {
        $categoryId = $request->query('category_id');
        $products = Product::where('category_id', $categoryId)
            ->where('is_active', true)
            ->take(5)
            ->get(['id', 'name', 'price', 'discount_price', 'image_url', 'slug']);

        return response()->json([
            'products' => $products
        ]);
    }

    /**
     * Get custom cake guidance steps
     */
    public function getCustomCakeSteps()
    {
        return response()->json([
            'steps' => [
                ['id' => 'size', 'question' => 'What size are you looking for?', 'options' => ['6 inch (Small)', '8 inch (Medium)', '10 inch (Large)']],
                ['id' => 'flavor', 'question' => 'Which flavor do you prefer?', 'options' => ['Chocolate Breeze', 'Vanilla Velvet', 'Red Velvet', 'Butterscotch']],
                ['id' => 'shape', 'question' => 'What shape should the cake be?', 'options' => ['Round', 'Square', 'Heart Shape']]
            ]
        ]);
    }
}
