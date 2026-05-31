<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\Service;

class AppoinmentSeeder extends Seeder
{

   

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service_1 = Service::find(1);

        $startTime_1 = Carbon::createFromFormat('H:i:s', '09:00:00');

        $endTime_1 = $startTime_1
            ->copy()
            ->addMinutes($service_1->duration_minutes);

        $service_2 = Service::find(2);

        $startTime_2 = Carbon::createFromFormat('H:i:s', '10:00:00');
        $endTime_2 = $startTime_2
            ->copy()
            ->addMinutes($service_2->duration_minutes);

        Appointment::create([
            'user_id' => 4,
            'barber_id' => 1,
            'service_id' => 1,
            'appointment_date' => '2026-06-15',
            'start_time' => $startTime_1->format('H:i:s'),
            'end_time' => $endTime_1->format('H:i:s'),
            'status' => 'CONFIRMED',
            'notes' => 'Cliente frecuente'
        ]);

        Appointment::create([
            'user_id' => 4,
            'barber_id' => 1,
            'service_id' => 2,
            'appointment_date' => '2026-06-15',
            'start_time' => $startTime_2->format('H:i:s'),
            'end_time' => $endTime_2->format('H:i:s'),
            'status' => 'PENDING',
            'notes' => null
        ]);

        Appointment::create([
            'user_id' => 4,
            'barber_id' => 2,
            'service_id' => 1,
            'appointment_date' => '2026-06-16',
            'start_time' => $startTime_1->format('H:i:s'),
            'end_time' => $endTime_1->format('H:i:s'),
            'status' => 'COMPLETED',
            'notes' => 'Primera visita'
        ]);

        Appointment::create([
            'user_id' => 4,
            'barber_id' => 2,
            'service_id' => 2,
            'appointment_date' => '2026-06-17',
            'start_time' => $startTime_2->format('H:i:s'),
            'end_time' => $endTime_2->format('H:i:s'),
            'status' => 'CANCELLED',
            'notes' => 'Cancelada por el cliente'
        ]);
    }
}
