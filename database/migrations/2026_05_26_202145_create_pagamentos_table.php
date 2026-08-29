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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plano_subscricao_id')->nullable()->constrained('plano_subscricoes')->nullOnDelete();
            $table->decimal('valor', 12, 2);
            $table->string('moeda', 3)->default('AOA');
            $table->string('metodo');              // "Transferência Bancária", "Multicaixa Express"
            $table->enum('estado', ['Pago', 'Pendente', 'Cancelado'])->default('Pendente');
            $table->date('data_pagamento');
            $table->string('referencia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
