<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentsController extends Controller
{
    public function indexClient($userId)
    {
        return Appointment::where('user_id', $userId)->get();
    }

    public function indexBarber($barberId)
    {
        return Appointment::where('barber_id', $barberId)->get();
    }

    public function indexAdmin()
    {
        return Appointment::all();
    }

    public function storeClient(Request $request, $userId)
    {
        $appointment = Appointment::create([
            'user_id' => $userId,
            'barber_id' => $request->barber_id,
            'service_id' => $request->service_id,
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Cita creada correctamente',
            'appointment' => $appointment
        ]);
    }

    public function cancelClient($id, $userId)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$appointment) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        if ($appointment->status !== 'pending') {
            return response()->json([
                'message' => 'No puedes cancelar una cita ya procesada'
            ], 400);
        }

        $appointment->update([
            'status' => 'cancelled'
        ]);

        return response()->json([
            'message' => 'Cita cancelada correctamente',
            'appointment' => $appointment
        ]);
    }
}
