<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table = 'notificacao';
    
    protected $fillable = [
        'titulo',
        'mensagem',
        'data_envio',
        'lida',
        'tipo_notificacao',
        'viagem_id'
    ];
}