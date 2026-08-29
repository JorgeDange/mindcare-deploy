<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE pagamentos MODIFY COLUMN estado ENUM('Pago','Pendente','Cancelado','aprovado','recusado') NOT NULL DEFAULT 'Pendente'");

        Schema::table('pagamentos', function (Blueprint $table) {
            $table->foreignId('plano_id')->nullable()->constrained('planos')->nullOnDelete()->after('paciente_id');
            $table->foreignId('aprovado_por')->nullable()->constrained('users')->nullOnDelete()->after('comprovativo_path');
            $table->timestamp('aprovado_em')->nullable()->after('aprovado_por');
            $table->text('notas_admin')->nullable()->after('aprovado_em');
        });
    }

    public function down(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->dropForeign(['plano_id']);
            $table->dropColumn(['plano_id', 'aprovado_por', 'aprovado_em', 'notas_admin']);
        });

        DB::statement("ALTER TABLE pagamentos MODIFY COLUMN estado ENUM('Pago','Pendente','Cancelado') NOT NULL DEFAULT 'Pendente'");
    }
};
