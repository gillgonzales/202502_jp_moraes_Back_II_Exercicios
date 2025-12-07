<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('avaliacao', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('nota');
            $table->text('comentario');
            $table->dateTime('data_avaliacao');
            $table->string('tipo_avaliacao', 50);
            $table->unsignedBigInteger('motorista_id');
            $table->unsignedBigInteger('passageiro_id');
            $table->unsignedBigInteger('viagem_id');
            $table->foreign('motorista_id')
                ->references('usuario_id')->on('motoristas')
                ->cascadeOnDelete();
            $table->foreign('passageiro_id')
                ->references('usuario_id')->on('passageiros')
                ->cascadeOnDelete();
            $table->foreign('viagem_id')
                ->references('id')->on('viagem')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('avaliacao');
    }
};
