<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    protected $fillable = ['warehouse_id', 'shelf_name'];

    public function warehouse()
    {
        // Cross-database relationship to sqlite
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
