<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Avaliacao\Criterio;

class CriteriosSeeder extends Seeder
{
    public function run(): void
    {
        $criterios = [
            ['nome' => 'Pontualidade e Assiduidade', 'descricao' => 'Cumprimento de horários e presença regular.'],
            ['nome' => 'Qualidade do Trabalho', 'descricao' => 'Excelência, precisão e padrões cumpridos.'],
            ['nome' => 'Colaboração e Trabalho em Equipa', 'descricao' => 'Capacidade de cooperar e comunicar com colegas.'],
            ['nome' => 'Conhecimento Técnico (Saber)', 'descricao' => 'Domínio de conceitos e teorias necessários ao cargo.'],
            ['nome' => 'Habilidade Prática (Saber Fazer)', 'descricao' => 'Execução prática e destreza no trabalho.'],
            ['nome' => 'Atitude e Motivação (Querer Fazer)', 'descricao' => 'Proatividade, responsabilidade e engajamento.'],
            ['nome' => 'Inovação e Aprendizagem Contínua', 'descricao' => 'Capacidade de adaptação, criatividade e aprendizagem.'],
        ];

        foreach ($criterios as $criterio) {
            Criterio::create($criterio);
        }
    }
}
