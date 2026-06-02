<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exists = Schedule::where('barber_id', $request->barber_id)
            ->where('work_date', $request->work_date)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Ya existe un horario para esta fecha'
            ], 409);
        }

        $schedule = Schedule::create([
            'barber_id' => $request->barber_id,
            'work_date' => $request->work_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_available' => true
        ]);

        return response()->json([
            'message' => 'Horario creado correctamente',
            'schedule' => $schedule
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
    }

    public function getScheduleByDate($barberId, $date)
    {
        $schedule = Schedule::where('barber_id', $barberId)
            ->where('work_date', $date)
            ->first();

        if (!$schedule) {
            return response()->json([
                'message' => 'El barbero no tiene horario para esa fecha'
            ], 404);
        }

        return response()->json($schedule);
    }
}
