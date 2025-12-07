<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacao';   
    public $timestamps = false;

    protected $fillable = [
        'nota',
        'comentario',
        'data_avaliacao',
        'tipo_avaliacao',
        'passageiro_id',   // FK → passageiros.usuario_id
        'motorista_id',    // FK → motoristas.usuario_id
        'viagem_id',
    ];

    protected $casts = [
        'data_avaliacao' => 'datetime',
        'nota' => 'integer',
    ];


    // N:1  Avaliacao → Passageiro (quem avaliou)
    public function passageiro()
    {
        return $this->belongsTo(
            Passageiro::class,
            'passageiro_id',   // FK nesta tabela
            'usuario_id'       // PK na tabela passageiros
        );
    }

    // N:1  Avaliacao → Motorista (quem foi avaliado)
    public function motorista()
    {
        return $this->belongsTo(
            Motorista::class,
            'motorista_id',    // FK nesta tabela
            'usuario_id'       // PK na tabela motoristas
        );
    }

    // (opcional) N:1  Avaliacao → Viagem
    public function viagem()
    {
        return $this->belongsTo(Viagem::class, 'viagem_id');
    }
}