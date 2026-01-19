<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CartItem extends Model
{
    use HasFactory;
    
    protected $fillable = ['cart_id', 'product_id', 'custom_cake_id', 'item_name', 'quantity', 'unit_price', 'total_price', 'customizations'];
    
    protected $casts = [
        'customizations' => 'array',
    ];
        
        public function cart() {
            return $this->belongsTo(Cart::class);
        }
        
        public function product() {
            return $this->belongsTo(Product::class);
        }
        
        public function customCake() {
            return $this->belongsTo(CustomCake::class);
        }

        /**
         * Update quantity and recalculate total price
         */
        public function updateQuantity($quantity)
        {
            $this->quantity = $quantity;
            $this->total_price = $this->unit_price * $quantity;
            $this->save();
            return $this;
        }
}
