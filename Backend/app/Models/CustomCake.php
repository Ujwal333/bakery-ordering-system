<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomCake extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cake_name',
        'size',
        'flavor',
        'frosting',
        'filling',
        'design_details',
        'special_instructions',
        'serves',
        'base_price',
        'customization_price',
        'total_price',
        'status',
        'estimated_completion',
        'completed_at',
        'image_url',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'customization_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'estimated_completion' => 'datetime',
        'completed_at' => 'datetime',
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
