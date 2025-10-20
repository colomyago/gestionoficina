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
        $equipments = [
            [
                'name' => 'Laptop Dell Inspiron 15',
                'codigo' => 'LAP-001',
                'categoria' => 'Computadoras',
                'description' => 'Laptop para trabajo de oficina con procesador Intel i5, 8GB RAM, 256GB SSD',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Laptop HP ProBook 450',
                'codigo' => 'LAP-002',
                'categoria' => 'Computadoras',
                'description' => 'Laptop con Intel i7, 16GB RAM, 512GB SSD',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Proyector Epson PowerLite',
                'codigo' => 'PROY-001',
                'categoria' => 'Proyección',
                'description' => 'Proyector para presentaciones, resolución 1080p, 3000 lúmenes',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Cámara Canon EOS R6',
                'codigo' => 'CAM-001',
                'categoria' => 'Fotografía',
                'description' => 'Cámara profesional para fotografía y video, incluye lente 24-70mm',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Tablet iPad Pro 12.9"',
                'codigo' => 'TAB-001',
                'categoria' => 'Tablets',
                'description' => 'Tablet para diseño y presentaciones, incluye Apple Pencil',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Monitor Samsung 27" 4K',
                'codigo' => 'MON-001',
                'categoria' => 'Monitores',
                'description' => 'Monitor externo para estaciones de trabajo, resolución 4K, conexión USB-C',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Impresora HP LaserJet Pro',
                'codigo' => 'IMP-001',
                'categoria' => 'Impresoras',
                'description' => 'Impresora láser monocromática, ideal para documentos de oficina',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Micrófono Blue Yeti',
                'codigo' => 'MIC-001',
                'categoria' => 'Audio',
                'description' => 'Micrófono USB para grabaciones y videoconferencias de alta calidad',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Router Wi-Fi 6 TP-Link',
                'codigo' => 'NET-001',
                'categoria' => 'Redes',
                'description' => 'Router de alta velocidad para redes empresariales, Wi-Fi 6',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Disco Duro Externo 2TB',
                'codigo' => 'STOR-001',
                'categoria' => 'Almacenamiento',
                'description' => 'Almacenamiento portátil para respaldos, USB 3.0, 2TB de capacidad',
                'status' => 'disponible',
                'user_id' => null,
                'fecha_prestado' => null,
                'fecha_devolucion' => null,
            ],
            [
                'name' => 'Teclado Mecánico Logitech',
                'codigo' => 'PER-001',
                'categoria' => 'Periféricos',
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