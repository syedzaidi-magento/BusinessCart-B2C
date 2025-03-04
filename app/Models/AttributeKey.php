<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeKey extends Model
{
    protected $fillable = ['model_type', 'key_name', 'data_type', 'is_required'];
}