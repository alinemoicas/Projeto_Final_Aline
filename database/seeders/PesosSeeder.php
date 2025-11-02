<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Avaliacao\Peso;

class PesosSeeder extends Seeder
{
    public function run(): void
    {
        $pesos = [
            ['valor' => 5, 'descricao' => 'Muito Baixo'],
            ['valor' => 10, 'descricao' => 'Baixo'],
            ['valor' => 15, 'descricao' => 'Médio'],
            ['valor' => 20, 'descricao' => 'Alto'],
            ['valor' => 30, 'descricao' => 'Muito Alto'],
        ];

        foreach ($pesos as $peso) {
            Peso::create($peso);
        }
    }
}