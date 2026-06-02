<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Service;
use Carbon\Carbon;

class AppointmentValidationService
{
    public function validate(
        int $barberId,
        string $appointmentDate,
        string $startTime,
        int $serviceId
    ): array {

        // 1. Buscar horario
        $schedule = Schedule::where('barber_id', $barberId)
            ->where('work_date', $appointmentDate)
            ->first();

        if (!$schedule) {
            return [
                'success' => false,
                'message' => 'El barbero no trabaja ese día.'
            ];
        }

        // 2. Buscar servicio
        $service = Service::find($serviceId);

        if (!$service) {
            return [
                'success' => false,
                'message' => 'Servicio no encontrado.'
            ];
        }

        $duration = $service->duration_minutes;

        $appointmentStart = Carbon::parse($startTime);

        $appointmentEnd = $appointmentStart
            ->copy()
            ->addMinutes($duration);

        $scheduleStart = Carbon::parse($schedule->start_time);

        $scheduleEnd = Carbon::parse($schedule->end_time);

        // 3. Validar inicio dentro del horario
        if ($appointmentStart->lt($scheduleStart)) {

            return [
                'success' => false,
                'message' => 'La cita inicia antes del horario laboral.'
            ];
        }

        // 4. Validar fin dentro del horario
        if ($appointmentEnd->gt($scheduleEnd)) {

            return [
                'success' => false,
                'message' => 'La cita termina fuera del horario laboral.'
            ];
        }

        // 5. Buscar citas existentes
        $appointments = Appointment::where(
                'barber_id',
                $barberId
            )
            ->where(
                'appointment_date',
                $appointmentDate
            )
            ->whereIn('status', [
                'PENDING',
                'CONFIRMED'
            ])
            ->get();

        foreach ($appointments as $appointment) {

            $existingStart = Carbon::parse(
                $appointment->start_time
            );

            $existingEnd = Carbon::parse(
                $appointment->end_time
            );

            if (
                $appointmentStart < $existingEnd &&
                $appointmentEnd > $existingStart
            ) {

                return [
                    'success' => false,
                    'message' => 'Ya existe una cita en ese horario.'
                ];
            }
        }

        return [
            'success' => true,
            'end_time' => $appointmentEnd->format('H:i:s')
        ];
    }
}