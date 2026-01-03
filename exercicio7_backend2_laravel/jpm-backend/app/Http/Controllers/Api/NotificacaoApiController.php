<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificacaoRequest;
use App\Http\Resources\NotificacaoResource;
use App\Models\Notificacao;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

class NotificacaoApiController extends Controller
{
    public function index()
    {
        try {
            $notificacoes = Notificacao::all();
            return response()->json($notificacoes);

        } catch (Exception $e) {
            \Log::error('Erro ao listar notificações: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao listar notificações',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

     //Fix: deveria usar Route Model Bindings
    // - Usar a injeção de dependência da Model (Route Model Binding).
    public function show($id)
    {
        try {
            $notificacao = Notificacao::findOrFail($id);
            return new NotificacaoResource($notificacao);

        } catch (ModelNotFoundException $e) {
            \Log::warning("Notificação não encontrada - ID: {$id}");
            return response()->json([
                'message' => 'Notificação não encontrada',
                'error' => "Nenhuma notificação com ID {$id} foi encontrada"
            ], 404);

        } catch (Exception $e) {
            \Log::error("Erro ao buscar notificação ID {$id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao buscar notificação',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    public function store(NotificacaoRequest $request)
    {
        try {
            \Log::info('Tentando criar notificação', $request->validated());

            $notificacao = Notificacao::create($request->validated());

            \Log::info("Notificação criada com sucesso - ID: {$notificacao->id}");

            return (new NotificacaoResource($notificacao))
                ->response()
                ->setStatusCode(201);

        } catch (QueryException $e) {
            \Log::error('Erro de banco ao criar notificação: ' . $e->getMessage());

            if ($e->getCode() === '23000') {
                return response()->json([
                    'message' => 'Erro ao criar notificação',
                    'error' => 'Registro duplicado no sistema'
                ], 422);
            }

            return response()->json([
                'message' => 'Erro ao criar notificação',
                'error' => 'Erro ao salvar os dados no banco'
            ], 500);

        } catch (Exception $e) {
            \Log::error('Erro ao criar notificação: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao criar notificação',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

     //Fix: deveria usar Route Model Bindings
    // - Usar a injeção de dependência da Model (Route Model Binding).
    public function update(NotificacaoRequest $request, $id)
    {
        try {
            $notificacao = Notificacao::findOrFail($id);

            \Log::info("Tentando atualizar notificação ID: {$id}", $request->validated());

            $notificacao->update($request->validated());

            \Log::info("Notificação ID {$id} atualizada com sucesso");

            return new NotificacaoResource($notificacao);

        } catch (ModelNotFoundException $e) {
            \Log::warning("Notificação não encontrada para atualização - ID: {$id}");
            return response()->json([
                'message' => 'Notificação não encontrada',
                'error' => "Nenhuma notificação com ID {$id} foi encontrada"
            ], 404);

        } catch (QueryException $e) {
            \Log::error("Erro de banco ao atualizar notificação ID {$id}: " . $e->getMessage());

            if ($e->getCode() === '23000') {
                return response()->json([
                    'message' => 'Erro ao atualizar notificação',
                    'error' => 'Registro duplicado no sistema'
                ], 422);
            }

            return response()->json([
                'message' => 'Erro ao atualizar notificação',
                'error' => 'Erro ao salvar os dados no banco'
            ], 500);

        } catch (Exception $e) {
            \Log::error("Erro ao atualizar notificação ID {$id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao atualizar notificação',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

     //Fix: deveria usar Route Model Bindings
    // - Usar a injeção de dependência da Model (Route Model Binding).
    public function destroy($id)
    {
        try {
            $notificacao = Notificacao::findOrFail($id);

            \Log::info("Tentando deletar notificação ID: {$id}");

            $notificacao->delete();

            \Log::info("Notificação ID {$id} deletada com sucesso");

            return response()->json([
                'message' => 'Notificação deletada com sucesso'
            ], 200);

        } catch (ModelNotFoundException $e) {
            \Log::warning("Notificação não encontrada para exclusão - ID: {$id}");
            return response()->json([
                'message' => 'Notificação não encontrada',
                'error' => "Nenhuma notificação com ID {$id} foi encontrada"
            ], 404);

        } catch (QueryException $e) {
            \Log::error("Erro de banco ao deletar notificação ID {$id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao deletar notificação',
                'error' => 'Não foi possível deletar. Pode haver vínculos com outras tabelas'
            ], 409);

        } catch (Exception $e) {
            \Log::error("Erro ao deletar notificação ID {$id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao deletar notificação',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }
}
