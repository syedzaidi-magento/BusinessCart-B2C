<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Shelf;

class Inventory extends Model
{
    protected $fillable = ['product_id', 'warehouse_id', 'shelf_id', 'quantity', 'custom_attributes'];

    protected $casts = [
        'custom_attributes' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        // Specify the connection for the warehouses table
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function shelf()
    {
        // Specify the connection for the shelves table
        return $this->belongsTo(Shelf::class, 'shelf_id');
    }
}
