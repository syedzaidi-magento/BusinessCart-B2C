<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateShelvesTable extends Migration
{
    public function up()
    {
        Schema::create('shelves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('warehouse_id');
            $table->string('shelf_name');
            $table->timestamps();

            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
        });

        DB::table('shelves')->insert([
            ['warehouse_id' => 1, 'shelf_name' => 'Default-Shelf-AAA'],
            ['warehouse_id' => 1, 'shelf_name' => 'Default-Shelf-BBB'],
            ['warehouse_id' => 1, 'shelf_name' => 'Default-Shelf-CCC'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('shelves');
    }
}
