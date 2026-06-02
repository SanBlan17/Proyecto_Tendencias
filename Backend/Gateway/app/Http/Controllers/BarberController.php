<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use Illuminate\Http\Request;

class BarberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barbers = Barber::with('user')->get();

        return response()->json($barbers);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Barber $barber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barber $barber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barber = Barber::find($id);

        if (!$barber) {
            return response()->json([
                'message' => 'Barbero no encontrado'
            ], 404);
        }

        $barber->update([
            'specialty' => $request->specialty,
            'experience_years' => $request->experience_years
        ]);

        return response()->json([
            'message' => 'Barbero actualizado correctamente',
            'barber' => $barber
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barber $barber)
    {
        //
    }
}
