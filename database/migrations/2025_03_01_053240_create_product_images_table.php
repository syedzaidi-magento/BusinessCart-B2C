<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        // Insert default product_images data
        DB::table('product_images')->insert([
            [
                'id' => 1,
                'product_id' => 1,
                'image_path' => 'images/products/67d8fa6802c70.jpg',
                'disk' => 'local',
                'position' => 1,
                'is_main' => true,
                'alt_text' => null,
                'created_at' => '2025-03-18 04:45:28',
                'updated_at' => '2025-03-18 04:45:28',
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'image_path' => 'images/products/67d903d5c42ce.jpg',
                'disk' => 'local',
                'position' => 1,
                'is_main' => true,
                'alt_text' => null,
                'created_at' => '2025-03-18 05:25:41',
                'updated_at' => '2025-03-18 05:25:41',
            ],
            [
                'id' => 3,
                'product_id' => 3,
                'image_path' => 'images/products/67d903e5d7136.jpg',
                'disk' => 'local',
                'position' => 1,
                'is_main' => true,
                'alt_text' => null,
                'created_at' => '2025-03-18 05:25:57',
                'updated_at' => '2025-03-18 05:25:57',
            ],
            [
                'id' => 4,
                'product_id' => 4,
                'image_path' => 'images/products/67d903fb66b62.jpg',
                'disk' => 'local',
                'position' => 1,
                'is_main' => true,
                'alt_text' => null,
                'created_at' => '2025-03-18 05:26:19',
                'updated_at' => '2025-03-18 05:26:19',
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
}