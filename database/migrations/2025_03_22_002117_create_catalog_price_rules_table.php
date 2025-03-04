<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
    }

    public function down()
    {
        Schema::dropIfExists('catalog_price_rule_products');
        Schema::dropIfExists('catalog_price_rules');
    }
}