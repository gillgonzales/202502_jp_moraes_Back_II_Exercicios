<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsuarioApiController;
use App\Http\Controllers\Api\AutomovelApiController;
use App\Http\Controllers\Api\NotificacaoApiController;

Route::post('/register', [AuthController::class, 'register']);   // cadastro completo
Route::post('/login',    [AuthController::class, 'login']);      // e-mail + senha


Route::middleware('auth:sanctum')->group(function () {

    // revoga o token atual
    Route::post('/logout', [AuthController::class, 'logout']);



    // Somente ADMINISTRADOR
    Route::middleware('role:ADMINISTRADOR')->group(function () {
        Route::apiResource('usuarios',     UsuarioApiController::class);

    });

    // ADMINISTRADOR ou MOTORISTA (Refatorar para Habilidades diretamente nos tokens[ability])
    Route::middleware('role:ADMINISTRADOR,MOTORISTA')->group(function () {
        Route::apiResource('automoveis',   AutomovelApiController::class);
    });
    //Deveria manter públicas as rotas GET usando except ou only

     Route::middleware('role:ADMINISTRADOR,MOTORISTA,PASSAGEIRO')->group(function () {
       Route::apiResource('notificacoes', NotificacaoApiController::class);
    });


});
