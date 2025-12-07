<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;          // qualquer visitante pode tentar login
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'senha' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',

            'senha.required' => 'A senha é obrigatória.',
            'senha.min' => 'A senha deve ter no mínimo :min caracteres.',
        ];
    }
}