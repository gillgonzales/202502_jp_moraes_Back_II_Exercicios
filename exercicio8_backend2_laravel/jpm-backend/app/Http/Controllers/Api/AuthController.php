<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Resources\AuthUserResource;      // Resource “leve” para auth
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    //registro para autenticacao do sistema

    public function register(AuthRegisterRequest $request)
    {
        // dados já validados: nome, email, senha
        $data = $request->validated();
        $data['senha'] = Hash::make($data['senha']);

        $usuario = Usuario::create($data);
        $token   = $usuario->createToken('api_token')->plainTextToken;

        return response()->json([
            'usuario' => new AuthUserResource($usuario),
            'token'   => $token,
        ], 201);
    }

    /**
     * POST /api/login
     */
   public function login(AuthLoginRequest $request)
    {
        $data    = $request->validated();                       // e-mail + senha
        $usuario = Usuario::where('email', $data['email'])->first();

        //Hash::check é legado, exemplo de LLM, em aula usamos o Auth::attempt
        if (! $usuario || ! Hash::check($data['senha'], $usuario->senha)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        // opcional: revogar todos os tokens antigos
        // $usuario->tokens()->delete();

        $token = $usuario->createToken('api_token')->plainTextToken;

        return response()->json([
            'usuario' => new AuthUserResource($usuario),
            'token'   => $token,
        ]);
    }

    /**
     * POST /api/logout
     * Revoga apenas o token usado nesta requisição.
     */
    //Faltou a opção para revogar todos os tokens
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso.',
        ]);
    }
}
