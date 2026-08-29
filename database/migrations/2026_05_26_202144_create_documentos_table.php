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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('partilhado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nome');
            $table->string('tipo', 10)->default('PDF');  // PDF, JPG, PNG
            $table->string('caminho');                    // path no Storage
            $table->unsignedBigInteger('tamanho')->default(0);
            $table->boolean('novo')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
