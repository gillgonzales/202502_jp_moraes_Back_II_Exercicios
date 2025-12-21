<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardRequest extends FormRequest
{

    public function authorize()
    {
        // Apenas administradores podem acessar o dashboard
        return $this->user() && $this->user()->tipo_usuario === 'ADMINISTRADOR';
    }


    public function rules()
    {
        return [
            // Filtros opcionais para versões futuras
            'periodo' => 'sometimes|in:7,15,30,60,90',  // dias
            'tipo'    => 'sometimes|in:usuarios,viagens,denuncias,todos',
        ];
    }

 
    public function messages()
    {
        return [
            'periodo.in' => 'Período inválido. Escolha entre: 7, 15, 30, 60 ou 90 dias.',
            'tipo.in'    => 'Tipo de métrica inválido.',
        ];
    }

    public function attributes()
    {
        return [
            'periodo' => 'período de análise',
            'tipo'    => 'tipo de métrica',
        ];
    }
}