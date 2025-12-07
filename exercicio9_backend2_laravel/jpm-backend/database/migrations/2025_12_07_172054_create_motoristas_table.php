<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('motoristas', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->primary();
            $table->string('cnh', 20);
            $table->date('validade_cnh');
            $table->string('categoria_cnh', 10);
            $table->string('foto_cnh');
            $table->integer('data_aprovacao')->default(0);
            $table->foreign('usuario_id')
                ->references('id')->on('usuarios')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('motoristas');
    }
};
