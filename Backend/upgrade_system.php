<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting System Upgrade...\n";

// 1. Database Schema Updates
echo "Checking Database Schema...\n";

if (!Schema::hasColumn('categories', 'parent_id')) {
    echo "Adding parent_id to categories...\n";
    Schema::table('categories', function (Blueprint $table) {
        $table->unsignedBigInteger('parent_id')->nullable()->after('id');
        $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
        $table->string('image_url')->nullable()->after('description');
    });
}

if (!Schema::hasColumn('products', 'variants')) {
    echo "Adding variants to products...\n";
    Schema::table('products', function (Blueprint $table) {
        $table->json('variants')->nullable()->after('stock');
    });
}

if (!Schema::hasColumn('products', 'is_active')) {
    echo "Adding is_active to products...\n";
    Schema::table('products', function (Blueprint $table) {
        $table->boolean('is_active')->default(true);
    });
}

if (!Schema::hasColumn('products', 'image_url')) {
    echo "Adding image_url to products...\n";
    Schema::table('products', function (Blueprint $table) {
        $table->string('image_url')->nullable();
    });
}

echo "Schema Verified.\n";

// 2. Data Population
echo "Seeding Data...\n";

// Ensure 'Cakes' root category exists
$cakesCategory = Category::firstOrCreate(
    ['slug' => 'cakes'],
    ['name' => 'Cakes', 'description' => 'Delicious cakes for all occasions', 'is_active' => true]
);

// Define Cake Subcategories
$cakeSubCategories = [
    'Wedding Cakes', 'Birthday Cakes', 'Anniversary Cakes', 'Baby Shower Cakes',
    'Celebration Cakes', 'Festival Cakes', 'Bento Cakes', 'Photo Cakes',
    'Tier Cakes', 'Custom Designer Cakes'
];

foreach ($cakeSubCategories as $subName) {
    Category::firstOrCreate(
        ['slug' => Str::slug($subName)],
        [
            'name' => $subName,
            'description' => $subName,
            'is_active' => true,
            'parent_id' => $cakesCategory->id
        ]
    );
}

// Define Cake Variant Sizes & Weight Multipliers (Base price * multiplier approx)
// We will assign these to products
$cakeVariants = [
    ['size' => '0.5 Pound', 'price_mod' => 0.6],
    ['size' => '1 Pound', 'price_mod' => 1.0],
    ['size' => '2 Pound', 'price_mod' => 1.9],
    ['size' => '3 Pound', 'price_mod' => 2.8],
    ['size' => '4 Pound', 'price_mod' => 3.7],
    ['size' => '5 Pound', 'price_mod' => 4.6],
    ['size' => '6+ Pound', 'price_mod' => 5.5],
];

// Helper to generate variants for a base price
function generateVariants($basePrice, $templates) {
    $variants = [];
    foreach ($templates as $t) {
        $variants[] = [
            'size' => $t['size'],
            'price' => ceil($basePrice * $t['price_mod'])
        ];
    }
    return $variants;
}

// Check/Add Products for cake subcategories (1 example per category if empty)
foreach ($cakeSubCategories as $subName) {
    $cat = Category::where('slug', Str::slug($subName))->first();
    if ($cat->products()->count() == 0) {
        Product::create([
            'category_id' => $cat->id,
            'name' => 'Signature ' . $subName,
            'slug' => Str::slug('Signature ' . $subName),
            'description' => 'Our finest ' . $subName . ' made with premium ingredients.',
            'price' => 1000, 
            'stock' => 100,
            'is_active' => true,
            'image_url' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
            'variants' => generateVariants(1000, $cakeVariants)
        ]);
    }
}


// Define New Top-Level Categories
$newCategories = [
    'Cupcakes' => [
        'items' => [
            'Vanilla Cupcake', 'Chocolate Cupcake', 'Red Velvet Cupcake', 'Strawberry Cupcake',
            'Oreo Cupcake', 'Blueberry Cupcake', 'Lemon Cupcake', 'Caramel Cupcake',
            'Coffee Cupcake', 'Rainbow Cupcake'
        ],
        'image' => 'https://images.unsplash.com/photo-1576618148400-f54bed99fcfd',
        'base_price' => 150
    ],
    'Cookies' => [
        'items' => [
            'Chocolate Chip', 'Butter Cookies', 'Oatmeal Cookies', 'Peanut Butter Cookies',
            'Almond Cookies', 'Coconut Cookies', 'Double Chocolate Cookies', 'Ginger Cookies',
            'Honey Cookies', 'Sugar Cookies'
        ],
        'image' => 'https://images.unsplash.com/photo-1499636138143-bd630f5cf388',
        'base_price' => 50
    ],
    'Pastries' => [
        'items' => [
            'Black Forest Pastry', 'White Forest Pastry', 'Chocolate Truffle Pastry', 'Pineapple Pastry',
            'Strawberry Pastry', 'Coffee Pastry', 'Mango Pastry', 'Red Velvet Pastry',
            'Oreo Pastry', 'Blueberry Pastry'
        ],
        'image' => 'https://images.unsplash.com/photo-1559553156-2e9713673c88',
        'base_price' => 120
    ],
    'Breads' => [
        'items' => [
            'White Bread', 'Brown Bread', 'Multigrain Bread', 'Garlic Bread', 'Milk Bread',
            'Bun', 'Croissant', 'Burger Bun', 'Sandwich Bread', 'French Bread'
        ],
        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff',
        'base_price' => 80
    ]
];

foreach ($newCategories as $catName => $data) {
    $cat = Category::firstOrCreate(
        ['slug' => Str::slug($catName)],
        [
            'name' => $catName,
            'description' => "Freshly baked $catName every day",
            'is_active' => true,
            'image_url' => $data['image']
        ]
    );

    foreach ($data['items'] as $prodName) {
        if (Product::where('name', $prodName)->exists()) continue;

        Product::create([
            'category_id' => $cat->id,
            'name' => $prodName,
            'slug' => Str::slug($prodName),
            'description' => "Delicious $prodName made fresh for you.",
            'price' => $data['base_price'],
            'stock' => 50,
            'is_active' => true,
            'image_url' => $data['image'], // Using category image as placeholder
            // No variants for simple items unless requested, user said "For all cake types"
            'variants' => null 
        ]);
    }
}

echo "Data Seeding Completed.\n";
