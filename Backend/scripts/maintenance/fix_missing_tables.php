<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

config(['database.default' => 'mysql']);

echo "Creating missing tables...\n";

try {
    // 1. User Addresses
    if (!Schema::hasTable('user_addresses')) {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type')->default('home'); // home, work, other
            $table->string('address'); // Street name / house no
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->default('Nepal');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
        echo "Created 'user_addresses'.\n";
    }

    // 2. Saved Items (Wishlist)
    if (!Schema::hasTable('saved_items')) {
        Schema::create('saved_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        echo "Created 'saved_items'.\n";
    }

    // 3. Payment Logs
    if (!Schema::hasTable('payment_logs')) {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->string('transaction_id')->nullable();
            $table->string('method'); // eSewa, Khalti, COD
            $table->decimal('amount', 10, 2);
            $table->string('status'); // pending, success, failed
            $table->text('response_data')->nullable(); // JSON response from gateway
            $table->timestamps();
        });
        echo "Created 'payment_logs'.\n";
    }

    // 4. Events (if needed for some feature)
    if (!Schema::hasTable('events')) {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        echo "Created 'events'.\n";
    }

    // 5. Pages (CMS)
    if (!Schema::hasTable('pages')) {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
        echo "Created 'pages'.\n";
    }

    // 6. Custom Cakes  (was also missing from restore)
    if (!Schema::hasTable('custom_cakes')) {
        Schema::create('custom_cakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Can be guest
            $table->string('cake_type')->default('Standard');
            $table->string('size');
            $table->string('flavor');
            $table->string('frosting');
            $table->json('decorations')->nullable();
            $table->text('message')->nullable(); // Custom message on cake
            $table->string('image_path')->nullable(); // Reference image upload
            $table->decimal('estimated_price', 10, 2)->nullable();
            $table->enum('status', ['pending', 'reviewed', 'accepted', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable(); // For pricing or rejection reason
            $table->timestamps();
        });
        echo "Created 'custom_cakes'.\n";
    }

    echo "✅ All missing tables created successfully.\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
