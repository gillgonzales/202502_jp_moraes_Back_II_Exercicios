<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\Http\Resources\UsuarioResource;
use App\Http\Resources\UsuarioResourceCollection;
use App\Models\Usuario;
use App\Models\Administrador;
use App\Models\Motorista;
use App\Models\Passageiro;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class UsuarioApiController extends Controller
{
    public function index()
    {
        try {
            $usuarios = Usuario::with([
                'motorista.automovel',
                'passageiro',
                'administrador',
                'notificacoes',
                'denunciasFeitas',
                'denunciasRecebidas'
            ])->paginate(10);               // troque para ->get() se não quiser paginação

            return new UsuarioResourceCollection($usuarios);

        } catch (Exception $e) {
            \Log::error('Erro ao listar usuários: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao listar usuários'
            ], 500);
        }
    }

    public function show(Usuario $usuario)
    {
        $usuario->load([
            'motorista.automovel',
            'passageiro',
            'administrador',
            'notificacoes',
        ]);

        return new UsuarioResource($usuario);
    }

    public function store(UsuarioRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();            

            $usuario = Usuario::create($data);

            switch ($data['tipo_usuario']) {
                case Usuario::TIPO_ADMIN:
                    Administrador::create(['usuario_id' => $usuario->id, 'data_atividade' => now()]);
                    break;
                case Usuario::TIPO_MOTORISTA:
                    Motorista::create(['usuario_id' => $usuario->id] + $request->only(['cnh', 'validade_cnh', 'categoria_cnh', 'foto_cnh']));
                    break;
                case Usuario::TIPO_PASSAGEIRO:
                    Passageiro::create(['usuario_id' => $usuario->id] + $request->only(['apelido']));
                    break;
            }

            DB::commit();
            return (new UsuarioResource($usuario->fresh()->loadMissing(['motorista', 'passageiro', 'administrador'])))
                ->response()
                ->setStatusCode(201);

        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Erro SQL ao criar usuário: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao criar usuário'], 422);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro geral ao criar usuário: ' . $e->getMessage());
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function update(UsuarioRequest $request, Usuario $usuario)
    {
        DB::beginTransaction();
        try {
            $usuario->update($request->validated());

            if ($usuario->motorista) {
                $usuario->motorista->update($request->only(['cnh', 'validade_cnh', 'categoria_cnh', 'foto_cnh']));
            }
            if ($usuario->passageiro) {
                $usuario->passageiro->update($request->only(['apelido']));
            }

            DB::commit();
            return new UsuarioResource($usuario->fresh()->loadMissing(['motorista', 'passageiro', 'administrador']));

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao actualizar usuário ' . $usuario->id . ': ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao actualizar usuário'], 500);
        }
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->json(['message' => 'Usuário removido']);
    }
}