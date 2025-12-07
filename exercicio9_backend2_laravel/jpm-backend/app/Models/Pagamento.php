<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;


    protected $table = 'pagamento';      // conforme script SQL
    public    $timestamps = true;        // created_at / updated_at existem na tabela

    protected $fillable = [
        'data_pagamento',
        'data_confirmacao',
        'valor',
        'status_pagamento',
        'forma_pagamento',
        'comprovante',
        'passageiro_id',   // FK → passageiros.usuario_id
        'viagem_id',       // FK → viagem.id
    ];

    protected $casts = [
        'data_pagamento'   => 'datetime',
        'data_confirmacao' => 'datetime',
        'valor'            => 'decimal:2',
    ];

    /* ============== RELACIONAMENTOS ============== */

    // N:1  Pagamento → Viagem
    public function viagem()
    {
        return $this->belongsTo(Viagem::class, 'viagem_id');
    }

    // N:1  Pagamento → Passageiro que pagou
    public function passageiro()
    {
        return $this->belongsTo(
            Passageiro::class,
            'passageiro_id',   // FK nesta tabela
            'usuario_id'       // PK na tabela passageiros
        );
    }
}