<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viagem extends Model
{
    use HasFactory;
    protected $table = 'viagem';   // singular, conforme script SQL
    public $timestamps = false;

    protected $fillable = [
        'data_inicio',
        'data_fim',
        'origem',
        'destino',
        'distancia',
        'duracao',
        'status_viagem',
        'rota',
        'tempoEspera',        // nome camelCase que existe na tabela
        'aceite_motorista',
        'motorista_id',       // FK → motoristas.usuario_id
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'aceite_motorista' => 'boolean',
    ];

    // N:M  Viagem ↔ Passageiros  (pivot viagem_passageiros)
    public function passageiros()
    {
        return $this->belongsToMany(
            Passageiro::class,
            'viagem_passageiros',
            'viagem_id',      // FK nesta pivô
            'passageiro_id'   // FK para passageiros.usuario_id
        )->withTimestamps();
    }

    // N:1  Viagem → Motorista
    public function motorista()
    {
        return $this->belongsTo(
            Motorista::class,
            'motorista_id',   // FK nesta tabela
            'usuario_id'      // PK na tabela motoristas
        );
    }

    // 1:N  Viagem → Pagamentos
    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class, 'viagem_id');
    }

    // 1:N  Viagem → Mensagens
    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'viagem_id');
    }

    // 1:N  Viagem → Notificações
    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class, 'viagem_id');
    }
}