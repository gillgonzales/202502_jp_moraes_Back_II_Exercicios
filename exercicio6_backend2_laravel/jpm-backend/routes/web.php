<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AutomovelController;
use App\Http\Controllers\NotificacaoController;
use Illuminate\Support\Facades\Route;

//==================== CRUD COMPLETO - USUARIOS ====================
// IMPORTANTE: Rotas específicas (create, edit) DEVEM vir ANTES das rotas com {id}

Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create'); 
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show'); 
Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::get('/usuarios/{id}/delete', [UsuarioController::class, 'confirmDelete'])->name('usuarios.confirmDelete'); //rota de redirecionamento
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');


//==================== CRUD COMPLETO - AUTOMOVEIS ====================

Route::get('/automoveis', [AutomovelController::class, 'index'])->name('automoveis.index');
Route::get('/automoveis/create', [AutomovelController::class, 'create'])->name('automoveis.create'); 
Route::post('/automoveis', [AutomovelController::class, 'store'])->name('automoveis.store');
Route::get('/automoveis/{id}', [AutomovelController::class, 'show'])->name('automoveis.show'); 
Route::get('/automoveis/{id}/edit', [AutomovelController::class, 'edit'])->name('automoveis.edit');
Route::put('/automoveis/{id}', [AutomovelController::class, 'update'])->name('automoveis.update');
Route::get('/automoveis/{id}/delete', [AutomovelController::class, 'confirmDelete'])->name('automoveis.confirmDelete');
Route::delete('/automoveis/{id}', [AutomovelController::class, 'destroy'])->name('automoveis.destroy');


//==================== CRUD COMPLETO - NOTIFICACOES ====================

Route::get('/notificacoes', [NotificacaoController::class, 'index'])->name('notificacoes.index');
Route::get('/notificacoes/create', [NotificacaoController::class, 'create'])->name('notificacoes.create'); 
Route::post('/notificacoes', [NotificacaoController::class, 'store'])->name('notificacoes.store');
Route::get('/notificacoes/{id}', [NotificacaoController::class, 'show'])->name('notificacoes.show');
Route::get('/notificacoes/{id}/edit', [NotificacaoController::class, 'edit'])->name('notificacoes.edit');
Route::put('/notificacoes/{id}', [NotificacaoController::class, 'update'])->name('notificacoes.update');
Route::get('/notificacoes/{id}/delete', [NotificacaoController::class, 'confirmDelete'])->name('notificacoes.confirmDelete');
Route::delete('/notificacoes/{id}', [NotificacaoController::class, 'destroy'])->name('notificacoes.destroy');