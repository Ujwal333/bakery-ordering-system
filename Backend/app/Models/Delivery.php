<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['order_id', 'delivery_location_id', 'delivery_date', 'delivery_time', 'status', 'notes'];
        
        public function order() {
            return $this->belongsTo(Order::class);
        }
        
        public function location() {
            return $this->belongsTo(DeliveryLocation::class, 'delivery_location_id');
        }
}
