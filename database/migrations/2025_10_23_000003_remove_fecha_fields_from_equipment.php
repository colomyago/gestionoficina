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
        Schema::table('equipment', function (Blueprint $table) {
            // Eliminar campos redundantes que ahora están en la tabla loans
            $table->dropColumn(['fecha_prestado', 'fecha_devolucion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            // Restaurar campos por si necesitamos hacer rollback
            $table->date('fecha_prestado')->nullable();
            $table->date('fecha_devolucion')->nullable();
        });
    }
};
