<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;
use App\Http\Resources\UsuarioResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\UsuarioResourceCollection;
use Illuminate\Database\QueryException;
use Exception;

class UsuarioApiController extends Controller
{
    // Listar todos os usuarios
    public function index()
    {
        try {
            // Paginação (10 por página) – troque por all() se não quiser paginação
            $usuarios = Usuario::all();

            return new UsuarioResourceCollection($usuarios);

        } catch (Exception $e) {
            \Log::error('Erro ao listar usuários: ' . $e->getMessage());

            return response()->json([
                'message' => 'Erro ao listar usuários',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    // Exibir um usuario específico
    public function show(Usuario $usuario)
    {
        try {
            return new UsuarioResource($usuario);

        } catch (Exception $e) {
            \Log::error("Erro ao buscar usuário ID {$usuario->id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao buscar usuário',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    // Criar um novo usuario
    public function store(UsuarioRequest $request)
    {
        try {
            \Log::info('Tentando criar usuário', $request->validated());

            $data = $request->validated();

            if (isset($data['senha'])) {
                $data['senha'] = bcrypt($data['senha']);
            }

            $usuario = Usuario::create($data);

            \Log::info("Usuário criado com sucesso - ID: {$usuario->id}");

            return (new UsuarioResource($usuario))
                ->response()
                ->setStatusCode(201);

        } catch (QueryException $e) {
            \Log::error('Erro de banco ao criar usuário: ' . $e->getMessage());

            if ($e->getCode() === '23000') {
                return response()->json([
                    'message' => 'Erro ao criar usuário',
                    'error' => 'Email ou CPF já cadastrado no sistema'
                ], 422);
            }

            return response()->json([
                'message' => 'Erro ao criar usuário',
                'error' => 'Erro ao salvar os dados no banco'
            ], 500);

        } catch (Exception $e) {
            \Log::error('Erro ao criar usuário: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao criar usuário',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    // Atualizar um usuario existente
    public function update(UsuarioRequest $request, Usuario $usuario)
    {
        try {
            \Log::info("Tentando atualizar usuário ID: {$usuario->id}", $request->validated());

            $data = $request->validated();

            if (array_key_exists('senha', $data)) {
                $data['senha'] = bcrypt($data['senha']);
            }

            $usuario->update($data);

            \Log::info("Usuário ID {$usuario->id} atualizado com sucesso");

            return new UsuarioResource($usuario);

        } catch (QueryException $e) {
            \Log::error("Erro de banco ao atualizar usuário ID {$usuario->id}: " . $e->getMessage());

            if ($e->getCode() === '23000') {
                return response()->json([
                    'message' => 'Erro ao atualizar usuário',
                    'error' => 'Email ou CPF já cadastrado para outro usuário'
                ], 422);
            }

            return response()->json([
                'message' => 'Erro ao atualizar usuário',
                'error' => 'Erro ao salvar os dados no banco'
            ], 500);

        } catch (Exception $e) {
            \Log::error("Erro ao atualizar usuário ID {$usuario->id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao atualizar usuário',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    // Deletar um usuario
    public function destroy(Usuario $usuario)
    {
        try {
            \Log::info("Tentando deletar usuário ID: {$usuario->id}");

            $usuario->delete();

            \Log::info("Usuário ID {$usuario->id} deletado com sucesso");

            return response()->json([
                'message' => 'Usuário deletado com sucesso'
            ], 200);

        } catch (QueryException $e) {
            \Log::error("Erro de banco ao deletar usuário ID {$usuario->id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao deletar usuário',
                'error' => 'Não foi possível deletar. Pode haver vínculos com outras tabelas'
            ], 409);

        } catch (Exception $e) {
            \Log::error("Erro ao deletar usuário ID {$usuario->id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao deletar usuário',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }
}