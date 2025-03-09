<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->string('group');
            $table->string('key');
            $table->text('value');
            $table->timestamps();

            $table->unique(['store_id', 'group', 'key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
