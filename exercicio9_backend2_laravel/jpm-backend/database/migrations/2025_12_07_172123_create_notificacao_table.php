<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notificacao', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('mensagem');
            $table->integer('data_envio');              // timestamp
            $table->boolean('lida')->default(false);
            $table->integer('tipo_notificacao');
            $table->unsignedBigInteger('viagem_id')->nullable();
            $table->timestamps();
            $table->foreign('viagem_id')
                ->references('id')->on('viagem')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('notificacao');
    }
};
