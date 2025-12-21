<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\Usuario;
use App\Models\Administrador;
use App\Models\Motorista;
use App\Models\Passageiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();      // NÃO hashear aqui!
            // o mutator setSenhaAttribute em Usuario já faz bcrypt

            /* 1) linha da tabela-base ------------------ */
            $usuario = Usuario::create($data);

            /* 2) linha da tabela-filha ----------------- */
            switch ($data['tipo_usuario']) {
                case Usuario::TIPO_ADMIN:
                    Administrador::create([
                        'usuario_id'     => $usuario->id,
                        'data_atividade' => now(),
                    ]);
                    break;

                case Usuario::TIPO_MOTORISTA:
                    Motorista::create([
                        'usuario_id'    => $usuario->id,
                        'cnh'           => $data['cnh'],
                        'validade_cnh'  => $data['validade_cnh'],
                        'categoria_cnh' => $data['categoria_cnh'],
                        'foto_cnh'      => $data['foto_cnh'] ?? '',
                    ]);
                    break;

                case Usuario::TIPO_PASSAGEIRO:
                    Passageiro::create([
                        'usuario_id'              => $usuario->id,
                        //'apelido'                 => $data['apelido'],
                        'fotoPerfil'              => $data['fotoPerfil'] ?? '',
                        'descricao_perfil'        => $data['descricao_perfil'] ?? '',
                        'preferencias_linguagem'  => $data['preferencias_linguagem'] ?? '',
                        'modo_favorito'           => $data['modo_favorito'] ?? '',
                        'frequencia_uso'          => $data['frequencia_uso'] ?? 0,
                        'aceita_compartilhamento' => $data['aceita_compartilhamento'] ?? true,
                    ]);
                    break;
            }

            DB::commit();

            $usuario->load(['motorista','passageiro','administrador']);

            $token = $usuario->createToken('api_token')->plainTextToken;

            return response()->json([
                'usuario' => new AuthUserResource($usuario),
                'token'   => $token,
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Erro ao registrar usuário: '.$e->getMessage());
            return response()->json(['message' => 'Falha ao criar usuário'], 500);
        }
    }

    /* =====================================================
       POST /api/login
    ===================================================== */
    public function login(AuthLoginRequest $request)
    {
        $credenciais = $request->validated();

        $usuario = Usuario::where('email', $credenciais['email'])->first();

        if (! $usuario || ! Hash::check($credenciais['senha'], $usuario->senha)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        $usuario->load(['motorista','passageiro','administrador']);

        $token = $usuario->createToken('api_token')->plainTextToken;

        return response()->json([
            'usuario' => new AuthUserResource($usuario),
            'token'   => $token,
        ]);
    }

    /* =====================================================
       POST /api/logout
    ===================================================== */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso.',
        ]);
    }
}