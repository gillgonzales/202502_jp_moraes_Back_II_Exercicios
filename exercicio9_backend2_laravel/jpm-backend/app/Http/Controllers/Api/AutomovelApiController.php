<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AutomovelRequest;
use App\Http\Resources\AutomovelResource;
use App\Models\Automovel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Exception;

class AutomovelApiController extends Controller
{
    public function __construct()
    {
        AutomovelResource::withoutWrapping();   // remove wrapper “data”
    }


    public function index()
    {
        $autos = Automovel::with('motorista.usuario')->get();
        return AutomovelResource::collection($autos);
    }

    public function show($id)
    {
        try {
            $auto = Automovel::with('motorista.usuario')->findOrFail($id);
            return new AutomovelResource($auto);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Automóvel não encontrado'], 404);
        }
    }

    public function store(AutomovelRequest $req)
    {
        $data = $req->validated();

        $placa = strtoupper($data['placa']);
        if (Automovel::whereRaw('upper(placa) = ?', [$placa])->exists()) {
            return response()->json(['error' => 'Placa já cadastrada'], 422);
        }

        try {
            $auto = Automovel::create($data);

            return (new AutomovelResource(
                        $auto->loadMissing('motorista.usuario')
                    ))->response()->setStatusCode(201);

        } catch (QueryException $e) {
            // erroInfo[1] == 1062  => Duplicate entry (MySQL)
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['error' => 'Placa já cadastrada'], 422);
            }

            \Log::error('Erro SQL ao criar automóvel: '.$e->getMessage());
            return response()->json(['message' => 'Erro ao criar automóvel'], 500);
        }
    }


    public function update(AutomovelRequest $req, $id)
    {
        DB::beginTransaction();
        try {
            $auto = Automovel::findOrFail($id);

            /* se a placa está sendo alterada, valida duplicidade */
            if ($req->filled('placa')) {
                $novaPlaca = strtoupper($req->input('placa'));
                if (Automovel::whereRaw('upper(placa)=?', [$novaPlaca])
                             ->where('id', '!=', $auto->id)
                             ->exists()) {
                    return response()->json(['error' => 'Placa já cadastrada'], 422);
                }
            }

            $auto->update($req->validated());

            DB::commit();
            return new AutomovelResource(
                $auto->loadMissing('motorista.usuario')
            );

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Automóvel não encontrado'], 404);

        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['error' => 'Placa já cadastrada'], 422);
            }
            \Log::error('Erro SQL ao atualizar automóvel '.$id.': '.$e->getMessage());
            return response()->json(['message' => 'Erro ao atualizar automóvel'], 500);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro geral ao atualizar automóvel '.$id.': '.$e->getMessage());
            return response()->json(['message' => 'Erro ao atualizar automóvel'], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $auto = Automovel::findOrFail($id);
            $auto->delete();

            return response()->json(['message' => 'Automóvel removido']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Automóvel não encontrado'], 404);
        }
    }
}