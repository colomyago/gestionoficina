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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade'); // Trabajador que solicitó
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null'); // Personal de mantenimiento
            $table->enum('status', ['pendiente', 'en_proceso', 'completado', 'rechazado'])->default('pendiente');
            $table->text('descripcion_problema');
            $table->text('solucion')->nullable();
            $table->enum('resultado', ['reparado', 'dado_de_baja', 'pendiente'])->default('pendiente');
            $table->timestamp('fecha_solicitud');
            $table->timestamp('fecha_completado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
