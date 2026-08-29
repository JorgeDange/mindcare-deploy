<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profissionais', function (Blueprint $table) {
            $table->index('especialidade');
        });

        Schema::table('planos', function (Blueprint $table) {
            $table->index('activo');
            $table->index('publico');
        });

        Schema::table('documentos', function (Blueprint $table) {
            $table->index('categoria');
            $table->index('novo');
        });
    }

    public function down(): void
    {
        Schema::table('profissionais', function (Blueprint $table) {
            $table->dropIndex(['especialidade']);
        });

        Schema::table('planos', function (Blueprint $table) {
            $table->dropIndex(['activo']);
            $table->dropIndex(['publico']);
        });

        Schema::table('documentos', function (Blueprint $table) {
            $table->dropIndex(['categoria']);
            $table->dropIndex(['novo']);
        });
    }
};
