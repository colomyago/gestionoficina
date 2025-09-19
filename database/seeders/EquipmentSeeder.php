<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;
use App\Models\User;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos usuarios existentes (asumiendo que ya tienes usuarios)
        $users = User::all();
        
        $equipments = [
            [
                'name' => 'Laptop Dell Inspiron 15',
                'description' => 'Laptop para trabajo de oficina con procesador Intel i5, 8GB RAM, 256GB SSD',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Proyector Epson PowerLite',
                'description' => 'Proyector para presentaciones, resolución 1080p, 3000 lúmenes',
                'status' => 'prestado',
                'user_id' => $users->isNotEmpty() ? $users->random()->id : null,
                'fecha_prestado' => now()->subDays(5),
                'fecha_devolucion' => now()->addDays(2),
            ],
            [
                'name' => 'Cámara Canon EOS R6',
                'description' => 'Cámara profesional para fotografía y video, incluye lente 24-70mm',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Tablet iPad Pro 12.9"',
                'description' => 'Tablet para diseño y presentaciones, incluye Apple Pencil',
                'status' => 'mantenimiento',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Monitor Samsung 27" 4K',
                'description' => 'Monitor externo para estaciones de trabajo, resolución 4K, conexión USB-C',
                'status' => 'prestado',
                'user_id' => $users->isNotEmpty() ? $users->random()->id : null,
                'fecha_prestado' => now()->subDays(10),
                'fecha_devolucion' => now()->addDays(5),
            ],
            [
                'name' => 'Impresora HP LaserJet Pro',
                'description' => 'Impresora láser monocromática, ideal para documentos de oficina',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Micrófono Blue Yeti',
                'description' => 'Micrófono USB para grabaciones y videoconferencias de alta calidad',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Router Wi-Fi 6 TP-Link',
                'description' => 'Router de alta velocidad para redes empresariales, Wi-Fi 6',
                'status' => 'prestado',
                'user_id' => $users->isNotEmpty() ? $users->random()->id : null,
                'fecha_prestado' => now()->subDays(3),
                'fecha_devolucion' => now()->addDays(7),
            ],
            [
                'name' => 'Disco Duro Externo 2TB',
                'description' => 'Almacenamiento portátil para respaldos, USB 3.0, 2TB de capacidad',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Teclado Mecánico Logitech',
                'description' => 'Teclado mecánico para programación, switches azules, retroiluminado',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ]
        ];

        foreach ($equipments as $equipment) {
            Equipment::create($equipment);
        }
    }
}