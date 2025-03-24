<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attribute_keys', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->string('key_name');
            $table->string('data_type');
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });

        DB::table('attribute_keys')->insert([
            ['model_type' => 'Product', 'key_name' => 'color', 'data_type' => 'string', 'is_required' => false],
            ['model_type' => 'Product', 'key_name' => 'size', 'data_type' => 'string', 'is_required' => false],
            ['model_type' => 'Product', 'key_name' => 'weight', 'data_type' => 'string', 'is_required' => false],
            ['model_type' => 'Product', 'key_name' => 'height', 'data_type' => 'string', 'is_required' => false],
            ['model_type' => 'Product', 'key_name' => 'width', 'data_type' => 'string', 'is_required' => false],
            ['model_type' => 'Product', 'key_name' => 'length', 'data_type' => 'string', 'is_required' => false],
            ['model_type' => 'Product', 'key_name' => 'material', 'data_type' => 'string', 'is_required' => false],
            ['model_type' => 'Product', 'key_name' => 'brand', 'data_type' => 'string', 'is_required' => false],
            ['model_type' => 'Product', 'key_name' => 'model', 'data_type' => 'string', 'is_required' => false],
            ['model_type' => 'Product', 'key_name' => 'upc', 'data_type' => 'string', 'is_required' => false],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_keys');
    }
};
