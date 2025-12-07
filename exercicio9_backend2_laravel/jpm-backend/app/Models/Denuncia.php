<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    use HasFactory;

    /* ============== CONFIGURAÇÃO BÁSICA ============== */

    protected $table      = 'denuncia';   // conforme script SQL
    public    $timestamps = false;

    protected $fillable = [
        'dataEnvio',
        'descricao',
        'tipoDenuncia',
        'statusDenuncia',
        'evidencia',
        'dataResposta',
        'resposta',

        // FKs
        'denunciado_id',
        'administrador_id',
        'viagem_id',
    ];

    protected $casts = [
        'dataEnvio'    => 'datetime',
        'dataResposta' => 'datetime',
    ];

    /* ============== RELACIONAMENTOS ============== */

    /**
     * N:M  Denúncia ←→ Usuários que denunciaram
     * tabela pivô: denuncia_denunciantes
     */
    public function denunciantes()
    {
        return $this->belongsToMany(
            Usuario::class,          
            'denuncia_denunciantes',  
            'denuncia_id',            
            'denunciante_id'         
        );
    }

    // N:1  Denúncia → Usuário denunciado
    public function denunciado()
    {
        return $this->belongsTo(Usuario::class, 'denunciado_id');
    }

    // N:1  Denúncia → Administrador que gerenciou
    public function administrador()
    {
        // 3º parâmetro informa que a PK na tabela administradores é usuario_id
        return $this->belongsTo(Administrador::class, 'administrador_id', 'usuario_id');
    }

    // N:1  Denúncia → Viagem relacionada (se houver)
    public function viagem()
    {
        return $this->belongsTo(Viagem::class, 'viagem_id');
    }
}