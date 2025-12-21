<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'metricas' => [
                'uso_plataforma' => $this->resource['metricas']['uso_plataforma'] ?? 0,
            ],
            
            'mudancas' => [
                'uso_mudanca' => $this->resource['mudancas']['uso_mudanca'] ?? '+0%',
            ],
            
            'usage' => [
                'usuarios_ativos'      => $this->resource['usage']['usuarios_ativos'] ?? 0,
                'viagens_realizadas'   => $this->resource['usage']['viagens_realizadas'] ?? 0,
                'denuncias_resolvidas' => $this->resource['usage']['denuncias_resolvidas'] ?? 0,
                'novos_cadastros'      => $this->resource['usage']['novos_cadastros'] ?? 0,
                'cancelamentos'        => $this->resource['usage']['cancelamentos'] ?? 0,
                'outros'               => $this->resource['usage']['outros'] ?? 0,
            ],
            
            // Metadados úteis
            'meta' => [
                'ultima_atualizacao' => now()->format('Y-m-d H:i:s'),
                'periodo_analise'    => 'Últimos 30 dias',
            ],
        ];
    }
}