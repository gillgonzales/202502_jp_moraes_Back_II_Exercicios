<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('automovel', function (Blueprint $table) {
            $table->id();
            $table->string('placa', 8)->unique();
            $table->string('modelo', 100);
            $table->string('tipo', 50);
            $table->string('marca', 50);
            $table->integer('ano_fabricacao');
            $table->string('cor', 30);
            $table->integer('capacidade_passageiros');
            $table->string('foto_veiculo', 255);
            $table->string('status_veiculo', 50)->default('DISPONIVEL');
            $table->integer('motorista_id');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automovels');
    }
};
