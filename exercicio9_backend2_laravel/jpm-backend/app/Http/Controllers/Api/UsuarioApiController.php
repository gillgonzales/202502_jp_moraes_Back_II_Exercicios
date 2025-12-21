<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use App\Models\Administrador;
use App\Models\Motorista;
use App\Models\Passageiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UsuarioApiController extends Controller
{
    public function __construct()
    {
        UsuarioResource::withoutWrapping();
    }

    public function index(Request $request)
    {
        $filterValidator = Validator::make($request->all(), [
            'tipo_usuario' => Rule::in([
                Usuario::TIPO_ADMIN,
                Usuario::TIPO_MOTORISTA,
                Usuario::TIPO_PASSAGEIRO
            ]),
            'status_conta' => Rule::in(['ATIVO', 'PENDENTE', 'SUSPENSO'])
        ]);

        if ($filterValidator->fails()) {
            return response()->json(['errors' => $filterValidator->errors()], 422);
        }

        $query = Usuario::with([
            'motorista.automovel',
            'passageiro',
            'administrador',
            'notificacoes',
            'denunciasFeitas',
            'denunciasRecebidas'
        ]);

        if ($request->filled('tipo_usuario')) {
            $query->where('tipo_usuario', $request->tipo_usuario);
        }
        if ($request->filled('status_conta')) {
            $query->where('status_conta', $request->status_conta);
        }

        return UsuarioResource::collection($query->get());
    }

    public function show($id)
    {
        try {
            $usuario = Usuario::with([
                'motorista.automovel',
                'passageiro',
                'administrador',
                'notificacoes',
            ])->findOrFail($id);

            return new UsuarioResource($usuario);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        $data = $this->validateUsuario($request);

        DB::beginTransaction();
        try {
            $usuario = Usuario::create($data);
            $this->createTipoDependente($data, $request, $usuario);

            DB::commit();

            return (new UsuarioResource(
                $usuario->fresh()->loadMissing(['motorista','passageiro','administrador'])
            ))->response()->setStatusCode(201);

        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Erro SQL ao criar usuário: '.$e->getMessage());
            return response()->json(['message' => 'Erro ao criar usuário'], 422);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro geral ao criar usuário: '.$e->getMessage());
            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $data = $this->validateUsuario($request, $usuario->id);

        DB::beginTransaction();
        try {
            $usuario->update($data);

            if ($usuario->motorista) {
                $usuario->motorista->update(
                    $request->only(['cnh','validade_cnh','categoria_cnh','foto_cnh'])
                );
            }
            if ($usuario->passageiro) {
                $usuario->passageiro->update($request->only(['apelido']));
            }

            DB::commit();

            return new UsuarioResource(
                $usuario->fresh()->loadMissing(['motorista','passageiro','administrador'])
            );

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao atualizar usuário '.$usuario->id.': '.$e->getMessage());
            return response()->json(['message' => 'Erro ao atualizar usuário'], 500);
        }
    }

    public function updatePartial(Request $request, $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nome'         => 'sometimes|string|max:255',
            'email'        => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('usuarios', 'email')->ignore($id)
            ],
            'tipo_usuario' => [
                'sometimes',
                Rule::in([
                    Usuario::TIPO_ADMIN,
                    Usuario::TIPO_MOTORISTA,
                    Usuario::TIPO_PASSAGEIRO
                ])
            ],
            'status_conta' => [
                'sometimes',
                Rule::in(['ATIVO', 'PENDENTE', 'SUSPENSO', 'ativo', 'inativo'])
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Normaliza status_conta se vier em minúsculas
            $data = $validator->validated();
            if (isset($data['status_conta'])) {
                $data['status_conta'] = strtoupper($data['status_conta']);
                // Converte 'inativo' para 'SUSPENSO' se necessário
                if ($data['status_conta'] === 'INATIVO') {
                    $data['status_conta'] = 'SUSPENSO';
                }
            }

            // Atualiza apenas os campos enviados
            $usuario->fill($data);
            $usuario->save();

            return new UsuarioResource($usuario->fresh());

        } catch (Exception $e) {
            \Log::error('Erro ao atualizar usuário parcialmente '.$id.': '.$e->getMessage());
            return response()->json(['message' => 'Erro ao atualizar usuário'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $usuario->delete();
        return response()->json(['message' => 'Usuário removido']);
    }


    private function validateUsuario(Request $request, ?int $id = null): array
    {
        $rules = [
            'nome'         => 'required|string|max:255',
            'email'        => [
                'required','email','max:255',
                Rule::unique('usuarios','email')->ignore($id)
            ],
            'telefone'     => ['nullable','string','regex:/^\+?[0-9]{8,15}$/'],
            'senha'        => $id
                              ? 'sometimes|nullable|string|min:6|confirmed'
                              : 'required|string|min:6|confirmed',
            'tipo_usuario' => [
                'required',
                Rule::in([Usuario::TIPO_ADMIN,
                          Usuario::TIPO_MOTORISTA,
                          Usuario::TIPO_PASSAGEIRO])
            ],
            'status_conta'    => ['sometimes', Rule::in(['ATIVO','PENDENTE','SUSPENSO'])],
            'foto_identidade' => ['sometimes','string','max:255'],
            // campos condicionais
            'cnh'           => 'required_if:tipo_usuario,'.Usuario::TIPO_MOTORISTA.'|string|max:20',
            'validade_cnh'  => 'required_if:tipo_usuario,'.Usuario::TIPO_MOTORISTA.'|date|after:today',
            'categoria_cnh' => 'required_if:tipo_usuario,'.Usuario::TIPO_MOTORISTA.'|string|in:A,B,C,D,E',
            'foto_cnh'      => 'required_if:tipo_usuario,'.Usuario::TIPO_MOTORISTA.'|string|max:255',
            'apelido'       => 'required_if:tipo_usuario,'.Usuario::TIPO_PASSAGEIRO.'|string|max:50',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'email.unique'        => 'E-mail já cadastrado.',
            'senha.confirmed'     => 'Confirmação de senha não confere.',
            'cnh.required_if'     => 'CNH é obrigatória para motoristas.',
            'apelido.required_if' => 'Apelido é obrigatório para passageiros.',
            'validade_cnh.after'  => 'Validade da CNH deve ser uma data futura.',
        ]);

        if ($validator->fails()) {
            abort(response()->json(['errors' => $validator->errors()], 422));
        }

        return $validator->validated();
    }

    private function createTipoDependente(array $data, Request $request, Usuario $usuario): void
    {
        switch ($data['tipo_usuario']) {
            case Usuario::TIPO_ADMIN:
                Administrador::create([
                    'usuario_id'     => $usuario->id,
                    'data_atividade' => now()
                ]);
                break;

            case Usuario::TIPO_MOTORISTA:
                Motorista::create(
                    ['usuario_id' => $usuario->id] +
                    $request->only(['cnh','validade_cnh','categoria_cnh','foto_cnh'])
                );
                break;

            case Usuario::TIPO_PASSAGEIRO:
                Passageiro::create(
                    ['usuario_id' => $usuario->id] +
                    $request->only(['apelido'])
                );
                break;
        }
    }
}