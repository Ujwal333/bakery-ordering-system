<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'size',
        'flavor',
        'serves',
        'ingredients',
        'allergens',
        'image_url',
        'rating',
        'stock',
        'is_featured',
        'is_popular',
        'is_special',
        'is_available',
        'customization_options',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'rating' => 'integer',
        'stock' => 'integer',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
        'is_special' => 'boolean',
        'is_available' => 'boolean',
        'customization_options' => 'array',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('stock', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeSpecial($query)
    {
        return $query->where('is_special', true);
    }

    // Accessors
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?: $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getInStockAttribute()
    {
        return $this->stock > 0;
    }

    // Check if product can be customized
    public function getCanCustomizeAttribute()
    {
        return !empty($this->customization_options);
    }
}
