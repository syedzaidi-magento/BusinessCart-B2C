<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        DB::table('inventories')->insert([
            [
                'product_id' => 1,
                'quantity' => 100,
                'warehouse_id' => 1,
                'shelf_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'quantity' => 50,
                'warehouse_id' => 1,
                'shelf_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'quantity' => 75,
                'warehouse_id' => 1,
                'shelf_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'quantity' => 200,
                'warehouse_id' => 1,
                'shelf_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
