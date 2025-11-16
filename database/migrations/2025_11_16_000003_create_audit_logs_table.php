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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event'); // loan_approved, loan_rejected, loan_returned, maintenance_created, etc.
            $table->string('auditable_type'); // Loan, Equipment, MaintenanceRequest
            $table->unsignedBigInteger('auditable_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que ejecutó la acción
            $table->json('old_values')->nullable(); // Valores anteriores
            $table->json('new_values')->nullable(); // Valores nuevos
            $table->text('description')->nullable(); // Descripción legible
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            // Índices
            $table->index(['auditable_type', 'auditable_id']);
            $table->index('event');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
