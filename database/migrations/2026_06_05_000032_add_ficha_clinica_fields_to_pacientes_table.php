<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->text('diagnostico')->nullable()->after('condicoes');
            $table->text('medicacao_atual')->nullable()->after('diagnostico');
            $table->text('historico_familiar')->nullable()->after('medicacao_atual');
            $table->text('observacoes_profissional')->nullable()->after('historico_familiar');
            $table->text('plano_terapeutico')->nullable()->after('observacoes_profissional');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['diagnostico', 'medicacao_atual', 'historico_familiar', 'observacoes_profissional', 'plano_terapeutico']);
        });
    }
};
