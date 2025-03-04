<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartPriceRule extends Model
{
    protected $fillable = ['name', 'coupon_code', 'type', 'discount_value', 'buy_quantity', 'free_quantity', 'min_cart_total', 'start_date', 'end_date', 'is_active'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function applyToCart($cartTotal, $cartItems)
    {
        if (!$this->is_active || ($this->start_date && now()->lt($this->start_date)) || ($this->end_date && now()->gt($this->end_date)) || ($this->min_cart_total && $cartTotal < $this->min_cart_total)) {
            return ['total' => $cartTotal, 'discount' => 0];
        }

        $discount = 0;
        if ($this->type === 'percentage') {
            $discount = $cartTotal * ($this->discount_value / 100);
        } elseif ($this->type === 'fixed') {
            $discount = $this->discount_value;
        } elseif ($this->type === 'buy_x_get_y_free') {
            $totalQty = array_sum($cartItems);
            if ($totalQty >= $this->buy_quantity) {
                $freeItems = floor($totalQty / $this->buy_quantity) * $this->free_quantity;
                // Simple discount logic assuming lowest-priced items are free
                $sortedPrices = array_map(fn($id) => Product::find($id)->price, array_keys($cartItems));
                sort($sortedPrices);
                $discount = array_sum(array_slice($sortedPrices, 0, min($freeItems, count($sortedPrices))));
            }
        }

        return [
            'total' => max(0, $cartTotal - $discount),
            'discount' => $discount,
        ];
    }
}