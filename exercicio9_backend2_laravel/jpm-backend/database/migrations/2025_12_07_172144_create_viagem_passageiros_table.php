<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('viagem_passageiros', function (Blueprint $table) {
            $table->unsignedBigInteger('viagem_id');
            $table->unsignedBigInteger('passageiro_id');
            $table->primary(['viagem_id', 'passageiro_id']);
            $table->timestamps();
            $table->foreign('viagem_id')
                ->references('id')->on('viagem')
                ->cascadeOnDelete();
            $table->foreign('passageiro_id')
                ->references('usuario_id')->on('passageiros')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('viagem_passageiros');
    }
};
