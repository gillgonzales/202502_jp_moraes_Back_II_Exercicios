<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificacaoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'mensagem' => 'required|string',
            'data_envio' => 'required|integer',
            'lida' => 'required|boolean',
            'tipo_notificacao' => 'required|integer',
            'viagem_id' => 'nullable|integer',
        ];
    }
}