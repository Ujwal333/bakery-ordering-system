<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Accessors
    public function getSubtotalAttribute()
    {
        return $this->items->sum('total_price');
    }

    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    // Get or create cart for current user/session
    public static function getOrCreateCart()
    {
        if (auth()->check()) {
            return self::firstOrCreate(['user_id' => auth()->id()]);
        } else {
            $sessionId = session()->getId();
            return self::firstOrCreate(['session_id' => $sessionId]);
        }
    }

    // Convert cart items to order items
    public function toOrderItems()
    {
        return $this->items->map(function ($cartItem) {
            return [
                'product_id' => $cartItem->product_id,
                'item_name' => $cartItem->product->name,
                'customizations' => $cartItem->customizations,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->unit_price,
                'total_price' => $cartItem->total_price,
            ];
        })->toArray();
    }

    // Clear cart after order placement
    public function clear()
    {
        $this->items()->delete();
    }
}
