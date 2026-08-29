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
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');               // Particular, Família, Corporativo, PME
            $table->string('slug')->unique();
            $table->enum('publico', ['individual', 'familia', 'empresa']);
            $table->text('descricao');
            $table->integer('sessoes_total');
            $table->decimal('preco', 10, 2)->nullable();
            $table->string('moeda', 3)->default('AOA');
            $table->json('beneficios')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planos');
    }
};
