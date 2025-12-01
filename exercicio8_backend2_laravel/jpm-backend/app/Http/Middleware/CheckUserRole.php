<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Permite acessar a rota apenas se o usuário estiver autenticado
     * e seu campo “tipo_usuario” constar na lista de papéis exigidos.
     *
     * Uso na rota:
     *     Route::middleware('role:ADMINISTRADOR,MOTORISTA')->group(...)
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user || ! in_array($user->tipo_usuario, $roles, true)) {
            return response()->json(['message' => 'Acesso não autorizado.'], 403);
        }

        return $next($request);
    }
}