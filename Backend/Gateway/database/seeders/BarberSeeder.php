<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barber;

class BarberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barber::create([
            'user_id' => 2,
            'specialty' => 'Corte clásico y degradados',
            'experience_years' => 5,
        ]);
        Barber::create([
            'user_id' => 3,
            'specialty' => 'Barbas y diseño moderno',
            'experience_years' => 3,
        ]);
    }
}
