<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\HuggyAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\ChamadasController;

Route::post('/ligar', [ChamadasController::class, 'iniciarLigacao']);
Route::get('/twilio/conectar', [ChamadasController::class, 'conectarUsuarios'])->name('twilio.conectar');


Route::post('/login', [AuthController::class, 'login']);

Route::get('/huggy/auth', [HuggyAuthController::class, 'redirectToHuggy']);
Route::get('/huggy/auth/callback', [HuggyAuthController::class, 'handleCallback']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/estados', [EstadoController::class, 'index']);

    // Rotas para Cidades
    Route::get('/cidades', [CidadeController::class, 'index']);

    // Rotas para Clientes
    Route::get('/clientes', [ClienteController::class, 'index']);
    Route::post('/clientes', [ClienteController::class, 'store']);
    Route::get('/clientes/{id}', [ClienteController::class, 'show']);
    Route::put('/clientes/{id}', [ClienteController::class, 'update']);
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);
});
