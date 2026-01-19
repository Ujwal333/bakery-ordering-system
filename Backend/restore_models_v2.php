<?php
// Properly restore all model files

$modelDefinitions = [
    'ActivityLog' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $table = 'activity_logs';
        protected $fillable = ['user_id', 'action', 'model', 'model_id', 'description', 'ip_address', 'user_agent'];
        protected $dates = ['created_at', 'updated_at', 'deleted_at'];
        
        public function user() {
            return $this->belongsTo(User::class);
        }
EOT
    ],
    'Admin' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['name', 'email', 'password', 'phone', 'role_id', 'status', 'last_login'];
        protected $hidden = ['password'];
        
        public function role() {
            return $this->belongsTo(Role::class);
        }
EOT
    ],
    'Brand' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['name', 'description', 'logo_url', 'is_active'];
        
        public function products() {
            return $this->hasMany(Product::class);
        }
EOT
    ],
    'Cart' => [
        'imports' => ['HasFactory' => true],
        'traits' => 'HasFactory',
        'content' => <<<'EOT'
protected $fillable = ['user_id', 'total_price'];
        
        public function user() {
            return $this->belongsTo(User::class);
        }
        
        public function items() {
            return $this->hasMany(CartItem::class);
        }
EOT
    ],
    'CartItem' => [
        'imports' => ['HasFactory' => true],
        'traits' => 'HasFactory',
        'content' => <<<'EOT'
protected $fillable = ['cart_id', 'product_id', 'custom_cake_id', 'quantity', 'price'];
        
        public function cart() {
            return $this->belongsTo(Cart::class);
        }
        
        public function product() {
            return $this->belongsTo(Product::class);
        }
        
        public function customCake() {
            return $this->belongsTo(CustomCake::class);
        }
EOT
    ],
    'Category' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['name', 'slug', 'description', 'is_active'];
        
        public function products() {
            return $this->hasMany(Product::class);
        }
EOT
    ],
    'ContactQuery' => [
        'imports' => ['HasFactory' => true],
        'traits' => 'HasFactory',
        'content' => <<<'EOT'
protected $table = 'contact_queries';
        protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status'];
EOT
    ],
    'CustomCake' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['user_id', 'name', 'description', 'base_price', 'status', 'image_url'];
        
        public function user() {
            return $this->belongsTo(User::class);
        }
EOT
    ],
    'Delivery' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['order_id', 'delivery_location_id', 'delivery_date', 'delivery_time', 'status', 'notes'];
        
        public function order() {
            return $this->belongsTo(Order::class);
        }
        
        public function location() {
            return $this->belongsTo(DeliveryLocation::class, 'delivery_location_id');
        }
EOT
    ],
    'DeliveryLocation' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $table = 'delivery_locations';
        protected $fillable = ['name', 'address', 'city', 'postal_code', 'latitude', 'longitude', 'delivery_fee'];
        
        public function deliveries() {
            return $this->hasMany(Delivery::class);
        }
EOT
    ],
    'Event' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['title', 'description', 'start_date', 'end_date', 'location', 'image_url', 'is_active'];
EOT
    ],
    'Order' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['user_id', 'order_number', 'total_amount', 'tax_amount', 'delivery_fee', 'status', 'payment_status', 'notes'];
        protected $dates = ['created_at', 'updated_at', 'deleted_at'];
        
        public function user() {
            return $this->belongsTo(User::class);
        }
        
        public function items() {
            return $this->hasMany(OrderItem::class);
        }
        
        public function payment() {
            return $this->hasOne(Payment::class);
        }
        
        public function tracking() {
            return $this->hasOne(OrderTracking::class);
        }
        
        public function delivery() {
            return $this->hasOne(Delivery::class);
        }
EOT
    ],
    'OrderItem' => [
        'imports' => ['HasFactory' => true],
        'traits' => 'HasFactory',
        'content' => <<<'EOT'
protected $fillable = ['order_id', 'product_id', 'custom_cake_id', 'quantity', 'unit_price', 'subtotal'];
        
        public function order() {
            return $this->belongsTo(Order::class);
        }
        
        public function product() {
            return $this->belongsTo(Product::class);
        }
        
        public function customCake() {
            return $this->belongsTo(CustomCake::class);
        }
EOT
    ],
    'OrderTracking' => [
        'imports' => ['HasFactory' => true],
        'traits' => 'HasFactory',
        'content' => <<<'EOT'
protected $table = 'order_trackings';
        protected $fillable = ['order_id', 'status', 'location', 'updated_at'];
        
        public function order() {
            return $this->belongsTo(Order::class);
        }
EOT
    ],
    'Page' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['title', 'slug', 'content', 'is_published'];
EOT
    ],
    'Payment' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['order_id', 'amount', 'payment_method', 'transaction_id', 'status', 'payment_date'];
        
        public function order() {
            return $this->belongsTo(Order::class);
        }
EOT
    ],
    'Product' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['name', 'description', 'price', 'stock', 'category_id', 'brand_id', 'image_url', 'is_active'];
        
        public function category() {
            return $this->belongsTo(Category::class);
        }
        
        public function brand() {
            return $this->belongsTo(Brand::class);
        }
EOT
    ],
    'Role' => [
        'imports' => ['HasFactory' => true],
        'traits' => 'HasFactory',
        'content' => <<<'EOT'
protected $fillable = ['name', 'description'];
        
        public function admins() {
            return $this->hasMany(Admin::class);
        }
EOT
    ],
    'Setting' => [
        'imports' => ['HasFactory' => true],
        'traits' => 'HasFactory',
        'content' => <<<'EOT'
protected $fillable = ['key', 'value'];
EOT
    ],
    'Subscriber' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['email', 'name', 'is_active'];
EOT
    ],
    'Testimonial' => [
        'imports' => ['HasFactory' => true, 'SoftDeletes' => true],
        'traits' => 'HasFactory, SoftDeletes',
        'content' => <<<'EOT'
protected $fillable = ['user_id', 'rating', 'comment', 'is_approved'];
        
        public function user() {
            return $this->belongsTo(User::class);
        }
EOT
    ],
    'User' => [
        'imports' => ['HasApiTokens' => true, 'HasFactory' => true, 'Notifiable' => true],
        'traits' => 'HasApiTokens, HasFactory, Notifiable',
        'baseClass' => 'Authenticatable',
        'content' => <<<'EOT'
protected $fillable = ['name', 'email', 'password', 'phone', 'address', 'city', 'postal_code', 'status'];
        protected $hidden = ['password', 'remember_token'];
        protected $casts = ['email_verified_at' => 'datetime'];
        
        public function orders() {
            return $this->hasMany(Order::class);
        }
        
        public function customCakes() {
            return $this->hasMany(CustomCake::class);
        }
        
        public function cart() {
            return $this->hasOne(Cart::class);
        }
EOT
    ]
];

$modelsDir = __DIR__ . '/app/Models';

foreach ($modelDefinitions as $modelName => $definition) {
    $baseClass = $definition['baseClass'] ?? 'Model';
    $traitsLine = 'use ' . $definition['traits'] . ';';
    
    if ($baseClass === 'Authenticatable') {
        $imports = 'use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;';
    } else {
        $imports = 'use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;';
    }
    
    $content = "<?php

namespace App\\Models;

$imports

class $modelName extends $baseClass
{
    $traitsLine
    
    {$definition['content']}
}
";
    
    $filePath = $modelsDir . '/' . $modelName . '.php';
    file_put_contents($filePath, $content);
    echo "Restored: $modelName\n";
}

echo "\n✓ All 22 models properly restored!\n";
?>
