<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('administradores', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->primary();
            $table->dateTime('data_atividade');
            $table->foreign('usuario_id')
                ->references('id')->on('usuarios')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('administradores');
    }
};
