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

        // Crear más usuarios Admin
        $admins = [
            ['name' => 'Laura Administradora', 'email' => 'laura@gestionoficina.com'],
            ['name' => 'Roberto Admin', 'email' => 'roberto@gestionoficina.com'],
        ];

        foreach ($admins as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password123'),
                    'role_id' => $adminRole->id,
                    'email_verified_at' => now(),
                ]
            );
            $this->command->info("👑 Admin adicional creado: {$user->name} ({$user->email})");
        }

        // Crear usuarios Trabajadores
        $trabajadores = [
            ['name' => 'Carlos Trabajador', 'email' => 'carlos@gestionoficina.com'],
            ['name' => 'María Trabajadora', 'email' => 'maria@gestionoficina.com'],
            ['name' => 'Juan Trabajador', 'email' => 'juan@gestionoficina.com'],
            ['name' => 'Sofia Desarrolladora', 'email' => 'sofia@gestionoficina.com'],
            ['name' => 'Diego Diseñador', 'email' => 'diego@gestionoficina.com'],
            ['name' => 'Valentina Marketing', 'email' => 'valentina@gestionoficina.com'],
            ['name' => 'Lucas Ventas', 'email' => 'lucas@gestionoficina.com'],
            ['name' => 'Camila RRHH', 'email' => 'camila@gestionoficina.com'],
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
            ['name' => 'Fernando Técnico', 'email' => 'fernando@gestionoficina.com'],
            ['name' => 'Patricia Técnica', 'email' => 'patricia@gestionoficina.com'],
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
        
        $totalUsers = User::count();
        $this->command->info("📊 Total de usuarios creados: $totalUsers");
        $this->command->table(
            ['Rol', 'Cantidad'],
            [
                ['Admin', User::where('role_id', $adminRole->id)->count()],
                ['Trabajador', User::where('role_id', $trabajadorRole->id)->count()],
                ['Mantenimiento', User::where('role_id', $mantenimientoRole->id)->count()],
            ]
        );
        
        $this->command->newLine();
        $this->command->info('🔑 Credenciales de acceso (contraseña para todos: password123):');
        $this->command->table(
            ['Rol', 'Email', 'Contraseña'],
            [
                ['Admin', 'admin@gestionoficina.com', 'password123'],
                ['Admin', 'laura@gestionoficina.com', 'password123'],
                ['Admin', 'roberto@gestionoficina.com', 'password123'],
                ['Trabajador', 'carlos@gestionoficina.com', 'password123'],
                ['Trabajador', 'maria@gestionoficina.com', 'password123'],
                ['Trabajador', 'juan@gestionoficina.com', 'password123'],
                ['Trabajador', 'sofia@gestionoficina.com', 'password123'],
                ['Trabajador', 'diego@gestionoficina.com', 'password123'],
                ['Trabajador', 'valentina@gestionoficina.com', 'password123'],
                ['Trabajador', 'lucas@gestionoficina.com', 'password123'],
                ['Trabajador', 'camila@gestionoficina.com', 'password123'],
                ['Mantenimiento', 'pedro@gestionoficina.com', 'password123'],
                ['Mantenimiento', 'ana@gestionoficina.com', 'password123'],
                ['Mantenimiento', 'fernando@gestionoficina.com', 'password123'],
                ['Mantenimiento', 'patricia@gestionoficina.com', 'password123'],
            ]
        );
    }
}