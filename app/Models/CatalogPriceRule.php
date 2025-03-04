<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogPriceRule extends Model
{
    protected $fillable = ['name', 'discount_percentage', 'discount_amount', 'start_date', 'end_date', 'is_active'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'catalog_price_rule_products');
    }

    public function applyDiscount($price)
    {
        if (!$this->is_active || ($this->start_date && now()->lt($this->start_date)) || ($this->end_date && now()->gt($this->end_date))) {
            return $price;
        }

        if ($this->discount_percentage) {
            return $price * (1 - $this->discount_percentage / 100);
        } elseif ($this->discount_amount) {
            return max(0, $price - $this->discount_amount);
        }

        return $price;
    }
}