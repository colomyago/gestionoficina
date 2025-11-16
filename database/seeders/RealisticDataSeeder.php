<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;
use App\Models\User;
use App\Models\Loan;
use App\Models\MaintenanceRequest;
use Carbon\Carbon;

class RealisticDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎯 Creando datos realistas del sistema...');
        $this->command->newLine();

        // Obtener usuarios - Admins
        $admin = User::where('email', 'admin@gestionoficina.com')->first();
        $laura = User::where('email', 'laura@gestionoficina.com')->first();
        $roberto = User::where('email', 'roberto@gestionoficina.com')->first();
        
        // Trabajadores
        $carlos = User::where('email', 'carlos@gestionoficina.com')->first();
        $maria = User::where('email', 'maria@gestionoficina.com')->first();
        $juan = User::where('email', 'juan@gestionoficina.com')->first();
        $sofia = User::where('email', 'sofia@gestionoficina.com')->first();
        $diego = User::where('email', 'diego@gestionoficina.com')->first();
        $valentina = User::where('email', 'valentina@gestionoficina.com')->first();
        $lucas = User::where('email', 'lucas@gestionoficina.com')->first();
        $camila = User::where('email', 'camila@gestionoficina.com')->first();
        
        // Mantenimiento
        $pedro = User::where('email', 'pedro@gestionoficina.com')->first();
        $ana = User::where('email', 'ana@gestionoficina.com')->first();
        $fernando = User::where('email', 'fernando@gestionoficina.com')->first();
        $patricia = User::where('email', 'patricia@gestionoficina.com')->first();

        // 1. EQUIPOS DISPONIBLES (15 equipos - inventario variado de oficina)
        $this->command->info('💻 Creando equipos disponibles en inventario...');
        
        // Limpiar datos anteriores para evitar duplicados
        $this->command->warn('⚠️  Limpiando datos anteriores...');
        \App\Models\Loan::truncate();
        \App\Models\MaintenanceRequest::truncate();
        \App\Models\Equipment::truncate();
        
        $equiposDisponibles = [
            // Computadoras (4)
            [
                'name' => 'MacBook Pro 16" M3',
                'codigo' => 'LAP-001',
                'categoria' => 'Computadoras',
                'description' => 'MacBook Pro 16 pulgadas con chip M3 Pro, 32GB RAM, 1TB SSD. Ideal para desarrollo y diseño.',
                'status' => 'disponible',
            ],
            [
                'name' => 'Dell XPS 15',
                'codigo' => 'LAP-002',
                'categoria' => 'Computadoras',
                'description' => 'Laptop Dell XPS 15, Intel i7 13va gen, 16GB RAM, 512GB SSD, pantalla 4K táctil.',
                'status' => 'disponible',
            ],
            [
                'name' => 'Lenovo Legion 5 Pro',
                'codigo' => 'LAP-007',
                'categoria' => 'Computadoras',
                'description' => 'Laptop gaming/workstation RTX 4060, Ryzen 7, 16GB RAM, 1TB SSD. Para renders y edición.',
                'status' => 'disponible',
            ],
            [
                'name' => 'ASUS ZenBook 14',
                'codigo' => 'LAP-008',
                'categoria' => 'Computadoras',
                'description' => 'Ultrabook i5 12va gen, 16GB RAM, 512GB SSD, OLED táctil. Ultra portátil.',
                'status' => 'disponible',
            ],
            
            // Tablets (2)
            [
                'name' => 'iPad Pro 12.9"',
                'codigo' => 'TAB-001',
                'categoria' => 'Tablets',
                'description' => 'iPad Pro 12.9" con Magic Keyboard y Apple Pencil, 256GB, ideal para presentaciones.',
                'status' => 'disponible',
            ],
            [
                'name' => 'Samsung Galaxy Tab S8 Ultra',
                'codigo' => 'TAB-004',
                'categoria' => 'Tablets',
                'description' => 'Tablet Android 14.6", S-Pen, 512GB, teclado book cover. Para Android development.',
                'status' => 'disponible',
            ],
            
            // Proyectores (1)
            [
                'name' => 'Proyector Epson EB-2250U',
                'codigo' => 'PROY-001',
                'categoria' => 'Proyección',
                'description' => 'Proyector 3LCD WUXGA, 5000 lúmenes, conexión HDMI/USB/WiFi. Para salas de reuniones.',
                'status' => 'disponible',
            ],
            
            // Cámaras (1)
            [
                'name' => 'Cámara Sony A7 IV',
                'codigo' => 'CAM-001',
                'categoria' => 'Fotografía',
                'description' => 'Cámara mirrorless full-frame 33MP con lente 24-70mm f/2.8. Incluye 3 baterías y SD 128GB.',
                'status' => 'disponible',
            ],
            
            // Monitores (2)
            [
                'name' => 'Monitor LG UltraWide 34"',
                'codigo' => 'MON-001',
                'categoria' => 'Monitores',
                'description' => 'Monitor curved 34" 21:9 3440x1440 IPS, 144Hz, HDR400, USB-C con Power Delivery.',
                'status' => 'disponible',
            ],
            [
                'name' => 'ASUS ProArt PA279CV 27"',
                'codigo' => 'MON-004',
                'categoria' => 'Monitores',
                'description' => 'Monitor 4K IPS profesional para diseñadores, 100% sRGB, calibrado.',
                'status' => 'disponible',
            ],
            
            // Audio (2)
            [
                'name' => 'Micrófono Shure SM7B',
                'codigo' => 'AUD-001',
                'categoria' => 'Audio',
                'description' => 'Micrófono dinámico cardioide con interfaz Focusrite Scarlett 2i2. Para grabaciones profesionales.',
                'status' => 'disponible',
            ],
            [
                'name' => 'Sistema Audio Conference Jabra',
                'codigo' => 'AUD-003',
                'categoria' => 'Audio',
                'description' => 'Speakerphone 360° con micrófono omnidireccional para salas de reuniones hasta 10 personas.',
                'status' => 'disponible',
            ],
            
            // Redes (1)
            [
                'name' => 'Router Cisco Catalyst',
                'codigo' => 'NET-001',
                'categoria' => 'Redes',
                'description' => 'Router empresarial Gigabit con soporte PoE+, 24 puertos, gestión cloud.',
                'status' => 'disponible',
            ],
            
            // Almacenamiento (1)
            [
                'name' => 'WD My Book 8TB External',
                'codigo' => 'ALM-003',
                'categoria' => 'Almacenamiento',
                'description' => 'Disco duro externo 8TB USB 3.0 con cifrado por hardware, backup automático.',
                'status' => 'disponible',
            ],
            
            // Accesorios (1)
            [
                'name' => 'Logitech MX Master 3S + Teclado MX Keys',
                'codigo' => 'ACC-001',
                'categoria' => 'Accesorios',
                'description' => 'Combo mouse y teclado inalámbrico profesional, multi-dispositivo, batería 70 días.',
                'status' => 'disponible',
            ],
        ];

        foreach ($equiposDisponibles as $equipo) {
            Equipment::create($equipo);
        }
        $this->command->info("✅ " . count($equiposDisponibles) . " equipos disponibles creados en inventario");

        // 2. EQUIPOS PRESTADOS CON PRÉSTAMOS ACTIVOS (10 equipos - distribuidos entre más usuarios)
        $this->command->info('📦 Creando equipos prestados con préstamos activos...');
        
        // Carlos - Desarrollador (2 equipos)
        $laptopCarlos = Equipment::create([
            'name' => 'Lenovo ThinkPad X1 Carbon',
            'codigo' => 'LAP-003',
            'categoria' => 'Computadoras',
            'description' => 'ThinkPad X1 Carbon Gen 11, Intel i7, 16GB RAM, 512GB SSD. Ultra liviana para viajes.',
            'status' => 'prestado',
            'user_id' => $carlos->id,
        ]);
        Loan::create([
            'equipment_id' => $laptopCarlos->id,
            'user_id' => $carlos->id,
            'assigned_by' => $admin->id,
            'status' => 'activo',
            'fecha_solicitud' => Carbon::now()->subDays(15),
            'fecha_prestamo' => Carbon::now()->subDays(14),
            'fecha_devolucion' => Carbon::now()->addDays(16),
            'motivo' => 'Desarrollo del proyecto de migración a Laravel 12. Necesito trabajar remoto.',
            'notas' => 'Aprobado para proyecto prioritario Q4',
        ]);

        $tabletCarlos = Equipment::create([
            'name' => 'Samsung Galaxy Tab S9+',
            'codigo' => 'TAB-002',
            'categoria' => 'Tablets',
            'description' => 'Galaxy Tab S9+ 12.4", 256GB, S-Pen incluido. Para presentaciones móviles.',
            'status' => 'prestado',
            'user_id' => $carlos->id,
        ]);
        Loan::create([
            'equipment_id' => $tabletCarlos->id,
            'user_id' => $carlos->id,
            'assigned_by' => $laura->id,
            'status' => 'activo',
            'fecha_solicitud' => Carbon::now()->subDays(8),
            'fecha_prestamo' => Carbon::now()->subDays(7),
            'fecha_devolucion' => Carbon::now()->addDays(8),
            'motivo' => 'Presentación de resultados trimestrales a clientes externos.',
            'notas' => 'Devolver después del evento del viernes',
        ]);

        // María - Marketing (2 equipos)
        $proyectorMaria = Equipment::create([
            'name' => 'BenQ MW612 Proyector',
            'codigo' => 'PROY-002',
            'categoria' => 'Proyección',
            'description' => 'Proyector DLP 4000 lúmenes, WXGA, con control remoto y estuche.',
            'status' => 'prestado',
            'user_id' => $maria->id,
        ]);
        Loan::create([
            'equipment_id' => $proyectorMaria->id,
            'user_id' => $maria->id,
            'assigned_by' => $admin->id,
            'status' => 'activo',
            'fecha_solicitud' => Carbon::now()->subDays(5),
            'fecha_prestamo' => Carbon::now()->subDays(4),
            'fecha_devolucion' => Carbon::now()->addDays(3),
            'motivo' => 'Capacitación interna del equipo de ventas - semana intensiva.',
            'notas' => 'Evento confirmado, sala 3A reservada',
        ]);

        $camaraMaria = Equipment::create([
            'name' => 'Canon EOS R6 Mark II',
            'codigo' => 'CAM-002',
            'categoria' => 'Fotografía',
            'description' => 'Cámara mirrorless 24MP con lentes 24-105mm y 50mm f/1.8. 2 baterías extra.',
            'status' => 'prestado',
            'user_id' => $maria->id,
        ]);
        Loan::create([
            'equipment_id' => $camaraMaria->id,
            'user_id' => $maria->id,
            'assigned_by' => $roberto->id,
            'status' => 'activo',
            'fecha_solicitud' => Carbon::now()->subDays(12),
            'fecha_prestamo' => Carbon::now()->subDays(11),
            'fecha_devolucion' => Carbon::now()->addDays(4),
            'motivo' => 'Sesión fotográfica de productos para catálogo Q1 2026.',
            'notas' => 'Proyecto marketing aprobado',
        ]);

        // Juan - Administrativo (1 equipo)
        $impresoraJuan = Equipment::create([
            'name' => 'HP LaserJet Pro MFP',
            'codigo' => 'IMP-001',
            'categoria' => 'Impresoras',
            'description' => 'Impresora multifunción láser color, WiFi, dúplex automático, ADF 50 hojas.',
            'status' => 'prestado',
            'user_id' => $juan->id,
        ]);
        Loan::create([
            'equipment_id' => $impresoraJuan->id,
            'user_id' => $juan->id,
            'assigned_by' => $admin->id,
            'status' => 'activo',
            'fecha_solicitud' => Carbon::now()->subDays(20),
            'fecha_prestamo' => Carbon::now()->subDays(19),
            'fecha_devolucion' => Carbon::now()->addDays(11),
            'motivo' => 'Oficina temporal en sucursal norte por 1 mes. Necesito imprimir contratos.',
            'notas' => 'Traslado aprobado por RRHH',
        ]);

        // Sofia - Desarrolladora (2 equipos)
        $laptopSofia = Equipment::create([
            'name' => 'MacBook Air M2',
            'codigo' => 'LAP-005',
            'categoria' => 'Computadoras',
            'description' => 'MacBook Air M2 2023, 16GB RAM, 512GB SSD. Ideal para desarrollo frontend.',
            'status' => 'prestado',
            'user_id' => $sofia->id,
        ]);
        Loan::create([
            'equipment_id' => $laptopSofia->id,
            'user_id' => $sofia->id,
            'assigned_by' => $laura->id,
            'status' => 'activo',
            'fecha_solicitud' => Carbon::now()->subDays(25),
            'fecha_prestamo' => Carbon::now()->subDays(24),
            'fecha_devolucion' => Carbon::now()->addDays(6),
            'motivo' => 'Proyecto de rediseño UI/UX. Necesito macOS para testing.',
            'notas' => 'Extendido por 1 mes - proyecto en curso',
        ]);

        $monitorSofia = Equipment::create([
            'name' => 'BenQ PD2725U 4K Designer',
            'codigo' => 'MON-003',
            'categoria' => 'Monitores',
            'description' => 'Monitor 27" 4K IPS para diseño, calibrado Pantone, USB-C DP.',
            'status' => 'prestado',
            'user_id' => $sofia->id,
        ]);
        Loan::create([
            'equipment_id' => $monitorSofia->id,
            'user_id' => $sofia->id,
            'assigned_by' => $admin->id,
            'status' => 'activo',
            'fecha_solicitud' => Carbon::now()->subDays(10),
            'fecha_prestamo' => Carbon::now()->subDays(9),
            'fecha_devolucion' => Carbon::now()->addDays(21),
            'motivo' => 'Monitor extra para aumentar productividad en home office.',
            'notas' => 'Setup dual monitor aprobado',
        ]);

        // Diego - Diseñador (1 equipo)
        $wacomDiego = Equipment::create([
            'name' => 'Wacom Cintiq Pro 16',
            'codigo' => 'DIS-001',
            'categoria' => 'Diseño',
            'description' => 'Tableta gráfica con pantalla 16", 4K, con Pro Pen 3 y ExpressKeys.',
            'status' => 'prestado',
            'user_id' => $diego->id,
        ]);
        Loan::create([
            'equipment_id' => $wacomDiego->id,
            'user_id' => $diego->id,
            'assigned_by' => $roberto->id,
            'status' => 'activo',
            'fecha_solicitud' => Carbon::now()->subDays(18),
            'fecha_prestamo' => Carbon::now()->subDays(17),
            'fecha_devolucion' => Carbon::now()->addDays(13),
            'motivo' => 'Ilustraciones para campaña publicitaria Q4. Necesito dibujo digital.',
            'notas' => 'Equipo especializado - manejar con cuidado',
        ]);

        // Valentina - Marketing (1 equipo)
        $dronValentina = Equipment::create([
            'name' => 'DJI Mavic 3 Pro Drone',
            'codigo' => 'DRON-001',
            'categoria' => 'Fotografía',
            'description' => 'Drone profesional con cámara Hasselblad, 3 baterías, estuche Fly More.',
            'status' => 'prestado',
            'user_id' => $valentina->id,
        ]);
        Loan::create([
            'equipment_id' => $dronValentina->id,
            'user_id' => $valentina->id,
            'assigned_by' => $laura->id,
            'status' => 'activo',
            'fecha_solicitud' => Carbon::now()->subDays(3),
            'fecha_prestamo' => Carbon::now()->subDays(2),
            'fecha_devolucion' => Carbon::now()->addDays(5),
            'motivo' => 'Video aéreo de nuevas instalaciones para redes sociales.',
            'notas' => 'Requiere licencia de piloto - verificada',
        ]);

        // Lucas - Ventas (1 equipo)
        $laptopLucas = Equipment::create([
            'name' => 'HP EliteBook 850',
            'codigo' => 'LAP-006',
            'categoria' => 'Computadoras',
            'description' => 'HP EliteBook 850 G9, i7, 32GB RAM, 1TB SSD, pantalla táctil.',
            'status' => 'prestado',
            'user_id' => $lucas->id,
        ]);
        Loan::create([
            'equipment_id' => $laptopLucas->id,
            'user_id' => $lucas->id,
            'assigned_by' => $admin->id,
            'status' => 'activo',
            'fecha_solicitud' => Carbon::now()->subDays(30),
            'fecha_prestamo' => Carbon::now()->subDays(29),
            'fecha_devolucion' => Carbon::now()->addDays(31),
            'motivo' => 'Gira de ventas por 2 meses - región sur. Visitas a 15 clientes.',
            'notas' => 'Préstamo largo plazo aprobado por dirección',
        ]);

        $this->command->info('✅ 10 equipos prestados con préstamos activos creados');

        // 3. SOLICITUDES PENDIENTES (6 solicitudes - diferentes usuarios)
        $this->command->info('⏳ Creando solicitudes pendientes de aprobación...');

        $microfono = Equipment::create([
            'name' => 'Rode NT-USB+',
            'codigo' => 'AUD-002',
            'categoria' => 'Audio',
            'description' => 'Micrófono USB condensador con filtro anti-pop y soporte shock mount.',
            'status' => 'disponible',
        ]);
        Loan::create([
            'equipment_id' => $microfono->id,
            'user_id' => $camila->id,
            'status' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subHours(6),
            'motivo' => 'Necesito grabar 10 videos tutoriales de RRHH para el curso interno de onboarding. Tengo el estudio reservado para la próxima semana.',
        ]);

        $monitor = Equipment::create([
            'name' => 'Dell UltraSharp 27" 4K',
            'codigo' => 'MON-002',
            'categoria' => 'Monitores',
            'description' => 'Monitor IPS 4K 27", calibrado de fábrica, USB-C hub integrado, altura ajustable.',
            'status' => 'disponible',
        ]);
        Loan::create([
            'equipment_id' => $monitor->id,
            'user_id' => $diego->id,
            'status' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subHours(3),
            'motivo' => 'Trabajo de diseño gráfico requiere monitor calibrado para matching de colores CMYK. Segundo monitor para mi estación.',
        ]);

        $disco = Equipment::create([
            'name' => 'SanDisk Extreme SSD 2TB',
            'codigo' => 'ALM-001',
            'categoria' => 'Almacenamiento',
            'description' => 'SSD externo NVMe USB 3.2, 1050MB/s, resistente al agua IP55.',
            'status' => 'disponible',
        ]);
        Loan::create([
            'equipment_id' => $disco->id,
            'user_id' => $juan->id,
            'status' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subDays(1),
            'motivo' => 'Backup de archivos del servidor antes de la actualización del fin de semana. Plan de contingencia.',
        ]);

        $switch = Equipment::create([
            'name' => 'TP-Link Gigabit Switch 24P',
            'codigo' => 'NET-002',
            'categoria' => 'Redes',
            'description' => 'Switch no administrable 24 puertos Gigabit, montaje en rack.',
            'status' => 'disponible',
        ]);
        Loan::create([
            'equipment_id' => $switch->id,
            'user_id' => $sofia->id,
            'status' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subDays(2),
            'motivo' => 'Expandir red en área de desarrollo. Tenemos 8 devs nuevos sin conexión ethernet.',
        ]);

        $impresora3d = Equipment::create([
            'name' => 'Creality Ender 3 V3',
            'codigo' => 'IMP3D-001',
            'categoria' => 'Impresoras 3D',
            'description' => 'Impresora 3D FDM, volumen 220x220x250mm, nivelación automática.',
            'status' => 'disponible',
        ]);
        Loan::create([
            'equipment_id' => $impresora3d->id,
            'user_id' => $valentina->id,
            'status' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subHours(18),
            'motivo' => 'Crear prototipos de merchandising para evento corporativo. Necesito 20 piezas.',
        ]);

        $oculus = Equipment::create([
            'name' => 'Meta Quest 3',
            'codigo' => 'VR-001',
            'categoria' => 'Realidad Virtual',
            'description' => 'Visor VR/AR con controladores, 128GB, estuche de transporte.',
            'status' => 'disponible',
        ]);
        Loan::create([
            'equipment_id' => $oculus->id,
            'user_id' => $lucas->id,
            'status' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subDays(1)->subHours(5),
            'motivo' => 'Demo de showroom virtual para cliente estratégico. Presentación en 3 días.',
        ]);

        $this->command->info('✅ 6 solicitudes pendientes creadas');

        // 4. EQUIPOS EN MANTENIMIENTO (5 equipos con solicitudes - diferentes técnicos)
        $this->command->info('🔧 Creando equipos en mantenimiento...');

        $laptopMantenimiento = Equipment::create([
            'name' => 'HP EliteBook 840',
            'codigo' => 'LAP-004',
            'categoria' => 'Computadoras',
            'description' => 'EliteBook 840 G10, i5 13va gen, 16GB RAM, 256GB SSD.',
            'status' => 'mantenimiento',
        ]);
        MaintenanceRequest::create([
            'equipment_id' => $laptopMantenimiento->id,
            'requested_by' => $juan->id,
            'assigned_to' => $pedro->id,
            'status' => 'en_proceso',
            'descripcion_problema' => 'La batería se descarga muy rápido, dura menos de 1 hora. Además el ventilador hace ruido extraño cuando se calienta.',
            'solucion' => 'Diagnóstico: Batería degradada al 45% de capacidad. Ventilador con polvo acumulado. Se ordenó batería nueva (ETA: 3 días). Limpieza de ventilador completada.',
            'resultado' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subDays(4),
        ]);

        $tabletMantenimiento = Equipment::create([
            'name' => 'Microsoft Surface Pro 9',
            'codigo' => 'TAB-003',
            'categoria' => 'Tablets',
            'description' => 'Surface Pro 9, i7, 16GB RAM, 512GB SSD, con teclado Type Cover.',
            'status' => 'mantenimiento',
        ]);
        MaintenanceRequest::create([
            'equipment_id' => $tabletMantenimiento->id,
            'requested_by' => $valentina->id,
            'assigned_to' => $ana->id,
            'status' => 'pendiente',
            'descripcion_problema' => 'La pantalla tiene manchas/sombras en la esquina inferior derecha. No responde bien al tacto en esa zona.',
            'resultado' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subDays(1),
        ]);

        $proyectorMantenimiento = Equipment::create([
            'name' => 'Optoma HD29H Proyector',
            'codigo' => 'PROY-003',
            'categoria' => 'Proyección',
            'description' => 'Proyector Full HD 4000 lúmenes, lámpara con 3000 horas de uso.',
            'status' => 'mantenimiento',
        ]);
        MaintenanceRequest::create([
            'equipment_id' => $proyectorMantenimiento->id,
            'requested_by' => $camila->id,
            'assigned_to' => null,
            'status' => 'pendiente',
            'descripcion_problema' => 'La imagen se ve amarillenta/opaca, perdió brillo. Creo que la lámpara está llegando al final de su vida útil.',
            'resultado' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subHours(12),
        ]);

        $routerMantenimiento = Equipment::create([
            'name' => 'Ubiquiti UniFi Dream Machine',
            'codigo' => 'NET-003',
            'categoria' => 'Redes',
            'description' => 'Router/firewall empresarial con WiFi 6, gestión cloud, PoE++.',
            'status' => 'mantenimiento',
        ]);
        MaintenanceRequest::create([
            'equipment_id' => $routerMantenimiento->id,
            'requested_by' => $sofia->id,
            'assigned_to' => $fernando->id,
            'status' => 'en_proceso',
            'descripcion_problema' => 'WiFi se desconecta cada 30 minutos. Puerto WAN parece no negociar bien la velocidad Gigabit.',
            'solucion' => 'Firmware desactualizado. Actualizado a v3.2.9. Puerto WAN limpiado. Monitoreo en curso.',
            'resultado' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subDays(6),
        ]);

        $nasMantenimiento = Equipment::create([
            'name' => 'Synology DS923+ NAS',
            'codigo' => 'ALM-002',
            'categoria' => 'Almacenamiento',
            'description' => 'NAS 4 bahías con 16TB total (4x4TB), RAID 5, 10GbE opcional.',
            'status' => 'mantenimiento',
        ]);
        MaintenanceRequest::create([
            'equipment_id' => $nasMantenimiento->id,
            'requested_by' => $carlos->id,
            'assigned_to' => $patricia->id,
            'status' => 'en_proceso',
            'descripcion_problema' => 'Disco 3 muestra advertencia SMART. Temperatura alta. Hace clicks raros.',
            'solucion' => 'Disco con sectores defectuosos detectados. Disco de reemplazo 4TB WD Red ordenado. Preparando rebuild de RAID.',
            'resultado' => 'pendiente',
            'fecha_solicitud' => Carbon::now()->subDays(3),
        ]);

        $this->command->info('✅ 5 equipos en mantenimiento creados');

        // 5. EQUIPOS DADOS DE BAJA (5 equipos - diferentes técnicos y usuarios)
        $this->command->info('❌ Creando equipos dados de baja con historial completo...');

        // Laptop dañada - reportada por Juan, atendida por Pedro
        $laptopBaja = Equipment::create([
            'name' => 'Dell Latitude 5420',
            'codigo' => 'LAP-BAJA-001',
            'categoria' => 'Computadoras',
            'description' => 'Laptop Dell con daño irreparable en motherboard. Dada de baja el ' . Carbon::now()->subDays(30)->format('d/m/Y'),
            'status' => 'baja',
        ]);
        MaintenanceRequest::create([
            'equipment_id' => $laptopBaja->id,
            'requested_by' => $juan->id,
            'assigned_to' => $pedro->id,
            'status' => 'completado',
            'descripcion_problema' => 'Se apagó de repente y no enciende más. No carga, no da señales de vida.',
            'solucion' => 'Diagnóstico técnico: Cortocircuito en motherboard. Costo de reparación ($850) supera 70% del valor del equipo ($1200). Recomendación: Dar de baja.',
            'resultado' => 'dado_de_baja',
            'fecha_solicitud' => Carbon::now()->subDays(35),
            'fecha_completado' => Carbon::now()->subDays(30),
        ]);

        // Tablet obsoleta - reportada por María, atendida por Ana
        $tabletBaja = Equipment::create([
            'name' => 'iPad Air 2019',
            'codigo' => 'TAB-BAJA-001',
            'categoria' => 'Tablets',
            'description' => 'iPad con pantalla rota y daño por líquido. Obsoleto. Dado de baja el ' . Carbon::now()->subDays(45)->format('d/m/Y'),
            'status' => 'baja',
        ]);
        MaintenanceRequest::create([
            'equipment_id' => $tabletBaja->id,
            'requested_by' => $maria->id,
            'assigned_to' => $ana->id,
            'status' => 'completado',
            'descripcion_problema' => 'Se cayó y la pantalla se rompió completamente. Además tiene manchas que parecen daño por agua.',
            'solucion' => 'Pantalla rota + daño por líquido en componentes internos. Modelo descontinuado (2019), sin soporte. Costo reparación supera valor de mercado. Equipo dado de baja según protocolo.',
            'resultado' => 'dado_de_baja',
            'fecha_solicitud' => Carbon::now()->subDays(50),
            'fecha_completado' => Carbon::now()->subDays(45),
        ]);

        // Proyector viejo - reportado por Camila, atendido por Fernando
        $proyectorBaja = Equipment::create([
            'name' => 'Epson PowerLite 2005',
            'codigo' => 'PROY-BAJA-001',
            'categoria' => 'Proyección',
            'description' => 'Proyector XGA con 8500 horas de lámpara. Fuera de servicio. Dado de baja el ' . Carbon::now()->subDays(60)->format('d/m/Y'),
            'status' => 'baja',
        ]);
        MaintenanceRequest::create([
            'equipment_id' => $proyectorBaja->id,
            'requested_by' => $camila->id,
            'assigned_to' => $fernando->id,
            'status' => 'completado',
            'descripcion_problema' => 'La lámpara fundida, colores distorsionados, imagen con líneas verticales.',
            'solucion' => 'Lámpara en fin de vida (8500h). Óptica dañada. Modelo del 2015 sin repuestos disponibles. Costo nueva lámpara + reparación óptica $950 vs equipo nuevo $800. Dado de baja.',
            'resultado' => 'dado_de_baja',
            'fecha_solicitud' => Carbon::now()->subDays(65),
            'fecha_completado' => Carbon::now()->subDays(60),
        ]);

        // Monitor con problema - reportado por Sofia, atendido por Patricia
        $monitorBaja = Equipment::create([
            'name' => 'Samsung SyncMaster 2243',
            'codigo' => 'MON-BAJA-001',
            'categoria' => 'Monitores',
            'description' => 'Monitor Full HD 22" con fuente de poder quemada. Dado de baja el ' . Carbon::now()->subDays(20)->format('d/m/Y'),
            'status' => 'baja',
        ]);
        MaintenanceRequest::create([
            'equipment_id' => $monitorBaja->id,
            'requested_by' => $sofia->id,
            'assigned_to' => $patricia->id,
            'status' => 'completado',
            'descripcion_problema' => 'No enciende. Huele a quemado. LED de power titila pero pantalla negra.',
            'solucion' => 'Capacitores de fuente explotados. Modelo 2011 descontinuado. Repuesto no oficial $180, sin garantía. Monitor nuevo similar $220. Decisión: Dar de baja por obsolescencia.',
            'resultado' => 'dado_de_baja',
            'fecha_solicitud' => Carbon::now()->subDays(22),
            'fecha_completado' => Carbon::now()->subDays(20),
        ]);

        // Impresora antigua - reportada por Lucas, atendida por Pedro
        $impresoraBaja = Equipment::create([
            'name' => 'Canon Pixma MP250',
            'codigo' => 'IMP-BAJA-001',
            'categoria' => 'Impresoras',
            'description' => 'Impresora multifunción con cabezal obstruido irreversible. Dada de baja el ' . Carbon::now()->subDays(15)->format('d/m/Y'),
            'status' => 'baja',
        ]);
        MaintenanceRequest::create([
            'equipment_id' => $impresoraBaja->id,
            'requested_by' => $lucas->id,
            'assigned_to' => $pedro->id,
            'status' => 'completado',
            'descripcion_problema' => 'No imprime colores. Solo sale negro con rayas. Limpieza automática no funciona.',
            'solucion' => 'Cabezal completamente obstruido. Intentos de limpieza manual fallidos. Edad: 9 años. Repuesto cabezal $140, equipo nuevo $180. No justifica reparación. Dado de baja.',
            'resultado' => 'dado_de_baja',
            'fecha_solicitud' => Carbon::now()->subDays(17),
            'fecha_completado' => Carbon::now()->subDays(15),
        ]);

        $this->command->info('✅ 5 equipos dados de baja creados con historial completo');

        // 6. HISTORIAL DE PRÉSTAMOS DEVUELTOS (6 préstamos pasados - más variedad)
        $this->command->info('📚 Creando historial de préstamos devueltos...');

        // Préstamos devueltos
        $macBookPro = Equipment::where('codigo', 'LAP-001')->first();
        Loan::create([
            'equipment_id' => $macBookPro->id,
            'user_id' => $diego->id,
            'assigned_by' => $admin->id,
            'status' => 'devuelto',
            'fecha_solicitud' => Carbon::now()->subDays(40),
            'fecha_prestamo' => Carbon::now()->subDays(39),
            'fecha_devolucion' => Carbon::now()->subDays(25),
            'fecha_devolucion_real' => Carbon::now()->subDays(10),
            'motivo' => 'Pruebas de rendimiento para aplicación iOS nativa.',
            'notas' => 'Devuelto en perfectas condiciones. Proyecto completado exitosamente.',
        ]);

        $ipadPro = Equipment::where('codigo', 'TAB-001')->first();
        Loan::create([
            'equipment_id' => $ipadPro->id,
            'user_id' => $lucas->id,
            'assigned_by' => $laura->id,
            'status' => 'devuelto',
            'fecha_solicitud' => Carbon::now()->subDays(20),
            'fecha_prestamo' => Carbon::now()->subDays(19),
            'fecha_devolucion' => Carbon::now()->subDays(12),
            'fecha_devolucion_real' => Carbon::now()->subDays(5),
            'motivo' => 'Demostración de producto en feria tecnológica.',
            'notas' => 'Devuelto antes de tiempo. Evento cancelado por mal clima.',
        ]);

        $epsonProyector = Equipment::where('codigo', 'PROY-001')->first();
        Loan::create([
            'equipment_id' => $epsonProyector->id,
            'user_id' => $camila->id,
            'assigned_by' => $roberto->id,
            'status' => 'devuelto',
            'fecha_solicitud' => Carbon::now()->subDays(35),
            'fecha_prestamo' => Carbon::now()->subDays(34),
            'fecha_devolucion' => Carbon::now()->subDays(27),
            'fecha_devolucion_real' => Carbon::now()->subDays(26),
            'motivo' => 'Capacitación de nuevos empleados - programa onboarding Q3.',
            'notas' => 'Devuelto a tiempo. Todo OK.',
        ]);

        $dellXPS = Equipment::where('codigo', 'LAP-002')->first();
        Loan::create([
            'equipment_id' => $dellXPS->id,
            'user_id' => $valentina->id,
            'assigned_by' => $admin->id,
            'status' => 'devuelto',
            'fecha_solicitud' => Carbon::now()->subDays(50),
            'fecha_prestamo' => Carbon::now()->subDays(49),
            'fecha_devolucion' => Carbon::now()->subDays(35),
            'fecha_devolucion_real' => Carbon::now()->subDays(15),
            'motivo' => 'Análisis de datos de campaña con Power BI. Necesito procesador potente.',
            'notas' => 'Devuelto con 1 día de retraso - justificado por extención de proyecto',
        ]);

        // Préstamos RECHAZADOS (2)
        $cameraFoto = Equipment::where('codigo', 'CAM-001')->first();
        Loan::create([
            'equipment_id' => $cameraFoto->id,
            'user_id' => $juan->id,
            'status' => 'rechazado',
            'fecha_solicitud' => Carbon::now()->subDays(7),
            'motivo' => 'Necesito la cámara para evento personal (cumpleaños familiar).',
            'notas' => 'Solicitud rechazada: Equipamiento exclusivo para uso profesional/corporativo según política IT-2024.',
        ]);

        $lenovoLaptop = Equipment::where('codigo', 'LAP-003')->first();
        Loan::create([
            'equipment_id' => $lenovoLaptop->id,
            'user_id' => $lucas->id,
            'status' => 'rechazado',
            'fecha_solicitud' => Carbon::now()->subDays(25),
            'motivo' => 'Laptop adicional para mi hijo que está estudiando programación.',
            'notas' => 'Rechazado por Laura Admin: Uso personal no autorizado. Equipos solo para trabajo corporativo.',
        ]);

        $this->command->info('✅ 6 préstamos históricos creados (4 devueltos + 2 rechazados)');

        // Resumen final
        $this->command->newLine();
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('✨ RESUMEN DE DATOS CREADOS - OFICINA REALISTA:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->table(
            ['Categoría', 'Cantidad', 'Descripción'],
            [
                ['Equipos Disponibles', '15', 'Inventario listo para préstamo (4 laptops, 2 tablets, 2 monitores, etc.)'],
                ['Equipos Prestados', '10', 'Con préstamos activos (Carlos x2, María x2, Juan, Sofia x2, Diego, Valentina, Lucas)'],
                ['Solicitudes Pendientes', '6', 'Esperando aprobación de admin (Camila, Diego, Juan, Sofia, Valentina, Lucas)'],
                ['Equipos en Mantenimiento', '5', 'En reparación (atendidos por Pedro, Ana, Fernando, Patricia)'],
                ['Equipos Dados de Baja', '5', 'Fuera de servicio con historial completo de mantenimiento'],
                ['Préstamos Históricos', '6', '4 devueltos + 2 rechazados (uso personal no permitido)'],
            ]
        );
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->newLine();
        
        // Estadísticas por usuario
        $this->command->info('👥 DISTRIBUCIÓN POR USUARIO:');
        $this->command->table(
            ['Usuario', 'Equipos Activos', 'Solicitudes Pendientes', 'Reportes Mantenimiento'],
            [
                ['Carlos (Trabajador)', '2', '0', '1'],
                ['María (Trabajadora)', '2', '0', '0'],
                ['Juan (Trabajador)', '1', '1', '1'],
                ['Sofia (Desarrolladora)', '2', '1', '1'],
                ['Diego (Diseñador)', '1', '1', '0'],
                ['Valentina (Marketing)', '1', '1', '1'],
                ['Lucas (Ventas)', '1', '1', '0'],
                ['Camila (RRHH)', '0', '1', '1'],
            ]
        );
        
        $this->command->newLine();
        $this->command->info('🎉 ¡Datos realistas creados exitosamente!');
        $this->command->info('💡 Total de equipos: ' . Equipment::count());
        $this->command->info('📋 Total de préstamos: ' . Loan::count());
        $this->command->info('🔧 Total de mantenimientos: ' . MaintenanceRequest::count());
        $this->command->info('👤 Total de usuarios: ' . User::count());
    }
}
