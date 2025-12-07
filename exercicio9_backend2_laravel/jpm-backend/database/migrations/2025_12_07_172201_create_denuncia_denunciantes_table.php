<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('denuncia_denunciantes', function (Blueprint $table) {
            $table->unsignedBigInteger('denuncia_id');
            $table->unsignedBigInteger('denunciante_id');
            $table->primary(['denuncia_id', 'denunciante_id']);
            $table->timestamps();
            $table->foreign('denuncia_id')
                ->references('id')->on('denuncia')
                ->cascadeOnDelete();
            $table->foreign('denunciante_id')
                ->references('id')->on('usuarios')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('denuncia_denunciantes');
    }
};
