<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariation;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'type' => 'simple',
                'name' => 'T-Shirt',
                'sku' => 'TS-001',
                'description' => 'A comfortable cotton T-shirt.',
                'price' => 19.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'type' => 'configurable',
                'name' => 'Custom Sneakers',
                'sku' => 'SNEAK-001',
                'description' => 'Sneakers with customizable colors.',
                'price' => 59.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 2 : null,
                'type' => 'simple',
                'name' => 'Notebook',
                'sku' => 'NB-001',
                'description' => 'A lined notebook for writing.',
                'price' => 5.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $productsVariations = [
            ['store_id' => config('app.enable_multi_store') ? 1 : null, 'type' => 'simple', 'name' => 'T-Shirt 2', 'sku' => 'tshirt-2', 'description' => 'A comfortable cotton T-shirt.', 'price' => 19.99],
            ['store_id' => config('app.enable_multi_store') ? 1 : null, 'type' => 'configurable', 'name' => 'Custom Sneakers', 'sku' => 'sneakers-2', 'description' => 'Sneakers with customizable colors.', 'price' => 59.99],
            ['store_id' => config('app.enable_multi_store') ? 2 : null, 'type' => 'simple', 'name' => 'Notebook', 'sku' => 'notebook-2', 'description' => 'A lined notebook for writing.', 'price' => 5.99],
        ];
    
        foreach ($productsVariations as $data) {
            $product = Product::create($data + ['created_at' => now(), 'updated_at' => now()]);
            if ($product->type === 'configurable') {
                ProductVariation::insert([
                    ['product_id' => $product->id, 'attribute' => 'color', 'value' => 'Red', 'price_adjustment' => 5.00, 'created_at' => now(), 'updated_at' => now()],
                    ['product_id' => $product->id, 'attribute' => 'color', 'value' => 'Blue', 'price_adjustment' => 0.00, 'created_at' => now(), 'updated_at' => now()],
                ]);
            }
        }

    }
}
