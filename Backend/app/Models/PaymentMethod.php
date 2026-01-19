<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'display_name',
        'description',
        'logo_url',
        'qr_code_path',
        'account_number',
        'account_name',
        'instructions',
        'is_active',
        'requires_verification',
        'sort_order',
        'extra_charge',
        'extra_charge_type',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_verification' => 'boolean',
        'extra_charge' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    /**
     * Scope to get only active payment methods
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Get formatted extra charge
     */
    public function getFormattedExtraChargeAttribute()
    {
        if ($this->extra_charge <= 0) {
            return 'Free';
        }

        if ($this->extra_charge_type === 'percentage') {
            return $this->extra_charge . '%';
        }

        return 'Rs ' . number_format($this->extra_charge, 2);
    }
}
