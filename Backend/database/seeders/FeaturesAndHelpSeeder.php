<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;
use App\Models\HelpContent;

class FeaturesAndHelpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Sample Features
        Feature::create([
            'title' => 'Easy Online Ordering',
            'description' => 'Browse our menu, customize your order, and checkout in minutes with our user-friendly interface.',
            'icon' => 'fas fa-shopping-cart',
            'benefits' => [
                'Simple 3-step process',
                'Save favorite items',
                'Real-time availability',
                'Secure payment options'
            ],
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Feature::create([
            'title' => 'Live Order Tracking',
            'description' => 'Follow your order from our bakery to your doorstep in real-time with GPS tracking.',
            'icon' => 'fas fa-map-marker-alt',
            'benefits' => [
                'Real-time GPS tracking',
                'Arrival notifications',
                'Driver contact info',
                'Estimated delivery time'
            ],
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Feature::create([
            'title' => 'Custom Cake Builder',
            'description' => 'Design your dream cake with our interactive customization tool and see it come to life.',
            'icon' => 'fas fa-paint-brush',
            'benefits' => [
                'Real-time preview',
                'Multiple flavor combinations',
                'Instant pricing',
                'Save your designs'
            ],
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Sample Help Cards
        HelpContent::create([
            'type' => 'help_card',
            'title' => 'Ordering',
            'content' => 'Learn how to place orders, use coupons, and customize your treats.',
            'icon' => 'fas fa-shopping-basket',
            'category' => 'ordering',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        HelpContent::create([
            'type' => 'help_card',
            'title' => 'Delivery',
            'content' => 'Tracking, delivery times, and coverage areas in Kathmandu Valley.',
            'icon' => 'fas fa-truck',
            'category' => 'delivery',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        HelpContent::create([
            'type' => 'help_card',
            'title' => 'Payments',
            'content' => 'Information on eSewa, Khalti, and Cash on Delivery options.',
            'icon' => 'fas fa-wallet',
            'category' => 'payments',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Sample FAQs
        HelpContent::create([
            'type' => 'faq',
            'title' => 'What are your opening hours?',
            'content' => 'We are open from 8:00 AM to 8:00 PM every day, including public holidays. Online orders can be placed 24/7.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        HelpContent::create([
            'type' => 'faq',
            'title' => 'Do you deliver outside Kathmandu?',
            'content' => 'Currently, we only deliver within the Kathmandu Valley (Kathmandu, Lalitpur, and Bhaktapur) to ensure the freshness of our baked goods.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        HelpContent::create([
            'type' => 'faq',
            'title' => 'Can I cancel my order?',
            'content' => 'Orders can be cancelled within 1 hour of placement. Custom cake orders cannot be cancelled once preparation has started (usually 24 hours before delivery).',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        HelpContent::create([
            'type' => 'faq',
            'title' => 'Are your cakes fresh daily?',
            'content' => 'Yes! Every item is baked fresh in the morning of your delivery date. We don\'t store cakes overnight.',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        HelpContent::create([
            'type' => 'faq',
            'title' => 'How do I track my order?',
            'content' => 'After placing your order, you will receive a tracking link via SMS and email. You can also track your order by visiting the Order Tracking page and entering your order number and phone number.',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        HelpContent::create([
            'type' => 'faq',
            'title' => 'What payment methods do you accept?',
            'content' => 'We accept eSewa, Khalti, and Cash on Delivery (COD). For online payments, you will be redirected to the payment gateway after placing your order.',
            'sort_order' => 6,
            'is_active' => true,
        ]);
    }
}
