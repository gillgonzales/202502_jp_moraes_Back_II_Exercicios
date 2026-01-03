<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable,HasFactory;

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
        'tipo_usuario'
    ];

    /* Esconde a senha (e token de sessão, se existir) quando
       o modelo for serializado para JSON.                  */
    protected $hidden = [
        'senha',
        'remember_token',   // só fará efeito se essa coluna existir
    ];

    /* Converte campos para tipos nativos (opcional) */
    protected $casts = [
        'email_verificado' => 'boolean',
        'data_nascimento'  => 'date',
        // 'senha'=>'hashed' //Descomente para não precisar ficar chamando bcrypt ou o ideal seria que seria o facade Hash::make
    ];

    /* Informa ao Laravel qual coluna é usada como senha.   */
    public function getAuthPassword()
    {
        return $this->senha;
    }
}
