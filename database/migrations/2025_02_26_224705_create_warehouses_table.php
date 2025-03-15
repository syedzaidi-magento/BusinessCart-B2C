<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWarehousesTable extends Migration
{
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('street');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip');
            $table->string('country');
            $table->text('contact_details')->nullable();
            $table->timestamps();
        });

        DB::table('warehouses')->insert([
            [
                'name' => 'Default Warehouse',
                'street' => '123 Main St',
                'city' => 'Anytown',
                'state' => 'CA',
                'zip' => '12345',
                'country' => 'US',
                'contact_details' => 'Phone: 123-456-7890',
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
