<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Funcionario;
use App\Models\Cargo;
use App\Models\Departamento;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $cargo = Cargo::firstOrCreate([
            'nome' => 'Gestora de RH'
        ], [
            'descricao' => 'Responsável pela gestão de Pessoas & Cultura',
            'categoria' => 'Tecnico Superior',
            'nivel' => 'Direcção'
        ]);

        $departamento = Departamento::firstOrCreate([
            'nome_dept' => 'Administração & GRH'
        ], [
            'sigla' => 'GRH',
            'descricao_dept' => 'Departamento responsável pela administração de pessoal'
        ]);

        $user = User::create([
            'name' => 'Aline Moicas',
            'email' => 'alinemoicas23@gmail.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin'
        ]);

        /*Funcionario::create([
            'nome' => 'Aline',
            'sobrenome'=> 'Moicas',
            'telefone' => '(+244) 923 000 100',
            'email' => 'alinemoicas23@gmail.com',
            'cargo_id' => $cargo->id,
            'dept_id' => $departamento->id,
            'data_admissao' => '2021-03-01',
            'chefe_id' => null,
            'categoria'=> 'Tecnico Superior',
            'estado' => 'activo',
            'user_id' => $user->id
        ]);*/
    }
}
