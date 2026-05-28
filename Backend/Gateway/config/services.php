<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Microservicios
    |--------------------------------------------------------------------------
    |
    | Configuración de URLs para los microservicios
    |
    */

    'appointment_service_url' => env('APPOINTMENT_SERVICE_URL', 'http://localhost:8001'),
    'barber_service_url' => env('BARBER_SERVICE_URL', 'http://localhost:8002'),

    /**
     * Clave API interna para comunicación entre servicios
     */
    'internal_api_key' => env('INTERNAL_API_KEY', 'your-internal-api-key-here'),

];
