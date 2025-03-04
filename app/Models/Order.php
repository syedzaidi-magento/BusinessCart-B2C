<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'store_id', 'customer_id', 'status', 'total', 'custom_attributes',
        'placed_at', 'completed_at', 'cancelled_at', 'refunded_at', 'archived_at'
    ];
    protected $casts = [
        'custom_attributes' => 'array',
    ];
    protected $dates = [
        'placed_at', 'completed_at', 'cancelled_at', 'refunded_at', 'archived_at', 'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}