<?php

namespace Database\Seeders;

use App\Models\Usuario;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Usuario::factory(3)->create();
        //Criar factories e seeders de mais dois models pelo menos
        //E testar as configurações dos relacionamentos entre eles ao popular o banco.
    }
}
