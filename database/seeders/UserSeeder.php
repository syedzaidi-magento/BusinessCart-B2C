<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'is_admin' => true,
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer One',
                'email' => 'customer1@example.com',
                'password' => Hash::make('password123'),
                'store_id' => config('app.enable_multi_store') ? 1 : null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer Two',
                'email' => 'customer2@example.com',
                'password' => Hash::make('password123'),
                'store_id' => config('app.enable_multi_store') ? 2 : null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
