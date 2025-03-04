<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartPriceRulesTable extends Migration
{
    public function up()
    {
        Schema::create('cart_price_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coupon_code')->nullable()->unique();
            $table->string('type'); // e.g., 'percentage', 'fixed', 'buy_x_get_y_free'
            $table->decimal('discount_value', 8, 2)->nullable(); // e.g., 10.00 for 10% or $10
            $table->integer('buy_quantity')->nullable(); // For buy X get Y free
            $table->integer('free_quantity')->nullable(); // For buy X get Y free
            $table->decimal('min_cart_total', 8, 2)->nullable(); // Minimum cart total to apply
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_price_rules');
    }
}