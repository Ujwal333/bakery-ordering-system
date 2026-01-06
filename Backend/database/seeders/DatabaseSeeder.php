<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@cinnamonbakery.com',
            'password' => Hash::make('admin123'),
            'phone' => '+977 9801234567',
            'address' => 'Sano Bharayang, Kathmandu',
            'profile_image' => 'https://randomuser.me/api/portraits/men/32.jpg',
            'role' => 'admin',
        ]);

        // Create regular users
        $users = [
            [
                'name' => 'Priya Sharma',
                'email' => 'priya@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+977 9841234567',
                'address' => 'Baneshwor, Kathmandu',
                'profile_image' => 'https://randomuser.me/api/portraits/women/44.jpg',
            ],
            [
                'name' => 'Rahul Patel',
                'email' => 'rahul@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+977 9812345678',
                'address' => 'Patan, Lalitpur',
                'profile_image' => 'https://randomuser.me/api/portraits/men/45.jpg',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Create categories
        $categories = [
            [
                'name' => 'Cakes',
                'slug' => 'cakes',
                'description' => 'Delicious cakes for all occasions',
                'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                'order' => 1,
            ],
            [
                'name' => 'Cupcakes',
                'slug' => 'cupcakes',
                'description' => 'Beautiful cupcakes in various flavors',
                'image' => 'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                'order' => 2,
            ],
            [
                'name' => 'Cookies',
                'slug' => 'cookies',
                'description' => 'Freshly baked cookies',
                'image' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                'order' => 3,
            ],
            [
                'name' => 'Pastries',
                'slug' => 'pastries',
                'description' => 'Flaky and delicious pastries',
                'image' => 'https://images.unsplash.com/photo-1559620192-032c4bc4674e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                'order' => 4,
            ],
            [
                'name' => 'Specials',
                'slug' => 'specials',
                'description' => 'Weekly specials and limited edition items',
                'image' => 'https://images.unsplash.com/photo-1587248722790-9a1d1b76a0e8?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                'order' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create products
        $products = [
            // Cakes
            [
                'category_id' => 1,
                'name' => 'Classic Vanilla Cake',
                'slug' => 'classic-vanilla-cake',
                'description' => 'Light and fluffy vanilla sponge with buttercream frosting',
                'price' => 1200.00,
                'size' => '6-inch',
                'flavor' => 'Vanilla',
                'serves' => 8,
                'ingredients' => 'Flour, sugar, eggs, butter, vanilla extract, milk',
                'allergens' => 'Eggs, Milk, Gluten',
                'image_url' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
                'rating' => 5,
                'stock' => 50,
                'is_featured' => true,
                'is_popular' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Chocolate Fudge Cake',
                'slug' => 'chocolate-fudge-cake',
                'description' => 'Rich chocolate cake with chocolate ganache',
                'price' => 1400.00,
                'discount_price' => 1250.00,
                'size' => '8-inch',
                'flavor' => 'Chocolate',
                'serves' => 12,
                'ingredients' => 'Flour, sugar, cocoa powder, eggs, butter, chocolate',
                'allergens' => 'Eggs, Milk, Gluten',
                'image_url' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
                'rating' => 5,
                'stock' => 30,
                'is_featured' => true,
                'is_popular' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Red Velvet Cake',
                'slug' => 'red-velvet-cake',
                'description' => 'Signature red velvet with cream cheese frosting',
                'price' => 1600.00,
                'size' => '6-inch',
                'flavor' => 'Red Velvet',
                'serves' => 8,
                'ingredients' => 'Flour, sugar, cocoa powder, buttermilk, eggs, red food coloring',
                'allergens' => 'Eggs, Milk, Gluten',
                'image_url' => 'https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
                'rating' => 4,
                'stock' => 25,
                'is_popular' => true,
            ],

            // Cupcakes
            [
                'category_id' => 2,
                'name' => 'Vanilla Cupcakes (Dozen)',
                'slug' => 'vanilla-cupcakes-dozen',
                'description' => '12 vanilla cupcakes with buttercream frosting',
                'price' => 600.00,
                'size' => 'Dozen',
                'flavor' => 'Vanilla',
                'serves' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
                'rating' => 5,
                'stock' => 100,
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Chocolate Cupcakes (Dozen)',
                'slug' => 'chocolate-cupcakes-dozen',
                'description' => '12 chocolate cupcakes with chocolate frosting',
                'price' => 650.00,
                'size' => 'Dozen',
                'flavor' => 'Chocolate',
                'serves' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1576618148400-f54bed99fcfd?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
                'rating' => 5,
                'stock' => 80,
                'is_popular' => true,
            ],

            // Cookies
            [
                'category_id' => 3,
                'name' => 'Chocolate Chip Cookies (Dozen)',
                'slug' => 'chocolate-chip-cookies-dozen',
                'description' => '12 freshly baked chocolate chip cookies',
                'price' => 300.00,
                'size' => 'Dozen',
                'flavor' => 'Chocolate Chip',
                'serves' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
                'rating' => 5,
                'stock' => 200,
            ],

            // Specials
            [
                'category_id' => 5,
                'name' => 'Red Velvet Jar Cake',
                'slug' => 'red-velvet-jar-cake',
                'description' => 'Delicious layers of red velvet cake with cream cheese frosting in a jar',
                'price' => 250.00,
                'flavor' => 'Red Velvet',
                'serves' => 1,
                'image_url' => 'https://images.unsplash.com/photo-1587248722790-9a1d1b76a0e8?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
                'rating' => 5,
                'stock' => 50,
                'is_special' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => 5,
                'name' => 'Nutella Donuts',
                'slug' => 'nutella-donuts',
                'description' => 'Fluffy donuts filled with rich Nutella',
                'price' => 150.00,
                'flavor' => 'Nutella',
                'serves' => 1,
                'image_url' => 'https://images.unsplash.com/photo-1550617931-e17a7b70dce2?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80',
                'rating' => 5,
                'stock' => 60,
                'is_special' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create sample order
        $order = Order::create([
            'order_number' => 'CB-' . date('Ymd') . '-A1B2C3',
            'user_id' => 2, // Priya's user
            'customer_name' => 'Priya Sharma',
            'customer_email' => 'priya@example.com',
            'customer_phone' => '+977 9841234567',
            'delivery_address' => 'Baneshwor, Kathmandu',
            'delivery_city' => 'Kathmandu',
            'delivery_state' => 'Bagmati',
            'delivery_zip' => '44600',
            'delivery_type' => 'delivery',
            'delivery_date' => now()->addDays(2),
            'delivery_time' => '15:00',
            'subtotal' => 2050.00,
            'delivery_charge' => 100.00,
            'tax' => 205.00,
            'total_amount' => 2355.00,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'status' => 'preparing',
            'confirmed_at' => now()->subHours(2),
            'preparing_at' => now()->subHour(),
        ]);

        // Add order items
        $orderItems = [
            [
                'order_id' => $order->id,
                'product_id' => 1,
                'item_name' => 'Classic Vanilla Cake (6-inch)',
                'quantity' => 1,
                'unit_price' => 1200.00,
                'total_price' => 1200.00,
            ],
            [
                'order_id' => $order->id,
                'product_id' => 4,
                'item_name' => 'Vanilla Cupcakes (Dozen)',
                'quantity' => 1,
                'unit_price' => 600.00,
                'total_price' => 600.00,
            ],
            [
                'order_id' => $order->id,
                'product_id' => 6,
                'item_name' => 'Chocolate Chip Cookies (Dozen)',
                'quantity' => 1,
                'unit_price' => 300.00,
                'total_price' => 300.00,
            ],
        ];

        foreach ($orderItems as $itemData) {
            OrderItem::create($itemData);
        }

        // Add tracking entries
        $order->tracking()->createMany([
            [
                'status' => 'pending',
                'description' => 'Order placed successfully',
                'location' => 'Online Store',
            ],
            [
                'status' => 'confirmed',
                'description' => 'Order confirmed by bakery',
                'location' => 'Cinnamon Bakery',
            ],
            [
                'status' => 'preparing',
                'description' => 'Chef is preparing your order',
                'location' => 'Kitchen',
                'estimated_time' => now()->addHours(2),
            ],
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('👤 Admin Login: admin@cinnamonbakery.com / admin123');
        $this->command->info('👤 User Login: priya@example.com / password123');
        $this->command->info('👤 User Login: rahul@example.com / password123');
        $this->command->info('📦 Sample Order: CB-' . date('Ymd') . '-A1B2C3');
    }
}
