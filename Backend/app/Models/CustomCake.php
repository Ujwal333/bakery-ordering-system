<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomCake extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference_number',
        'cake_name',
        'size',
        'size_price',
        'flavor',
        'flavor_price',
        'frosting',
        'frosting_price',
        'decorations',
        'decorations_price',
        'custom_message',
        'image_path',
        'total_price',
        'status',
        'delivery_date',
        'delivery_time',
    ];

    protected $casts = [
        'size_price' => 'decimal:2',
        'flavor_price' => 'decimal:2',
        'frosting_price' => 'decimal:2',
        'decorations_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'delivery_date' => 'date',
        'decorations' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Calculate total price
    public function calculateTotalPrice()
    {
        $this->total_price = $this->base_price + $this->customization_price;
        $this->save();
    }

    // Update status
    public function updateStatus($status)
    {
        $this->status = $status;

        if ($status === 'completed') {
            $this->completed_at = now();
        }

        $this->save();
    }

    // Get formatted design details
    public function getFormattedDesignAttribute()
    {
        $details = [];

        if ($this->size) $details[] = "Size: {$this->size}";
        if ($this->flavor) $details[] = "Flavor: {$this->flavor}";
        if ($this->frosting) $details[] = "Frosting: {$this->frosting}";
        if ($this->filling) $details[] = "Filling: {$this->filling}";
        if ($this->serves) $details[] = "Serves: {$this->serves}";

        return implode(', ', $details);
    }
}
