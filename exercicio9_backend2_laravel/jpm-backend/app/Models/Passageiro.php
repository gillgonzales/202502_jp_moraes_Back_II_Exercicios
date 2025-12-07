<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passageiro extends Model
{
    use HasFactory;

    protected $table = 'passageiros';  
    protected $primaryKey = 'usuario_id';    // PK = FK para usuarios.id
    public $incrementing = false;           // não auto-incrementa
    protected $keyType = 'int';
    public $timestamps = false;           // sem created_at/updated_at

    protected $fillable = [
        'usuario_id',
        'apelido',
        'fotoPerfil',
        'descricao_perfil',
        'preferencias_linguagem',
        'modo_favorito',
        'frequencia_uso',
        'aceita_compartilhamento',
    ];

    protected $casts = [
        'aceita_compartilhamento' => 'boolean',
        'frequencia_uso' => 'integer',
    ];


    // 1:1  Passageiro → linha base em 'usuarios'
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // N:M  Passageiro ↔ Viagens   (pivot viagem_passageiros)
    public function viagens()
    {
        return $this->belongsToMany(
            Viagem::class,
            'viagem_passageiros',
            'passageiro_id',   // FK na pivô → passageiros.usuario_id
            'viagem_id'        // FK na pivô → viagem.id
        )->withTimestamps();
    }

    // 1:N  Passageiro → Avaliações feitas
    public function avaliacoesFeitas()
    {
        return $this->hasMany(
            Avaliacao::class,
            'passageiro_id',   // FK na tabela avaliacao
            'usuario_id'       // PK local (passageiros)
        );
    }

    // (opcional) 1:N  Passageiro → Pagamentos
    public function pagamentos()
    {
        return $this->hasMany(
            Pagamento::class,
            'passageiro_id',   // FK na tabela pagamento
            'usuario_id'       // PK local
        );
    }
}