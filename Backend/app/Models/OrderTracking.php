<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    use HasFactory;

    protected $table = 'order_tracking';

    protected $fillable = [
        'order_id',
        'status',
        'description',
        'location',
        'estimated_time',
        'updated_by',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accessors
    public function getFormattedStatusAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->status));
    }

    public function getStatusIconAttribute()
    {
        $icons = [
            'confirmed' => 'check-circle',
            'preparing' => 'utensils',
            'out_for_delivery' => 'truck',
            'delivered' => 'home',
        ];

        return $icons[$this->status] ?? 'info-circle';
    }
}
