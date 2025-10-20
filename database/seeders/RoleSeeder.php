<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario Admin
        User::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@gestionoficina.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Crear usuarios Trabajadores
        User::create([
            'name' => 'Carlos Trabajador',
            'email' => 'carlos@gestionoficina.com',
            'password' => Hash::make('password123'),
            'role' => 'trabajador',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'María Trabajadora',
            'email' => 'maria@gestionoficina.com',
            'password' => Hash::make('password123'),
            'role' => 'trabajador',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Juan Trabajador',
            'email' => 'juan@gestionoficina.com',
            'password' => Hash::make('password123'),
            'role' => 'trabajador',
            'email_verified_at' => now(),
        ]);

        // Crear usuarios de Mantenimiento
        User::create([
            'name' => 'Pedro Mantenimiento',
            'email' => 'pedro@gestionoficina.com',
            'password' => Hash::make('password123'),
            'role' => 'mantenimiento',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ana Mantenimiento',
            'email' => 'ana@gestionoficina.com',
            'password' => Hash::make('password123'),
            'role' => 'mantenimiento',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Usuarios con roles creados exitosamente');
        $this->command->info('📧 Admin: admin@gestionoficina.com');
        $this->command->info('📧 Trabajadores: carlos@, maria@, juan@gestionoficina.com');
        $this->command->info('📧 Mantenimiento: pedro@, ana@gestionoficina.com');
        $this->command->info('🔑 Contraseña para todos: password123');
    }
}
