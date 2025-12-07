<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'idade' => $this->idade,
            'sexo' => $this->sexo,
            'telefone' => $this->telefone,
            'data_nascimento' => $this->data_nascimento,
            'cpf' => $this->cpf,
            'endereco' => $this->endereco,
            'nacionalidade' => $this->nacionalidade,
            'ultima_atividade' => $this->ultima_atividade,
            'email_verificado' => $this->email_verificado,
            'status_conta' => $this->status_conta,
            'foto_identidade' => $this->foto_identidade,
            'tipo_usuario' => $this->tipo_usuario,
        ];
    }
}
