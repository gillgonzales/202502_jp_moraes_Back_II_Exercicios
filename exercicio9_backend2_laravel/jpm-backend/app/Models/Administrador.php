<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;

    protected $table = 'administradores';     
    protected $primaryKey = 'usuario_id';          
    public $incrementing = false;               
    protected $keyType = 'int';
    public $timestamps = false;          

    protected $fillable = [
        'usuario_id',
        'data_atividade',
    ];

    protected $casts = [
        'data_atividade' => 'datetime',
    ];


    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /* 1:N  Administrador → Denúncias que ele gerencia   */
    public function denunciasGerenciadas()
    {
        // 3º parâmetro indica a PK da tabela administradores
        return $this->hasMany(Denuncia::class, 'administrador_id', 'usuario_id');
    }
}