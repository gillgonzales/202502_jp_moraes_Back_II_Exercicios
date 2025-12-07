<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('denuncia', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dataEnvio');
            $table->text('descricao');
            $table->string('tipoDenuncia', 100);
            $table->string('statusDenuncia', 50)->default('ABERTA');
            $table->string('evidencia');
            $table->dateTime('dataResposta');
            $table->text('resposta')->default('');
            $table->unsignedBigInteger('denunciado_id');
            $table->unsignedBigInteger('administrador_id');
            $table->unsignedBigInteger('viagem_id');
            $table->timestamps();
            $table->foreign('denunciado_id')
                ->references('id')->on('usuarios')
                ->cascadeOnDelete();
            $table->foreign('administrador_id')
                ->references('usuario_id')->on('administradores')
                ->cascadeOnDelete();
            $table->foreign('viagem_id')
                ->references('id')->on('viagem')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('denuncia');
    }
};
