<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Corte de cabello',
            'description' => 'Corte básico para caballero con acabado profesional',
            'duration_minutes' => 30,
            'price' => 15000,
        ]);

        Service::create([
            'name' => 'Corte + barba',
            'description' => 'Incluye perfilado de barba y corte moderno',
            'duration_minutes' => 45,
            'price' => 25000,
        ]);

        Service::create([
            'name' => 'Barba completa',
            'description' => 'Diseño, perfilado y arreglo completo de barba',
            'duration_minutes' => 25,
            'price' => 12000,
        ]);

        Service::create([
            'name' => 'Corte premium',
            'description' => 'Corte personalizado con asesoría de estilo',
            'duration_minutes' => 60,
            'price' => 30000,
        ]);
    }
}
