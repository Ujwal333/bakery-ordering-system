<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'user_id', 'order_number', 'customer_name', 'customer_email', 'customer_phone',
        'delivery_address', 'delivery_province', 'delivery_district', 'delivery_city', 
        'delivery_area', 'delivery_street', 'delivery_state', 'delivery_zip', 
        'latitude', 'longitude', 'delivery_type', 'table_number', 'order_source',
        'delivery_date', 'delivery_time', 'delivery_window',
        'subtotal', 'delivery_charge', 'tax', 'total_amount', 'payment_method', 
        'payment_status', 'status', 'special_instructions',
        'logistic_partner_id', 'handed_over_at'
    ];

    protected $casts = [
        'handed_over_at' => 'datetime',
        'order_date' => 'datetime',
        'delivery_date' => 'date',
    ];

    public function tableReservation()
    {
        return $this->hasOne(TableReservation::class, 'current_order_id');
    }
        
        public function user() {
            return $this->belongsTo(User::class);
        }
        
        public function orderItems() {
            return $this->hasMany(OrderItem::class);
        }
        
        public function payments() {
            return $this->hasMany(Payment::class);
        }
        
        public function tracking() {
            return $this->hasOne(OrderTracking::class);
        }
        
        public function deliveries() {
            return $this->hasMany(Delivery::class);
        }

        public function logisticPartner() {
            return $this->belongsTo(LogisticPartner::class);
        }
}
