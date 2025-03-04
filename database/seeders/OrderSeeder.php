<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'user_id' => 2, // Customer One
                'status' => 'pending',
                'total' => 19.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'user_id' => 2, // Customer One
                'status' => 'completed',
                'total' => 59.99,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
            ],
            [
                'store_id' => config('app.enable_multi_store') ? 2 : null,
                'user_id' => 3, // Customer Two
                'status' => 'pending',
                'total' => 5.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
