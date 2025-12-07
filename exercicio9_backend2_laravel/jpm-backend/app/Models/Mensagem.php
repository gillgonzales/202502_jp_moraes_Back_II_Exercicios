<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    use HasFactory;

    protected $table = 'mensagem';    // conforme script SQL
    public $timestamps = false;

    protected $fillable = [
        'conteudo',
        'data_envio',
        'lida',
        'viagem_id',   // FK → viagem.id
        'usuario_id',  // FK → usuarios.id  (quem enviou)
    ];

    protected $casts = [
        'data_envio' => 'datetime',
        'lida' => 'boolean',
    ];

    // N:1  Mensagem → Viagem
    public function viagem()
    {
        return $this->belongsTo(Viagem::class, 'viagem_id');
    }

    // N:1  Mensagem → Usuário (remetente)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}