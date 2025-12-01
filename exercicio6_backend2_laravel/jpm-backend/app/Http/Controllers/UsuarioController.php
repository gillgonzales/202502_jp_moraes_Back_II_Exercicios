<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // ===== READ (LISTAGEM) =====
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    // ===== READ (VISUALIZAR UM) =====
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    // ===== CREATE (MOSTRAR FORMULÁRIO) =====
    public function create()
    {
        return view('usuarios.create');
    }

    // ===== CREATE (SALVAR NO BANCO) =====
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios',
            'senha' => 'required|string|min:6',
            'idade' => 'required|integer',
            'sexo' => 'required|string|max:10',
            'telefone' => 'required|string|max:20',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:usuarios',
            'endereco' => 'required|string',
            'nacionalidade' => 'required|string|max:100',
            'ultima_atividade' => 'required|date',
            'email_verificado' => 'nullable|boolean',
            'status_conta' => 'nullable|string|max:50',
            'foto_identidade' => 'nullable|string',
            'tipo_usuario' => 'required|in:ADMINISTRADOR,PASSAGEIRO,MOTORISTA'
        ]);

        // Criptografar a senha antes de salvar
        $validatedData['senha'] = bcrypt($validatedData['senha']);

        Usuario::create($validatedData);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    // ===== UPDATE (MOSTRAR FORMULÁRIO DE EDIÇÃO) =====
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    // ===== UPDATE (ATUALIZAR NO BANCO) =====
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'senha' => 'nullable|string|min:6',
            'idade' => 'required|integer',
            'sexo' => 'required|string|max:10',
            'telefone' => 'required|string|max:20',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:usuarios,cpf,' . $id,
            'endereco' => 'required|string',
            'nacionalidade' => 'required|string|max:100',
            'ultima_atividade' => 'required|date',
            'email_verificado' => 'nullable|boolean',
            'status_conta' => 'nullable|string|max:50',
            'foto_identidade' => 'nullable|string',
            'tipo_usuario' => 'required|in:ADMINISTRADOR,PASSAGEIRO,MOTORISTA'
        ]);

        $usuario = Usuario::findOrFail($id);

        // Se a senha foi preenchida, criptografa
        if (!empty($validatedData['senha'])) {
            $validatedData['senha'] = bcrypt($validatedData['senha']);
        } else {
            // Se não preencheu, remove do array para não atualizar
            unset($validatedData['senha']);
        }

        $usuario->update($validatedData);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    // ===== DELETE (DELETAR) =====

    public function confirmDelete($id) //metodo para confirmar o delete
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.delete', compact('usuario'));
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário deletado com sucesso!');
    }
}
