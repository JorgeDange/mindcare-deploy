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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('profissional_id')->constrained('profissionais');
            $table->date('data');
            $table->time('hora');
            $table->enum('modalidade', ['online', 'presencial']);
            $table->enum('estado', ['Agendada', 'Realizada', 'Faltou', 'Cancelada'])->default('Agendada');
            $table->enum('tipo', ['Individual', 'Casal', 'Familiar', 'Avaliação Inicial', 'Grupo'])->default('Individual');
            $table->boolean('confirmada')->default(false);
            $table->string('link_videocall')->nullable();
            $table->text('observacoes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
