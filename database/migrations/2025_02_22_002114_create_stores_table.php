<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStoresTable extends Migration
{
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        DB::table('stores')->insert([
            'name' => 'Default Store',
            'description' => 'The default store for your eCommerce.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
    }

    public function down()
    {
        Schema::dropIfExists('stores');
        
    }
}