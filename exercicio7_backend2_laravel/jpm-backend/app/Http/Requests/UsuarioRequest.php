<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $usuarioId = $this->usuario ? $this->usuario->id : null;

        $rules = [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuarioId,
            'senha' => ($this->isMethod('post') ? 'required' : 'sometimes') . '|string|min:4',
            'idade' => 'required|integer|min:0|max:150',
            'sexo' => 'required|string|in:Masculino,Feminino,Outro',
            'telefone' => 'required|string|max:20',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:20|unique:usuarios,cpf,' . $usuarioId,
            'endereco' => 'required|string|max:500',
            'nacionalidade' => 'required|string|max:100',
            'ultima_atividade' => 'required|date',
            'email_verificado' => 'required|boolean',
            'status_conta' => 'required|string|in:ATIVO,INATIVO,BLOQUEADO,PENDENTE',
            'foto_identidade' => 'required|string|max:255',
            'tipo_usuario' => 'required|string|in:ADMINISTRADOR,PASSAGEIRO,MOTORISTA',
        ];

        return $rules;
    }
}
