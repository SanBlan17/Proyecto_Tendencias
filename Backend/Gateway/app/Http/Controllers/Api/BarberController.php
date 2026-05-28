<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class BarberController extends Controller
{
    /**
     * Obtener todos los barberos/servicios
     */
    public function index(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $request->bearerToken(),
                'Content-Type' => 'application/json'
            ])->get(config('services.barber_service_url') . '/api/barbers');

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch barbers'
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
     * Crear un nuevo barbero/servicio
     */
    public function store(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $request->bearerToken(),
                'Content-Type' => 'application/json'
            ])->post(config('services.barber_service_url') . '/api/barbers', $request->all());

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create barber'
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
     * Obtener un barbero/servicio específico
     */
    public function show(Request $request, $id)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $request->bearerToken(),
                'Content-Type' => 'application/json'
            ])->get(config('services.barber_service_url') . '/api/barbers/' . $id);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barber not found'
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
     * Actualizar un barbero/servicio
     */
    public function update(Request $request, $id)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $request->bearerToken(),
                'Content-Type' => 'application/json'
            ])->put(config('services.barber_service_url') . '/api/barbers/' . $id, $request->all());

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update barber'
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
     * Eliminar un barbero/servicio
     */
    public function destroy(Request $request, $id)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $request->bearerToken(),
                'Content-Type' => 'application/json'
            ])->delete(config('services.barber_service_url') . '/api/barbers/' . $id);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete barber'
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
