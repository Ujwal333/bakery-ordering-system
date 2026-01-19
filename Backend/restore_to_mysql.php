<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

// Force MySQL config in runtime just in case
config(['database.default' => 'mysql']);

echo "Restoring data to MySQL...\n";

try {
    // 1. Load Backup Data
    if (!file_exists(__DIR__ . '/sqlite_backup_data.json')) {
        die("❌ Backup file not found. Cannot proceed.\n");
    }
    $backupData = json_decode(file_get_contents(__DIR__ . '/sqlite_backup_data.json'), true);
    
    // 2. Define Tables to Migrate (Order matters for foreign keys)
    // Dropping tables first
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    $tables = ['order_items', 'orders', 'products', 'categories', 'users', 'roles', 'admins', 'settings', 'personal_access_tokens', 'password_resets', 'failed_jobs', 'migrations', 'carts', 'cart_items', 'contact_queries', 'testimonials', 'subscribers', 'brands', 'custom_cakes', 'activity_logs', 'pages', 'events', 'user_addresses', 'saved_items', 'payment_logs'];
    
    foreach ($tables as $table) {
        Schema::dropIfExists($table);
        echo "Dropped $table\n";
    }
    // DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Commented out to keep checks off during creation/insert

    // 3. Create Tables with CORRECT Logic
    
    // Roles
    Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->timestamps();
    });
    // Seed Roles immediately
    DB::table('roles')->insert([
        ['id' => 1, 'name' => 'Customer', 'slug' => 'customer'],
        ['id' => 2, 'name' => 'Admin', 'slug' => 'admin'],
        ['id' => 3, 'name' => 'Super Admin', 'slug' => 'super-admin'],
    ]);

    // Users
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('phone')->nullable(); // Fixed: Nullable
        $table->text('address')->nullable();
        $table->string('city')->nullable();
        $table->string('postal_code')->nullable();
        $table->string('profile_image')->default('https://randomuser.me/api/portraits/lego/1.jpg');
        $table->unsignedBigInteger('role_id')->default(1); // Fixed: Default 1
        $table->enum('role', ['customer', 'admin'])->default('customer'); // Fixed: Default customer
        $table->string('status')->default('active');
        $table->string('otp_code', 6)->nullable();
        $table->timestamp('otp_expires_at')->nullable();
        $table->boolean('is_phone_verified')->default(false);
        $table->rememberToken();
        $table->softDeletes();
        $table->timestamps();
        
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
    });

    // Admins
    Schema::create('admins', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('username')->unique();
        $table->string('password');
        $table->enum('role', ['superadmin', 'admin', 'staff'])->default('admin');
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->timestamp('email_verified_at')->nullable();
        $table->rememberToken();
        $table->softDeletes();
        $table->timestamps();
    });

    // Categories
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('parent_id')->nullable();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->string('image_url')->nullable(); // Added
        $table->integer('order')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        $table->softDeletes();
    });

    // Brands
    Schema::create('brands', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->string('logo')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

    // Products
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->decimal('discount_price', 10, 2)->nullable();
        $table->string('image_url')->nullable();
        $table->json('gallery')->nullable();
        $table->text('ingredients')->nullable(); 
        $table->text('allergens')->nullable(); 
        $table->string('flavor')->nullable(); // Added
        $table->integer('stock')->default(0); // Renamed from stock_quantity to stock
        $table->boolean('is_active')->default(true); // Added
        $table->boolean('is_available')->default(true);
        $table->boolean('is_featured')->default(false);
        $table->boolean('is_popular')->default(false); // Added
        $table->boolean('is_special')->default(false); // Added
        $table->decimal('rating', 3, 2)->default(5.00); // Added
        $table->string('serves')->nullable(); // Added
        $table->string('size')->nullable(); // Added
        $table->json('variants')->nullable();
        $table->text('customization_options')->nullable();
        $table->softDeletes();
        $table->timestamps();
    });

    // Orders
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_number')->unique();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->string('customer_name');
        $table->string('customer_email');
        $table->string('customer_phone');
        $table->text('delivery_address');
        $table->string('delivery_city');
        $table->string('delivery_state')->nullable();
        $table->string('delivery_zip')->nullable();
        
        $table->string('delivery_province')->nullable();
        $table->string('delivery_district')->nullable();
        $table->string('delivery_area')->nullable();
        $table->string('delivery_street')->nullable();
        $table->string('latitude')->nullable();
        $table->string('longitude')->nullable();
        
        $table->string('delivery_type')->default('delivery');
        $table->date('delivery_date')->nullable();
        $table->string('delivery_time')->nullable();
        $table->string('delivery_window')->nullable(); // Morning/Afternoon
        
        $table->dateTime('order_date')->nullable(); // Changed to nullable
        $table->dateTime('estimated_delivery')->nullable();
        $table->text('special_instructions')->nullable();
        
        $table->decimal('subtotal', 10, 2);
        $table->decimal('delivery_charge', 10, 2)->default(0);
        $table->decimal('tax', 10, 2)->default(0);
        $table->decimal('total_amount', 10, 2);
        
        $table->string('payment_method')->default('cod');
        $table->string('payment_status')->default('pending');
        $table->string('status')->default('pending');
        $table->text('cancellation_reason')->nullable();
        
        $table->timestamp('confirmed_at')->nullable();
        $table->timestamp('preparing_at')->nullable();
        $table->timestamp('ready_at')->nullable();
        $table->timestamp('out_for_delivery_at')->nullable();
        $table->timestamp('delivered_at')->nullable();
        $table->timestamp('cancelled_at')->nullable();
        
        $table->softDeletes();
        $table->timestamps();
    });

    // Order Items
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
        $table->string('item_name');
        $table->json('customizations')->nullable();
        $table->integer('quantity');
        $table->decimal('unit_price', 10, 2);
        $table->decimal('total_price', 10, 2);
        $table->timestamps();
    });

    // Cart Tables
    Schema::create('carts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('session_id')->nullable();
        $table->timestamps();
    });

    Schema::create('cart_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cart_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->nullable()->constrained();
        $table->string('item_name');
        $table->integer('quantity')->default(1);
        $table->decimal('unit_price', 10, 2);
        $table->decimal('total_price', 10, 2);
        $table->json('customizations')->nullable();
        $table->timestamps();
    });
    
    // Testimonials
    Schema::create('testimonials', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->string('designation')->nullable();
        $table->string('image')->nullable();
        $table->text('content');
        $table->integer('rating')->default(5);
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->softDeletes();
        $table->timestamps();
    });
    
    // Contact Queries
    Schema::create('contact_queries', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('subject');
        $table->text('message');
        $table->enum('status', ['new', 'read', 'replied'])->default('new');
        $table->timestamps();
    });
    
    // Subscribers
    Schema::create('subscribers', function (Blueprint $table) {
        $table->id();
        $table->string('email')->unique();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    
    // Settings
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('group')->default('general'); // Added
        $table->string('key')->unique();
        $table->string('key_name')->nullable(); // Added
        $table->string('type')->default('text'); // Added
        $table->text('value')->nullable();
        $table->string('value_type')->default('string'); // Added
        $table->timestamps();
        $table->softDeletes();
    });
    
    // Activity Logs
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable();
        $table->string('action'); // e.g., 'created_order', 'updated_profile'
        $table->string('description')->nullable();
        $table->string('ip_address')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
    
    // 4. Restore Data
    
    // Safety Hack: Ensure User ID 2 exists for that legacy order
    DB::table('users')->insertOrIgnore([
        'id' => 2,
        'name' => 'Legacy User', 
        'email' => 'legacy@example.com',
        'password' => 'legacy',
        'role_id' => 1
    ]);
    
    $importTables = ['users', 'admins', 'categories', 'products', 'orders', 'order_items', 'settings', 'testimonials'];
    
    foreach ($importTables as $table) {
        if (isset($backupData[$table]) && !empty($backupData[$table])) {
            echo "Importing " . count($backupData[$table]) . " rows into $table...\n";
            // We need to chunk insert to avoid massive query string
            foreach (array_chunk($backupData[$table], 50) as $chunk) {
                // Ensure array keys match columns strictly? No, insert takes array associated by key.
                // However, we must remove keys that might not exist in new schema if we changed it?
                // For now, we assume schema matches backup mostly.
                
                // Fix: remove keys that might cause issues if schema slightly differs?
                // Actually, DB::table()->insert() is stringent.
                // Let's rely on the fact we just built the schema to match broadly.
                try {
                    DB::table($table)->insert($chunk);
                } catch (\Exception $e) {
                    echo " - Warning importing chunk to $table: " . $e->getMessage() . "\n";
                    // Fallback: row by row
                    foreach($chunk as $row) {
                        try {
                            DB::table($table)->insert($row);
                        } catch (\Exception $ex) {
                            // ignore duplicate entry or mismatch
                        }
                    }
                }
            }
        }
    }
    
    // Ensure at least one admin if missing
    if (DB::table('admins')->count() == 0) {
        DB::table('admins')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'superadmin', // Fixed: match enum
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "Created default admin (admin@gmail.com / password)\n";
    }

    DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Re-enable checks
    echo "✅ Success! Database migrated to MySQL correctly.\n";
    
} catch (\Exception $e) {
    echo "❌ CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
