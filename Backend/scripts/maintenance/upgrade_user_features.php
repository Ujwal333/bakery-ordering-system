<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting User Features Upgrade...\n";

// 1. Create Saved Items (Wishlist) Table
if (!Schema::hasTable('saved_items')) {
    echo "Creating saved_items table...\n";
    Schema::create('saved_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->timestamps();
        $table->unique(['user_id', 'product_id']); // Prevent duplicates
    });
}

// 2. Create User Addresses Table
if (!Schema::hasTable('user_addresses')) {
    echo "Creating user_addresses table...\n";
    Schema::create('user_addresses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('type')->default('Home'); // Home, Work, Other
        $table->text('address');
        $table->string('city')->default('Kathmandu');
        $table->string('phone')->nullable();
        $table->boolean('is_default')->default(false);
        $table->timestamps();
    });
} else {
    // If exists, ensure is_default column exists
    if (!Schema::hasColumn('user_addresses', 'is_default')) {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
    }
}

echo "Database Upgrade Complete for User Features.\n";
