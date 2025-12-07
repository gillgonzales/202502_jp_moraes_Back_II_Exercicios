<?php

//usando table-per-type - tenho um SQL pronto (esta junto com o dump do banco)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();                                           // bigint unsigned
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('senha');
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
            $table->string('foto_identidade')->default('');
            $table->enum('tipo_usuario', ['ADMINISTRADOR', 'PASSAGEIRO', 'MOTORISTA']);
            //$table->timestamps(false, false);                       
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
