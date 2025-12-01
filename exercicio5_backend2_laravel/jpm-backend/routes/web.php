<?php

// http://localhost:8090/usuarios
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AutomovelController;
use App\Http\Controllers\NotificacaoController;
use Illuminate\Support\Facades\Route;

Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');

Route::get('/automoveis', [AutomovelController::class, 'index'])->name('automoveis.index');
Route::get('/automoveis/{id}', [AutomovelController::class, 'show'])->name('automoveis.show');

Route::get('/notificacoes', [NotificacaoController::class, 'index'])->name('notificacoes.index');
Route::get('/notificacoes/{id}', [NotificacaoController::class, 'show'])->name('notificacoes.show');