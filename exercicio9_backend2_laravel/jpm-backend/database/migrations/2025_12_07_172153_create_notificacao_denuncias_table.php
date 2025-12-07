<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notificacao_denuncias', function (Blueprint $table) {
            $table->unsignedBigInteger('notificacao_id');
            $table->unsignedBigInteger('denuncia_id');
            $table->primary(['notificacao_id', 'denuncia_id']);
            $table->timestamps();
            $table->foreign('notificacao_id')
                ->references('id')->on('notificacao')
                ->cascadeOnDelete();
            $table->foreign('denuncia_id')
                ->references('id')->on('denuncia')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('notificacao_denuncias');
    }
};
