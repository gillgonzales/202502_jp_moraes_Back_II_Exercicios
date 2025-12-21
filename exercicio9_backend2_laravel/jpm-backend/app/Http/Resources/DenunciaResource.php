<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DenunciaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'dataEnvio'       => optional($this->dataEnvio)->format('Y-m-d H:i:s'),
            'descricao'       => $this->descricao,
            'tipoDenuncia'    => $this->tipoDenuncia,
            'statusDenuncia'  => $this->statusDenuncia,
            'evidencia'       => $this->evidencia,
            'dataResposta'    => optional($this->dataResposta)->format('Y-m-d H:i:s'),
            'resposta'        => $this->resposta,

            // ───── Relações (só aparecem se estiverem carregadas) ─────
            'denunciantes' => $this->whenLoaded('denunciantes', function () {
                return $this->denunciantes->map(function ($u) {
                    return [
                        'id'   => $u->id,
                        'nome' => $u->nome,
                    ];
                });
            }),

            'denunciado' => $this->whenLoaded('denunciado', function () {
                return [
                    'id'   => $this->denunciado->id,
                    'nome' => $this->denunciado->nome,
                ];
            }),

            'administrador' => $this->whenLoaded('administrador', function () {
                return [
                    'id'   => $this->administrador->usuario_id,
                    'nome' => $this->administrador->usuario->nome ?? null,
                ];
            }),

            'viagem' => $this->whenLoaded('viagem', function () {
                return [
                    'id'         => $this->viagem->id,
                    'dataSaida'  => optional($this->viagem->dataSaida)->format('Y-m-d H:i:s'),
                ];
            }),
        ];
    }
}