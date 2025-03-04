<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image_path', 'disk', 'position', 'is_main', 'alt_text'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute()
    {
        $disk = trim($this->disk, '"'); // Remove quotes if present
        if ($disk === 'local') {
            return Storage::disk('public')->url($this->image_path);
        } elseif ($disk === 's3') {
            return Storage::disk('s3')->url($this->image_path);
        }
        return asset('images/default-product.png');
    }
}