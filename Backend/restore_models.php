<?php
// Restore all corrupted model files with proper content

$models = [
    'ActivityLog' => 'class ActivityLog extends Model
    {
        use HasFactory, SoftDeletes;
        protected $table = \'activity_logs\';
        protected $fillable = [\'user_id\', \'action\', \'model\', \'model_id\', \'description\', \'ip_address\', \'user_agent\'];
        protected $dates = [\'created_at\', \'updated_at\', \'deleted_at\'];
        public function user() {
            return $this->belongsTo(User::class);
        }
    }',
    'Admin' => 'class Admin extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'name\', \'email\', \'password\', \'phone\', \'role_id\', \'status\', \'last_login\'];
        protected $hidden = [\'password\'];
        public function role() {
            return $this->belongsTo(Role::class);
        }
    }',
    'Brand' => 'class Brand extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'name\', \'description\', \'logo_url\', \'is_active\'];
        public function products() {
            return $this->hasMany(Product::class);
        }
    }',
    'Cart' => 'class Cart extends Model
    {
        use HasFactory;
        protected $fillable = [\'user_id\', \'total_price\'];
        public function user() {
            return $this->belongsTo(User::class);
        }
        public function items() {
            return $this->hasMany(CartItem::class);
        }
    }',
    'CartItem' => 'class CartItem extends Model
    {
        use HasFactory;
        protected $fillable = [\'cart_id\', \'product_id\', \'custom_cake_id\', \'quantity\', \'price\'];
        public function cart() {
            return $this->belongsTo(Cart::class);
        }
        public function product() {
            return $this->belongsTo(Product::class);
        }
        public function customCake() {
            return $this->belongsTo(CustomCake::class);
        }
    }',
    'Category' => 'class Category extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'name\', \'slug\', \'description\', \'is_active\'];
        public function products() {
            return $this->hasMany(Product::class);
        }
    }',
    'ContactQuery' => 'class ContactQuery extends Model
    {
        use HasFactory;
        protected $table = \'contact_queries\';
        protected $fillable = [\'name\', \'email\', \'phone\', \'subject\', \'message\', \'status\'];
    }',
    'CustomCake' => 'class CustomCake extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'user_id\', \'name\', \'description\', \'base_price\', \'status\', \'image_url\'];
        public function user() {
            return $this->belongsTo(User::class);
        }
    }',
    'Delivery' => 'class Delivery extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'order_id\', \'delivery_location_id\', \'delivery_date\', \'delivery_time\', \'status\', \'notes\'];
        public function order() {
            return $this->belongsTo(Order::class);
        }
        public function location() {
            return $this->belongsTo(DeliveryLocation::class, \'delivery_location_id\');
        }
    }',
    'DeliveryLocation' => 'class DeliveryLocation extends Model
    {
        use HasFactory, SoftDeletes;
        protected $table = \'delivery_locations\';
        protected $fillable = [\'name\', \'address\', \'city\', \'postal_code\', \'latitude\', \'longitude\', \'delivery_fee\'];
        public function deliveries() {
            return $this->hasMany(Delivery::class);
        }
    }',
    'Event' => 'class Event extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'title\', \'description\', \'start_date\', \'end_date\', \'location\', \'image_url\', \'is_active\'];
    }',
    'Order' => 'class Order extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'user_id\', \'order_number\', \'total_amount\', \'tax_amount\', \'delivery_fee\', \'status\', \'payment_status\', \'notes\'];
        protected $dates = [\'created_at\', \'updated_at\', \'deleted_at\'];
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
    }',
    'OrderItem' => 'class OrderItem extends Model
    {
        use HasFactory;
        protected $fillable = [\'order_id\', \'product_id\', \'custom_cake_id\', \'quantity\', \'unit_price\', \'subtotal\'];
        public function order() {
            return $this->belongsTo(Order::class);
        }
        public function product() {
            return $this->belongsTo(Product::class);
        }
        public function customCake() {
            return $this->belongsTo(CustomCake::class);
        }
    }',
    'OrderTracking' => 'class OrderTracking extends Model
    {
        use HasFactory;
        protected $table = \'order_trackings\';
        protected $fillable = [\'order_id\', \'status\', \'location\', \'updated_at\'];
        public function order() {
            return $this->belongsTo(Order::class);
        }
    }',
    'Page' => 'class Page extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'title\', \'slug\', \'content\', \'is_published\'];
    }',
    'Payment' => 'class Payment extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'order_id\', \'amount\', \'payment_method\', \'transaction_id\', \'status\', \'payment_date\'];
        public function order() {
            return $this->belongsTo(Order::class);
        }
    }',
    'Product' => 'class Product extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'name\', \'description\', \'price\', \'stock\', \'category_id\', \'brand_id\', \'image_url\', \'is_active\'];
        public function category() {
            return $this->belongsTo(Category::class);
        }
        public function brand() {
            return $this->belongsTo(Brand::class);
        }
    }',
    'Role' => 'class Role extends Model
    {
        use HasFactory;
        protected $fillable = [\'name\', \'description\'];
        public function admins() {
            return $this->hasMany(Admin::class);
        }
    }',
    'Setting' => 'class Setting extends Model
    {
        use HasFactory;
        protected $fillable = [\'key\', \'value\'];
    }',
    'Subscriber' => 'class Subscriber extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'email\', \'name\', \'is_active\'];
    }',
    'Testimonial' => 'class Testimonial extends Model
    {
        use HasFactory, SoftDeletes;
        protected $fillable = [\'user_id\', \'rating\', \'comment\', \'is_approved\'];
        public function user() {
            return $this->belongsTo(User::class);
        }
    }',
    'User' => 'class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;
        protected $fillable = [\'name\', \'email\', \'password\', \'phone\', \'address\', \'city\', \'postal_code\', \'status\'];
        protected $hidden = [\'password\', \'remember_token\'];
        protected $casts = [\'email_verified_at\' => \'datetime\'];
        public function orders() {
            return $this->hasMany(Order::class);
        }
        public function customCakes() {
            return $this->hasMany(CustomCake::class);
        }
        public function cart() {
            return $this->hasOne(Cart::class);
        }
    }'
];

$modelsDir = __DIR__ . '/app/Models';

foreach ($models as $modelName => $classContent) {
    $filePath = $modelsDir . '/' . $modelName . '.php';
    
    // Determine base class and imports
    if ($modelName === 'User') {
        $extends = 'extends Authenticatable';
        $baseImports = 'use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Notifications\\Notifiable;
use Laravel\\Sanctum\\HasApiTokens;';
    } else {
        $extends = 'extends Model';
        $baseImports = 'use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\SoftDeletes;';
    }
    
    $content = "<?php

namespace App\\Models;

$baseImports

class $modelName $extends
{
    use HasFactory;
    
    $classContent
}
";
    
    file_put_contents($filePath, $content);
    echo "Restored: $modelName\n";
}

echo "\n✓ All models restored!\n";
?>
