<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando creación de roles y usuarios...');

        // Crear roles si no existen
        $adminRole = Role::firstOrCreate(
            ['code' => 'admin'],
            ['name' => 'Administrador']
        );
        $this->command->info("✅ Rol Admin creado/verificado (ID: {$adminRole->id})");

        $trabajadorRole = Role::firstOrCreate(
            ['code' => 'trabajador'],
            ['name' => 'Trabajador']
        );
        $this->command->info("✅ Rol Trabajador creado/verificado (ID: {$trabajadorRole->id})");

        $mantenimientoRole = Role::firstOrCreate(
            ['code' => 'mantenimiento'],
            ['name' => 'Mantenimiento']
        );
        $this->command->info("✅ Rol Mantenimiento creado/verificado (ID: {$mantenimientoRole->id})");

        $this->command->newLine();
        $this->command->info('👥 Creando usuarios...');

        // Crear usuario Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@gestionoficina.com'],
            [
                'name' => 'Administrador Principal',
                'password' => Hash::make('password123'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );
        $this->command->info("👑 Admin creado: {$admin->name} ({$admin->email}) - Role ID: {$admin->role_id}");

        // Crear usuarios Trabajadores
        $trabajadores = [
            ['name' => 'Carlos Trabajador', 'email' => 'carlos@gestionoficina.com'],
            ['name' => 'María Trabajadora', 'email' => 'maria@gestionoficina.com'],
            ['name' => 'Juan Trabajador', 'email' => 'juan@gestionoficina.com'],
        ];

        foreach ($trabajadores as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password123'),
                    'role_id' => $trabajadorRole->id,
                    'email_verified_at' => now(),
                ]
            );
            $this->command->info("👷 Trabajador creado: {$user->name} ({$user->email})");
        }

        // Crear usuarios de Mantenimiento
        $mantenimiento = [
            ['name' => 'Pedro Mantenimiento', 'email' => 'pedro@gestionoficina.com'],
            ['name' => 'Ana Mantenimiento', 'email' => 'ana@gestionoficina.com'],
        ];

        foreach ($mantenimiento as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password123'),
                    'role_id' => $mantenimientoRole->id,
                    'email_verified_at' => now(),
                ]
            );
            $this->command->info("🔧 Mantenimiento creado: {$user->name} ({$user->email})");
        }

        $this->command->newLine();
        $this->command->info('✅ ¡Proceso completado exitosamente!');
        $this->command->newLine();
        $this->command->table(
            ['Rol', 'Email', 'Contraseña'],
            [
                ['Admin', 'admin@gestionoficina.com', 'password123'],
                ['Trabajador', 'carlos@gestionoficina.com', 'password123'],
                ['Trabajador', 'maria@gestionoficina.com', 'password123'],
                ['Trabajador', 'juan@gestionoficina.com', 'password123'],
                ['Mantenimiento', 'pedro@gestionoficina.com', 'password123'],
                ['Mantenimiento', 'ana@gestionoficina.com', 'password123'],
            ]
        );
    }
}