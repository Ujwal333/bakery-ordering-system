<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'item_name',
        'customizations',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'customizations' => 'array',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    // Relationships
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Update quantity and recalculate total
    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->total_price = $this->unit_price * $quantity;
        $this->save();
    }
}
