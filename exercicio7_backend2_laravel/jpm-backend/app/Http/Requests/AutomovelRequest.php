<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutomovelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $automovelId = $this->automovel ? $this->automovel->id : null;

        return [
            'placa' => 'required|string|max:10|unique:automovel,placa,' . $automovelId,
            'modelo' => 'required|string|max:255',  
            'tipo' => 'required|string|max:100',
            'marca' => 'required|string|max:255',
            'ano_fabricacao' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'cor' => 'required|string|max:50',
            'capacidade_passageiros' => 'required|integer|min:1|max:50',
            'foto_veiculo' => 'required|string|max:255',
            'status_veiculo' => 'required|string|in:DISPONIVEL,EM_VIAGEM,MANUTENCAO,INATIVO',
            'motorista_id' => 'required|integer',
        ];
    }
}
