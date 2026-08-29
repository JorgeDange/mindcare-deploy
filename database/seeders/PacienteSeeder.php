<?php

namespace Database\Seeders;

use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Plano;
use App\Models\PlanoSubscricao;
use App\Models\Profissional;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $profissionais = Profissional::all();
        if ($profissionais->isEmpty()) {
            $this->command->warn('Nenhum profissional encontrado. Execute ProfissionalSeeder primeiro.');

            return;
        }

        $planoParticular = Plano::where('slug', 'particular-basico')->first();

        $nomes = [
            'Ana Cristina Lopes',
            'Bruno Santos',
            'Carla Moreira',
            'Diago Fernandes',
            'Elena Silva',
            'Filipe Costa',
            'Gabriela Oliveira',
            'Hugo Martins',
            'Inês Pereira',
            'João Rodrigues',
        ];

        foreach ($nomes as $i => $nome) {
            $email = strtolower(str_replace(' ', '.', $nome)).'@email.com';
            $profissional = $profissionais[$i % $profissionais->count()];

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $nome,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'paciente',
                ]
            );

            $paciente = Paciente::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'profissional_id' => $profissional->id,
                    'motivo_consulta' => 'Acompanhamento psicológico',
                    'data_inicio' => now()->subMonths(3),
                ]
            );

            if ($planoParticular) {
                PlanoSubscricao::updateOrCreate(
                    [
                        'paciente_id' => $paciente->id,
                        'plano_id' => $planoParticular->id,
                    ],
                    [
                        'paciente_id' => $paciente->id,
                        'plano_id' => $planoParticular->id,
                        'sessoes_usadas' => 1,
                        'data_inicio' => now()->subMonths(1),
                        'data_validade' => now()->addMonths(11),
                        'estado' => 'Activo',
                    ]
                );
            }

            Consulta::create([
                'paciente_id' => $paciente->id,
                'profissional_id' => $profissional->id,
                'data' => now()->subWeek()->format('Y-m-d'),
                'hora' => '10:00:00',
                'modalidade' => 'online',
                'estado' => 'Realizada',
                'tipo' => 'Individual',
            ]);

            Consulta::create([
                'paciente_id' => $paciente->id,
                'profissional_id' => $profissional->id,
                'data' => now()->addDays(3)->format('Y-m-d'),
                'hora' => '14:30:00',
                'modalidade' => 'presencial',
                'estado' => 'Agendada',
                'tipo' => 'Individual',
            ]);
        }
    }
}
