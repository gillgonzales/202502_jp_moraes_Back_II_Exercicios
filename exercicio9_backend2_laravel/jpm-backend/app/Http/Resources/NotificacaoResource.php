<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificacaoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'mensagem' => $this->mensagem,
            'data_envio' => $this->data_envio,
            'lida' => $this->lida,
            'tipo_notificacao' => $this->tipo_notificacao,
            'viagem_id' => $this->viagem_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
