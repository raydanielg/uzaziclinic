<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'quantity',
        'price',
        'expiry_date',
        'status',
        'description',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'price' => 'decimal:2',
    ];

    /**
     * Check if medicine is low stock
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= 10;
    }

    /**
     * Check if medicine is expired
     */
    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        if ($this->isExpired()) {
            return 'bg-danger-subtle text-danger';
        }
        if ($this->isLowStock()) {
            return 'bg-warning-subtle text-warning';
        }
        return 'bg-success-subtle text-success';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        if ($this->isExpired()) {
            return 'Expired';
        }
        if ($this->isLowStock()) {
            return 'Low Stock';
        }
        return 'In Stock';
    }
}
