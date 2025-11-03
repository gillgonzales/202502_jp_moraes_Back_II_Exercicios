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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('email', 255)->unique();
            $table->string('senha', 255);
            $table->integer('idade');
            $table->string('sexo', 10);
            $table->string('telefone', 20);
            $table->date('data_nascimento');
            $table->string('cpf', 14)->unique();
            $table->text('endereco');
            $table->string('nacionalidade', 100);
            $table->dateTime('ultima_atividade');
            $table->boolean('email_verificado')->default(false);
            $table->string('status_conta', 50)->default('PENDENTE');
            $table->string('foto_identidade', 255)->default('');
            $table->enum('tipo_usuario', ['ADMINISTRADOR', 'PASSAGEIRO', 'MOTORISTA']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
