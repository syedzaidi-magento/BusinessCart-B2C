<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = ['store_id', 'group', 'key', 'value'];

    // Predefined configuration keys
    protected static $predefinedKeys = [
        'customer_group_wholesale_discount' => [
        'group' => 'customer',
        'type' => 'decimal',
        'default' => 0.20,
        'description' => 'Discount percentage for Wholesale customer group',
        ],
        'customer_group_retailer_discount' => [
            'group' => 'customer',
            'type' => 'decimal',
            'default' => 0.10,
            'description' => 'Discount percentage for Retailer customer group',
        ],
        'shipping_method_free_enable' => [
            'group' => 'shipping',
            'type' => 'boolean',
            'default' => false,
            'description' => 'Enable free shipping method',
        ],
        'shipping_method_free_label' => [
            'group' => 'shipping',
            'type' => 'string',
            'default' => 'Free Shipping',
            'description' => 'Label for free shipping method',
        ],
        'shipping_method_free_minimum' => [
            'group' => 'shipping',
            'type' => 'decimal',
            'default' => 50.00,
            'description' => 'Minimum order amount for free shipping',
        ],
        'shipping_method_flat_rate_enable' => [
            'group' => 'shipping',
            'type' => 'boolean',
            'default' => true,
            'description' => 'Enable flat rate shipping method',
        ],
        'shipping_method_flat_rate_label' => [
            'group' => 'shipping',
            'type' => 'string',
            'default' => 'Flat Rate',
            'description' => 'Label for flat rate shipping method',
        ],
        'shipping_method_flat_rate_amount' => [
            'group' => 'shipping',
            'type' => 'decimal',
            'default' => 5.99,
            'description' => 'Flat rate shipping amount',
        ],
        'payment_method_amazon_enable' => [
            'group' => 'payment',
            'type' => 'boolean',
            'default' => false,
            'description' => 'Enable Amazon Pay',
        ],
        'payment_method_amazon_label' => [
            'group' => 'payment',
            'type' => 'string',
            'default' => 'Amazon Pay',
            'description' => 'Label for Amazon Pay',
        ],
        'payment_method_amazon_merchant_id' => [
            'group' => 'payment',
            'type' => 'string',
            'default' => '',
            'description' => 'Amazon Pay Merchant ID',
        ],
        'payment_method_amazon_access_key' => [
            'group' => 'payment',
            'type' => 'string',
            'default' => '',
            'description' => 'Amazon Pay Access Key',
        ],
        'payment_method_amazon_secret_key' => [
            'group' => 'payment',
            'type' => 'string',
            'default' => '',
            'description' => 'Amazon Pay Secret Key',
        ],
        'payment_method_google_enable' => [
            'group' => 'payment',
            'type' => 'boolean',
            'default' => false,
            'description' => 'Enable Google Pay',
        ],
        'payment_method_google_label' => [
            'group' => 'payment',
            'type' => 'string',
            'default' => 'Google Pay',
            'description' => 'Label for Google Pay',
        ],
        'payment_method_stripe_enable' => [
        'group' => 'payment',
        'type' => 'boolean',
        'default' => false,
        'description' => 'Enable Stripe Payment',
        ],
        'payment_method_stripe_label' => [
            'group' => 'payment',
            'type' => 'string',
            'default' => 'Credit/Debit Card (Stripe)',
            'description' => 'Label for Stripe Payment',
        ],
        'payment_method_stripe_publishable_key' => [
            'group' => 'payment',
            'type' => 'string',
            'default' => '',
            'description' => 'Stripe Publishable Key',
        ],
        'payment_method_stripe_secret_key' => [
            'group' => 'payment',
            'type' => 'string',
            'default' => '',
            'description' => 'Stripe Secret Key',
        ],
        'payment_method_po_enable' => [
            'group' => 'payment',
            'type' => 'boolean',
            'default' => false,
            'description' => 'Enable Purchase Order Payment',
        ],
        'payment_method_po_label' => [
            'group' => 'payment',
            'type' => 'string',
            'default' => 'Purchase Order',
            'description' => 'Label for Purchase Order Payment',
        ],
        'tax_rate' => [
            'group' => 'tax',
            'type' => 'decimal',
            'default' => 0.08,
            'description' => 'Tax rate applied to subtotal',
        ],
    ];

    // Helper methods for predefined keys
    public static function getPredefinedKeys()
    {
        return array_keys(self::$predefinedKeys);
    }

    public static function getDefinition($key)
    {
        return self::$predefinedKeys[$key] ?? null;
    }

    public static function getDefault($key)
    {
        return self::$predefinedKeys[$key]['default'] ?? null;
    }

    public static function getType($key)
    {
        return self::$predefinedKeys[$key]['type'] ?? 'string';
    }

    // Accessor for value casting
    public function getValueAttribute($value)
    {
        $type = self::getType($this->key);
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'decimal':
                return (float) $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    // Retrieve config value with fallback
    public static function getConfigValue($key, $storeId = null)
    {
        if (!in_array($key, self::getPredefinedKeys())) {
            return self::getDefault($key); // Fallback to default if key is invalid
        }

        $config = self::where('key', $key)
            ->where('store_id', $storeId)
            ->first();

        if (!$config && $storeId) {
            $config = self::where('key', $key)
                ->whereNull('store_id')
                ->first();
        }

        return $config ? $config->value : self::getDefault($key);
    }

    // Override create/update to enforce predefined keys
    public static function create(array $attributes = [])
    {
        if (!isset($attributes['key']) || !in_array($attributes['key'], self::getPredefinedKeys())) {
            throw new \Exception("Invalid configuration key: {$attributes['key']}");
        }
        return parent::create($attributes);
    }

    public function update(array $attributes = [], array $options = [])
    {
        if (isset($attributes['key']) && !in_array($attributes['key'], self::getPredefinedKeys())) {
            throw new \Exception("Cannot update to invalid configuration key: {$attributes['key']}");
        }
        return parent::update($attributes, $options);
    }
}