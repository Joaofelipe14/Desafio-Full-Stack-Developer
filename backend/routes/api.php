<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HuggyAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CallController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HuggyWebhookController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StateController;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VoiceGrant;

use App\Http\Controllers\TwilioController;

Route::post('/make-call', [TwilioController::class, 'Call']);  


Route::post('/login', [AuthController::class, 'login']);
Route::get('/huggy/auth', [HuggyAuthController::class, 'redirectToHuggy']);
Route::get('/huggy/auth/callback', [HuggyAuthController::class, 'handleCallback']);

Route::post('/weebhook', [HuggyWebhookController::class, 'receberWebhook']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/me', [AuthController::class, 'logout']);


    Route::get('/states', [StateController::class, 'index']);
    Route::get('/states/{state_id}/cities', [StateController::class, 'cities']);


    // Rotas para Cidades
    Route::get('/cities', [CityController::class, 'index']);

    // Rotas para Clientes
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::get('/clients/{id}', [ClientController::class, 'show']);
    Route::put('/clients/{id}', [ClientController::class, 'update']);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

    // rota para gráficos 
    Route::get('/reports/clients-by-city', [ReportController::class, 'clientsByCity']);
    Route::get('/reports/clients-by-state', [ReportController::class, 'clientsBystate']);
    Route::get('/reports/clients-by-age', [ReportController::class, 'clientsByAge']);



});

