<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificacaoRequest;
use App\Http\Resources\NotificacaoResource;
use App\Models\Notificacao;
use Illuminate\Support\Facades\DB;
use Exception;

class NotificacaoApiController extends Controller
{
    public function index()
    {
        //preciso dar o ajuste depois nessa relacao para relacionar com o usuario totalmente (vou mexer quando implementar o repository)
        $nots = Notificacao::with(['usuarios', 'viagem', 'denuncias'])->paginate(10);
        return NotificacaoResource::collection($nots);
    }

    public function show($id)
    {
        $not = Notificacao::with(['usuarios', 'viagem', 'denuncias'])->findOrFail($id);
        return new NotificacaoResource($not);
    }

    public function store(NotificacaoRequest $req)
    {
        DB::beginTransaction();
        try {
            // corpo principal
            $not = Notificacao::create($req->validated());


            if ($req->filled('users'))
                $not->usuarios()->attach($req->input('users'));
            if ($req->filled('denuncias'))
                $not->denuncias()->attach($req->input('denuncias'));

            DB::commit();
            return (new NotificacaoResource(
                $not->load(['usuarios', 'denuncias', 'viagem'])
            ))->response()->setStatusCode(201);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao criar notificação: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao criar notificação'], 500);
        }
    }

    public function update(NotificacaoRequest $req, $id)
    {
        DB::beginTransaction();
        $not = Notificacao::findOrFail($id);
        $not->update($req->validated());

        // sincroniza pivôs (se vierem no payload)
        if ($req->has('users'))
            $not->usuarios()->sync($req->input('users'));
        if ($req->has('denuncias'))
            $not->denuncias()->sync($req->input('denuncias'));

        DB::commit();
        return new NotificacaoResource($not->load(['usuarios', 'denuncias', 'viagem']));
    }

    public function destroy($id)
    {
        Notificacao::findOrFail($id)->delete();
        return response()->json(['message' => 'Notificação removida']);
    }
}