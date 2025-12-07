<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('viagem', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim')->nullable();
            $table->string('origem');
            $table->string('destino');
            $table->decimal('distancia', 10, 2);
            $table->decimal('duracao', 10, 2);
            $table->string('status_viagem', 50)->default('PENDENTE');
            $table->text('rota');
            $table->decimal('tempoEspera', 5, 2)->default(0);
            $table->boolean('aceite_motorista')->default(false);
            $table->unsignedBigInteger('motorista_id');
            $table->foreign('motorista_id')
                ->references('usuario_id')->on('motoristas')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('viagem');
    }
};
