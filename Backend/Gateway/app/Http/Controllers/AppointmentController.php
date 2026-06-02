<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use Carbon\Carbon;
use App\Services\AppointmentValidationService;

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
        $id = auth()->user()->barber->id;
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
        $service = Service::findOrFail($request->service_id);

        $validator = new AppointmentValidationService();

        $result = $validator->validate(
            $request->barber_id,
            $request->appointment_date,
            $request->start_time,
            $request->service_id
        );
        if (!$result['success']) {

            return response()->json([
                'message' => $result['message']
            ], 422);
        }

        // $endTime = Carbon::parse($request->start_time)
        //     ->addMinutes($service->duration_minutes);
        
        $data = [
            'user_id' => auth()->id(),
            'barber_id' => $request->barber_id,
            'service_id' => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $result['end_time'],
            'status' => 'PENDING',
            'notes' => $request->notes
        ];

        $url = $this->apiUrl . '/store_client/';
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->post($url, $data);
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

    public function confirmed_appointment_barbero($id_appointment)
    {
        $barberId = auth()->user()->barber->id;

        $response = Http::withHeaders([
            'X-API-Key' => $this->apiKey
        ])->put($this->apiUrl . "/confirm_barber/{$barberId}/{$id_appointment}");

        return $response->json();
    }
}
