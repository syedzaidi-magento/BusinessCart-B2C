<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuration;
use Database\Seeders\ProductSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\StoreSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StoreSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
        
        // Seed configurations
        $configs = [
            [
                'store_id' => null, // Global config
                'group' => 'branding',
                'key' => 'primary_color',
                'value' => '#008080', // Teal
                'type' => 'string',
                'description' => 'Primary brand color in hex format',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => null, // Global config
                'group' => 'branding',
                'key' => 'logo_svg',
                'value' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0 0v-4m0 4h4m-4 0H8"/></svg>',
                'type' => 'string',
                'description' => 'SVG code for the admin logo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'group' => 'shipping',
                'key' => 'type',
                'value' => 'flat',
                'type' => 'string',
                'description' => 'Shipping method type',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'group' => 'shipping',
                'key' => 'flat_rate',
                'value' => '5.99',
                'type' => 'decimal',
                'description' => 'Flat shipping rate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 2 : null,
                'group' => 'shipping',
                'key' => 'type',
                'value' => 'free',
                'type' => 'string',
                'description' => 'Shipping method type',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 2 : null,
                'group' => 'shipping',
                'key' => 'free_shipping_minimum',
                'value' => '50.00',
                'type' => 'decimal',
                'description' => 'Minimum order for free shipping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Payment configs
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'group' => 'payment',
                'key' => 'methods',
                'value' => json_encode(['amazon_pay', 'google_pay']),
                'type' => 'json',
                'description' => 'Enabled payment methods',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'group' => 'payment',
                'key' => 'amazon_pay_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable Amazon Pay',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'group' => 'payment',
                'key' => 'google_pay_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable Google Pay',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // New tax configs
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'group' => 'tax',
                'key' => 'rate',
                'value' => '0.10', // 10% tax rate
                'type' => 'decimal',
                'description' => 'Tax rate applied to subtotal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 2 : null,
                'group' => 'tax',
                'key' => 'rate',
                'value' => '0.08', // 8% tax rate
                'type' => 'decimal',
                'description' => 'Tax rate applied to subtotal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // New storage config
            [
                'store_id' => null, // Global config
                'group' => 'storage',
                'key' => 'driver',
                'value' => 'local', // Default to local storage
                'type' => 'string',
                'description' => 'Storage driver for product images (local or s3)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($configs as $config) {
            Configuration::updateOrCreate(
                ['store_id' => $config['store_id'], 'group' => $config['group'], 'key' => $config['key']],
                $config
            );
        }

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    }
}
