<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['customer_id', 'store_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
