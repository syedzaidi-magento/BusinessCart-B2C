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
        $configs = [];
        foreach (Configuration::getPredefinedKeys() as $key) {
            $definition = Configuration::getDefinition($key);
            $value = Configuration::getDefault($key);
            if ($definition['type'] === 'json' || is_array($value)) {
                $value = json_encode($value);
            }
            $configs[] = [
                'store_id' => null,
                'group' => $definition['group'],
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        Configuration::insert($configs);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    }
}
