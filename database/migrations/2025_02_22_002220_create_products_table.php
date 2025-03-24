<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable(); // Nullable for single-store mode
            $table->enum('type', ['simple', 'configurable', 'grouped', 'bundle']);
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0)->nullable();
            $table->json('custom_attributes')->nullable()->after('description');
            $table->boolean('featured')->default(false);
            
            $table->timestamps();
        });

        // Insert some sample products
        DB::table('products')->insert([
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'type' => 'simple',
                'name' => 'uSetGo Heat Resistant Silicone Baking Gloves Gray',
                'sku' => 'PROD-001',
                'description' => 'HEAT RESISTANT KITCHEN MITTEN: Our silicone oven mitts are heat resistant up to 500°F / 260°C durable and 13inch extra long to protect your hands and forearms from burns.This oven gloves will keep your hands, wrists, and forearms safe in extreme heat conditions. WATERPROOF: silicone protects your hands from being scalded by powerful steam and also prevents gloves from getting wet. SUPER GRIP : These silicone oven mitts are flexible, breathable, non-skid, textured palm. The soft polyester-cotton lining also adds an extra protection & comfort layer. EASY TO CLEAN : 100% ultra-grade silicone is BPA-free and non-toxic, durable and safe oven mitts. uSetGo mitts are designed with anti-slip silicone on the surface. Unlike other cotton oven mitts, our silicone oven mitts are stain-resistant and easily cleanable, with just some warm water & a little soap. Or, if you’re short on time, just throw them into the washing machine. They’ll come out as new either way! EASY STORAGE : comes with hanging loops , hangs them when not in use in cabinets or pantry. WRIST AND COUNTER PROTECTION: uSetGo oven mitts are perfect potholders for better kitchen and grill use. With these pairs you can worry free by working over hot flames, ovens, stoves or grills, especially when pulling out hot pans, Lifting the steam pot lid，serving hot plates, or placing dishware on your counter safely. RISK-FREE OVEN GLOVES: We’re so confident that you will love your pairs while cooking risk-free from burns and steams. 100% SATISFACTION : with your order, please feel free to contact us directly for replacement or refund even if the Amazon return window is closed.',
                'short_description' => 'HEAT RESISTANT KITCHEN MITTEN: Our silicone oven mitts are heat resistant up to 500°F / 260°C durable and 13inch extra long to protect your hands and forearms from burns.This oven gloves will keep your hands, wrists, and forearms safe in extreme heat conditions. WATERPROOF: silicone protects your hands from being scalded by powerful steam and also prevents gloves from getting wet. SUPER GRIP : These silicone oven mitts are flexible, breathable, non-skid, textured palm. The soft polyester-cotton lining also adds an extra protection & comfort layer. EASY TO CLEAN : 100% ultra-grade silicone is BPA-free and non-toxic, durable and safe oven mitts. uSetGo mitts are designed with anti-slip silicone on the surface. Unlike other cotton oven mitts, our silicone oven mitts are stain-resistant and easily cleanable, with just some warm water & a little soap. Or, if you’re short on time, just throw them into the washing machine. They’ll come out as new either way! EASY STORAGE : comes with hanging loops , hangs them when not in use in cabinets or pantry. WRIST AND COUNTER PROTECTION: uSetGo oven mitts are perfect potholders for better kitchen and grill use. With these pairs you can worry free by working over hot flames, ovens, stoves or grills, especially when pulling out hot pans, Lifting the steam pot lid，serving hot plates, or placing dishware on your counter safely. RISK-FREE OVEN GLOVES: We’re so confident that you will love your pairs while cooking risk-free from burns and steams. 100% SATISFACTION : with your order, please feel free to contact us directly for replacement or refund even if the Amazon return window is closed.',
                'price' => 29.99,
                'quantity' => 100,
                'featured' => true, // Set featured for the sample product
                'custom_attributes' => '{"color":"Gray","size":"Large","weight":"1.2","height":"12","width":"8","length":"12","material":"Silicone","brand":"uSetGo","model":"2021","upc":"196852772346"}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'type' => 'simple',
                'name' => 'Product Two',
                'sku' => 'PROD-002',
                'description' => 'This is another simple product.',
                'short_description' => 'This is a short description for the product.',
                'price' => 29.99,
                'quantity' => 0,
                'featured' => true,
                'custom_attributes' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'type' => 'simple',
                'name' => 'Product Three',
                'sku' => 'PROD-003',
                'description' => 'This is a third simple product.',
                'short_description' => 'This is a short description for the product.',
                'price' => 39.99,
                'quantity' => 75,
                'featured' => true,
                'custom_attributes' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'type' => 'simple',
                'name' => 'Product Four',
                'sku' => 'PROD-004',
                'description' => 'This is a fourth simple product.',
                'short_description' => 'This is a short description for the product.',
                'price' => 49.99,
                'quantity' => 25,
                'featured' => true,
                'custom_attributes' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
