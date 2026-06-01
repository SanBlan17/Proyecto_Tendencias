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

    public function storeClient(Request $request)
    {
        
        try {

            $appointment = Appointment::create([
                'user_id' => $request->user_id,
                'barber_id' => $request->barber_id,
                'service_id' => $request->service_id,
                'appointment_date' => $request->appointment_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            return response()->json([
                'message' => 'Cita creada correctamente',
                'appointment' => $appointment
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);

        }
    }

    public function cancelClient($id, $userId)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$appointment) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        if ($appointment->status !== 'PENDING') {
            return response()->json([
                'message' => 'No puedes cancelar una cita ya procesada'
            ], 400);
        }

        $appointment->update([
            'status' => 'CANCELLED'
        ]);

        return response()->json([
            'message' => 'Cita cancelada correctamente',
            'appointment' => $appointment
        ]);
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();
        return response()->json(['message' => 'Cita eliminada']);
    }

    public function confirmBarber($barberId, $appointmentId)
    {
        $appointment = Appointment::where('id', $appointmentId)->where('barber_id', $barberId)->first();

        if (!$appointment) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $appointment->update([
            'status' => 'CONFIRMED'
        ]);

        return response()->json([
            'message' => 'Cita confirmada correctamente',
            'appointment' => $appointment
        ]);
    }

}
