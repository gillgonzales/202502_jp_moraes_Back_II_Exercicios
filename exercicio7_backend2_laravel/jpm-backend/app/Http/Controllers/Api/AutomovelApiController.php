<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Automovel;
use Illuminate\Http\Request;
use App\Http\Requests\AutomovelRequest;
use App\Http\Resources\AutomovelResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

class AutomovelApiController extends Controller
{
    /**
     * Lista todos os automóveis
     */
    public function index()
    {
        try {
            $automoveis = Automovel::all();
            return response()->json($automoveis);

        } catch (Exception $e) {
            \Log::error('Erro ao listar automóveis: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao listar automóveis',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * Exibe um automóvel específico
     */
    //Fix: deveria usar Route Model Bindings
    // - Usar a injeção de dependência da Model (Route Model Binding).
    public function show($id)
    {
        try {
            $automovel = Automovel::findOrFail($id);
            return new AutomovelResource($automovel);

        } catch (ModelNotFoundException $e) {
            \Log::warning("Automóvel não encontrado - ID: {$id}");
            return response()->json([
                'message' => 'Automóvel não encontrado',
                'error' => "Nenhum automóvel com ID {$id} foi encontrado"
            ], 404);

        } catch (Exception $e) {
            \Log::error("Erro ao buscar automóvel ID {$id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao buscar automóvel',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * Cria um novo automóvel
     */
    public function store(AutomovelRequest $request)
    {
        try {
            \Log::info('Tentando criar automóvel', $request->validated());

            $automovel = Automovel::create($request->validated());

            \Log::info("Automóvel criado com sucesso - ID: {$automovel->id}");

            return (new AutomovelResource($automovel))
                ->response()
                ->setStatusCode(201);

        } catch (QueryException $e) {
            \Log::error('Erro de banco ao criar automóvel: ' . $e->getMessage());

            // Verifica se é erro de duplicidade (placa já existe)
            if ($e->getCode() === '23000') {
                return response()->json([
                    'message' => 'Erro ao criar automóvel',
                    'error' => 'Placa já cadastrada no sistema'
                ], 422);
            }

            return response()->json([
                'message' => 'Erro ao criar automóvel',
                'error' => 'Erro ao salvar os dados no banco'
            ], 500);

        } catch (Exception $e) {
            \Log::error('Erro ao criar automóvel: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao criar automóvel',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * Atualiza um automóvel existente
     */
     //Fix: deveria usar Route Model Bindings
    // - Usar a injeção de dependência da Model (Route Model Binding).
    public function update(AutomovelRequest $request, $id)
    {
        try {
            $automovel = Automovel::findOrFail($id);

            \Log::info("Tentando atualizar automóvel ID: {$id}", $request->validated());

            $automovel->update($request->validated());

            \Log::info("Automóvel ID {$id} atualizado com sucesso");

            return new AutomovelResource($automovel);

        } catch (ModelNotFoundException $e) {
            \Log::warning("Automóvel não encontrado para atualização - ID: {$id}");
            return response()->json([
                'message' => 'Automóvel não encontrado',
                'error' => "Nenhum automóvel com ID {$id} foi encontrado"
            ], 404);

        } catch (QueryException $e) {
            \Log::error("Erro de banco ao atualizar automóvel ID {$id}: " . $e->getMessage());

            // Verifica se é erro de duplicidade (placa já existe)
            if ($e->getCode() === '23000') {
                return response()->json([
                    'message' => 'Erro ao atualizar automóvel',
                    'error' => 'Placa já cadastrada para outro veículo'
                ], 422);
            }

            return response()->json([
                'message' => 'Erro ao atualizar automóvel',
                'error' => 'Erro ao salvar os dados no banco'
            ], 500);

        } catch (Exception $e) {
            \Log::error("Erro ao atualizar automóvel ID {$id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao atualizar automóvel',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }

    /**
     * Remove um automóvel
     */
     //Fix: deveria usar Route Model Bindings
    // - Usar a injeção de dependência da Model (Route Model Binding).
    public function destroy($id)
    {
        try {
            $automovel = Automovel::findOrFail($id);

            \Log::info("Tentando deletar automóvel ID: {$id}");

            $automovel->delete();

            \Log::info("Automóvel ID {$id} deletado com sucesso");

            return response()->json([
                'message' => 'Automóvel deletado com sucesso'
            ], 200);

        } catch (ModelNotFoundException $e) {
            \Log::warning("Automóvel não encontrado para exclusão - ID: {$id}");
            return response()->json([
                'message' => 'Automóvel não encontrado',
                'error' => "Nenhum automóvel com ID {$id} foi encontrado"
            ], 404);

        } catch (QueryException $e) {
            \Log::error("Erro de banco ao deletar automóvel ID {$id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao deletar automóvel',
                'error' => 'Não foi possível deletar. Pode haver vínculos com outras tabelas'
            ], 409);

        } catch (Exception $e) {
            \Log::error("Erro ao deletar automóvel ID {$id}: " . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao deletar automóvel',
                'error' => 'Ocorreu um erro interno no servidor'
            ], 500);
        }
    }
}
