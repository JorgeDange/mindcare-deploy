<?php

namespace Database\Seeders;

use App\Models\Plano;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlanosPublicosSeeder extends Seeder
{
    public function run()
    {
        $planos = [
            // PARTICULARES (individual)
            [
                'nome' => 'Básico (Particular)',
                'publico' => 'individual',
                'descricao' => 'Para quem quer começar e ter suporte contínuo.',
                'preco' => 50000,
                'sessoes_total' => 2,
                'beneficios' => json_encode([
                    '2 consultas por mês',
                    'Linha de apoio 24h (intervenção em crise)',
                    '20% de desconto em workshops e palestras',
                ]),
            ],
            [
                'nome' => 'Avançado (Particular)',
                'publico' => 'individual',
                'descricao' => 'Para quem precisa de acompanhamento mais completo.',
                'preco' => 70000,
                'sessoes_total' => 4,
                'beneficios' => json_encode([
                    '4 consultas por mês',
                    '1 consulta psiquiátrica por trimestre',
                    'Teleconsulta de emergência',
                    'Avaliação anual completa',
                ]),
            ],
            [
                'nome' => 'Premium (Particular)',
                'publico' => 'individual',
                'descricao' => 'Para acompanhamento intensivo e familiar.',
                'preco' => 139000,
                'sessoes_total' => 6,
                'beneficios' => json_encode([
                    '6 consultas por mês',
                    '1 consulta psiquiátrica por mês',
                    '2 terapias familiares por ano',
                    'Workshops gratuitos',
                ]),
            ],

            // FAMILIARES & KANDENGUE (familia)
            [
                'nome' => 'Básico (Familiar)',
                'publico' => 'familia',
                'descricao' => 'Cobertura essencial para famílias até 3 membros.',
                'preco' => 85000,
                'sessoes_total' => 4,
                'beneficios' => json_encode([
                    '4 consultas por mês (partilhadas)',
                    'Terapia familiar mensal',
                    'Linha de apoio 24h',
                ]),
            ],
            [
                'nome' => 'Avançado (Familiar)',
                'publico' => 'familia',
                'descricao' => 'Para famílias até 5 membros com acompanhamento completo.',
                'preco' => 130000,
                'sessoes_total' => 8,
                'beneficios' => json_encode([
                    '8 consultas por mês (partilhadas)',
                    '2 terapias familiares por mês',
                    'Check-up emocional trimestral',
                    'Palestras exclusivas para pais',
                ]),
            ],
            [
                'nome' => 'Premium (Familiar)',
                'publico' => 'familia',
                'descricao' => 'Cobertura total para famílias grandes com até 7 membros.',
                'preco' => 200000,
                'sessoes_total' => 0, // 0 = ilimitado
                'beneficios' => json_encode([
                    'Consultas ilimitadas (fair use)',
                    'Terapia familiar semanal',
                    'Apoio a cuidadores dedicado',
                    'Workshops e palestras gratuitos',
                ]),
            ],
            [
                'nome' => 'Kandengue',
                'publico' => 'familia',
                'descricao' => 'Cuidado especializado para crianças e adolescentes.',
                'preco' => 45000,
                'sessoes_total' => 4,
                'beneficios' => json_encode([
                    'Ludoterapia especializada',
                    'Avaliação psicológica infantil',
                    'Orientação parental',
                    'Relatórios escolares',
                    'Terapia ABA (quando indicado)',
                    'Prevenção precoce',
                ]),
            ],

            // CORPORATIVOS (empresa)
            [
                'nome' => 'Essencial (Corporativo)',
                'publico' => 'empresa',
                'descricao' => 'Até 20 colaboradores. Ideal para pequenas empresas.',
                'preco' => 0, // Sob consulta
                'sessoes_total' => 0,
                'beneficios' => json_encode([
                    'Diagnóstico de clima organizacional',
                    '2 workshops por trimestre',
                    'Linha de apoio para colaboradores',
                ]),
            ],
            [
                'nome' => 'Profissional (Corporativo)',
                'publico' => 'empresa',
                'descricao' => 'Até 100 colaboradores. Para médias empresas.',
                'preco' => 0,
                'sessoes_total' => 0,
                'beneficios' => json_encode([
                    'Tudo do plano Essencial',
                    'Mentoria de liderança mensal',
                    'Dashboards de RH',
                    'Soft skills training trimestral',
                ]),
            ],
            [
                'nome' => 'Enterprise (Corporativo)',
                'publico' => 'empresa',
                'descricao' => 'Ilimitado. Solução completa para grandes empresas.',
                'preco' => 0,
                'sessoes_total' => 0,
                'beneficios' => json_encode([
                    'Tudo do plano Profissional',
                    'Psicólogo residente na empresa',
                    'Programa de gestão de estresse',
                    'SOS corporativo 24h',
                ]),
            ],
        ];

        foreach ($planos as $plano) {
            Plano::updateOrCreate(
                ['nome' => $plano['nome']],
                [
                    'slug' => Str::slug($plano['nome']),
                    'publico' => $plano['publico'],
                    'descricao' => $plano['descricao'],
                    'preco' => $plano['preco'],
                    'sessoes_total' => $plano['sessoes_total'],
                    'moeda' => 'AOA',
                    'beneficios' => $plano['beneficios'],
                    'activo' => true,
                ]
            );
        }
    }
}
