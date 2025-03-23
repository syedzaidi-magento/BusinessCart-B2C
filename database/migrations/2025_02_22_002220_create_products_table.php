<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable(); // Nullable for single-store mode
            $table->enum('type', ['simple', 'configurable', 'grouped', 'bundle']);
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0)->nullable();
            $table->json('custom_attributes')->nullable()->after('description');
            $table->boolean('featured')->default(false);
            
            $table->timestamps();
        });

        // Insert some sample products
        DB::table('products')->insert([
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'type' => 'simple',
                'name' => 'Product One',
                'sku' => 'PROD-001',
                'description' => 'This is a simple product.',
                'short_description' => 'This is a short description for the product.',
                'price' => 19.99,
                'quantity' => 100,
                'featured' => true, // Set featured for the sample product
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'type' => 'simple',
                'name' => 'Product Two',
                'sku' => 'PROD-002',
                'description' => 'This is another simple product.',
                'short_description' => 'This is a short description for the product.',
                'price' => 29.99,
                'quantity' => 0,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'type' => 'simple',
                'name' => 'Product Three',
                'sku' => 'PROD-003',
                'description' => 'This is a third simple product.',
                'short_description' => 'This is a short description for the product.',
                'price' => 39.99,
                'quantity' => 75,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'type' => 'simple',
                'name' => 'Product Four',
                'sku' => 'PROD-004',
                'description' => 'This is a fourth simple product.',
                'short_description' => 'This is a short description for the product.',
                'price' => 49.99,
                'quantity' => 25,
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
