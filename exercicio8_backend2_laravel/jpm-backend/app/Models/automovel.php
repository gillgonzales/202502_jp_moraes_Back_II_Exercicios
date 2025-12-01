<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Automovel extends Model
{
    protected $table = 'automovel';
    public $timestamps = false;
    
    protected $fillable = [
        'placa',
        'modelo',
        'tipo',
        'marca',
        'ano_fabricacao',
        'cor',
        'capacidade_passageiros',
        'foto_veiculo',
        'status_veiculo',
        'motorista_id'
    ];
}