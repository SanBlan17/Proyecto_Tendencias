<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
    public function getAvailableSlots(Request $request, $barberId)
    {
        $date = $request->date;
        $serviceId = $request->service_id;

        $schedule = Schedule::where('barber_id', $barberId)->where('work_date', $date)->first();

        if (!$schedule) {
            return response()->json([
                'message' => 'El barbero no trabaja ese día'
            ], 404);
        }

        $service = Service::find($serviceId);

        if (!$service) {
            return response()->json([
                'message' => 'Servicio no encontrado'
            ], 404);
        }

        $duration = $service->duration_minutes;

        $slots = [];

        $current = Carbon::parse($schedule->start_time);

        $endSchedule = Carbon::parse($schedule->end_time);

        while (
            $current->copy()
                ->addMinutes($duration)
                ->lte($endSchedule)
        ) {

            $slots[] = $current->format('H:i');

            $current->addMinutes($duration);
        }

        $appointments = Appointment::where('barber_id', $barberId)->where('appointment_date', $date)->whereIn('status',['PENDING','CONFIRMED'])->get();
        $availableSlots = [];
        foreach ($slots as $slot) {

            $slotStart = Carbon::parse($slot);

            $slotEnd = $slotStart
                ->copy()
                ->addMinutes($duration);

            $occupied = false;

            foreach ($appointments as $appointment) {

                $appointmentStart = Carbon::parse(
                    $appointment->start_time
                );

                $appointmentEnd = Carbon::parse(
                    $appointment->end_time
                );

                if (
                    $slotStart < $appointmentEnd &&
                    $slotEnd > $appointmentStart
                ) {
                    $occupied = true;
                    break;
                }
            }

            if (!$occupied) {
                $availableSlots[] = $slot;
            }
        }

        return response()->json([
            'barber_id' => $barberId,
            'date' => $date,
            'service_id' => $serviceId,
            'available_slots' => $availableSlots
        ]);
    }
}
