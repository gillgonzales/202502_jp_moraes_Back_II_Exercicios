<?php

namespace App\Http\Controllers;

use App\Models\Automovel;
use Illuminate\Http\Request;

class AutomovelController extends Controller
{
    // ===== READ (LISTAGEM) =====
    public function index()
    {
        $automoveis = Automovel::all();
        return view('automoveis.index', compact('automoveis'));
    }

    // ===== READ (VISUALIZAR UM) =====
    public function show($id)
    {
        $automovel = Automovel::findOrFail($id);
        return view('automoveis.show', compact('automovel'));
    }

    // ===== CREATE (MOSTRAR FORMULÁRIO) =====
    public function create()
    {
        return view('automoveis.create');
    }

    // ===== CREATE (SALVAR NO BANCO) =====
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'placa' => 'required|string|max:8|unique:automovel',
            'modelo' => 'required|string|max:100',
            'tipo' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
            'ano_fabricacao' => 'required|integer',
            'cor' => 'required|string|max:30',
            'capacidade_passageiros' => 'required|integer',
            'foto_veiculo' => 'required|string',
            'status_veiculo' => 'nullable|string|max:50',
            'motorista_id' => 'required|integer'
        ]);

        Automovel::create($validatedData);

        return redirect()->route('automoveis.index')
            ->with('success', 'Automóvel criado com sucesso!');
    }

    // ===== UPDATE (MOSTRAR FORMULÁRIO DE EDIÇÃO) =====
    public function edit($id)
    {
        $automovel = Automovel::findOrFail($id);
        return view('automoveis.edit', compact('automovel'));
    }

    // ===== UPDATE (ATUALIZAR NO BANCO) =====
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'placa' => 'required|string|max:8|unique:automovel,placa,' . $id,
            'modelo' => 'required|string|max:100',
            'tipo' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
            'ano_fabricacao' => 'required|integer',
            'cor' => 'required|string|max:30',
            'capacidade_passageiros' => 'required|integer',
            'foto_veiculo' => 'required|string',
            'status_veiculo' => 'nullable|string|max:50',
            'motorista_id' => 'required|integer'
        ]);

        $automovel = Automovel::findOrFail($id);
        $automovel->update($validatedData);

        return redirect()->route('automoveis.index')
            ->with('success', 'Automóvel atualizado com sucesso!');
    }

    // ===== DELETE (DELETAR) =====

    public function confirmDelete($id) //confirmacao do delete
    {
        $automovel = Automovel::findOrFail($id);
        return view('automoveis.delete', compact('automovel'));
    }


    public function destroy($id)
    {
        $automovel = Automovel::findOrFail($id);
        $automovel->delete();

        return redirect()->route('automoveis.index')
            ->with('success', 'Automóvel deletado com sucesso!');
    }



}