<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Automovel extends Model
{
    use HasFactory;


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
        'motorista_id',
    ];

    // N:1  Automóvel → Motorista (PK da tabela motoristas = usuario_id)
    public function motorista()
    {
        return $this->belongsTo(
            Motorista::class,   // model alvo
            'motorista_id',     // FK nesta tabela (automovel)
            'usuario_id'        // PK na tabela motoristas
        );
    }
}