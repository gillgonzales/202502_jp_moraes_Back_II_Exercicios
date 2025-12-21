<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//table-per-type

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'idade',
        'sexo',
        'telefone',
        'data_nascimento',
        'cpf',
        'endereco',
        'nacionalidade',
        'ultima_atividade',
        'email_verificado',
        'status_conta',
        'foto_identidade',
        'tipo_usuario',
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    protected $casts = [
        'email_verificado' => 'boolean',
        'data_nascimento' => 'date',
        'ultima_atividade' => 'datetime',
    ];


    // 1:1  – subtipos (tabelas filhas)
    public function motorista()
    {
        return $this->hasOne(Motorista::class, 'usuario_id');
    }

    public function passageiro()
    {
        return $this->hasOne(Passageiro::class, 'usuario_id');
    }

    public function administrador()
    {
        return $this->hasOne(Administrador::class, 'usuario_id');
    }

    public function notificacoes()
    {
        return $this->belongsToMany(
            Notificacao::class,
            'notificacao_usuarios',
            'usuario_id',
            'notificacao_id'
        )->withTimestamps();
    }

    public function denunciasFeitas()
    {
        return $this->belongsToMany(
            Denuncia::class,
            'denuncia_denunciantes',
            'denunciante_id',
            'denuncia_id'
        )->withTimestamps();
    }

    // 1:N – Denúncias em que o usuário é denunciado
    public function denunciasRecebidas()
    {
        return $this->hasMany(Denuncia::class, 'denunciado_id');
    }

    /* =============== HELPERS DE PAPEL (opcional) =============== */

    const TIPO_ADMIN = 'ADMINISTRADOR';
    const TIPO_PASSAGEIRO = 'PASSAGEIRO';
    const TIPO_MOTORISTA = 'MOTORISTA';

    public function scopeAdmins($q)
    {
        return $q->where('tipo_usuario', self::TIPO_ADMIN);
    }
    public function scopePassageiros($q)
    {
        return $q->where('tipo_usuario', self::TIPO_PASSAGEIRO);
    }
    public function scopeMotoristas($q)
    {
        return $q->where('tipo_usuario', self::TIPO_MOTORISTA);
    }

    public function isAdmin()
    {
        return $this->tipo_usuario === self::TIPO_ADMIN;
    }
    public function isPassageiro()
    {
        return $this->tipo_usuario === self::TIPO_PASSAGEIRO;
    }
    public function isMotorista()
    {
        return $this->tipo_usuario === self::TIPO_MOTORISTA;
    }

    /* =============== AUTH =============== */

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }
}