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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('profissional_id')->nullable()->constrained('profissionais')->nullOnDelete();
            $table->string('motivo_consulta')->nullable();
            $table->text('condicoes')->nullable();
            $table->text('medicacao')->nullable();
            $table->text('observacoes')->nullable();
            $table->date('data_inicio')->nullable();
            $table->json('preferencias')->nullable();  // {modalidade, notif_email, notif_sms, alto_contraste}
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
