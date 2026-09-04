<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->integer('frequencia_cardiaca')->nullable()->after('plano_terapeutico');
            $table->integer('pressao_sistolica')->nullable()->after('frequencia_cardiaca');
            $table->integer('pressao_diastolica')->nullable()->after('pressao_sistolica');
            $table->decimal('peso', 5, 2)->nullable()->after('pressao_diastolica');
        });
    }

    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['frequencia_cardiaca', 'pressao_sistolica', 'pressao_diastolica', 'peso']);
        });
    }
};
