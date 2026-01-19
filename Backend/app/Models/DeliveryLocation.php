<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryLocation extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'delivery_locations';
        protected $fillable = ['name', 'address', 'city', 'postal_code', 'latitude', 'longitude', 'delivery_fee'];
        
        public function deliveries() {
            return $this->hasMany(Delivery::class);
        }
}
