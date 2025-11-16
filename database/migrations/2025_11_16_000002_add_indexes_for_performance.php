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
        // Índices para la tabla equipment
        Schema::table('equipment', function (Blueprint $table) {
            $table->index('status');
            $table->index('user_id');
            $table->index(['status', 'user_id']);
        });

        // Índices para la tabla loans
        Schema::table('loans', function (Blueprint $table) {
            $table->index('status');
            $table->index('user_id');
            $table->index('equipment_id');
            $table->index('assigned_by');
            $table->index('fecha_prestamo');
            $table->index('fecha_devolucion');
            $table->index(['status', 'user_id']);
            $table->index(['status', 'equipment_id']);
        });

        // Índices para la tabla maintenance_requests
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->index('status');
            $table->index('equipment_id');
            $table->index('requested_by');
            $table->index('assigned_to');
            $table->index('resultado');
            $table->index(['status', 'assigned_to']);
        });

        // Índices para la tabla users
        Schema::table('users', function (Blueprint $table) {
            $table->index('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status', 'user_id']);
        });

        Schema::table('loans', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['equipment_id']);
            $table->dropIndex(['assigned_by']);
            $table->dropIndex(['fecha_prestamo']);
            $table->dropIndex(['fecha_devolucion']);
            $table->dropIndex(['status', 'user_id']);
            $table->dropIndex(['status', 'equipment_id']);
        });

        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['equipment_id']);
            $table->dropIndex(['requested_by']);
            $table->dropIndex(['assigned_to']);
            $table->dropIndex(['resultado']);
            $table->dropIndex(['status', 'assigned_to']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role_id']);
        });
    }
};
