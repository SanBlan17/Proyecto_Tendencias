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
        // Crear usuarios de prueba en el Gateway
        User::create([
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'email' => 'juan@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+34 600 123 456',
            'is_active' => true
        ]);

        User::create([
            'first_name' => 'María',
            'last_name' => 'García',
            'email' => 'maria@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+34 600 234 567',
            'is_active' => true
        ]);

        User::create([
            'first_name' => 'Carlos',
            'last_name' => 'López',
            'email' => 'carlos@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+34 600 345 678',
            'is_active' => true
        ]);

        User::create([
            'first_name' => 'Ana',
            'last_name' => 'Martínez',
            'email' => 'ana@example.com',
            'password' => Hash::make('password123'),
            'phone' => '+34 600 456 789',
            'is_active' => true
        ]);

        $this->command->info('Gateway users seeded successfully!');
    }
}
