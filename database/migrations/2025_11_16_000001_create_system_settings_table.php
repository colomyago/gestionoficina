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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insertar configuraciones por defecto
        DB::table('system_settings')->insert([
            [
                'key' => 'max_equipments_per_worker',
                'value' => '5',
                'type' => 'integer',
                'description' => 'Cantidad máxima de equipos que un trabajador puede tener prestados simultáneamente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'dias_aviso_vencimiento',
                'value' => '7',
                'type' => 'integer',
                'description' => 'Días antes de la fecha de devolución para mostrar advertencia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
