<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pagamento', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_pagamento');
            $table->dateTime('data_confirmacao')->nullable();
            $table->decimal('valor', 10, 2);
            $table->string('status_pagamento', 50)->default('PENDENTE');
            $table->string('forma_pagamento', 50);
            $table->string('comprovante')->default('');
            $table->unsignedBigInteger('passageiro_id');
            $table->unsignedBigInteger('viagem_id');
            $table->timestamps();
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
        Schema::dropIfExists('pagamento');
    }
};
