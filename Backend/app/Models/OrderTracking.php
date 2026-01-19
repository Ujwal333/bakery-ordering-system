<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OrderTracking extends Model
{
    use HasFactory;
    
    protected $table = 'order_trackings';
        protected $fillable = ['order_id', 'status', 'location', 'updated_at'];
        
        public function order() {
            return $this->belongsTo(Order::class);
        }
}
