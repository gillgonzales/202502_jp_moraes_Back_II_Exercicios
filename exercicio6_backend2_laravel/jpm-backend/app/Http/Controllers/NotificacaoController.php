<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    // ===== READ (LISTAGEM) =====
    public function index()
    {
        $notificacoes = Notificacao::all();
        return view('notificacoes.index', compact('notificacoes'));
    }

    // ===== READ (VISUALIZAR UMA) =====
    public function show($id)
    {
        $notificacao = Notificacao::findOrFail($id);
        return view('notificacoes.show', compact('notificacao'));
    }

    // ===== CREATE (MOSTRAR FORMULÁRIO) =====
    public function create()
    {
        return view('notificacoes.create');
    }

    // ===== CREATE (SALVAR NO BANCO) =====
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'mensagem' => 'required|string',
            'data_envio' => 'required|integer',
            'lida' => 'nullable|boolean',
            'tipo_notificacao' => 'required|integer',
            'viagem_id' => 'nullable|integer'
        ]);

        Notificacao::create($validatedData);

        return redirect()->route('notificacoes.index')
            ->with('success', 'Notificação criada com sucesso!');
    }

    // ===== UPDATE (MOSTRAR FORMULÁRIO DE EDIÇÃO) =====
    public function edit($id)
    {
        $notificacao = Notificacao::findOrFail($id);
        return view('notificacoes.edit', compact('notificacao'));
    }

    // ===== UPDATE (ATUALIZAR NO BANCO) =====
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'mensagem' => 'required|string',
            'data_envio' => 'required|integer',
            'lida' => 'nullable|boolean',
            'tipo_notificacao' => 'required|integer',
            'viagem_id' => 'nullable|integer'
        ]);

        $notificacao = Notificacao::findOrFail($id);
        $notificacao->update($validatedData);

        return redirect()->route('notificacoes.index')
            ->with('success', 'Notificação atualizada com sucesso!');
    }

    // ===== DELETE (DELETAR) =====
    public function confirmDelete($id) //tela para confirmar a deletagem
    {
        $notificacao = Notificacao::findOrFail($id);
        return view('notificacoes.delete', compact('notificacao'));
    }

    public function destroy($id)
    {
        $notificacao = Notificacao::findOrFail($id);
        $notificacao->delete();

        return redirect()->route('notificacoes.index')
            ->with('success', 'Notificação deletada com sucesso!');
    }
}