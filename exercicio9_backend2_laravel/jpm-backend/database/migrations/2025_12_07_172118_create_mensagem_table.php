<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mensagem', function (Blueprint $table) {
            $table->id();
            $table->text('conteudo');
            $table->dateTime('data_envio');
            $table->boolean('lida')->default(false);
            $table->unsignedBigInteger('viagem_id');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('viagem_id')
                ->references('id')->on('viagem')
                ->cascadeOnDelete();
            $table->foreign('usuario_id')
                ->references('id')->on('usuarios')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('mensagem');
    }
};
