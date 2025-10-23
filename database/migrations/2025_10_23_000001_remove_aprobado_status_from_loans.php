<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Actualizar cualquier registro con estado 'aprobado' a 'activo'
        DB::table('loans')
            ->where('status', 'aprobado')
            ->update(['status' => 'activo']);

        // Modificar la columna para eliminar 'aprobado' del enum
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pendiente', 'rechazado', 'activo', 'devuelto') NOT NULL DEFAULT 'pendiente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar el enum con 'aprobado'
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pendiente', 'aprobado', 'rechazado', 'activo', 'devuelto') NOT NULL DEFAULT 'pendiente'");
    }
};
