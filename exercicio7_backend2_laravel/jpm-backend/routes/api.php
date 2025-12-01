<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rotas API de usuarios
Route::apiResource('usuarios', App\Http\Controllers\Api\UsuarioApiController::class);

// Rotas API de automoveis
Route::apiResource('automoveis', App\Http\Controllers\Api\AutomovelApiController::class);

// Rotas API de notificacoes
Route::apiResource('notificacoes', App\Http\Controllers\Api\NotificacaoApiController::class);
