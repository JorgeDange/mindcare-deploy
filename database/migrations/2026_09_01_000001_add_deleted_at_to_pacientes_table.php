<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['pacientes', 'users', 'consultas', 'profissionais', 'documentos'];

        foreach ($tables as $table) {
            if (! Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $bl) use ($table) {
                    $bl->timestamps();   // cria created_at/updated_at se nao existirem
                    $bl->softDeletes();  // cria deleted_at
                });
            }
        }
    }

    public function down(): void
    {
        $tables = ['pacientes', 'users', 'consultas', 'profissionais', 'documentos'];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $bl) use ($table) {
                    $bl->dropSoftDeletes();
                });
            }
        }
    }
};
