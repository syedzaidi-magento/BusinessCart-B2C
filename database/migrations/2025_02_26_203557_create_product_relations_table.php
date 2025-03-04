<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('related_product_id')->constrained('products')->onDelete('cascade');
            $table->integer('position')->default(0); // Order of related products
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_relations');
    }
};
