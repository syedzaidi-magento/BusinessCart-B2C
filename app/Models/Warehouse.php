<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = ['name', 'street', 'city', 'state', 'zip', 'country', 'contact_details'];

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }

    public function inventories()
    {
        // Cross-database relationship to sqlite_products
        return $this->hasMany(Inventory::class, 'warehouse_id');
    }
}
