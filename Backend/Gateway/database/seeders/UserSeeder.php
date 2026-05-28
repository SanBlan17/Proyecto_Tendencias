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
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'password' => Hash::make('password123'),
            'phone' => '3001234567',
            'role_id' => 1,
        ]);

        User::create([
            'name' => 'María Gómez',
            'email' => 'maria@example.com',
            'password' => Hash::make('password123'),
            'phone' => '3019876543',
            'role_id' => 2,
        ]);

        User::create([
            'name' => 'Carlos Ruiz',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password123'),
            'phone' => '3105551122',
            'role_id' => 2,
        ]);
    }
}
