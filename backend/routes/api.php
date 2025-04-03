<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HuggyAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CallController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HuggyWebhookController;
use App\Http\Controllers\StateController;

Route::post('/call', [CallController::class, 'initCall']);
Route::get('/twilio/connect', [CallController::class, 'connectUsers'])->name('twilio.connect');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/huggy/auth', [HuggyAuthController::class, 'redirectToHuggy']);
Route::get('/huggy/auth/callback', [HuggyAuthController::class, 'handleCallback']);

Route::post('/weebhook', [HuggyWebhookController::class, 'receberWebhook']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/states', [StateController::class, 'index']);

    // Rotas para Cidades
    Route::get('/cities', [CityController::class, 'index']);

    // Rotas para Clientes
    Route::get('/customers', [ClientController::class, 'index']);
    Route::post('/customers', [ClientController::class, 'store']);
    Route::get('/customers/{id}', [ClientController::class, 'show']);
    Route::put('/customers/{id}', [ClientController::class, 'update']);
    Route::delete('/customers/{id}', [ClientController::class, 'destroy']);
});
