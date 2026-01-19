<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'discount_price', 
        'stock', 'category_id', 'brand_id', 'image_url', 'gallery',
        'is_active', 'is_available', 'is_featured', 'is_popular', 'is_special', 'variants'
    ];

    protected $casts = [
        'variants' => 'array',
        'gallery' => 'array',
    ];
        
    public function category() {
        return $this->belongsTo(Category::class);
    }
        
    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query) {
        return $query->where('is_available', true);
    }

    public function scopePopular($query) {
        return $query->where('is_popular', true);
    }

    public function scopeFeatured($query) {
        return $query->where('is_featured', true);
    }

    public function scopeSpecial($query) {
        return $query->where('is_special', true);
    }
}
