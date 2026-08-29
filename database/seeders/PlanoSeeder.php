<?php

namespace Database\Seeders;

use App\Models\Plano;
use Illuminate\Database\Seeder;

class PlanoSeeder extends Seeder
{
    public function run(): void
    {
        $planos = [
            // ─── PARTICULARES ───
            [
                'nome' => 'Básico',
                'slug' => 'particular-basico',
                'publico' => 'individual',
                'descricao' => '2 consultas por mês',
                'sessoes_total' => 2,
                'preco' => 50000,
                'beneficios' => [
                    '2 consultas por mês',
                    'Linha de apoio 24h (intervenção em crise)',
                    '20% de desconto em workshops e palestras',
                ],
            ],
            [
                'nome' => 'Avançado',
                'slug' => 'particular-avancado',
                'publico' => 'individual',
                'descricao' => '4 consultas por mês',
                'sessoes_total' => 4,
                'preco' => 70000,
                'beneficios' => [
                    '4 consultas por mês',
                    '1 consulta psiquiátrica por trimestre',
                    'Teleconsulta de emergência',
                    'Avaliação anual completa',
                ],
            ],
            [
                'nome' => 'Premium',
                'slug' => 'particular-premium',
                'publico' => 'individual',
                'descricao' => '6 consultas por mês',
                'sessoes_total' => 6,
                'preco' => 139000,
                'beneficios' => [
                    '6 consultas por mês',
                    '1 consulta psiquiátrica por mês',
                    '2 terapias familiares por ano',
                    'Workshops gratuitos',
                ],
            ],

            // ─── FAMILIAR & KANDENGUE ───
            [
                'nome' => 'Familiar Básico',
                'slug' => 'familiar-basico',
                'publico' => 'familia',
                'descricao' => 'Até 3 membros · 4 consultas/mês',
                'sessoes_total' => 4,
                'preco' => 85000,
                'beneficios' => [
                    '4 consultas por mês (partilhadas)',
                    'Terapia familiar mensal',
                    'Linha de apoio 24h',
                ],
            ],
            [
                'nome' => 'Familiar Avançado',
                'slug' => 'familiar-avancado',
                'publico' => 'familia',
                'descricao' => 'Até 5 membros · 8 consultas/mês',
                'sessoes_total' => 8,
                'preco' => 130000,
                'beneficios' => [
                    '8 consultas por mês (partilhadas)',
                    '2 terapias familiares por mês',
                    'Check-up emocional trimestral',
                    'Palestras exclusivas para pais',
                ],
            ],
            [
                'nome' => 'Familiar Premium',
                'slug' => 'familiar-premium',
                'publico' => 'familia',
                'descricao' => 'Até 7 membros · consultas ilimitadas',
                'sessoes_total' => 99,
                'preco' => 200000,
                'beneficios' => [
                    'Consultas ilimitadas (fair use)',
                    'Terapia familiar semanal',
                    'Apoio a cuidadores dedicado',
                    'Workshops e palestras gratuitos',
                ],
            ],
            [
                'nome' => 'Kandengue',
                'slug' => 'kandengue',
                'publico' => 'familia',
                'descricao' => 'Infantojuvenil a partir de 45.000 Kz/mês',
                'sessoes_total' => 4,
                'preco' => 45000,
                'beneficios' => [
                    'Ludoterapia especializada',
                    'Avaliação psicológica infantil',
                    'Orientação parental',
                    'Relatórios escolares',
                    'Terapia ABA (quando indicado)',
                    'Prevenção precoce',
                ],
            ],

            // ─── CORPORATIVOS ───
            [
                'nome' => 'Essencial',
                'slug' => 'corporativo-essencial',
                'publico' => 'empresa',
                'descricao' => 'Até 20 colaboradores',
                'sessoes_total' => 0,
                'preco' => 0,
                'beneficios' => [
                    'Diagnóstico de clima organizacional',
                    '2 workshops por trimestre',
                    'Linha de apoio para colaboradores',
                ],
            ],
            [
                'nome' => 'Profissional',
                'slug' => 'corporativo-profissional',
                'publico' => 'empresa',
                'descricao' => 'Até 100 colaboradores',
                'sessoes_total' => 0,
                'preco' => 0,
                'beneficios' => [
                    'Tudo do plano Essencial',
                    'Mentoria de liderança mensal',
                    'Dashboards de RH',
                    'Soft skills training trimestral',
                ],
            ],
            [
                'nome' => 'Enterprise',
                'slug' => 'corporativo-enterprise',
                'publico' => 'empresa',
                'descricao' => 'Ilimitado',
                'sessoes_total' => 0,
                'preco' => 0,
                'beneficios' => [
                    'Tudo do plano Profissional',
                    'Psicólogo residente na empresa',
                    'Programa de gestão de estresse',
                    'SOS corporativo 24h',
                ],
            ],
        ];

        foreach ($planos as $dados) {
            Plano::updateOrCreate(
                ['slug' => $dados['slug']],
                $dados
            );
        }
    }
}
