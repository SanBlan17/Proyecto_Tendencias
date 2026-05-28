<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registrar un nuevo usuario
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Llamar al servicio de Citas para registrar el usuario
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Content-Type' => 'application/json'
            ])->post(config('services.appointment_service_url') . '/api/auth/register', [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
            ]);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => $response->json()['message'] ?? 'Registration failed'
                ], $response->status());
            }

            $data = $response->json();

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'token' => $data['token'] ?? null,
                'user' => $data['user'] ?? null
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Iniciar sesión
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Llamar al servicio de Citas para autenticar el usuario
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Content-Type' => 'application/json'
            ])->post(config('services.appointment_service_url') . '/api/auth/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => $response->json()['message'] ?? 'Invalid credentials'
                ], $response->status());
            }

            $data = $response->json();

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $data['token'] ?? null,
                'user' => $data['user'] ?? null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verificar token
     */
    public function verify(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token not provided'
            ], 401);
        }

        try {
            // Verificar el token en el servicio de Citas
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post(config('services.appointment_service_url') . '/api/auth/verify');

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid token'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'message' => 'Token is valid',
                'user' => $response->json()['user'] ?? null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during token verification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token not provided'
            ], 401);
        }

        try {
            // Cerrar sesión en el servicio de Citas
            $response = Http::withHeaders([
                'X-API-Key' => config('services.internal_api_key'),
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post(config('services.appointment_service_url') . '/api/auth/logout');

            return response()->json([
                'success' => true,
                'message' => 'Logout successful'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
