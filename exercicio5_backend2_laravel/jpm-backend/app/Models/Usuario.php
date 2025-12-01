<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
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
}