<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $fillable = ['name', 'code', 'is_default'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}