# Datos de Demostración del Sistema

Este documento describe los datos realistas creados por los seeders para demostrar todas las funcionalidades del sistema.

## 🎯 Objetivo

Los seeders crean un escenario completo de oficina con 15 usuarios, 41 equipos y múltiples interacciones que demuestran todos los flujos del sistema: préstamos activos, solicitudes pendientes, equipos en mantenimiento, equipos dados de baja e historial de operaciones.

## 👥 Usuarios Creados (15 total)

### Administradores (3)
| Email | Nombre | Contraseña |
|-------|--------|------------|
| admin@gestionoficina.com | Administrador Principal | password123 |
| laura@gestionoficina.com | Laura Administradora | password123 |
| roberto@gestionoficina.com | Roberto Admin | password123 |

**Qué hacen:** Aprueban/rechazan préstamos, asignan equipos directamente, gestionan usuarios y ven todas las estadísticas.

### Trabajadores (8)
| Email | Nombre | Departamento | Contraseña |
|-------|--------|--------------|------------|
| carlos@gestionoficina.com | Carlos Trabajador | Desarrollo | password123 |
| maria@gestionoficina.com | María Trabajadora | Marketing | password123 |
| juan@gestionoficina.com | Juan Trabajador | Administrativo | password123 |
| sofia@gestionoficina.com | Sofia Desarrolladora | Desarrollo | password123 |
| diego@gestionoficina.com | Diego Diseñador | Diseño | password123 |
| valentina@gestionoficina.com | Valentina Marketing | Marketing | password123 |
| lucas@gestionoficina.com | Lucas Ventas | Ventas | password123 |
| camila@gestionoficina.com | Camila RRHH | Recursos Humanos | password123 |

**Qué hacen:** Solicitan préstamos de equipos, devuelven equipos, reportan problemas de mantenimiento.

### Personal de Mantenimiento (4)
| Email | Nombre | Especialidad | Contraseña |
|-------|--------|--------------|------------|
| pedro@gestionoficina.com | Pedro Mantenimiento | Técnico Principal | password123 |
| ana@gestionoficina.com | Ana Mantenimiento | Técnica | password123 |
| fernando@gestionoficina.com | Fernando Técnico | Redes e Infraestructura | password123 |
| patricia@gestionoficina.com | Patricia Técnica | Hardware y Almacenamiento | password123 |

**Qué hacen:** Reciben solicitudes de reparación, diagnostican, reparan o dan de baja equipos.

## 💻 Equipos del Sistema (41 total)

### 1. Equipos Disponibles (15)

Inventario listo para ser prestado:

#### Computadoras (4)
- **LAP-001**: MacBook Pro 16" M3 (32GB RAM, 1TB SSD)
- **LAP-002**: Dell XPS 15 (i7 13va gen, 16GB RAM, 512GB SSD)
- **LAP-007**: Lenovo Legion 5 Pro (RTX 4060, Ryzen 7, 16GB RAM)
- **LAP-008**: ASUS ZenBook 14 (i5 12va gen, OLED táctil)

#### Tablets (2)
- **TAB-001**: iPad Pro 12.9" (256GB, Magic Keyboard, Apple Pencil)
- **TAB-004**: Samsung Galaxy Tab S8 Ultra (14.6", 512GB, S-Pen)

#### Monitores (2)
- **MON-001**: LG UltraWide 34" (21:9, 144Hz, HDR400)
- **MON-004**: ASUS ProArt PA279CV 27" (4K, 100% sRGB)

#### Audio (2)
- **AUD-001**: Micrófono Shure SM7B (con interfaz Focusrite)
- **AUD-003**: Sistema Audio Conference Jabra (360°, 10 personas)

#### Otros (5)
- **PROY-001**: Proyector Epson EB-2250U (5000 lúmenes, WUXGA)
- **CAM-001**: Cámara Sony A7 IV (33MP, lente 24-70mm)
- **NET-001**: Router Cisco Catalyst (24 puertos PoE+)
- **ALM-003**: WD My Book 8TB External (cifrado por hardware)
- **ACC-001**: Logitech MX Master 3S + Teclado MX Keys

### 2. Equipos Prestados (10)

#### Carlos (Desarrollo) - 2 equipos
- **LAP-003**: Lenovo ThinkPad X1 Carbon (prestado hace 14 días, vence en 16 días)
  - Motivo: Desarrollo del proyecto de migración a Laravel 12
  - Aprobado por: Admin Principal
  
- **TAB-002**: Samsung Galaxy Tab S9+ (prestado hace 7 días, vence en 8 días)
  - Motivo: Presentación de resultados trimestrales a clientes
  - Aprobado por: Laura Admin

#### María (Marketing) - 2 equipos
- **PROY-002**: BenQ MW612 Proyector (prestado hace 4 días, vence en 3 días)
  - Motivo: Capacitación interna del equipo de ventas
  - Aprobado por: Admin Principal
  
- **CAM-002**: Canon EOS R6 Mark II (prestado hace 11 días, vence en 4 días)
  - Motivo: Sesión fotográfica de productos para catálogo Q1 2026
  - Aprobado por: Roberto Admin

#### Juan (Administrativo) - 1 equipo
- **IMP-001**: HP LaserJet Pro MFP (prestado hace 19 días, vence en 11 días)
  - Motivo: Oficina temporal en sucursal norte por 1 mes
  - Aprobado por: Admin Principal

#### Sofia (Desarrollo) - 2 equipos
- **LAP-005**: MacBook Air M2 (prestado hace 24 días, vence en 6 días)
  - Motivo: Proyecto de rediseño UI/UX, testing en macOS
  - Aprobado por: Laura Admin
  
- **MON-003**: BenQ PD2725U 4K Designer (prestado hace 9 días, vence en 21 días)
  - Motivo: Monitor extra para aumentar productividad en home office
  - Aprobado por: Admin Principal

#### Diego (Diseño) - 1 equipo
- **DIS-001**: Wacom Cintiq Pro 16 (prestado hace 17 días, vence en 13 días)
  - Motivo: Ilustraciones para campaña publicitaria Q4
  - Aprobado por: Roberto Admin

#### Valentina (Marketing) - 1 equipo
- **DRON-001**: DJI Mavic 3 Pro Drone (prestado hace 2 días, vence en 5 días)
  - Motivo: Video aéreo de nuevas instalaciones para redes sociales
  - Aprobado por: Laura Admin
  - Nota: Licencia de piloto verificada

#### Lucas (Ventas) - 1 equipo
- **LAP-006**: HP EliteBook 850 (prestado hace 29 días, vence en 31 días)
  - Motivo: Gira de ventas por 2 meses - región sur, 15 clientes
  - Aprobado por: Admin Principal

### 3. Solicitudes Pendientes de Aprobación (6)

| Usuario | Equipo | Motivo | Hace |
|---------|--------|--------|------|
| Camila (RRHH) | **AUD-002**: Rode NT-USB+ | Grabar 10 videos tutoriales de RRHH para onboarding | 6 horas |
| Diego (Diseño) | **MON-002**: Dell UltraSharp 27" 4K | Segundo monitor para matching de colores CMYK | 3 horas |
| Juan (Admin) | **ALM-001**: SanDisk Extreme SSD 2TB | Backup del servidor antes de actualización | 1 día |
| Sofia (Dev) | **NET-002**: TP-Link Gigabit Switch 24P | Expandir red en área de desarrollo, 8 devs nuevos | 2 días |
| Valentina (Marketing) | **IMP3D-001**: Creality Ender 3 V3 | Crear prototipos de merchandising (20 piezas) | 18 horas |
| Lucas (Ventas) | **VR-001**: Meta Quest 3 | Demo de showroom virtual para cliente estratégico | 1 día 5 horas |

### 4. Equipos en Mantenimiento (5)

| Equipo | Problema | Técnico | Estado | Hace |
|--------|----------|---------|--------|------|
| **LAP-004**: HP EliteBook 840 | Batería degradada (45%) + ventilador ruidoso | Pedro | En proceso | 4 días |
| - Solución: Batería nueva ordenada (ETA 3 días), limpieza completada |
| **TAB-003**: Microsoft Surface Pro 9 | Pantalla con manchas, no responde al tacto | Ana | Pendiente | 1 día |
| **PROY-003**: Optoma HD29H | Imagen amarillenta, lámpara al final de vida útil | No asignado | Pendiente | 12 horas |
| **NET-003**: Ubiquiti UniFi Dream Machine | WiFi se desconecta cada 30 min, puerto WAN lento | Fernando | En proceso | 6 días |
| - Solución: Firmware actualizado, puerto limpiado, en monitoreo |
| **ALM-002**: Synology DS923+ NAS | Disco 3 con advertencia SMART, temperatura alta | Patricia | En proceso | 3 días |
| - Solución: Disco de reemplazo ordenado, preparando rebuild de RAID |

### 5. Equipos Dados de Baja (5)

| Equipo | Motivo de Baja | Técnico | Fecha Baja | Usuario Reportante |
|--------|----------------|---------|------------|---------------------|
| **LAP-BAJA-001**: Dell Latitude 5420 | Cortocircuito en motherboard. Costo reparación $850 > 70% valor equipo ($1200) | Pedro | Hace 30 días | Juan |
| **TAB-BAJA-001**: iPad Air 2019 | Pantalla rota + daño por líquido. Modelo descontinuado, sin soporte | Ana | Hace 45 días | María |
| **PROY-BAJA-001**: Epson PowerLite 2005 | Lámpara fundida (8500h), óptica dañada. Modelo 2015 sin repuestos | Fernando | Hace 60 días | Camila |
| **MON-BAJA-001**: Samsung SyncMaster 2243 | Fuente quemada. Modelo 2011, repuesto $180 sin garantía vs nuevo $220 | Patricia | Hace 20 días | Sofia |
| **IMP-BAJA-001**: Canon Pixma MP250 | Cabezal obstruido irreversible. 9 años, repuesto $140 vs nuevo $180 | Pedro | Hace 15 días | Lucas |

**Criterio de baja:** Equipo se da de baja cuando el costo de reparación supera el 60-70% del valor del equipo, o cuando es obsoleto/descontinuado sin repuestos.

### 6. Historial de Préstamos (6)

#### Préstamos Devueltos (4)

| Usuario | Equipo | Préstamo | Devolución Real | Estado |
|---------|--------|----------|-----------------|--------|
| Diego | MacBook Pro 16" M3 | 39 días (14 días) | Devuelto hace 10 días | A tiempo |
| - Motivo: Pruebas de rendimiento para aplicación iOS nativa |
| - Nota: Devuelto en perfectas condiciones |
| Lucas | iPad Pro 12.9" | 19 días (7 días) | Devuelto hace 5 días | Antes de tiempo |
| - Motivo: Demostración de producto en feria tecnológica |
| - Nota: Evento cancelado por mal clima |
| Camila | Proyector Epson EB-2250U | 34 días (7 días) | Devuelto hace 26 días | A tiempo |
| - Motivo: Capacitación de nuevos empleados - onboarding Q3 |
| - Nota: Todo OK |
| Valentina | Dell XPS 15 | 49 días (14 días) | Devuelto hace 15 días | 1 día retraso |
| - Motivo: Análisis de datos de campaña con Power BI |
| - Nota: Retraso justificado por extensión de proyecto |

#### Préstamos Rechazados (2)

| Usuario | Equipo | Motivo Solicitud | Motivo Rechazo | Hace |
|---------|--------|------------------|----------------|------|
| Juan | Cámara Sony A7 IV | Evento personal (cumpleaños familiar) | Equipamiento exclusivo para uso profesional/corporativo | 7 días |
| Lucas | Lenovo ThinkPad X1 Carbon | Laptop adicional para hijo estudiando programación | Uso personal no autorizado | 25 días |

## 📊 Estadísticas del Sistema

### Resumen General
- **Total usuarios:** 15 (3 admins + 8 trabajadores + 4 técnicos)
- **Total equipos:** 41 equipos
- **Total préstamos registrados:** 22 (10 activos + 6 históricos + 6 pendientes)
- **Total solicitudes de mantenimiento:** 10

### Distribución de Equipos por Estado
| Estado | Cantidad | Porcentaje |
|--------|----------|------------|
| Disponible | 15 | 36.6% |
| Prestado | 10 | 24.4% |
| Mantenimiento | 5 | 12.2% |
| Baja | 5 | 12.2% |
| Pendiente (solicitud) | 6 | 14.6% |

### Distribución por Categoría
- Computadoras: 10 (4 disponibles + 5 prestadas + 1 baja)
- Tablets: 5 (2 disponibles + 2 prestadas + 1 baja)
- Monitores: 5 (2 disponibles + 2 prestadas + 1 baja)
- Proyección: 4 (1 disponible + 1 prestado + 1 mantenimiento + 1 baja)
- Audio: 3 (2 disponibles + 1 pendiente)
- Fotografía/Video: 3 (1 disponible + 1 prestado + 1 drone prestado)
- Redes: 3 (1 disponible + 1 pendiente + 1 mantenimiento)
- Almacenamiento: 3 (1 disponible + 1 pendiente + 1 mantenimiento)
- Otros: 5 (diseño, impresoras, VR, accesorios)

### Actividad por Usuario

| Usuario | Equipos Activos | Solicitudes Pendientes | Reportes Mantenimiento |
|---------|----------------|------------------------|------------------------|
| Carlos | 2 | 0 | 1 |
| María | 2 | 0 | 1 |
| Juan | 1 | 1 | 1 |
| Sofia | 2 | 1 | 1 |
| Diego | 1 | 1 | 0 |
| Valentina | 1 | 1 | 1 |
| Lucas | 1 | 1 | 1 |
| Camila | 0 | 1 | 1 |

### Carga de Trabajo - Mantenimiento

| Técnico | Casos Activos | Casos Completados | Equipos Dados de Baja |
|---------|---------------|-------------------|----------------------|
| Pedro | 1 (en proceso) | 0 | 2 |
| Ana | 1 (pendiente) | 0 | 1 |
| Fernando | 1 (en proceso) | 0 | 1 |
| Patricia | 1 (en proceso) | 0 | 1 |

## 🎯 Escenarios de Prueba Sugeridos

### Como Admin
1. Revisar las 6 solicitudes pendientes y aprobar/rechazar
2. Ver el dashboard con estadísticas actualizadas
3. Asignar directamente un equipo disponible a un trabajador
4. Revisar historial de préstamos devueltos y rechazados
5. Ver equipos en mantenimiento y dados de baja

### Como Trabajador (Carlos)
1. Ver tus 2 equipos prestados actualmente
2. Solicitar un nuevo equipo del inventario disponible
3. Reportar un problema con uno de tus equipos
4. Devolver un equipo

### Como Técnico de Mantenimiento (Pedro)
1. Ver tu solicitud de mantenimiento asignada (HP EliteBook)
2. Actualizar el diagnóstico y solución
3. Completar la reparación o dar de baja el equipo
4. Ver historial de equipos dados de baja

## 🚀 Cómo Ejecutar los Seeders

```bash
# Resetear base de datos y ejecutar seeders
./vendor/bin/sail artisan migrate:fresh --seed

# O con alias sail configurado:
sail artisan migrate:fresh --seed
```

**Nota:** Este comando eliminará todos los datos existentes y creará los datos de demostración.

## 📝 Archivos de Seeders

- `database/seeders/DatabaseSeeder.php` - Orquestador principal
- `database/seeders/RoleSeeder.php` - Crea roles y 15 usuarios
- `database/seeders/RealisticDataSeeder.php` - Crea 41 equipos y todas las interacciones

## 💡 Personalización

Si necesitas agregar más datos de prueba, edita `RealisticDataSeeder.php`:

- Agregar más usuarios en `RoleSeeder.php`
- Agregar más equipos en la sección "Equipos Disponibles"
- Crear más préstamos activos asignando equipos a usuarios
- Simular más solicitudes pendientes
- Agregar más equipos en mantenimiento o dados de baja

---

**Última actualización:** Noviembre 2025
