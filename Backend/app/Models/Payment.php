<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments'; // Use the correct table name

    protected $fillable = ['order_id', 'user_id', 'amount', 'provider', 'transaction_id', 'status', 'response_data'];

        public function order() {
            return $this->belongsTo(Order::class);
        }
}
