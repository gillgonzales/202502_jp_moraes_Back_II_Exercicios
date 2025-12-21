<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DenunciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isCreate = $this->isMethod('post');

        $rules = [
            'dataEnvio'       => $isCreate ? 'required|date' : 'sometimes|date',
            'descricao'       => 'required|string',
            'tipoDenuncia'    => [
                'required',
                Rule::in(['COMPORTAMENTO','SEGURANCA','OUTRO'])
            ],
            'statusDenuncia'  => [
                'sometimes',
                Rule::in(['PENDENTE','EM_ANALISE','FECHADA'])
            ],
            'evidencia'       => 'sometimes|string|max:255',
            'dataResposta'    => 'sometimes|date',
            'resposta'        => 'sometimes|string',

            'denunciado_id'   => 'required|exists:usuarios,id',
            'administrador_id'=> 'sometimes|nullable|exists:administradores,usuario_id',
            'viagem_id'       => 'sometimes|nullable|exists:viagem,id',

            // array de denunciantes
            'denunciantes'    => 'sometimes|array',
            'denunciantes.*'  => 'integer|exists:usuarios,id',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'dataEnvio.required'       => 'A data de envio é obrigatória.',
            'descricao.required'       => 'Descrição é obrigatória.',
            'tipoDenuncia.in'          => 'Tipo de denúncia inválido.',
            'statusDenuncia.in'        => 'Status da denúncia inválido.',
            'denunciado_id.exists'     => 'Usuário denunciado não encontrado.',
            'administrador_id.exists'  => 'Administrador informado não encontrado.',
            'viagem_id.exists'         => 'Viagem informada não encontrada.',
            'denunciantes.*.exists'    => 'Denunciante informado não encontrado.',
        ];
    }
}