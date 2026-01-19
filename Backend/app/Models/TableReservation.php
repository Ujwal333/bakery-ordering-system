<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TableReservation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'table_number',
        'status',
        'current_order_id',
        'occupied_at',
        'available_at'
    ];

    protected $casts = [
        'occupied_at' => 'datetime',
        'available_at' => 'datetime',
    ];

    public function currentOrder()
    {
        return $this->belongsTo(Order::class, 'current_order_id');
    }

    /**
     * Get available tables
     */
    public static function getAvailableTables()
    {
        return self::where('status', 'available')->pluck('table_number')->toArray();
    }

    /**
     * Mark table as occupied
     */
    public function occupy($orderId)
    {
        $this->update([
            'status' => 'occupied',
            'current_order_id' => $orderId,
            'occupied_at' => now(),
            'available_at' => null
        ]);
    }

    /**
     * Free up the table
     */
    public function free()
    {
        $this->update([
            'status' => 'available',
            'current_order_id' => null,
            'occupied_at' => null,
            'available_at' => now()
        ]);
    }
}
