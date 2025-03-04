<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('image_path');
            $table->string('disk'); // 'local' or 's3'
            $table->integer('position')->default(0);
            $table->boolean('is_main')->default(false);
            $table->string('alt_text')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index('product_id'); // For performance
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
}