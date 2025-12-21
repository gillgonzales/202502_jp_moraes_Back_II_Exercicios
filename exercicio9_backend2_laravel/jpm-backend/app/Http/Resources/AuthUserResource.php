<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'nome'         => $this->nome,
            'email'        => $this->email,
            'tipo_usuario' => $this->tipo_usuario,  
        ];
    }
}