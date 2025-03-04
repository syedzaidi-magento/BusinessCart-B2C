<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTieredPricingTable extends Migration
{
    public function up()
    {
        Schema::create('tiered_pricings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('min_quantity'); // e.g., Buy 5+
            $table->decimal('price', 8, 2); // Special price for this tier
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tiered_pricings');
    }
}