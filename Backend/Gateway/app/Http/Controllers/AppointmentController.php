<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Obtener todas las citas
     */

    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('MICROSERVICE_APPOINTMENTS_SERVICES');
        $this->apiKey = env('API_KEY');
    }

    public function index_client()
    {
        $id = Auth::id();
        $url = $this->apiUrl . '/index_client/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
    }

    public function index_barber()
    {
        $id = Auth::id();
        $url = $this->apiUrl . '/index_barber/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
    }

    public function index_admin()
    {
        $url = $this->apiUrl . '/index_admin/';
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
    }


    /**
     * Crear una nueva cita
     */
    public function store_client(Request $request)
    {
        $id = Auth::id();
        $url = $this->apiUrl . '/store_client/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->post($url, $request->all());
        return $response->json();
    }

    /**
     * Obtener una cita específica
     */
    

    /**
     * Eliminar una cita
     */
    public function destroy(Request $request, $id)
    {
        $url = $this->apiUrl . '/delete_appointment/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->delete($url);
        return $response->json();
    }

    public function cancel_appointment_client($id)
    {
        $userId = Auth::id();

        $response = Http::withHeaders([
            'X-API-Key' => $this->apiKey
        ])->put($this->apiUrl . "/cancel_client/{$id}/{$userId}");

        return $response->json();
    }
}
