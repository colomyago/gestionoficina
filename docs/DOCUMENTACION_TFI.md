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

## 2. HISTORIAL DE VERSIONES

### Versión 0.1.0 - Inicio del Proyecto (Julio 2025)
**Fecha**: 15 de Julio de 2025  
**Estado**: Planificación

**Actividades:**
- Definición de requisitos funcionales
- Diseño de arquitectura del sistema
- Modelado de base de datos (DER)
- Selección de tecnologías:
  - Backend: Laravel 12
  - Frontend: Filament 4.0
  - Base de datos: MySQL 8.0
  - Deploy: Railway
- Definición de roles y permisos
- Diseño de flujos de trabajo (préstamos, mantenimiento)
- Creación de repositorio Git

---

### Versión 0.2.0 - Alpha (Agosto 2025)
**Fecha**: 1 de Agosto de 2025  
**Estado**: Desarrollo

**Configuración Inicial:**
- Instalación de Laravel 12
- Instalación de Filament 4.0
- Configuración de AdminPanelProvider
- Autenticación con email y contraseña
- Panel de administración básico

**Base de Datos:**
- Migraciones base de Laravel
- Configuración de MySQL en local (Sail)
- Tabla `roles` con 3 roles predefinidos

**Entorno de Desarrollo:**
- Laravel Sail configurado
- Docker compose con MySQL, Redis, Mailpit
- Configuración de .env local

---

### Versión 0.3.0 - Alpha (Agosto 2025)
**Fecha**: 10 de Agosto de 2025  
**Estado**: Desarrollo

**Nuevas Funcionalidades:**
- Gestión de Equipos (EquipmentResource)
- CRUD completo con formularios Filament
- Campos: nombre, descripción, estado, imagen
- Filtros por estado en tabla
- Badges de color por estado

**Migraciones:**
- Tabla `equipment` con campos: name, description, status, image_path
- Enum para status: 'disponible', 'prestado', 'mantenimiento', 'baja'

---

### Versión 0.4.0 - Alpha (Agosto 2025)
**Fecha**: 25 de Agosto de 2025  
**Estado**: Desarrollo

**Nuevas Funcionalidades:**
- Gestión de Usuarios (UserResource)
- CRUD completo de usuarios
- Asignación de roles en formulario
- Contraseña opcional al editar (solo cambiar si se completa)
- Validación de email único

**Seeders:**
- RoleSeeder: 3 roles (Admin, Trabajador, Mantenimiento)
- UserSeeder: usuarios de prueba por rol
  - admin@gestionoficina.com
  - carlos@gestionoficina.com (trabajador)
  - pedro@gestionoficina.com (mantenimiento)
  - Contraseña: password123

---

### Versión 0.5.0 - Alpha (Septiembre 2025)
**Fecha**: 5 de Septiembre de 2025  
**Estado**: Testing funcional

**Nuevas Funcionalidades:**
- Solicitud de Préstamos (SolicitudPrestamoResource)
- Selección de equipo disponible en formulario
- Campo de motivo obligatorio
- Estado inicial "Pendiente"

**Migraciones:**
- Tabla `loans` con campos: equipment_id, user_id, requested_at, loan_date, return_date, status, approved_by, reason, rejection_reason, notes
- Enums para status: 'pendiente', 'rechazado', 'activo', 'devuelto'

**Seeders:**
- Equipos de prueba (10 equipos)
- Solicitudes de prueba en diferentes estados

---

### Versión 0.6.0 - Alpha (Septiembre 2025)
**Fecha**: 20 de Septiembre de 2025  
**Estado**: Testing funcional

**Nuevas Funcionalidades:**
- Módulo "Mis Solicitudes" (vista trabajador)
- Módulo "Mis Equipos" (equipos asignados al trabajador)
- Reportar problemas en equipos asignados
- Cancelar solicitudes pendientes
- Ver motivo de rechazo en solicitudes

**Scopes en Models:**
- `Loan::pending()`, `Loan::active()`, `Loan::rejected()`, `Loan::returned()`
- `Equipment::available()`, `Equipment::loaned()`, `Equipment::maintenance()`, `Equipment::decommissioned()`
- `MaintenanceRequest::pending()`, `MaintenanceRequest::inProgress()`, `MaintenanceRequest::completed()`

**Políticas de Autorización:**
- LoanPolicy: trabajador solo ve sus propias solicitudes
- EquipmentPolicy: trabajador no puede editar/eliminar equipos
- UserPolicy: solo admin puede gestionar usuarios

---

### Versión 0.7.0 - Beta (Octubre 2025)
**Fecha**: 10 de Octubre de 2025  
**Estado**: Testing interno

**Nuevas Funcionalidades:**
- Gestión de Solicitudes (vista administrador)
- Aprobar solicitudes con fecha de devolución
- Rechazar solicitudes con motivo obligatorio
- Ver detalles completos de solicitudes
- Asignación directa de equipos (sin solicitud previa)

**Automatizaciones:**
- Al aprobar solicitud: equipo pasa a "Prestado", solicitud a "Activo"
- Al rechazar solicitud: equipo permanece "Disponible", solicitud a "Rechazado"
- Al reportar problema: equipo pasa a "Mantenimiento", préstamo activo se marca como devuelto

**Validaciones:**
- No permitir aprobar solicitudes si equipo no está disponible
- Fecha de devolución debe ser posterior a fecha de préstamo
- Motivo obligatorio al rechazar solicitud
- Descripción obligatoria al reportar problema

---

### Versión 0.8.0 - Beta (Octubre 2025)
**Fecha**: 25 de Octubre de 2025  
**Estado**: Testing interno

**Nuevas Funcionalidades:**
- Módulo de Mantenimiento completo
- Asignación de técnicos a solicitudes de mantenimiento
- Cambio de estado: Pendiente → En Proceso → Completado
- Dar de baja equipos irreparables
- Rechazar solicitudes de mantenimiento
- Historial de mantenimientos por equipo

**Mejoras de UI:**
- Badges de color por estado (equipos, solicitudes, mantenimiento)
- Iconos en menú lateral
- Tablas responsive
- Filtros colapsables en móvil

**Migraciones:**
- Tabla `maintenance_requests` con campos: equipment_id, reported_by, description, status, assigned_to, solution, result
- Índices en columnas de foreign keys

---

### Versión 0.9.0 - Release Candidate (Noviembre 2025)
**Fecha**: 10 de Noviembre de 2025  
**Estado**: Testing final

**Cambios Implementados:**
- Integración completa de auditoría en todas las operaciones
- Dashboards con gráficos CircleChart
- Widget de préstamos activos en dashboard trabajador
- Widget de solicitudes pendientes en dashboard mantenimiento
- Configuración del sistema (SystemSettings model + resource)
- Validación de límite de equipos por trabajador
- Alertas de vencimiento en dashboard y "Mis Equipos"

**Correcciones:**
- Filtros en tablas no persistían al navegar
- Badges de notificación no se actualizaban en tiempo real
- Fechas de devolución permitían valores pasados
- Al dar de baja un equipo, el préstamo activo no se cerraba automáticamente

**Pruebas:**
- Testing completo de flujos de préstamo
- Testing de mantenimiento (reparado vs baja)
- Testing de validaciones de fecha
- Testing de límites de equipos

---

### Versión 1.0.0 - Versión Final (Noviembre 2025)
**Fecha de Lanzamiento**: 19 de Noviembre de 2025  
**Estado**: Producción

**Características Principales:**
- Sistema completamente funcional en producción
- 11 módulos implementados y operativos
- 3 roles de usuario con permisos diferenciados
- Despliegue en Railway con base de datos MySQL 8.0
- Interfaz completa con Filament 4.0

**Nuevas Funcionalidades:**
- Dashboard personalizado por rol con widgets estadísticos
- Gráficos interactivos de distribución de equipos
- Sistema de badges para notificaciones en tiempo real
- Alertas de vencimiento configurables
- Auditoría completa de todas las operaciones
- Configuración de parámetros del sistema (max_equipments_per_worker, dias_aviso_vencimiento)
- Historial completo de préstamos por equipo
- Historial completo de mantenimientos por equipo
- Filtros avanzados en todas las tablas
- Búsqueda en tiempo real

**Módulos Implementados:**
1. Gestión de Equipos (CRUD completo + historial)
2. Gestión de Usuarios (CRUD + asignación de roles)
3. Gestión de Roles (sistema de permisos)
4. Solicitudes de Préstamo (flujo completo: solicitar → aprobar/rechazar → devolver)
5. Mis Solicitudes (vista trabajador con filtros)
6. Mis Equipos (equipos asignados al trabajador logueado)
7. Gestión de Solicitudes (vista admin de todas las solicitudes)
8. Mantenimiento (flujo completo: reportar → asignar → reparar/dar de baja)
9. Configuración del Sistema (parámetros editables)
10. Auditoría (registro automático de operaciones)
11. Dashboards Personalizados (3 dashboards según rol)

**Mejoras de Seguridad:**
- Autenticación con Laravel Sanctum
- Validación de roles en todos los endpoints
- Políticas de autorización (EquipmentPolicy, LoanPolicy, etc.)
- Protección CSRF en formularios
- Sanitización de entradas
- Validación de fechas (DateValidationService)
- Límite de equipos por trabajador configurable

**Optimizaciones de Rendimiento:**
- Eager loading en relaciones Eloquent (->with())
- Índices en columnas de búsqueda frecuente
- Caché de consultas pesadas
- Paginación en todas las tablas (15 items por página)
- Queries optimizadas con scopes

**Infraestructura:**
- Despliegue automatizado en Railway
- Base de datos MySQL 8.0 en Railway
- HTTPS forzado en producción
- Manejo de proxies confiables (TrustProxies)
- Configuración de cookies seguras
- Variables de entorno protegidas

**Testing:**
- Tests unitarios para servicios (DateValidationService, LoanValidationService)
- Tests de feature para flujos completos
- Tests de políticas de autorización
- Cobertura de casos edge

**Documentación:**
- Manual de usuario completo (3 roles)
- Documentación técnica detallada
- Guía de despliegue en Railway
- Comandos de Sail documentados
- Diagramas de arquitectura
- Esquema de base de datos (DER)
- Preguntas frecuentes (FAQ)
- Glosario de términos

---

## 3. OBJETIVO Y DESCRIPCIÓN DE LA PROPUESTA

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

### 5.2 Estructura de Directorios del Proyecto

La organización del proyecto sigue la estructura estándar de Laravel con extensiones para Filament:

#### Directorio Raíz
```
gestionoficina/
├── app/                    Código fuente de la aplicación
├── bootstrap/              Archivos de arranque del framework
├── config/                 Archivos de configuración
├── database/               Migraciones, seeders y factories
├── public/                 Punto de entrada web y assets públicos
├── resources/              Vistas, CSS y JavaScript
├── routes/                 Definición de rutas
├── storage/                Archivos generados, logs y caché
├── tests/                  Tests automatizados
├── vendor/                 Dependencias de Composer
├── docs/                   Documentación del proyecto
├── .env                    Variables de entorno
├── artisan                 CLI de Laravel
├── composer.json           Dependencias PHP
├── package.json            Dependencias JavaScript
├── docker-compose.yml      Configuración de Docker
└── Procfile                Configuración de Railway
```

#### app/ - Código de la Aplicación

```
app/
│
├── Filament/                      [Presentación]
│   ├── Resources/                 → CRUD (Equipos, Usuarios, Préstamos, etc.)
│   ├── Widgets/                   → Dashboards y estadísticas
│   └── Pages/                     → Páginas personalizadas
│
├── Models/                        [Datos]
│   ├── User.php, Role.php
│   ├── Equipment.php, Loan.php
│   ├── MaintenanceRequest.php
│   └── AuditLog.php, SystemSetting.php
│
├── Policies/                      [Autorización]
│   └── *Policy.php                → Permisos por rol
│
├── Services/                      [Lógica de Negocio]
│   └── *ValidationService.php     → Reglas de validación
│
├── Http/                          [HTTP]
│   ├── Controllers/
│   └── Middleware/
│
└── Providers/                     [Configuración]
    └── AppServiceProvider.php
```

#### database/ - Base de Datos

```
database/
│
├── migrations/                         Esquema de base de datos
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 2025_10_20_213921_create_roles_table.php
│   ├── 2025_09_17_061641_create_equipment_table.php
│   ├── 2025_10_20_000002_create_loans_table.php
│   ├── 2025_10_20_000003_create_maintenance_requests_table.php
│   ├── 2025_11_16_000001_create_system_settings_table.php
│   └── 2025_11_16_000003_create_audit_logs_table.php
│
├── seeders/                            Datos de prueba
│   ├── DatabaseSeeder.php              → Seeder principal
│   ├── RoleSeeder.php                  → 3 roles base
│   ├── UserSeeder.php                  → 15 usuarios de demo
│   └── EquipmentSeeder.php             → 41 equipos de demo
│
└── factories/                          Factories para testing
    └── UserFactory.php
```

#### resources/ - Vistas y Assets

```
resources/
│
├── views/                              Plantillas Blade
│   ├── components/                     → Componentes reutilizables
│   ├── layouts/                        → Layouts base
│   └── vendor/                         → Vistas de paquetes
│
├── css/
│   └── app.css                         → Estilos principales (Tailwind)
│
└── js/
    └── app.js                          → JavaScript principal
```

#### routes/ - Rutas de la Aplicación

```
routes/
│
├── web.php                             Rutas web (Filament las maneja)
├── api.php                             Rutas API (no implementadas)
└── console.php                         Comandos Artisan personalizados
```

#### config/ - Configuraciones

```
config/
│
├── app.php                             Configuración general
├── auth.php                            Autenticación
├── database.php                        Conexiones de BD
├── filament.php                        Configuración de Filament
├── services.php                        APIs externas
└── session.php                         Configuración de sesiones
```

#### tests/ - Testing

```
tests/
│
├── Feature/                            Tests de funcionalidades
│   ├── LoanTest.php                    → Tests de préstamos
│   ├── EquipmentTest.php               → Tests de equipos
│   └── MaintenanceTest.php             → Tests de mantenimiento
│
├── Unit/                               Tests unitarios
│   ├── LoanValidationServiceTest.php   → Tests de servicios
│   └── DateValidationServiceTest.php
│
└── TestCase.php                        Clase base de tests
```

#### docs/ - Documentación

```
docs/
│
├── DOCUMENTACION_TFI.md                Este documento
├── SISTEMA_ROLES.md                    Roles y permisos detallados
├── FLUJO_COMPLETO_SISTEMA.md           Flujos de trabajo
├── RAILWAY_DEPLOYMENT.md               Guía de deployment
├── DATOS_DEMO.md                       Usuarios y equipos de demo
├── COMANDOS_SAIL.md                    Referencia de comandos
└── DIAGRAMA_BASE_DATOS.md              Diagrama ER
```

#### Archivos de Configuración del Proyecto

```
Raíz del proyecto/
│
├── .env                                Variables de entorno
├── .env.example                        Plantilla de variables
├── .gitignore                          Archivos ignorados por Git
├── artisan                             CLI de Laravel
├── composer.json                       Dependencias PHP
├── composer.lock                       Versiones exactas de dependencias
├── package.json                        Dependencias JavaScript
├── package-lock.json                   Versiones exactas de npm
├── vite.config.js                      Configuración de Vite (build)
├── tailwind.config.js                  Configuración de Tailwind CSS
├── phpunit.xml                         Configuración de tests
├── docker-compose.yml                  Servicios Docker (Sail)
├── Dockerfile                          Imagen Docker personalizada
├── Procfile                            Comandos de Railway
└── README.md                           Información del proyecto
```

**Notas sobre la estructura:**

1. **Separación de responsabilidades**: Cada directorio tiene un propósito específico
2. **Escalabilidad**: Fácil agregar nuevos recursos siguiendo la estructura
3. **Mantenibilidad**: Código organizado por capas (Presentación, Lógica, Datos)
4. **Testing**: Tests organizados por tipo (Feature/Unit)
5. **Documentación**: Centralizada en carpeta `docs/`

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

## 8. MANUAL DE USUARIO

### 8.1 Introducción

El Sistema de Gestión de Oficina es una aplicación web diseñada para facilitar el control y administración de equipos tecnológicos dentro de una organización. El sistema permite gestionar préstamos de equipos, controlar su estado, registrar mantenimientos y generar auditorías de todas las operaciones realizadas.

**Acceso al Sistema**

URL de acceso: https://gestionoficina-production.up.railway.app/admin

El sistema es compatible con los principales navegadores web (Chrome, Firefox, Edge, Safari) y funciona correctamente en dispositivos desktop, tablets y móviles.

**Roles de Usuario**

El sistema cuenta con tres roles diferenciados:

- **Administrador**: Control completo del sistema. Gestiona equipos, usuarios, aprueba o rechaza solicitudes de préstamo, configura parámetros del sistema y visualiza auditorías.

- **Trabajador**: Usuario estándar que puede solicitar préstamos de equipos, consultar sus solicitudes activas, reportar problemas en equipos asignados y devolver equipos.

- **Personal de Mantenimiento**: Responsable de gestionar las solicitudes de reparación, actualizar el estado de los equipos en mantenimiento y decidir si un equipo debe ser reparado o dado de baja.

**Organización del Manual**

Este manual está organizado en tres secciones principales, una por cada rol de usuario. Cada sección incluye instrucciones detalladas acompañadas de capturas de pantalla numeradas que ilustran cada funcionalidad.

---

### 8.2 Inicio de Sesión

Todos los usuarios acceden al sistema a través de la misma pantalla de login. El sistema identificará automáticamente el rol del usuario y lo redirigirá al dashboard correspondiente.

**Figura 1: Pantalla de Inicio de Sesión**
*[CAPTURA: Pantalla completa de login con campos de email y contraseña, botón "Iniciar Sesión"]*

**Pasos para iniciar sesión:**

1. Abrir la URL del sistema en el navegador web
2. Ingresar el email proporcionado por el administrador
3. Ingresar la contraseña
4. Hacer clic en el botón "Iniciar Sesión"
5. El sistema valida las credenciales y redirige al dashboard según el rol asignado

En caso de olvidar la contraseña, contactar al administrador del sistema para solicitar un restablecimiento.

---

### 8.3 Manual del Administrador

Los administradores tienen control completo sobre todas las funcionalidades del sistema. Pueden gestionar equipos, usuarios, aprobar o rechazar solicitudes, configurar parámetros y consultar auditorías.

#### 8.3.1 Dashboard del Administrador

**Figura 2: Dashboard Completo del Administrador**
*[CAPTURA: Vista completa del dashboard con widgets de estadísticas, gráfico circular, tabla de préstamos recientes, menú lateral con badges]*

Al iniciar sesión, el administrador visualiza un dashboard con información relevante:

- **Estadísticas Generales**: Muestra el total de equipos en el sistema, cantidad de equipos prestados, disponibles y en mantenimiento.

- **Gráfico Circular**: Representa visualmente la distribución de equipos según su estado actual.

- **Préstamos Recientes**: Tabla con los últimos préstamos realizados, incluyendo usuario, equipo, fechas y estado.

- **Badges de Notificación**: En el menú lateral aparecen badges numéricos indicando solicitudes pendientes de aprobación o equipos que requieren atención.

#### 8.3.2 Gestión de Equipos

##### Ver y Filtrar Equipos

**Figura 3: Listado de Equipos con Filtros**
*[CAPTURA: Página "Equipos" con tabla completa, barra de búsqueda, filtros de estado, badges de colores, columnas ordenables]*

Para acceder al listado de equipos:

1. Hacer clic en "Equipos" en el menú lateral
2. Se muestra una tabla con todos los equipos del sistema

**Características del listado:**

- **Barra de búsqueda**: Permite buscar equipos por nombre
- **Filtros por estado**: Disponible, Prestado, Mantenimiento, Baja
- **Badges de color**: Identifican visualmente el estado de cada equipo (verde=disponible, amarillo=prestado, azul=mantenimiento, gris=baja)
- **Columnas ordenables**: Click en los encabezados para ordenar alfabéticamente o por fecha
- **Acciones disponibles**: Botones de editar, ver historial, asignar, eliminar

##### Crear Nuevo Equipo

**Figura 4: Formulario de Creación de Equipo**
*[CAPTURA: Modal o página de crear equipo con formulario vacío: Nombre, Descripción, Estado, Imagen]*

Para crear un nuevo equipo:

1. En la página de Equipos, hacer clic en el botón "Nuevo Equipo" o "Crear"
2. Completar los siguientes campos:
   - **Nombre** (obligatorio): Identificación del equipo (ej: "Laptop Dell XPS 15")
   - **Descripción** (opcional): Detalles adicionales como especificaciones técnicas, número de serie, ubicación física
   - **Estado**: Seleccionar estado inicial (generalmente "Disponible")
   - **Imagen** (opcional): Cargar una fotografía del equipo
3. Hacer clic en "Guardar" o "Crear"
4. El sistema confirma la creación y el equipo aparece en el listado

##### Editar Equipo Existente

**Figura 5: Formulario de Edición con Datos Pre-cargados**
*[CAPTURA: Modal de edición de un equipo existente con formulario completo de datos]*

Para modificar un equipo:

1. En la tabla de equipos, localizar el equipo a editar
2. Hacer clic en el botón "Editar" (icono de lápiz)
3. Se abre un formulario con los datos actuales del equipo
4. Modificar los campos necesarios
5. Hacer clic en "Guardar"
6. El sistema actualiza la información

**Nota**: El cambio de estado desde esta pantalla debe hacerse con precaución. Los cambios de estado automáticos (cuando se aprueba un préstamo o se reporta un problema) son gestionados por el sistema.

##### Ver Historial de Préstamos

**Figura 6: Historial Completo de un Equipo**
*[CAPTURA: Vista de historial con tabla de préstamos anteriores, fechas, usuarios, estados]*

Para consultar el historial de un equipo:

1. En la tabla de equipos, hacer clic en "Ver Historial" o icono de historial
2. Se muestra una tabla con todos los préstamos históricos del equipo

**Información visible:**
- Usuario que tuvo asignado el equipo
- Fecha de préstamo
- Fecha de devolución
- Estado de la solicitud
- Administrador que aprobó
- Notas adicionales

Esta información es útil para:
- Identificar equipos con alto índice de uso
- Rastrear responsabilidades en caso de daños
- Analizar patrones de uso

#### 8.3.3 Gestión de Solicitudes de Préstamo

##### Listado de Solicitudes

**Figura 7: Todas las Solicitudes con Badge de Pendientes**
*[CAPTURA: Página "Gestión de Solicitudes" con tabla de solicitudes, badge numérico en menú, badges de color por estado]*

Para acceder a las solicitudes:

1. Hacer clic en "Gestión de Solicitudes" en el menú lateral
2. El badge junto al nombre del menú indica la cantidad de solicitudes pendientes de aprobación
3. Se muestra una tabla con todas las solicitudes del sistema

**Características:**
- **Filtros**: Por estado (pendiente, activo, rechazado, devuelto), usuario solicitante, equipo
- **Badges de color**: Amarillo=pendiente, verde=activo, rojo=rechazado, gris=devuelto
- **Información visible**: Trabajador solicitante, equipo solicitado, motivo, fecha de solicitud, estado

##### Aprobar Solicitud

**Figura 8: Modal de Aprobación de Solicitud**
*[CAPTURA: Modal con fecha de préstamo auto-completada, selector de fecha de devolución, campo de notas opcional]*

Para aprobar una solicitud pendiente:

1. Localizar la solicitud con estado "Pendiente"
2. Hacer clic en el botón "Aprobar"
3. Se abre un modal con los siguientes campos:
   - **Fecha de préstamo**: Se completa automáticamente con la fecha actual
   - **Fecha de devolución**: Seleccionar usando el calendario (debe ser posterior a la fecha de préstamo)
   - **Notas** (opcional): Instrucciones o recordatorios para el trabajador
4. Hacer clic en "Aprobar"

**Figura 9: Solicitud Aprobada - Cambio de Estado**
*[CAPTURA: Tabla de solicitudes después de aprobar, notificación de éxito, solicitud con badge verde "Activo"]*

**¿Qué sucede al aprobar?**
- La solicitud cambia al estado "Activo"
- El equipo cambia automáticamente al estado "Prestado"
- El trabajador puede ver el equipo en su sección "Mis Equipos"
- Se registra la operación en la auditoría del sistema

##### Rechazar Solicitud

**Figura 10: Modal de Rechazo con Motivo**
*[CAPTURA: Modal con campo de texto "Motivo del rechazo" obligatorio]*

Para rechazar una solicitud:

1. Localizar la solicitud con estado "Pendiente"
2. Hacer clic en el botón "Rechazar"
3. Se abre un modal solicitando el motivo del rechazo
4. **Importante**: El campo de motivo es obligatorio. Explicar claramente por qué se rechaza la solicitud (ej: "El equipo está programado para mantenimiento", "El equipo ya está asignado a otro proyecto prioritario")
5. Hacer clic en "Rechazar"

El trabajador podrá ver este motivo al consultar su solicitud, por lo que debe ser claro y profesional.

##### Ver Detalles de Solicitud

**Figura 11: Vista Detallada de una Solicitud**
*[CAPTURA: Panel con toda la información de la solicitud: equipo, trabajador, motivo, fechas, estado, notas]*

Para ver los detalles completos de una solicitud:

1. En la tabla de solicitudes, hacer clic en "Ver" o en el nombre de la solicitud
2. Se muestra un panel con toda la información:
   - Datos del equipo solicitado (nombre, descripción, estado)
   - Información del trabajador solicitante
   - Motivo de la solicitud
   - Fecha de solicitud
   - Fechas de préstamo y devolución (si fue aprobada)
   - Estado actual
   - Notas del administrador
   - Motivo de rechazo (si aplica)

#### 8.3.4 Gestión de Usuarios

##### Listado de Usuarios

**Figura 12: Tabla de Usuarios con Roles**
*[CAPTURA: Página "Usuarios" con lista de usuarios, badges de roles (Admin=azul, Trabajador=verde, Mantenimiento=amarillo), email, acciones]*

Para acceder a la gestión de usuarios:

1. Hacer clic en "Usuarios" en el menú lateral
2. Se muestra una tabla con todos los usuarios del sistema

**Información visible:**
- Nombre completo
- Email (usado para login)
- Rol (identificado con badge de color)
- Acciones disponibles (editar, eliminar)

##### Asignar Equipo Directamente a Usuario

**Figura 13: Modal de Asignación Directa de Equipo**
*[CAPTURA: Modal con selector de usuario, campo fecha de devolución, campo notas]*

El administrador puede asignar equipos directamente sin que el trabajador haga una solicitud previa:

1. Ir a la página de "Equipos"
2. Localizar un equipo con estado "Disponible"
3. Hacer clic en el botón "Asignar"
4. Se abre un modal con:
   - **Selector de usuario**: Lista desplegable con todos los trabajadores
   - **Fecha de devolución**: Seleccionar usando el calendario
   - **Notas** (opcional): Instrucciones o detalles adicionales
5. Hacer clic en "Asignar"

**¿Qué sucede?**
- Se crea automáticamente un préstamo (sin solicitud previa)
- El equipo pasa al estado "Prestado"
- El trabajador ve el equipo en su sección "Mis Equipos"
- Se registra la operación en auditoría

##### Crear Nuevo Usuario

**Figura 14: Formulario de Creación de Usuario**
*[CAPTURA: Modal de crear usuario con campos: Nombre, Email, Contraseña, Confirmar contraseña, Rol]*

Para crear un nuevo usuario:

1. En la página de Usuarios, hacer clic en "Nuevo Usuario"
2. Completar los siguientes campos:
   - **Nombre**: Nombre completo del usuario
   - **Email**: Dirección de correo electrónico (será el nombre de usuario para login)
   - **Contraseña**: Debe cumplir con los requisitos de seguridad (mínimo 8 caracteres)
   - **Confirmar contraseña**: Debe coincidir con la contraseña ingresada
   - **Rol**: Seleccionar Administrador, Trabajador o Mantenimiento
3. Hacer clic en "Crear"

**Figura 15: Usuario Creado Exitosamente**
*[CAPTURA: Tabla de usuarios después de crear, notificación de éxito, nuevo usuario en la tabla]*

El sistema confirma la creación y el usuario aparece en la tabla. Se recomienda comunicar las credenciales al usuario de forma segura.

##### Editar Usuario

**Figura 16: Edición de Usuario Existente**
*[CAPTURA: Modal de editar usuario con formulario y datos pre-cargados, nota visible de que contraseña es opcional]*

Para modificar un usuario existente:

1. En la tabla de usuarios, hacer clic en "Editar"
2. Se abre un formulario con los datos actuales del usuario
3. Modificar los campos necesarios
4. **Importante**: El campo de contraseña es opcional. Solo completarlo si se desea cambiar la contraseña del usuario
5. Hacer clic en "Guardar"

**Precauciones:**
- Cambiar el rol de un usuario afecta sus permisos inmediatamente
- Si se modifica el email, el usuario deberá usar el nuevo email para iniciar sesión

#### 8.3.5 Gestión de Mantenimiento (Vista Administrador)

**Figura 17: Solicitudes de Mantenimiento - Vista Administrador**
*[CAPTURA: Página "Mantenimiento" con tabla de todas las solicitudes: Equipo, Reportado por, Descripción, Técnico, Estado, Resultado]*

El administrador puede visualizar todas las solicitudes de mantenimiento del sistema:

1. Hacer clic en "Mantenimiento" en el menú lateral
2. Se muestra una tabla con todas las solicitudes

**Información visible:**
- Equipo en mantenimiento
- Trabajador que reportó el problema
- Descripción detallada del problema
- Técnico asignado (si aplica)
- Estado: Pendiente, En proceso, Completado, Rechazado
- Resultado: Reparado, Dado de baja, o vacío si aún no está completado

Esta vista es de solo lectura para el administrador. La gestión activa la realiza el personal de mantenimiento.

#### 8.3.6 Configuración del Sistema

**Figura 18: Parámetros Configurables**
*[CAPTURA: Página "Configuración del Sistema" con tabla de parámetros: keys y valores (max_equipments_per_worker: 5, dias_aviso_vencimiento: 7)]*

Para acceder a la configuración:

1. Hacer clic en "Configuración" en el menú lateral
2. Se muestra una tabla con los parámetros configurables del sistema

**Parámetros disponibles:**

- **max_equipments_per_worker**: Cantidad máxima de equipos que un trabajador puede tener asignados simultáneamente (valor por defecto: 5)

- **dias_aviso_vencimiento**: Cantidad de días previos al vencimiento en los que el sistema muestra alertas de vencimiento próximo (valor por defecto: 7)

**Figura 19: Editar Parámetro**
*[CAPTURA: Modal de edición de parámetro con campo para cambiar el valor]*

Para modificar un parámetro:

1. Hacer clic en "Editar" junto al parámetro deseado
2. Se abre un modal con el valor actual
3. Ingresar el nuevo valor
4. Hacer clic en "Guardar"
5. Los cambios se aplican inmediatamente en todo el sistema

---

### 8.4 Manual del Trabajador

Los trabajadores tienen acceso limitado a funcionalidades relacionadas exclusivamente con sus propios préstamos y equipos asignados. No pueden ver información de otros trabajadores ni realizar acciones administrativas.

#### 8.4.1 Dashboard del Trabajador

**Figura 20: Dashboard Personalizado del Trabajador**
*[CAPTURA: Dashboard con widget "Mis Préstamos Activos", estadísticas personales, alertas de vencimiento]*

Al iniciar sesión, el trabajador visualiza un dashboard personalizado con:

- **Widget "Mis Préstamos Activos"**: Lista de equipos actualmente asignados al trabajador con fechas de devolución

- **Mis Estadísticas**: Números personales como total de préstamos realizados, préstamos activos actuales, solicitudes pendientes

- **Alertas de Vencimiento**: Si algún equipo asignado está próximo a su fecha de devolución (según el parámetro configurado por el administrador), se muestra una alerta visual

#### 8.4.2 Solicitar un Préstamo

**Figura 21: Formulario de Solicitud de Préstamo**
*[CAPTURA: Modal con selector de equipo (lista desplegable), campo motivo]*

Para solicitar un equipo en préstamo:

1. Hacer clic en "Solicitar Préstamo" en el menú o botón principal
2. Se abre un formulario con dos campos:
   - **Equipo**: Lista desplegable que muestra solo los equipos con estado "Disponible"
   - **Motivo**: Campo de texto obligatorio donde se debe explicar claramente para qué necesita el equipo
3. Completar ambos campos
4. Hacer clic en "Enviar Solicitud"

**Ejemplo de motivo bien redactado:**
"Necesito la laptop Dell XPS para realizar presentación con cliente externo el día viernes 22/11. Presentación de propuesta comercial que requiere software de diseño."

**Figura 22: Solicitud Creada Exitosamente**
*[CAPTURA: Notificación de éxito después de crear solicitud]*

El sistema confirma que la solicitud fue creada. Ahora debe esperar a que un administrador la apruebe o rechace. El trabajador recibirá el equipo solo después de la aprobación.

#### 8.4.3 Mis Solicitudes

**Figura 23: Historial de Solicitudes del Trabajador**
*[CAPTURA: Página "Mis Solicitudes" con tabla de SOLO las solicitudes del usuario logueado, badges de diferentes estados]*

Para consultar todas sus solicitudes:

1. Hacer clic en "Mis Solicitudes" en el menú lateral
2. Se muestra una tabla con todas las solicitudes realizadas por el trabajador (solo las propias, no de otros usuarios)

**Estados posibles:**

- **Pendiente** (badge amarillo): La solicitud está esperando aprobación del administrador
- **Activo** (badge verde): La solicitud fue aprobada y el equipo está asignado al trabajador
- **Rechazado** (badge rojo): La solicitud fue rechazada por el administrador
- **Devuelto** (badge gris): El préstamo finalizó y el equipo fue devuelto

**Acciones disponibles:**

- **Cancelar**: Solo disponible para solicitudes pendientes. Permite cancelar una solicitud antes de que sea evaluada
- **Ver Detalles**: Muestra información completa de la solicitud

**Figura 24: Ver Motivo de Rechazo**
*[CAPTURA: Detalle de solicitud rechazada con motivo visible explicando por qué se rechazó]*

Si una solicitud fue rechazada, al hacer clic en "Ver Detalles" se muestra el motivo proporcionado por el administrador. Esto permite al trabajador comprender por qué no se aprobó su solicitud y, si corresponde, realizar una nueva solicitud en el futuro considerando ese motivo.

#### 8.4.4 Mis Equipos

**Figura 25: Equipos Actualmente Asignados**
*[CAPTURA: Página "Mis Equipos" con tabla de equipos asignados, fechas de préstamo y devolución, alertas de vencimiento]*

Para ver los equipos actualmente asignados:

1. Hacer clic en "Mis Equipos" en el menú lateral
2. Se muestra una tabla con todos los equipos que el trabajador tiene en su poder

**Información mostrada:**
- Nombre del equipo
- Descripción
- Fecha de préstamo (cuándo se le asignó)
- Fecha de devolución estimada
- **Alerta de vencimiento**: Si faltan 7 días o menos para la fecha de devolución, se muestra un badge de advertencia "Vence en X días"

**Acciones disponibles:**
- **Reportar Problema**: Permite notificar problemas técnicos o daños en el equipo
- **Ver Detalles**: Muestra información completa del préstamo

**Importante:** Cuando un equipo muestra alerta de vencimiento próximo, el trabajador debe planificar su devolución o contactar al administrador para solicitar una extensión si aún necesita el equipo.

#### 8.4.5 Reportar Problema

**Figura 26: Modal de Reporte de Problema**
*[CAPTURA: Modal con campo de descripción del problema (obligatorio)]*

Si un equipo asignado presenta fallas o daños:

1. En "Mis Equipos", localizar el equipo con problemas
2. Hacer clic en el botón "Reportar Problema"
3. Se abre un modal con un campo de descripción
4. **Importante**: Describir el problema de forma detallada y técnica. Incluir:
   - Síntomas específicos
   - Cuándo comenzó el problema
   - Si el equipo es aún utilizable o no
   - Cualquier circunstancia relevante (caída, derrame de líquido, etc.)
5. Hacer clic en "Reportar"

**Ejemplo de descripción detallada:**
"La pantalla de la laptop parpadea constantemente. Se observa una línea vertical azul en el lado derecho que empeora al mover el equipo. El problema comenzó hace 2 días. El equipo es aún utilizable pero la línea es molesta para trabajar."

**Figura 27: Problema Reportado - Equipo en Mantenimiento**
*[CAPTURA: Notificación de éxito, equipo desapareciendo de "Mis Equipos"]*

**¿Qué sucede al reportar un problema?**
- El sistema crea automáticamente una solicitud de mantenimiento
- El equipo cambia al estado "Mantenimiento"
- El equipo desaparece de "Mis Equipos" del trabajador
- Si el trabajador tenía un préstamo activo de ese equipo, el préstamo se marca como devuelto automáticamente
- El personal de mantenimiento recibe la solicitud y se encargará de evaluar y reparar el equipo
- El trabajador no necesita realizar ninguna acción adicional

---

### 8.5 Manual del Personal de Mantenimiento

El personal de mantenimiento es responsable de gestionar las reparaciones de equipos, actualizar su estado y decidir si un equipo debe ser reparado o dado de baja permanentemente.

#### 8.5.1 Dashboard de Mantenimiento

**Figura 28: Dashboard con Solicitudes Pendientes**
*[CAPTURA: Dashboard con widget de solicitudes pendientes, badge en menú con cantidad]*

Al iniciar sesión, el personal de mantenimiento visualiza:

- **Widget "Solicitudes Pendientes"**: Lista de equipos reportados esperando ser atendidos
- **Badge en el menú**: Número de solicitudes pendientes de atención
- **Estadísticas**: Total de solicitudes completadas, en proceso, pendientes

#### 8.5.2 Gestión de Solicitudes de Mantenimiento

**Figura 29: Listado de Solicitudes de Mantenimiento**
*[CAPTURA: Tabla completa con equipos reportados, descripción de problemas, estados, filtros]*

Para acceder a las solicitudes:

1. Hacer clic en "Solicitudes de Mantenimiento" en el menú lateral
2. Se muestra una tabla con todas las solicitudes de reparación

**Información visible:**
- Equipo en mantenimiento
- Trabajador que reportó el problema
- Descripción detallada del problema
- Estado: Pendiente, En proceso, Completado, Rechazado
- Técnico asignado (si ya fue asignado)
- Resultado: Reparado, Dado de baja (si ya está completado)

**Filtros disponibles:**
- Por estado (pendiente, en proceso, completado, rechazado)
- Por equipo
- Por técnico asignado

**Acciones disponibles:**
- **Asignarme**: El técnico se asigna la solicitud a sí mismo
- **Cambiar a En Proceso**: Marca que se comenzó a trabajar en la reparación
- **Completar Mantenimiento**: Finaliza la solicitud indicando el resultado
- **Rechazar**: Si el problema no requiere mantenimiento real

**Flujo típico de trabajo:**

1. Técnico ve solicitudes pendientes
2. Se asigna una solicitud haciendo clic en "Asignarme"
3. Cambia el estado a "En Proceso" cuando comienza a trabajar
4. Realiza la reparación física del equipo
5. Completa la solicitud indicando la solución aplicada y el resultado

#### 8.5.3 Completar Mantenimiento

**Figura 30: Modal de Completar Mantenimiento**
*[CAPTURA: Modal con campo "Solución aplicada", selector "Resultado" (Reparado/Dado de Baja)]*

Para completar una solicitud de mantenimiento:

1. En la tabla de solicitudes, localizar una solicitud "En Proceso"
2. Hacer clic en "Completar"
3. Se abre un modal con dos campos:

**Campos del formulario:**

- **Solución aplicada** (obligatorio): Descripción técnica detallada de las acciones realizadas. Debe incluir:
  - Diagnóstico del problema
  - Repuestos o componentes reemplazados (con modelos si es posible)
  - Pruebas realizadas
  - Tiempo estimado de prueba
  - Estado final del equipo

- **Resultado** (obligatorio): Seleccionar una de dos opciones:
  - **Reparado**: El equipo fue reparado exitosamente y puede volver a usarse
  - **Dado de Baja**: El equipo no puede ser reparado o el costo de reparación no justifica mantenerlo

**Ejemplo de "Solución aplicada" para Reparado:**
"Reemplazo de pantalla LCD modelo LP156WF6-SPB1. Cable flex reinstalado correctamente. Testeo realizado durante 30 minutos sin problemas. Equipo funcionando correctamente. Se recomienda manejar con cuidado ya que esta es la segunda pantalla reemplazada."

**Ejemplo de "Solución aplicada" para Dado de Baja:**
"Diagnóstico: Daño irreparable en placa madre, circuitos quemados. Costo estimado de reparación: $800. Valor de reemplazo del equipo completo: $600. El equipo tiene 6 años de antigüedad y múltiples reparaciones previas. Se recomienda dar de baja y adquirir equipo nuevo."

4. Hacer clic en "Completar"

**¿Qué sucede según el resultado?**

**Si se marca como "Reparado":**
- La solicitud de mantenimiento cambia al estado "Completado"
- El equipo vuelve automáticamente al estado "Disponible"
- El equipo puede ser asignado nuevamente a trabajadores
- Se registra la reparación en el historial del equipo

**Si se marca como "Dado de Baja":**
- La solicitud de mantenimiento cambia al estado "Completado"
- El equipo cambia al estado "Baja" permanentemente
- El equipo no puede ser asignado nunca más
- El equipo permanece en el sistema solo como registro histórico
- El administrador debe considerar adquirir un equipo de reemplazo

#### 8.5.4 Rechazar Solicitud de Mantenimiento

En algunos casos, un trabajador puede reportar un "problema" que en realidad no requiere mantenimiento técnico (por ejemplo, el equipo solo necesitaba un reinicio).

Para rechazar una solicitud:

1. En la tabla de solicitudes, hacer clic en "Rechazar"
2. Se abre un modal solicitando el motivo
3. Explicar por qué no requiere mantenimiento
4. Hacer clic en "Rechazar"

**Ejemplo de motivo:**
"Problema resuelto con reinicio simple del sistema operativo. Equipo testado durante 15 minutos, funcionando normalmente. No requiere mantenimiento físico."

**¿Qué sucede?**
- La solicitud cambia al estado "Rechazado"
- El equipo vuelve automáticamente al estado "Disponible"
- El equipo puede ser asignado nuevamente

---

### 8.6 Preguntas Frecuentes

**¿Qué hago si olvido mi contraseña?**
Contactar al administrador del sistema para solicitar un restablecimiento de contraseña.

**¿Puedo solicitar múltiples equipos a la vez?**
Sí, pero cada equipo requiere una solicitud individual. El sistema limita la cantidad de equipos simultáneos según lo configurado por el administrador (por defecto, 5 equipos).

**¿Qué pasa si no devuelvo un equipo en la fecha indicada?**
El sistema mostrará alertas visuales. El administrador puede contactarlo o gestionar manualmente la devolución. Se recomienda comunicarse con el administrador antes del vencimiento si necesita una extensión.

**¿Puedo cancelar una solicitud después de enviarla?**
Sí, siempre que esté en estado "Pendiente". Una vez aprobada, debe contactar al administrador.

**¿Qué hago si daño un equipo accidentalmente?**
Reportar el problema inmediatamente usando la función "Reportar Problema" con una descripción honesta y detallada del incidente.

**Como administrador, ¿puedo aprobar mi propia solicitud?**
Técnicamente sí, pero no es una buena práctica. Se recomienda que otro administrador apruebe solicitudes.

**¿Las auditorías registran todas las acciones?**
Sí, el sistema registra automáticamente todas las operaciones significativas: creación/edición de equipos, aprobaciones, rechazos, asignaciones, reportes de problemas, mantenimientos completados, etc.

---

### 8.7 Glosario de Términos

**Badge**: Indicador visual de color que identifica estados o roles.

**Dashboard**: Pantalla principal que muestra resumen e información relevante al iniciar sesión.

**Equipo**: Cualquier dispositivo tecnológico gestionado por el sistema (laptops, tablets, monitores, periféricos, etc.).

**Estado**: Situación actual de un equipo (Disponible, Prestado, Mantenimiento, Baja).

**Modal**: Ventana emergente sobre la pantalla principal que solicita información o confirmación.

**Préstamo**: Asignación temporal de un equipo a un trabajador.

**Solicitud**: Petición realizada por un trabajador para obtener un equipo en préstamo.

**Widget**: Componente visual del dashboard que muestra información específica.

---

### 8.8 Guía de Capturas de Pantalla

**Para ilustrar este manual con capturas reales del sistema, se requieren 30 capturas organizadas de la siguiente manera:**

#### CAPTURAS GENERALES (1)
- **Figura 1**: Pantalla de login completa

#### CAPTURAS ADMINISTRADOR (18)
- **Figura 2**: Dashboard completo con widgets y estadísticas
- **Figura 3**: Listado de equipos con filtros y badges
- **Figura 4**: Formulario crear equipo vacío
- **Figura 5**: Formulario editar equipo con datos
- **Figura 6**: Historial de préstamos de un equipo
- **Figura 7**: Listado solicitudes con badge de pendientes
- **Figura 8**: Modal aprobar solicitud
- **Figura 9**: Solicitud aprobada (notificación + badge verde)
- **Figura 10**: Modal rechazar solicitud
- **Figura 11**: Vista detallada de una solicitud
- **Figura 12**: Tabla de usuarios con badges de roles
- **Figura 13**: Modal asignar equipo directamente
- **Figura 14**: Formulario crear usuario
- **Figura 15**: Usuario creado (notificación + tabla actualizada)
- **Figura 16**: Formulario editar usuario
- **Figura 17**: Solicitudes de mantenimiento vista admin
- **Figura 18**: Tabla de parámetros configurables
- **Figura 19**: Modal editar parámetro

#### CAPTURAS TRABAJADOR (8)
- **Figura 20**: Dashboard trabajador
- **Figura 21**: Formulario solicitar préstamo
- **Figura 22**: Solicitud creada (notificación)
- **Figura 23**: Mis solicitudes (tabla)
- **Figura 24**: Detalle solicitud rechazada con motivo
- **Figura 25**: Mis equipos asignados
- **Figura 26**: Modal reportar problema
- **Figura 27**: Problema reportado (notificación)

#### CAPTURAS MANTENIMIENTO (3)
- **Figura 28**: Dashboard mantenimiento
- **Figura 29**: Listado solicitudes de mantenimiento
- **Figura 30**: Modal completar mantenimiento

**Usuarios de prueba para capturar:**
- Admin: admin@gestionoficina.com (password: password123)
- Trabajador: carlos@gestionoficina.com (password: password123)
- Mantenimiento: pedro@gestionoficina.com (password: password123)

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
