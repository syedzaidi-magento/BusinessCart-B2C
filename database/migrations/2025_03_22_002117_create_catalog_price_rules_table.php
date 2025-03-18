<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCatalogPriceRulesTable extends Migration
{
    public function up()
    {
        Schema::create('catalog_price_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('discount_percentage', 5, 2)->nullable(); // e.g., 10.00 for 10% off
            $table->decimal('discount_amount', 8, 2)->nullable(); // e.g., 5.00 for $5 off
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('catalog_price_rule_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catalog_price_rule_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            $table->foreign('catalog_price_rule_id')->references('id')->on('catalog_price_rules')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        // Insert default catalog price rule
        DB::table('catalog_price_rules')->insert([
            'name' => 'Default 30% Off Sale',
            'discount_percentage' => 30.00, // 30% off
            'discount_amount' => null,      // No fixed amount discount
            'start_date' => now(),          // Starts immediately
            'end_date' => now()->addMonth(), // Ends in 1 month
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Optional: Associate with all existing products (uncomment if desired)
        $ruleId = DB::table('catalog_price_rules')->first()->id;
        $productIds = DB::table('products')->pluck('id')->toArray();
        
        $pivotData = array_map(function ($productId) use ($ruleId) {
            return [
                'catalog_price_rule_id' => $ruleId,
                'product_id' => $productId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $productIds);

        if (!empty($pivotData)) {
            DB::table('catalog_price_rule_products')->insert($pivotData);
        }

    }

    public function down()
    {
        Schema::dropIfExists('catalog_price_rule_products');
        Schema::dropIfExists('catalog_price_rules');
    }
}