<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    // Listagem de todas as notificações
    public function index()
    {
        $notificacoes = Notificacao::all();
        return view('notificacoes.index', compact('notificacoes'));
    }

    // Visualização única de uma notificação
    public function show($id)
    {
        $notificacao = Notificacao::findOrFail($id);
        return view('notificacoes.show', compact('notificacao'));
    }
}