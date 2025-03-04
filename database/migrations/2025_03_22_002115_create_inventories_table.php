<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->unsignedBigInteger('warehouse_id')->after('product_id');
            $table->unsignedBigInteger('shelf_id')->after('warehouse_id');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('shelf_id')->references('id')->on('shelves')->onDelete('cascade');
            $table->index(['product_id', 'warehouse_id', 'shelf_id']);
            $table->json('custom_attributes')->nullable()->after('location');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
