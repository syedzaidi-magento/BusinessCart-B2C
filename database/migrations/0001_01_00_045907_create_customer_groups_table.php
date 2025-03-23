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
        Schema::create('customer_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique(); // e.g., 'Customer', 'Wholesale', 'Retailer'
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        DB::table('customer_groups')->insert([
            ['name' => 'Customer', 'code' => 'customer', 'is_default' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wholesale', 'code' => 'wholesale', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Retailer', 'code' => 'retailer', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_groups');
    }
};
