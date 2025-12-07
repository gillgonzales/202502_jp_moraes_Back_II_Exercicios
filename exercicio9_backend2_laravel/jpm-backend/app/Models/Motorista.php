<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    use HasFactory;

    protected $table        = 'motoristas';   // tabela filha
    protected $primaryKey   = 'usuario_id';   // PK = FK para usuarios.id
    public    $incrementing = false;          // não auto-incrementa
    protected $keyType      = 'int';
    public    $timestamps   = false;          // sem created_at/updated_at

    protected $fillable = [
        'usuario_id',
        'cnh',
        'validade_cnh',
        'categoria_cnh',
        'foto_cnh',
        'data_aprovacao',
    ];

    protected $casts = [
        'validade_cnh'  => 'date',
        'data_aprovacao'=> 'datetime',
    ];

    // 1:1  Motorista → linha base em 'usuarios'
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // 1:1  Motorista → Automóvel
    public function automovel()
    {
        return $this->hasOne(
            Automovel::class,   // model alvo
            'motorista_id',     // FK na tabela automovel
            'usuario_id'        // PK local
        );
    }

    // 1:N  Motorista → Viagens
    public function viagens()
    {
        return $this->hasMany(
            Viagem::class,
            'motorista_id',     // FK na tabela viagens
            'usuario_id'        // PK local
        );
    }

    // 1:N  Motorista → Avaliações recebidas
    public function avaliacoesRecebidas()
    {
        return $this->hasMany(
            Avaliacao::class,
            'motorista_id',     // FK na tabela avaliacao
            'usuario_id'        // PK local
        );
    }
}