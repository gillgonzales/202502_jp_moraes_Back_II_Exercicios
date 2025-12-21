<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsuarioApiController;
use App\Http\Controllers\Api\AutomovelApiController;
use App\Http\Controllers\Api\NotificacaoApiController;
use App\Http\Controllers\Api\DenunciasApiController;
use App\Http\Controllers\Api\DashboardController;



Route::post('/register', [AuthController::class, 'register']);   // cadastro completo
Route::post('/login', [AuthController::class, 'login']);      // e-mail + senha


Route::middleware('auth:sanctum')->group(function () {

    // revoga o token atual
    Route::post('/logout', [AuthController::class, 'logout']);



    // Somente ADMINISTRADOR
    Route::middleware('role:ADMINISTRADOR')->group(function () {
        Route::apiResource('usuarios', UsuarioApiController::class);
        Route::patch('/usuarios/{id}/partial', [UsuarioApiController::class, 'updatePartial']);
        Route::apiResource('denuncias', DenunciasApiController::class);
         Route::patch(
            'denuncias/{denuncia}/status',
            [DenunciasApiController::class, 'updateStatus']
        );
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });

    // ADMINISTRADOR ou MOTORISTA
    Route::middleware('role:ADMINISTRADOR,MOTORISTA')->group(function () {
        Route::apiResource('automoveis', AutomovelApiController::class);
    });

    Route::middleware('role:ADMINISTRADOR,MOTORISTA,PASSAGEIRO')->group(function () {
        Route::apiResource('notificacoes', NotificacaoApiController::class);
    });


});