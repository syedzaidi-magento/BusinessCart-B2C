<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['store_id', 'name', 'sku', 'type', 'price', 'quantity', 'description', 'custom_attributes', 'featured'];
    protected $casts = [
        'custom_attributes' => 'array',
    ];

    public const TYPES = ['simple', 'configurable', 'grouped', 'bundle'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'product_relations', 'parent_product_id', 'related_product_id')
                    ->withPivot('position');
    }

    public function attributeKeys()
    {
        return AttributeKey::where('model_type', 'Product')->get();
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id'); // Define the relationship
    }

    public function isInStock()
    {
        if ($this->type === 'grouped' || $this->type === 'bundle') {
            return $this->relatedProducts->sum(fn($related) => $related->inventory ? $related->inventory->quantity : 0) > 0;
        }
        if ($this->type === 'configurable') {
            return $this->variations->sum('quantity') > 0;
        }
        return $this->inventory ? $this->inventory->quantity > 0 : false; // Use inventory relationship
    }

    // New relationship
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function catalogPriceRules()
    {
        return $this->belongsToMany(CatalogPriceRule::class, 'catalog_price_rule_products');
    }

    public function tieredPricing()
    {
        return $this->hasMany(TieredPricing::class);
    }

    public function getEffectivePrice($quantity = 1)
    {
        $price = $this->price;
    
        $tier = $this->tieredPricing()->where('min_quantity', '<=', $quantity)->orderBy('min_quantity', 'desc')->first();
        if ($tier) {
            $price = $tier->price;
        }
    
        \Log::debug("Product {$this->id} base price: $price, rules count: " . $this->catalogPriceRules->count());
        foreach ($this->catalogPriceRules as $rule) {
            $originalPrice = $price;
            $price = $rule->applyDiscount($price);
            \Log::debug("Rule {$rule->id} applied to Product {$this->id}: Original $originalPrice -> Discounted $price");
        }
    
        return $price;
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }
}