<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    // Specify the table name (optional if it matches the model name pluralized)
    protected $table = 'configurations';

    // Define fillable fields for mass assignment
    protected $fillable = ['store_id', 'group', 'key', 'value', 'type', 'description'];

    // Define the type of the value field
    protected $casts = [
        'value' => 'array', // Casts JSON to array
    ];

    // Accessor to cast the value based on type
    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case 'integer':
                return (int) $value;
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }
}
