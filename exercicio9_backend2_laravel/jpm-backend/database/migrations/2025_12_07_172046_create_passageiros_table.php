<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('passageiros', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->primary();
            $table->string('apelido', 100)->default('');
            $table->string('fotoPerfil')->default('');
            $table->text('descricao_perfil')->default('');
            $table->string('preferencias_linguagem', 50)->default('');
            $table->string('modo_favorito', 50)->default('');
            $table->integer('frequencia_uso')->default(0);
            $table->boolean('aceita_compartilhamento')->default(true);
            $table->foreign('usuario_id')
                ->references('id')->on('usuarios')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('passageiros');
    }
};
