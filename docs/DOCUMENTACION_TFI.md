# Documentación Técnica - Sistema de Gestión de Oficina
## Trabajo Final Integrador

---

## 1. INTEGRANTES DEL EQUIPO

**[Completar con tus datos]**

- Nombre completo
- Legajo/Matrícula
- Email
- Carrera
- Institución educativa

---

## 2. OBJETIVO Y DESCRIPCIÓN DE LA PROPUESTA

### 2.1 Objetivo General
Desarrollar un sistema web para la gestión integral de equipos tecnológicos de oficina, que permita controlar préstamos, mantenimiento e inventario a través de un sistema de roles con permisos diferenciados.

### 2.2 Objetivos Específicos
1. Implementar un sistema de préstamos con flujo de aprobación
2. Controlar el inventario de equipos con estados y disponibilidad
3. Gestionar solicitudes de mantenimiento y reparaciones
4. Establecer un sistema de roles con permisos específicos
5. Mantener auditoría completa de todas las operaciones
6. Proporcionar dashboards personalizados según rol de usuario

### 2.3 Alcance del Sistema
El sistema **permite**:
- Solicitar préstamos de equipos (trabajadores)
- Aprobar/rechazar préstamos (administradores)
- Asignar equipos directamente sin solicitud previa (administradores)
- Reportar problemas en equipos (trabajadores)
- Gestionar mantenimiento y reparaciones (personal de mantenimiento)
- Dar de baja equipos irreparables
- Configurar parámetros del sistema (administradores)
- Auditar todas las operaciones realizadas

El sistema **NO incluye**:
- Facturación o control de costos
- Gestión de proveedores
- Control de repuestos
- Sistema de notificaciones por email/SMS
- Reservas anticipadas de equipos

### 2.4 Problema que Resuelve
En muchas organizaciones, el control de equipos tecnológicos se realiza de forma manual (planillas Excel, correos, papeles), generando:
- Pérdida de equipos o extravío
- Falta de claridad sobre quién tiene qué equipo
- Demoras en aprobaciones de préstamos
- Equipos en mal estado sin reportar
- Imposibilidad de auditar operaciones

Este sistema centraliza toda la gestión en una plataforma web accesible desde cualquier lugar.

### 2.5 Justificación Académica
Este proyecto fue desarrollado como Trabajo Final Integrador, aplicando conocimientos de:
- Desarrollo web full-stack
- Bases de datos relacionales
- Arquitectura de software
- Testing y calidad
- Despliegue en producción
- Documentación técnica

---

## 3. PLAN DE TRABAJO

### 3.1 Metodología de Desarrollo
Se utilizó una metodología ágil iterativa con entregas incrementales:

**Fase 1 - Análisis y Diseño (2 semanas)**
- Relevamiento de requisitos
- Diseño de base de datos
- Definición de roles y permisos
- Diseño de arquitectura del sistema

**Fase 2 - Implementación Core (4 semanas)**
- Configuración del entorno (Laravel Sail + Docker)
- Modelos y migraciones de base de datos
- Sistema de autenticación y roles
- CRUD básico de equipos y usuarios

**Fase 3 - Módulos Principales (4 semanas)**
- Sistema de préstamos con aprobaciones
- Gestión de mantenimiento
- Dashboards personalizados por rol
- Widgets y estadísticas

**Fase 4 - Optimizaciones (2 semanas)**
- Sistema de auditoría
- Optimizaciones de rendimiento
- Validaciones centralizadas
- Testing y corrección de bugs

**Fase 5 - Deployment y Documentación (1 semana)**
- Despliegue en Railway (producción)
- Documentación técnica
- Manual de usuario
- Datos de demostración

### 3.2 Cronograma
| Fase | Duración | Estado |
|------|----------|--------|
| Análisis y Diseño | 2 semanas | ✅ Completado |
| Implementación Core | 4 semanas | ✅ Completado |
| Módulos Principales | 4 semanas | ✅ Completado |
| Optimizaciones | 2 semanas | ✅ Completado |
| Deployment y Documentación | 1 semana | ✅ Completado |

**Total:** 13 semanas

---

## 4. TECNOLOGÍAS UTILIZADAS

### 4.1 Lenguajes de Programación
- **PHP 8.2**: Lenguaje principal del backend
- **JavaScript/Alpine.js**: Interactividad del frontend (incluido en Livewire)
- **HTML5**: Estructura de vistas
- **CSS3/Tailwind CSS**: Estilos y diseño responsive

### 4.2 Frameworks
- **Laravel 12**: Framework PHP principal
  - Versión más reciente con mejoras de rendimiento
  - Eloquent ORM para manejo de base de datos
  - Sistema de autenticación integrado
  - Middleware y gates para autorización

- **Filament 4.0**: Framework de administración
  - Interfaz de administración completa
  - CRUD generado automáticamente
  - Sistema de formularios y tablas
  - Widgets para dashboards
  - Sistema de notificaciones

- **Livewire 3**: Framework de componentes reactivos
  - Integrado con Filament
  - Interactividad sin escribir JavaScript
  - Actualizaciones en tiempo real

### 4.3 Sistema de Gestión de Base de Datos
- **MySQL 8.0**: Base de datos relacional
  - InnoDB como motor de almacenamiento
  - Transacciones ACID
  - Índices para optimización
  - Foreign keys para integridad referencial

### 4.4 Plataforma de Desarrollo
- **Docker**: Contenedorización
- **Laravel Sail**: Entorno de desarrollo dockerizado
  - PHP 8.4
  - MySQL 8.0
  - Redis (caché)
  - Mailpit (testing de emails)
  - Selenium (testing)

- **Composer**: Gestor de dependencias PHP
- **NPM**: Gestor de dependencias JavaScript
- **Vite**: Build tool para assets frontend

### 4.5 Plataforma de Producción
- **Railway**: Platform as a Service (PaaS)
  - Despliegue automático desde GitHub
  - Base de datos MySQL incluida
  - HTTPS automático
  - Monitoreo y logs
  - URL: https://gestionoficina-production.up.railway.app

### 4.6 Control de Versiones
- **Git**: Sistema de control de versiones
- **GitHub**: Repositorio remoto
  - Repositorio: https://github.com/colomyago/gestionoficina
  - Branch principal: `main`
  - Auto-deploy a Railway habilitado

### 4.7 Herramientas de Desarrollo
- **Visual Studio Code**: IDE principal
- **PHPUnit**: Testing unitario
- **Laravel Pint**: Code style (PSR-12)
- **Blade**: Motor de plantillas de Laravel

### 4.8 Librerías y Paquetes Principales

**Backend (Composer):**
```json
{
  "laravel/framework": "^12.0",
  "filament/filament": "^4.0",
  "livewire/livewire": "^3.0",
  "spatie/laravel-query-builder": "Para filtros avanzados",
  "lab404/laravel-impersonate": "Impersonalización de usuarios"
}
```

**Frontend (NPM):**
```json
{
  "tailwindcss": "^3.4",
  "alpinejs": "^3.14",
  "autoprefixer": "^10.4",
  "postcss": "^8.4"
}
```

### 4.9 Stack Completo

```
┌─────────────────────────────────────┐
│         NAVEGADOR WEB               │
│    (Chrome, Firefox, Edge)          │
└──────────────┬──────────────────────┘
               │ HTTPS
               ▼
┌─────────────────────────────────────┐
│      FILAMENT UI (Frontend)         │
│  - Tailwind CSS                     │
│  - Alpine.js (Livewire)             │
│  - Blade Templates                  │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│      LARAVEL 12 (Backend)           │
│  - Controllers                      │
│  - Models (Eloquent)                │
│  - Policies (Authorization)         │
│  - Services (Business Logic)        │
│  - Middleware                       │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│        MySQL 8.0 (Database)         │
│  - 8 tablas principales             │
│  - Índices optimizados              │
│  - Foreign Keys                     │
└─────────────────────────────────────┘
```

---

## 5. ARQUITECTURA DEL SISTEMA

### 5.1 Patrón de Arquitectura: MVC + Repository

El sistema implementa el patrón **Model-View-Controller (MVC)** extendido con una capa de servicios:

```
┌──────────────────────────────────────────────────────┐
│                   CLIENTE WEB                        │
│              (Navegador del usuario)                 │
└────────────────────┬─────────────────────────────────┘
                     │ HTTP/HTTPS
                     ▼
┌──────────────────────────────────────────────────────┐
│                  CAPA DE PRESENTACIÓN                │
│                                                      │
│  ┌─────────────────────────────────────────────┐   │
│  │   FILAMENT RESOURCES (Controllers)          │   │
│  │  - EquipmentResource                        │   │
│  │  - UserResource                             │   │
│  │  - LoanResource                             │   │
│  │  - MaintenanceRequestResource               │   │
│  └─────────────────┬───────────────────────────┘   │
│                    │                                │
│  ┌─────────────────▼───────────────────────────┐   │
│  │   FILAMENT VIEWS (Blade + Livewire)         │   │
│  │  - Forms                                    │   │
│  │  - Tables                                   │   │
│  │  - Widgets                                  │   │
│  │  - Dashboards                               │   │
│  └─────────────────────────────────────────────┘   │
└────────────────────┬─────────────────────────────────┘
                     │
                     ▼
┌──────────────────────────────────────────────────────┐
│              CAPA DE LÓGICA DE NEGOCIO               │
│                                                      │
│  ┌─────────────────────────────────────────────┐   │
│  │   POLICIES (Autorización)                   │   │
│  │  - EquipmentPolicy                          │   │
│  │  - LoanPolicy                               │   │
│  │  - UserPolicy                               │   │
│  │  - MaintenanceRequestPolicy                 │   │
│  └─────────────────┬───────────────────────────┘   │
│                    │                                │
│  ┌─────────────────▼───────────────────────────┐   │
│  │   SERVICES (Lógica de negocio)              │   │
│  │  - LoanValidationService                    │   │
│  │  - DateValidationService                    │   │
│  │  - GeminiService (IA)                       │   │
│  └─────────────────┬───────────────────────────┘   │
│                    │                                │
│  ┌─────────────────▼───────────────────────────┐   │
│  │   MODELS (Eloquent ORM)                     │   │
│  │  - User                                     │   │
│  │  - Equipment                                │   │
│  │  - Loan                                     │   │
│  │  - MaintenanceRequest                       │   │
│  │  - Role                                     │   │
│  │  - AuditLog                                 │   │
│  │  - SystemSetting                            │   │
│  └─────────────────┬───────────────────────────┘   │
└────────────────────┬─────────────────────────────────┘
                     │
                     ▼
┌──────────────────────────────────────────────────────┐
│                  CAPA DE DATOS                       │
│                                                      │
│  ┌──────────────────────────────────────────────┐  │
│  │   DATABASE LAYER (MySQL 8.0)                 │  │
│  │  - Tablas normalizadas                       │  │
│  │  - Índices                                   │  │
│  │  - Foreign Keys                              │  │
│  │  - Transacciones                             │  │
│  └──────────────────────────────────────────────┘  │
└──────────────────────────────────────────────────────┘
```

### 5.2 Estructura de Directorios

```
gestionoficina/
│
├── app/
│   ├── Filament/                    # Capa de presentación
│   │   ├── Resources/               # CRUD de recursos
│   │   │   ├── Equipment/
│   │   │   │   ├── EquipmentResource.php
│   │   │   │   ├── Pages/
│   │   │   │   ├── Schemas/
│   │   │   │   └── Tables/
│   │   │   ├── Users/
│   │   │   │   ├── UserResource.php
│   │   │   │   └── ...
│   │   │   ├── Roles/
│   │   │   │   └── RoleResource.php
│   │   │   ├── GestionSolicitudesResource.php  # Admin: todas las solicitudes
│   │   │   ├── SolicitudPrestamoResource.php    # Trabajador: mis solicitudes
│   │   │   ├── MisEquiposResource.php           # Trabajador: mis equipos
│   │   │   ├── MantenimientoResource.php        # Mantenimiento + Admin
│   │   │   └── SystemSettingResource.php        # Admin: configuración
│   │   │
│   │   └── Widgets/                 # Dashboards
│   │       ├── StatsOverviewWidget.php          # Admin: estadísticas generales
│   │       ├── EquipmentChartWidget.php         # Admin: gráficos
│   │       ├── RecentLoansWidget.php            # Admin: préstamos recientes
│   │       ├── PendingMaintenanceWidget.php     # Mantenimiento: pendientes
│   │       ├── MyActiveLoansWidget.php          # Trabajador: mis préstamos
│   │       └── MisEquiposStatsWidget.php        # Trabajador: mis estadísticas
│   │
│   ├── Models/                      # Capa de datos (Eloquent)
│   │   ├── User.php
│   │   ├── Equipment.php
│   │   ├── Loan.php
│   │   ├── MaintenanceRequest.php
│   │   ├── Role.php
│   │   ├── AuditLog.php
│   │   └── SystemSetting.php
│   │
│   ├── Policies/                    # Autorización
│   │   ├── EquipmentPolicy.php
│   │   ├── LoanPolicy.php
│   │   ├── MaintenanceRequestPolicy.php
│   │   └── UserPolicy.php
│   │
│   ├── Services/                    # Lógica de negocio
│   │   ├── LoanValidationService.php
│   │   ├── DateValidationService.php
│   │   └── GeminiService.php
│   │
│   └── Providers/                   # Configuración
│       ├── AppServiceProvider.php
│       └── Filament/
│           └── AdminPanelProvider.php
│
├── database/
│   ├── migrations/                  # Esquema de base de datos
│   ├── seeders/                     # Datos de prueba
│   │   ├── RoleSeeder.php
│   │   ├── UserSeeder.php
│   │   ├── EquipmentSeeder.php
│   │   └── DatabaseSeeder.php
│   └── factories/
│       └── UserFactory.php
│
├── resources/
│   ├── views/                       # Vistas Blade
│   ├── css/
│   └── js/
│
├── routes/
│   ├── web.php                      # Rutas web
│   ├── api.php                      # API (no implementada)
│   └── console.php                  # Comandos Artisan
│
├── config/                          # Configuraciones
├── storage/                         # Archivos y logs
├── public/                          # Assets públicos
├── tests/                           # Testing
└── docs/                            # Documentación
```

### 5.3 Flujo de una Operación Típica

**Ejemplo: Trabajador solicita un préstamo**

1. **Presentación**: Usuario ingresa a `SolicitudPrestamoResource` y completa formulario
2. **Controller**: Filament Resource procesa la petición
3. **Policy**: `LoanPolicy::create()` verifica permisos del usuario
4. **Service**: `LoanValidationService` valida reglas de negocio:
   - Usuario no exceda límite de equipos (configurable)
   - Equipo esté disponible
   - Fechas sean válidas
5. **Model**: Se crea registro en tabla `loans` con estado `pendiente`
6. **Audit**: Se registra en `audit_logs` la acción
7. **View**: Usuario ve notificación de éxito y su solicitud aparece en la tabla

**Ejemplo: Admin aprueba préstamo**

1. **Presentación**: Admin ve solicitud en `GestionSolicitudesResource`
2. **Action**: Hace clic en "Aprobar" (table action)
3. **Policy**: `LoanPolicy::approve()` verifica que sea admin
4. **Transacción DB**: 
   - Actualiza `loans.status` a `activo`
   - Actualiza `equipment.status` a `prestado`
   - Actualiza `equipment.user_id` con el trabajador
   - Registra fecha de préstamo
5. **Audit**: Registra aprobación en `audit_logs`
6. **Notificación**: Trabajador ve notificación (en sistema)

### 5.4 Seguridad

**Autenticación:**
- Laravel Sanctum para sesiones
- Contraseñas hasheadas con bcrypt
- Protección CSRF en todos los formularios

**Autorización:**
- Laravel Gates y Policies
- Verificación en cada operación CRUD
- Middleware para proteger rutas

**Validación:**
- Server-side validation en todos los formularios
- Validaciones de negocio en Services
- Sanitización de inputs

**Base de Datos:**
- Prepared statements (Eloquent)
- Transacciones para operaciones críticas
- Foreign keys con acciones en cascada

**Producción:**
- HTTPS forzado
- Cookies seguras
- Configuración de proxies confiables (Railway)
- Variables de entorno para credenciales

---

## 6. LISTADO DE MÓDULOS DESARROLLADOS

### 6.1 Módulo de Autenticación
**Descripción:** Control de acceso al sistema

**Funcionalidades:**
- Login de usuarios
- Logout
- Recuperación de contraseña (estructura base)
- Sesiones persistentes

**Archivos principales:**
- `config/auth.php`
- `app/Models/User.php`
- Vistas de Filament (auto-generadas)

---

### 6.2 Módulo de Gestión de Usuarios
**Descripción:** CRUD completo de usuarios del sistema

**Funcionalidades:**
- ✅ Listar usuarios con filtros (por rol, búsqueda)
- ✅ Crear nuevos usuarios
- ✅ Editar información de usuarios
- ✅ Eliminar usuarios (soft delete opcional)
- ✅ Asignar roles
- ✅ Ver historial de préstamos por usuario
- ✅ Impersonar usuarios (para testing)

**Roles que acceden:**
- Admin (completo)

**Archivos principales:**
- `app/Filament/Resources/Users/UserResource.php`
- `app/Models/User.php`
- `app/Policies/UserPolicy.php`
- `database/migrations/0001_01_01_000000_create_users_table.php`

**Tabla asociada:** `users`

---

### 6.3 Módulo de Gestión de Roles
**Descripción:** Definición y asignación de roles

**Funcionalidades:**
- ✅ Listar roles existentes
- ✅ Ver usuarios por rol
- 🔒 Crear/editar/eliminar roles (bloqueado en v1.0)

**Roles predefinidos:**
1. **Admin** (`admin`): Acceso total al sistema
2. **Trabajador** (`trabajador`): Solicita préstamos, reporta problemas
3. **Mantenimiento** (`mantenimiento`): Gestiona reparaciones

**Roles que acceden:**
- Admin (solo lectura)

**Archivos principales:**
- `app/Filament/Resources/Roles/RoleResource.php`
- `app/Models/Role.php`
- `database/migrations/2025_10_20_213921_create_roles_table.php`
- `database/seeders/RoleSeeder.php`

**Tabla asociada:** `roles`

---

### 6.4 Módulo de Gestión de Equipos
**Descripción:** Inventario completo de equipos tecnológicos

**Funcionalidades:**
- ✅ Listar equipos con filtros (estado, tipo, asignado a)
- ✅ Crear nuevos equipos
- ✅ Editar información de equipos
- ✅ Eliminar equipos (lógico)
- ✅ Cargar imagen del equipo
- ✅ Ver historial completo de préstamos
- ✅ Ver historial de mantenimientos
- ✅ Cambiar estado manualmente (disponible, prestado, mantenimiento, baja)
- ✅ Asignar directamente a un trabajador (sin solicitud previa)
- ✅ Liberar equipo (devolución directa)

**Estados posibles:**
- `disponible`: Listo para prestar
- `prestado`: Asignado a un trabajador
- `mantenimiento`: En reparación
- `baja`: Dado de baja permanentemente

**Roles que acceden:**
- Admin (completo)
- Trabajador (solo lectura de equipos disponibles)
- Mantenimiento (solo lectura)

**Archivos principales:**
- `app/Filament/Resources/Equipment/EquipmentResource.php`
- `app/Models/Equipment.php`
- `app/Policies/EquipmentPolicy.php`
- `database/migrations/2025_09_17_061641_create_equipment_table.php`
- `database/seeders/EquipmentSeeder.php` (41 equipos de demo)

**Tabla asociada:** `equipment`

---

### 6.5 Módulo de Solicitudes de Préstamo (Trabajador)
**Descripción:** Trabajadores solicitan equipos

**Funcionalidades:**
- ✅ Ver MIS solicitudes (filtradas por usuario logueado)
- ✅ Crear nueva solicitud de préstamo
- ✅ Ver estado de mis solicitudes (pendiente/rechazado/activo/devuelto)
- ✅ Cancelar solicitud pendiente
- ✅ Ver motivo de rechazo (si aplica)
- ✅ Ver fecha estimada de devolución
- ✅ Validación: No exceder límite de equipos simultáneos
- ✅ Validación: No solicitar equipos ya prestados

**Roles que acceden:**
- Trabajador (solo sus propias solicitudes)

**Archivos principales:**
- `app/Filament/Resources/SolicitudPrestamoResource.php`
- Usa modelo `Loan.php`

**Tabla asociada:** `loans`

---

### 6.6 Módulo de Gestión de Solicitudes (Admin)
**Descripción:** Administradores gestionan TODAS las solicitudes

**Funcionalidades:**
- ✅ Ver TODAS las solicitudes del sistema
- ✅ Filtrar por estado, usuario, equipo
- ✅ Aprobar solicitudes pendientes
- ✅ Rechazar solicitudes con motivo
- ✅ Establecer fecha estimada de devolución
- ✅ Agregar notas internas
- ✅ Ver historial completo de cada préstamo
- ✅ Forzar devolución de equipo
- ✅ Badge con contador de solicitudes pendientes

**Acciones disponibles:**
- **Aprobar**: Cambia estado a `activo`, equipo pasa a `prestado`
- **Rechazar**: Cambia estado a `rechazado`, equipo sigue `disponible`
- **Forzar devolución**: Devuelve equipo, cambia a `devuelto`

**Roles que acceden:**
- Admin

**Archivos principales:**
- `app/Filament/Resources/GestionSolicitudesResource.php`
- `app/Services/LoanValidationService.php`
- `app/Policies/LoanPolicy.php`

**Tabla asociada:** `loans`

---

### 6.7 Módulo Mis Equipos (Trabajador)
**Descripción:** Trabajadores ven equipos actualmente asignados

**Funcionalidades:**
- ✅ Ver equipos que ACTUALMENTE tengo prestados
- ✅ Ver fecha de préstamo y devolución estimada
- ✅ Reportar problema en equipo
- ✅ Alertas de vencimiento próximo (configurable)
- ✅ Widget con estadísticas personales

**Acción destacada: Reportar Problema**
1. Trabajador hace clic en "Reportar Problema"
2. Ingresa descripción del problema
3. Sistema crea `MaintenanceRequest` automáticamente
4. Equipo cambia a estado `mantenimiento`
5. Si había préstamo activo, se marca como devuelto automáticamente
6. Personal de mantenimiento recibe notificación (badge)

**Roles que acceden:**
- Trabajador (solo sus equipos)

**Archivos principales:**
- `app/Filament/Resources/MisEquiposResource.php`
- `app/Filament/Widgets/MyActiveLoansWidget.php`
- `app/Filament/Widgets/MisEquiposStatsWidget.php`

**Tabla asociada:** `loans` (con filtro `user_id`)

---

### 6.8 Módulo de Mantenimiento
**Descripción:** Gestión de reparaciones y equipos en mal estado

**Funcionalidades:**
- ✅ Ver TODAS las solicitudes de mantenimiento
- ✅ Filtrar por estado (pendiente/en_proceso/completado/rechazado)
- ✅ Asignarse solicitudes de mantenimiento
- ✅ Cambiar estado a "En proceso"
- ✅ Completar reparación con solución
- ✅ Marcar equipo como "Reparado" (vuelve a disponible)
- ✅ Dar de baja equipo irreparable (estado `baja`)
- ✅ Rechazar solicitud de mantenimiento con motivo
- ✅ Ver historial de mantenimientos por equipo
- ✅ Badge con contador de solicitudes pendientes

**Estados de mantenimiento:**
- `pendiente`: Recién reportado
- `en_proceso`: Técnico trabajando en ello
- `completado`: Reparado o dado de baja
- `rechazado`: No requiere mantenimiento

**Resultados posibles:**
- `reparado`: Equipo vuelve a `disponible`
- `dado_de_baja`: Equipo pasa a `baja` permanentemente
- `pendiente`: Sin resolver aún

**Roles que acceden:**
- Mantenimiento (completo)
- Admin (completo)

**Archivos principales:**
- `app/Filament/Resources/MantenimientoResource.php`
- `app/Models/MaintenanceRequest.php`
- `app/Policies/MaintenanceRequestPolicy.php`
- `app/Filament/Widgets/PendingMaintenanceWidget.php`
- `database/migrations/2025_10_20_000003_create_maintenance_requests_table.php`

**Tabla asociada:** `maintenance_requests`

---

### 6.9 Módulo de Configuración del Sistema
**Descripción:** Parámetros configurables del sistema

**Funcionalidades:**
- ✅ Configurar límite de equipos por trabajador
- ✅ Configurar días de aviso antes de vencimiento
- ✅ Ver/editar configuraciones existentes
- 🔒 Agregar nuevas configuraciones (manual en BD)

**Configuraciones actuales:**
- `max_equipments_per_worker`: Máximo 5 equipos simultáneos (default)
- `dias_aviso_vencimiento`: Aviso 7 días antes (default)

**Roles que acceden:**
- Admin

**Archivos principales:**
- `app/Filament/Resources/SystemSettingResource.php`
- `app/Models/SystemSetting.php`
- `database/migrations/2025_11_16_000001_create_system_settings_table.php`

**Tabla asociada:** `system_settings`

---

### 6.10 Módulo de Auditoría
**Descripción:** Registro de todas las operaciones críticas

**Funcionalidades:**
- ✅ Registro automático de eventos
- ✅ Ver historial de auditoría (futuro dashboard)
- ✅ Rastrear quién hizo qué y cuándo
- ✅ Guardar valores anteriores y nuevos (JSON)
- ✅ Registrar IP y user agent

**Eventos auditados:**
- Aprobación de préstamos
- Rechazo de préstamos
- Devolución de equipos
- Creación de solicitudes de mantenimiento
- Reparaciones completadas
- Equipos dados de baja
- Asignación directa de equipos
- Cambios de estado

**Archivos principales:**
- `app/Models/AuditLog.php`
- `database/migrations/2025_11_16_000003_create_audit_logs_table.php`

**Tabla asociada:** `audit_logs`

---

### 6.11 Módulo de Dashboards

#### Dashboard Admin
**Widgets:**
- `StatsOverviewWidget`: Estadísticas generales (totales)
  - Total de equipos
  - Equipos prestados
  - Equipos disponibles
  - Solicitudes pendientes
  - En mantenimiento

- `EquipmentChartWidget`: Gráfico de equipos por estado

- `RecentLoansWidget`: Últimos 5 préstamos aprobados

#### Dashboard Trabajador
**Widgets:**
- `MyActiveLoansWidget`: Mis préstamos activos con alertas

- `MisEquiposStatsWidget`: Mis estadísticas personales
  - Equipos actualmente prestados
  - Total de préstamos históricos
  - Solicitudes pendientes

#### Dashboard Mantenimiento
**Widgets:**
- `PendingMaintenanceWidget`: Solicitudes de mantenimiento pendientes

**Archivos principales:**
- `app/Filament/Widgets/` (todos los widgets listados)

---

### 6.12 Módulo de Integraciones (Futuro)

#### Gemini AI Service (Preparado pero no activo)
**Descripción:** Servicio para sugerencias inteligentes

**Funcionalidades preparadas:**
- Análisis de patrones de préstamos
- Sugerencias de equipos según perfil de usuario
- Predicción de necesidades de mantenimiento

**Archivo:**
- `app/Services/GeminiService.php`

**Estado:** ⚠️ Preparado pero no implementado en UI

---

## 7. BASE DE DATOS - ESQUEMA COMPLETO

### 7.1 Diagrama Entidad-Relación (Descripción)

**Entidades principales:**
1. `users` - Usuarios del sistema
2. `roles` - Roles de usuario
3. `equipment` - Equipos tecnológicos
4. `loans` - Préstamos de equipos
5. `maintenance_requests` - Solicitudes de mantenimiento
6. `audit_logs` - Registro de auditoría
7. `system_settings` - Configuración del sistema
8. `sessions` - Sesiones de usuario (Laravel)

**Relaciones:**

```
users (1) ──── (N) equipment
  │              (usuario asignado actualmente)
  │
  ├─── (N) loans (user_id)
  │              (usuario que solicita/tiene)
  │
  ├─── (N) loans (assigned_by)
  │              (admin que aprobó)
  │
  ├─── (N) maintenance_requests (requested_by)
  │              (quien reportó problema)
  │
  ├─── (N) maintenance_requests (assigned_to)
  │              (técnico asignado)
  │
  ├─── (N) audit_logs
  │              (quien ejecutó acción)
  │
  └─── (1) roles
               (rol del usuario)

equipment (1) ──── (N) loans
  │                (equipo prestado)
  │
  └─── (N) maintenance_requests
               (equipo en mantenimiento)
```

### 7.2 Tablas Detalladas

#### Tabla: `users`
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role_id BIGINT UNSIGNED NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL,
    INDEX idx_users_role_id (role_id),
    INDEX idx_users_email (email)
);
```

#### Tabla: `roles`
```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(255) UNIQUE NOT NULL,  -- 'admin', 'trabajador', 'mantenimiento'
    name VARCHAR(255) NOT NULL,          -- 'Administrador', 'Trabajador', 'Mantenimiento'
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_roles_code (code)
);
```

#### Tabla: `equipment`
```sql
CREATE TABLE equipment (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    status ENUM('disponible', 'prestado', 'mantenimiento', 'baja') DEFAULT 'disponible',
    user_id BIGINT UNSIGNED NULL,       -- Usuario que actualmente lo tiene
    image VARCHAR(255) NULL,            -- Ruta de imagen
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_equipment_status (status),
    INDEX idx_equipment_user_id (user_id)
);
```

#### Tabla: `loans`
```sql
CREATE TABLE loans (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    equipment_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,           -- Quien solicita/tiene
    assigned_by BIGINT UNSIGNED NULL,           -- Admin que aprobó
    status ENUM('pendiente', 'rechazado', 'activo', 'devuelto') DEFAULT 'pendiente',
    fecha_solicitud DATE NULL,
    fecha_prestamo DATETIME NULL,               -- Cuándo se aprobó y entregó
    fecha_devolucion DATE NULL,                 -- Fecha estimada de devolución
    fecha_devolucion_real DATETIME NULL,        -- Cuándo se devolvió realmente
    motivo TEXT NULL,                           -- Por qué lo necesita
    notas TEXT NULL,                            -- Notas del admin
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_loans_status (status),
    INDEX idx_loans_user_id (user_id),
    INDEX idx_loans_equipment_id (equipment_id),
    INDEX idx_loans_fecha_devolucion (fecha_devolucion)
);
```

#### Tabla: `maintenance_requests`
```sql
CREATE TABLE maintenance_requests (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    equipment_id BIGINT UNSIGNED NOT NULL,
    requested_by BIGINT UNSIGNED NOT NULL,      -- Quien reportó
    assigned_to BIGINT UNSIGNED NULL,           -- Técnico asignado
    status ENUM('pendiente', 'en_proceso', 'completado', 'rechazado') DEFAULT 'pendiente',
    descripcion_problema TEXT NOT NULL,
    solucion TEXT NULL,
    resultado ENUM('reparado', 'dado_de_baja', 'pendiente') DEFAULT 'pendiente',
    fecha_solicitud TIMESTAMP NOT NULL,
    fecha_completado TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE,
    FOREIGN KEY (requested_by) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_maintenance_status (status),
    INDEX idx_maintenance_equipment_id (equipment_id),
    INDEX idx_maintenance_assigned_to (assigned_to)
);
```

#### Tabla: `audit_logs`
```sql
CREATE TABLE audit_logs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    event VARCHAR(255) NOT NULL,                -- 'loan_approved', 'loan_rejected', etc.
    auditable_type VARCHAR(255) NOT NULL,       -- 'App\Models\Loan', 'App\Models\Equipment'
    auditable_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,           -- Quien ejecutó la acción
    old_values JSON NULL,                       -- Estado anterior
    new_values JSON NULL,                       -- Estado nuevo
    description TEXT NULL,                      -- Descripción legible
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_audit_auditable (auditable_type, auditable_id),
    INDEX idx_audit_event (event),
    INDEX idx_audit_user_id (user_id),
    INDEX idx_audit_created_at (created_at)
);
```

#### Tabla: `system_settings`
```sql
CREATE TABLE system_settings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    key VARCHAR(255) UNIQUE NOT NULL,
    value TEXT NULL,
    type VARCHAR(255) DEFAULT 'string',         -- 'string', 'integer', 'boolean', 'json'
    description VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_system_settings_key (key)
);
```

### 7.3 Datos de Demostración

**15 Usuarios creados:**
- 3 Administradores (admin, laura, roberto)
- 8 Trabajadores (carlos, maria, juan, sofia, diego, valentina, lucas, camila)
- 4 Personal de Mantenimiento (pedro, ana, fernando, patricia)

**41 Equipos creados:**
- 10 Laptops (Dell, HP, Lenovo, MacBook)
- 8 Tablets (iPad, Samsung Galaxy Tab)
- 6 Proyectores (Epson, BenQ)
- 5 Cámaras (Canon, Sony, Nikon)
- 5 Monitores (Dell, Samsung, LG)
- 4 Equipos de Audio (Micrófonos, Altavoces)
- 3 Equipos de Red (Routers, Switches)

Ver detalle completo en: `docs/DATOS_DEMO.md`

---

## 8. CAPTURAS DE PANTALLA Y MANUAL DE USUARIO

### 8.1 Guía para Capturar Pantallas

Para tu informe, necesitas capturar:

**Dashboard Admin:**
1. Vista principal con widgets (Stats, Chart, Recent Loans)
2. Gestión de Equipos - Listado con filtros
3. Gestión de Equipos - Formulario de edición
4. Gestión de Solicitudes - Tabla con badge de pendientes
5. Gestión de Solicitudes - Acción de aprobar (modal)
6. Gestión de Usuarios - Listado con roles
7. Mantenimiento - Listado de solicitudes

**Dashboard Trabajador:**
1. Vista principal con widgets (My Active Loans, Stats)
2. Solicitar Préstamo - Formulario
3. Mis Solicitudes - Listado (con diferentes estados)
4. Mis Equipos - Listado con acción "Reportar Problema"
5. Reportar Problema - Modal con formulario

**Dashboard Mantenimiento:**
1. Vista principal con widget de pendientes
2. Solicitudes de Mantenimiento - Listado
3. Completar Mantenimiento - Formulario con opciones (reparado/baja)

### 8.2 Manual de Usuario - Estructura Sugerida

#### Para Administradores

**1. Gestión de Equipos**
- Cómo agregar un nuevo equipo
- Cómo editar información de un equipo
- Cómo dar de baja un equipo
- Cómo asignar un equipo directamente a un trabajador

**2. Gestión de Solicitudes de Préstamo**
- Cómo ver solicitudes pendientes (badge indicador)
- Cómo aprobar una solicitud
- Cómo rechazar una solicitud con motivo
- Cómo establecer fecha de devolución
- Cómo forzar devolución de un equipo

**3. Gestión de Usuarios**
- Cómo crear un nuevo usuario
- Cómo asignar roles
- Cómo ver el historial de préstamos de un usuario

**4. Gestión de Mantenimiento**
- Cómo ver solicitudes de mantenimiento pendientes
- Cómo completar un mantenimiento
- Cómo dar de baja un equipo irreparable

**5. Configuración del Sistema**
- Cómo cambiar el límite de equipos por trabajador
- Cómo configurar días de aviso de vencimiento

#### Para Trabajadores

**1. Solicitar un Préstamo**
- Cómo buscar equipos disponibles
- Cómo completar formulario de solicitud
- Qué información proporcionar (motivo)
- Cómo ver el estado de mi solicitud

**2. Mis Equipos Actuales**
- Cómo ver qué equipos tengo prestados
- Cómo ver fecha de devolución
- Alertas de vencimiento próximo

**3. Reportar Problemas**
- Cuándo reportar un problema
- Cómo usar la acción "Reportar Problema"
- Qué información incluir en la descripción
- Qué pasa después de reportar

**4. Mis Solicitudes**
- Cómo ver mis solicitudes (historial)
- Estados posibles: pendiente, activo, rechazado, devuelto
- Cómo cancelar una solicitud pendiente

#### Para Personal de Mantenimiento

**1. Ver Solicitudes Pendientes**
- Cómo acceder al módulo de Mantenimiento
- Badge indicador de pendientes
- Filtros por estado

**2. Trabajar en una Reparación**
- Cómo cambiar estado a "En proceso"
- Cómo asignarse una solicitud

**3. Completar un Mantenimiento**
- Cómo marcar como reparado (equipo vuelve a disponible)
- Cómo dar de baja un equipo (irreparable)
- Importancia de registrar la solución aplicada

**4. Ver Historial de Mantenimientos**
- Cómo ver mantenimientos anteriores de un equipo
- Estadísticas de reparaciones

---

## 9. ASPECTOS TÉCNICOS ADICIONALES

### 9.1 Optimizaciones Implementadas

**Performance:**
- Eager loading para evitar N+1 queries
- Índices en columnas frecuentemente consultadas
- Caché de configuraciones del sistema
- Paginación en todas las tablas

**Validaciones:**
- Servicios centralizados (`LoanValidationService`, `DateValidationService`)
- Validaciones de negocio antes de operaciones críticas
- Transacciones de base de datos para operaciones múltiples

**Seguridad:**
- Políticas de autorización en cada operación
- Sanitización de inputs
- HTTPS forzado en producción
- Protección CSRF

### 9.2 Características de Producción

**Deployment Automático:**
- Push a `main` → Railway despliega automáticamente
- Migraciones automáticas en deployment
- Variables de entorno en Railway

**Monitoreo:**
- Logs accesibles en Railway dashboard
- Métricas de rendimiento
- Uso de recursos (CPU, RAM, DB)

**Base de Datos:**
- MySQL en Railway (plan gratuito)
- Backups automáticos
- Conexión segura

### 9.3 Testing

**Tests Disponibles:**
- Feature tests para flujos principales
- Unit tests para servicios
- Test de políticas de autorización

**Comando:**
```bash
./vendor/bin/sail artisan test
```

### 9.4 Documentación Disponible

En la carpeta `docs/`:
- `SISTEMA_ROLES.md`: Detalle completo de roles y permisos
- `FLUJO_COMPLETO_SISTEMA.md`: Flujos de trabajo paso a paso
- `RAILWAY_DEPLOYMENT.md`: Guía de deployment
- `DATOS_DEMO.md`: Usuarios y equipos de demostración
- `COMANDOS_SAIL.md`: Referencia de comandos

---

## 10. CONCLUSIONES Y TRABAJO FUTURO

### 10.1 Objetivos Cumplidos
✅ Sistema completamente funcional con 3 roles diferenciados  
✅ Gestión completa de préstamos con aprobaciones  
✅ Control de inventario con estados  
✅ Sistema de mantenimiento con trazabilidad  
✅ Auditoría de operaciones críticas  
✅ Dashboards personalizados por rol  
✅ Deployment en producción funcional  
✅ 41 equipos y 15 usuarios de demostración  
✅ Documentación técnica completa  

### 10.2 Mejoras Futuras (Post-TFI)

**Funcionalidades:**
- [ ] Notificaciones por email/SMS
- [ ] Sistema de reservas anticipadas
- [ ] Reportes y estadísticas avanzadas (PDF/Excel)
- [ ] API REST para integraciones externas
- [ ] App móvil (PWA o nativa)
- [ ] Código QR para equipos
- [ ] Historial fotográfico de equipos
- [ ] Chat interno entre roles
- [ ] Integración con Active Directory/LDAP
- [ ] Dashboard de IA con Gemini (predicciones)

**Técnicas:**
- [ ] Tests E2E con Selenium
- [ ] Cobertura de tests > 80%
- [ ] CI/CD con GitHub Actions
- [ ] Monitoreo con Sentry
- [ ] Caché con Redis en producción
- [ ] Queue system para emails
- [ ] Multi-idioma (i18n)
- [ ] Dark mode

### 10.3 Lecciones Aprendidas
- Laravel Sail facilita enormemente el desarrollo local
- Filament acelera el desarrollo de CRUDs
- Railway es excelente para deployment rápido
- La arquitectura en capas (Services, Policies) mejora mantenibilidad
- Los seeders con datos realistas son cruciales para demos

---

## 11. REFERENCIAS

### 11.1 Documentación Oficial
- Laravel 12: https://laravel.com/docs/12.x
- Filament 4: https://filamentphp.com/docs/4.x/
- MySQL 8.0: https://dev.mysql.com/doc/refman/8.0/
- Tailwind CSS: https://tailwindcss.com/docs
- Docker: https://docs.docker.com/

### 11.2 Repositorios
- Proyecto: https://github.com/colomyago/gestionoficina
- Laravel Sail: https://github.com/laravel/sail
- Filament: https://github.com/filamentphp/filament

### 11.3 Servicios Externos
- Railway: https://railway.app
- GitHub: https://github.com

---

## 12. GLOSARIO

**CRUD:** Create, Read, Update, Delete - Operaciones básicas de base de datos

**Eloquent:** ORM (Object-Relational Mapping) de Laravel para interactuar con la base de datos

**Middleware:** Capa de software que filtra peticiones HTTP antes de llegar al controlador

**Migration:** Archivo que define cambios en el esquema de base de datos

**Seeder:** Archivo que inserta datos de prueba en la base de datos

**Policy:** Clase que define reglas de autorización para un modelo

**Livewire:** Framework de Laravel para componentes reactivos sin JavaScript

**Filament:** Framework de administración construido sobre Laravel y Livewire

**Railway:** Plataforma de deployment (PaaS - Platform as a Service)

**Docker:** Plataforma de contenedorización para desarrollo

**Sail:** Wrapper de Docker específico de Laravel

**Widget:** Componente visual del dashboard (estadísticas, gráficos, etc.)

**Badge:** Indicador visual numérico (ej: contador de notificaciones)

**Eager Loading:** Técnica de optimización que carga relaciones en una sola query

**Soft Delete:** Borrado lógico (marca como eliminado sin borrar físicamente)

**Foreign Key:** Clave foránea que relaciona dos tablas

**Index:** Estructura de datos que mejora velocidad de búsqueda en BD

**Transaction:** Conjunto de operaciones de BD que se ejecutan atómicamente

**Auditable:** Modelo que registra automáticamente cambios en audit_logs

**Enum:** Tipo de dato con valores predefinidos (ej: estado = 'pendiente' | 'activo')

---

## 13. HISTORIAL DE REVISIONES

| Versión | Fecha | Autor | Cambios |
|---------|-------|-------|---------|
| 1.0 | [Fecha actual] | [Tu nombre] | Versión inicial - Documentación completa del TFI |

---

**FIN DEL DOCUMENTO**

---

## APÉNDICES

### Apéndice A: Comandos Útiles

**Instalación:**
```bash
git clone https://github.com/colomyago/gestionoficina.git
cd gestionoficina
cp .env.example .env
docker run --rm -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

**Desarrollo:**
```bash
# Iniciar servicios
./vendor/bin/sail up -d

# Ver logs
./vendor/bin/sail logs -f

# Ejecutar migraciones
./vendor/bin/sail artisan migrate

# Resetear base de datos con datos de prueba
./vendor/bin/sail artisan migrate:fresh --seed

# Acceder a MySQL
./vendor/bin/sail mysql

# Ejecutar tests
./vendor/bin/sail artisan test

# Detener servicios
./vendor/bin/sail down
```

### Apéndice B: Variables de Entorno Importantes

```env
APP_NAME="Gestión de Oficina"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://gestionoficina-production.up.railway.app

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=gestionoficina
DB_USERNAME=root
DB_PASSWORD=password
```

### Apéndice C: Estructura de JSON en audit_logs

**Ejemplo de registro de auditoría:**
```json
{
  "event": "loan_approved",
  "auditable_type": "App\\Models\\Loan",
  "auditable_id": 42,
  "user_id": 1,
  "old_values": {
    "status": "pendiente",
    "assigned_by": null,
    "fecha_prestamo": null
  },
  "new_values": {
    "status": "activo",
    "assigned_by": 1,
    "fecha_prestamo": "2025-11-18 14:30:00"
  },
  "description": "Admin admin@gestionoficina.com aprobó el préstamo #42",
  "ip_address": "192.168.1.10",
  "user_agent": "Mozilla/5.0...",
  "created_at": "2025-11-18 14:30:00"
}
```
