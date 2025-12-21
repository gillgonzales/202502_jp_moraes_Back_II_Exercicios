<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificacaoRequest;
use App\Http\Resources\NotificacaoResource;
use App\Models\Notificacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class NotificacaoApiController extends Controller
{
    public function __construct()
    {
        NotificacaoResource::withoutWrapping();   // remove envelope “data”
    }


    public function index()
    {
        $nots = Notificacao::with(['usuarios', 'viagem', 'denuncias'])->get();

        return NotificacaoResource::collection($nots);
    }

    /* ───────────────────────── DETALHE ──────────────────────── */
    public function show($id)
    {
        try {
            $not = Notificacao::with(['usuarios', 'viagem', 'denuncias'])
                    ->findOrFail($id);

            return new NotificacaoResource($not);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Notificação não encontrada'], 404);
        }
    }

    public function store(NotificacaoRequest $req)
    {
        DB::beginTransaction();

        try {
            $not = Notificacao::create($req->validated());

            if ($req->filled('usuarios')) {
                $not->usuarios()->attach($req->input('usuarios'));
            }
            if ($req->filled('denuncias')) {
                $not->denuncias()->attach($req->input('denuncias'));
            }

            DB::commit();

            return (new NotificacaoResource(
                        $not->load(['usuarios', 'denuncias', 'viagem'])
                    ))->response()->setStatusCode(201);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao criar notificação: '.$e->getMessage());

            return response()->json(['message' => 'Erro ao criar notificação'], 500);
        }
    }

    public function update(NotificacaoRequest $req, $id)
    {
        DB::beginTransaction();

        try {
            $not = Notificacao::findOrFail($id);
            $not->update($req->validated());

            if ($req->has('usuarios')) {
                $not->usuarios()->sync($req->input('usuarios'));
            }
            if ($req->has('denuncias')) {
                $not->denuncias()->sync($req->input('denuncias'));
            }

            DB::commit();

            return new NotificacaoResource(
                $not->load(['usuarios', 'denuncias', 'viagem'])
            );

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Notificação não encontrada'], 404);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao actualizar notificação '.$id.': '.$e->getMessage());

            return response()->json(['message' => 'Erro ao actualizar notificação'], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $not = Notificacao::findOrFail($id);

            $not->usuarios()->detach();
            $not->denuncias()->detach();
            $not->delete();

            return response()->json(['message' => 'Notificação removida']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Notificação não encontrada'], 404);
        }
    }
}