<?php

namespace Database\Factories;

use App\Models\Usuario;                              // modelo alvo
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;               // aponta para Usuario

    // Define os valores padrão de cada coluna
    public function definition(): array
    {
        return [
            'nome'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'senha'             => Hash::make('password'), // senha default
            'idade'             => $this->faker->numberBetween(18, 60),
            'sexo'              => $this->faker->randomElement(['M', 'F']),
            'telefone'          => $this->faker->phoneNumber(),
            'data_nascimento'   => $this->faker->date(),
            'cpf' => str_pad($this->faker->randomNumber(9), 11, '0', STR_PAD_LEFT),
            'endereco'          => $this->faker->address(),
            'nacionalidade'     => 'brasileira',
            'ultima_atividade'  => now(),
            'email_verificado'  => true,
            'status_conta'      => 'ativa',
            'foto_identidade'   => 'teste.jpg',
            'tipo_usuario'      => 'ADMINISTRADOR',
            //'remember_token'    => Str::random(10),  // só se a coluna existir (talvez tenha que criar depois ,vou ver)
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verificado' => false,
        ]);
    }
}