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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que solicita/tiene el equipo
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null'); // Admin que asignó
            $table->enum('status', ['pendiente', 'aprobado', 'rechazado', 'activo', 'devuelto'])->default('pendiente');
            $table->date('fecha_solicitud')->nullable();
            $table->date('fecha_prestamo')->nullable();
            $table->date('fecha_devolucion')->nullable();
            $table->text('motivo')->nullable(); // Por qué necesita el equipo
            $table->text('notas')->nullable(); // Notas del admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
