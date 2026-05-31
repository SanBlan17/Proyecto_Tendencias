<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppoinmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::create([
            'user_id' => 4,
            'barber_id' => 1,
            'service_id' => 1,
            'appointment_date' => '2026-06-15',
            'start_time' => '09:00:00',
            'end_time' => '09:30:00',
            'status' => 'CONFIRMED',
            'notes' => 'Cliente frecuente'
        ]);

        Appointment::create([
            'user_id' => 4,
            'barber_id' => 1,
            'service_id' => 2,
            'appointment_date' => '2026-06-15',
            'start_time' => '10:00:00',
            'end_time' => '10:45:00',
            'status' => 'PENDING',
            'notes' => null
        ]);

        Appointment::create([
            'user_id' => 4,
            'barber_id' => 2,
            'service_id' => 1,
            'appointment_date' => '2026-06-16',
            'start_time' => '14:00:00',
            'end_time' => '14:30:00',
            'status' => 'COMPLETED',
            'notes' => 'Primera visita'
        ]);

        Appointment::create([
            'user_id' => 4,
            'barber_id' => 2,
            'service_id' => 3,
            'appointment_date' => '2026-06-17',
            'start_time' => '16:00:00',
            'end_time' => '17:00:00',
            'status' => 'CANCELLED',
            'notes' => 'Cancelada por el cliente'
        ]);
    }
}
