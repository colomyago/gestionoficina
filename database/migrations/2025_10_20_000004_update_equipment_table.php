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
            // Modificar el campo status para incluir más estados
            $table->enum('status', ['disponible', 'prestado', 'mantenimiento', 'baja'])
                ->default('disponible')
                ->change();
            
            // Agregar más campos útiles
            $table->string('codigo')->unique()->nullable()->after('name');
            $table->string('categoria')->nullable()->after('codigo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['codigo', 'categoria']);
            // Revertir status a los valores originales
            $table->string('status')->default('disponible')->change();
        });
    }
};
