<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_address',
        'delivery_city',
        'delivery_state',
        'delivery_zip',
        'delivery_type',
        'delivery_date',
        'delivery_time',
        'special_instructions',
        'subtotal',
        'delivery_charge',
        'tax',
        'total_amount',
        'payment_method',
        'payment_status',
        'status',
        'cancellation_reason',
        'confirmed_at',
        'preparing_at',
        'ready_at',
        'out_for_delivery_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'order_date' => 'datetime',
        'estimated_delivery' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'CB-' . strtoupper(uniqid());
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tracking()
    {
        return $this->hasMany(OrderTracking::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePreparing($query)
    {
        return $query->where('status', 'preparing');
    }

    public function scopeOutForDelivery($query)
    {
        return $query->where('status', 'out_for_delivery');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    // Accessors
    public function getProgressPercentageAttribute()
    {
        $statusOrder = ['confirmed', 'preparing', 'out_for_delivery', 'delivered'];
        $currentIndex = array_search($this->status, $statusOrder);
        $total = count($statusOrder) - 1;

        return $currentIndex !== false ? round(($currentIndex / $total) * 100) : 0;
    }

    public function getProgressStepsAttribute()
    {
        $steps = [
            ['label' => 'Order Confirmed', 'icon' => 'check', 'status' => 'completed'],
            ['label' => 'Preparing', 'icon' => 'utensils', 'status' => $this->status === 'confirmed' ? 'pending' : ($this->status === 'preparing' ? 'active' : 'completed')],
            ['label' => 'Out for Delivery', 'icon' => 'truck', 'status' => in_array($this->status, ['confirmed', 'preparing']) ? 'pending' : ($this->status === 'out_for_delivery' ? 'active' : 'completed')],
            ['label' => 'Delivered', 'icon' => 'home', 'status' => $this->status === 'delivered' ? 'completed' : 'pending'],
        ];

        return $steps;
    }

    // Update order status with timestamp tracking
    public function updateStatus($status)
    {
        $this->status = $status;

        if ($status === 'delivered') {
            $this->delivered_at = now();
        }

        $this->save();

        // Create tracking entry
        OrderTracking::create([
            'order_id' => $this->id,
            'status' => $status,
            'message' => $this->getStatusMessage($status),
        ]);
    }

    // Get status message for tracking
    private function getStatusMessage($status)
    {
        $messages = [
            'confirmed' => 'Your order has been confirmed and is being prepared.',
            'preparing' => 'Your order is being prepared with care.',
            'out_for_delivery' => 'Your order is out for delivery.',
            'delivered' => 'Your order has been delivered successfully.',
        ];

        return $messages[$status] ?? 'Order status updated.';
    }
}
