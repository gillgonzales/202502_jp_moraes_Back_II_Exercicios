<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AutomovelResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'placa' => $this->placa,
            'modelo' => $this->modelo,
            'tipo' => $this->tipo,
            'marca' => $this->marca,
            'ano_fabricacao' => $this->ano_fabricacao,
            'cor' => $this->cor,
            'capacidade_passageiros' => $this->capacidade_passageiros,
            'foto_veiculo' => $this->foto_veiculo,
            'status_veiculo' => $this->status_veiculo,
            'motorista_id' => $this->motorista_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
