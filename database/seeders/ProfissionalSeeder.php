<?php

namespace Database\Seeders;

use App\Models\Profissional;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfissionalSeeder extends Seeder
{
    public function run(): void
    {
        $dados = [
            [
                'name' => 'Dra. Ana Lopes',
                'email' => 'ana@mindcare.ao',
                'especialidade' => 'Psicologia Clínica',
                'registro_profissional' => '12345',
                'bio' => 'Especialista em ansiedade e stress.',
            ],
            [
                'name' => 'Dr. Carlos Mendes',
                'email' => 'carlos@mindcare.ao',
                'especialidade' => 'Psiquiatria',
                'registro_profissional' => '12346',
                'bio' => 'Psiquiatra com experiência em perturbações do humor.',
            ],
            [
                'name' => 'Dra. Sofia Neto',
                'email' => 'sofia@mindcare.ao',
                'especialidade' => 'Psicologia Infantil',
                'registro_profissional' => '12347',
                'bio' => 'Especialista em terapia infantil e adolescente.',
            ],
        ];

        foreach ($dados as $d) {
            $user = User::updateOrCreate(
                ['email' => $d['email']],
                [
                    'name' => $d['name'],
                    'email' => $d['email'],
                    'password' => Hash::make('password'),
                    'role' => 'profissional',
                ]
            );

            Profissional::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'especialidade' => $d['especialidade'],
                    'registro_profissional' => $d['registro_profissional'],
                    'bio' => $d['bio'],
                    'activo' => true,
                ]
            );
        }
    }
}
