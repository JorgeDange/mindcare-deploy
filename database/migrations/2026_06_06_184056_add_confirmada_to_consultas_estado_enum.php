<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE consultas MODIFY COLUMN estado ENUM('Agendada', 'Confirmada', 'Realizada', 'Faltou', 'Cancelada') NOT NULL DEFAULT 'Agendada'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE consultas MODIFY COLUMN estado ENUM('Agendada', 'Realizada', 'Faltou', 'Cancelada') NOT NULL DEFAULT 'Agendada'");
    }
};
