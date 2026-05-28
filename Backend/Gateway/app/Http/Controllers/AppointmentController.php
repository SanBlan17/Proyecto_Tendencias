<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class AppointmentController extends Controller
{
    /**
     * Obtener todas las citas
     */
    public function index(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $request->bearerToken(),
                'Content-Type' => 'application/json'
            ])->get(config('services.appointment_service_url') . '/api/appointments');

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch appointments'
                ], $response->status());
            }

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva cita
     */
    public function store(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $request->bearerToken(),
                'Content-Type' => 'application/json'
            ])->post(config('services.appointment_service_url') . '/api/appointments', $request->all());

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create appointment'
                ], $response->status());
            }

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener una cita específica
     */
    public function show(Request $request, $id)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $request->bearerToken(),
                'Content-Type' => 'application/json'
            ])->get(config('services.appointment_service_url') . '/api/appointments/' . $id);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment not found'
                ], $response->status());
            }

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar una cita
     */
    public function update(Request $request, $id)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $request->bearerToken(),
                'Content-Type' => 'application/json'
            ])->put(config('services.appointment_service_url') . '/api/appointments/' . $id, $request->all());

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update appointment'
                ], $response->status());
            }

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una cita
     */
    public function destroy(Request $request, $id)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $request->bearerToken(),
                'Content-Type' => 'application/json'
            ])->delete(config('services.appointment_service_url') . '/api/appointments/' . $id);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete appointment'
                ], $response->status());
            }

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
