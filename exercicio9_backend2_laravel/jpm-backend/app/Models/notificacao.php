<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    use HasFactory;

    protected $table = 'notificacao';    

    protected $fillable = [
        'titulo',
        'mensagem',
        'data_envio',
        'lida',
        'tipo_notificacao',
        'viagem_id',          // FK opcional
    ];

    protected $casts = [
        'data_envio' => 'integer',   // armazena timestamp (INT)
        'lida'       => 'boolean',
    ];

    /**
     * N:M  Notificação ←→ Usuários (quem recebe)
     * Tabela pivô: notificacao_usuarios
     */
    public function usuarios()
    {
        return $this->belongsToMany(
            Usuario::class,
            'notificacao_usuarios',
            'notificacao_id',
            'usuario_id'
        )->withTimestamps();
    }

    /**
     * N:M  Notificação ←→ Denúncias (alertas de denúncia)
     * Tabela pivô: notificacao_denuncias
     */
    public function denuncias()
    {
        return $this->belongsToMany(
            Denuncia::class,
            'notificacao_denuncias',
            'notificacao_id',
            'denuncia_id'
        )->withTimestamps();
    }

    /**
     * N:1  Notificação → Viagem (opcional)
     */
    public function viagem()
    {
        return $this->belongsTo(Viagem::class, 'viagem_id');
    }
}