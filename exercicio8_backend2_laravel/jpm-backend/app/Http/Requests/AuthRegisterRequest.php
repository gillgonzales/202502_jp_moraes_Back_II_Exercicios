<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Qualquer visitante pode registrar-se
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'              => 'required|string|max:50',
            'email'             => 'required|string|email|max:255|unique:usuarios,email',
            'senha'             => 'required|string|min:6',

            'idade'             => 'required|integer|min:18|max:100',
            'sexo'              => 'required|in:Masculino,Feminino,Outro',
            'telefone'          => 'required|string|max:20',
            'data_nascimento'   => 'required|date',
            'cpf'               => 'required|string|max:20|unique:usuarios,cpf',
            'endereco'          => 'required|string|max:255',
            'nacionalidade'     => 'required|string|max:100',
            'ultima_atividade'  => 'nullable|date',
            'status_conta'      => 'in:ATIVO,PENDENTE|nullable',
            'foto_identidade'   => 'nullable|string|max:255',
            'tipo_usuario'      => 'required|in:ADMINISTRADOR,PASSAGEIRO,MOTORISTA',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'         => 'O nome é obrigatório.',
            'nome.max'              => 'O nome deve ter no máximo 50 caracteres.',
            'email.required'        => 'O e-mail é obrigatório.',
            'email.email'           => 'Informe um e-mail válido.',
            'email.unique'          => 'Este e-mail já está cadastrado.',
            'senha.required'        => 'A senha é obrigatória.',
            'senha.min'             => 'A senha deve ter no mínimo :min caracteres.',
            'idade.required'        => 'A idade é obrigatória.',
            'idade.integer'         => 'A idade deve ser um número inteiro.',
            'idade.min'             => 'A idade mínima é :min.',
            'idade.max'             => 'A idade máxima é :max.',
            'sexo.required'         => 'O sexo é obrigatório.',
            'sexo.in'               => 'Sexo deve ser Masculino, Feminino ou Outro.',
            'cpf.required'          => 'O CPF é obrigatório.',
            'cpf.unique'            => 'Este CPF já está cadastrado.',
            'tipo_usuario.required' => 'O tipo de usuário é obrigatório.',
            'tipo_usuario.in'       => 'Tipo de usuário deve ser ADMINISTRADOR, PASSAGEIRO ou MOTORISTA.',
        ];
    }
}