# SRS - Especificación de Requisitos de Software

## Sistema de Gestión de Oficina

**Versión:** 1.0  
**Fecha:** 4 de noviembre de 2025  
**Autores:** Yago Colombo, Gaston Heinz, Tomas Mattei  
**Curso:** Gestión de Desarrollo de Software  

---

## Tabla de Contenidos

1. [Introducción](#1-introducción)
2. [Descripción General](#2-descripción-general)
3. [Requisitos Específicos](#3-requisitos-específicos)
4. [Apéndices](#4-apéndices)

---

## 1. Introducción

### 1.1 Propósito

Este documento describe los requisitos del Sistema de Gestión de Oficina, una aplicación web diseñada para gestionar equipos tecnológicos, préstamos a empleados y solicitudes de mantenimiento. El sistema está dirigido a organizaciones que necesitan controlar su inventario de equipos y el flujo de préstamos de manera eficiente.

### 1.2 Alcance

El **Sistema de Gestión de Oficina** es una aplicación web que permite:

- Registrar y gestionar equipos de oficina (computadoras, tablets, impresoras, etc.)
- Controlar préstamos de equipos a trabajadores
- Gestionar solicitudes de mantenimiento y reparaciones
- Administrar usuarios con diferentes roles y permisos
- Generar reportes y estadísticas en tiempo real
- Mantener historial completo de todas las operaciones

**Beneficios esperados:**
- Reducción del 80% en tiempo de búsqueda de equipos
- 100% de trazabilidad de equipos
- Control automatizado de préstamos
- Gestión eficiente de mantenimiento
- Reducción de pérdidas de equipamiento

### 1.3 Definiciones, Acrónimos y Abreviaturas

| Término | Definición |
|---------|------------|
| Admin | Usuario administrador del sistema |
| CRUD | Create, Read, Update, Delete (Crear, Leer, Actualizar, Eliminar) |
| Equipo | Cualquier dispositivo tecnológico gestionado por el sistema |
| Préstamo | Asignación temporal de un equipo a un trabajador |
| Solicitud | Petición de préstamo o mantenimiento |
| Trabajador | Usuario que puede solicitar y usar equipos |
| Técnico | Usuario encargado del mantenimiento de equipos |
| BD | Base de Datos |
| API | Application Programming Interface |
| UI | User Interface (Interfaz de Usuario) |

### 1.4 Referencias

- Laravel 12 Documentation: https://laravel.com/docs/12.x
- Filament 4.0 Documentation: https://filamentphp.com/docs/4.x
- MySQL 8.0 Documentation: https://dev.mysql.com/doc/
- IEEE Std 830-1998: IEEE Recommended Practice for Software Requirements Specifications

### 1.5 Visión General

Este documento está organizado en 7 secciones principales que describen todos los aspectos del sistema, desde requisitos funcionales hasta restricciones técnicas y de diseño.

---

## 2. Descripción General

### 2.1 Perspectiva del Producto

El Sistema de Gestión de Oficina es un sistema independiente que opera como una aplicación web accesible desde cualquier navegador. El sistema se compone de:

- **Frontend:** Interfaz web construida con Filament 4.0, Tailwind CSS y Livewire
- **Backend:** API REST desarrollada en Laravel 12 (PHP 8.2+)
- **Base de Datos:** MySQL 8.0 para almacenamiento persistente
- **Contenedores:** Docker para entorno de desarrollo y despliegue

**Diagrama de Contexto:**

```
┌─────────────┐
│  Navegador  │
└──────┬──────┘
       │ HTTPS
       ▼
┌─────────────────────────────┐
│   Aplicación Web (Filament) │
└──────────┬──────────────────┘
           │
           ▼
┌─────────────────────────────┐
│   Backend Laravel (API)     │
└──────────┬──────────────────┘
           │
           ▼
┌─────────────────────────────┐
│   Base de Datos MySQL       │
└─────────────────────────────┘
```

### 2.2 Funciones del Producto

El sistema proporciona las siguientes funciones principales:

#### 2.2.1 Gestión de Equipos
- Registrar nuevos equipos con código único
- Actualizar información de equipos
- Cambiar estado de equipos
- Dar de baja equipos obsoletos o irreparables
- Consultar historial completo de cada equipo

#### 2.2.2 Gestión de Usuarios
- Crear usuarios con diferentes roles
- Asignar y modificar roles
- Activar/desactivar cuentas
- Gestionar permisos por rol

#### 2.2.3 Gestión de Préstamos
- Solicitar préstamos de equipos
- Aprobar o rechazar solicitudes
- Asignar equipos directamente (sin solicitud previa)
- Registrar devoluciones
- Controlar fechas de préstamo y devolución
- Ver historial de préstamos

#### 2.2.4 Gestión de Mantenimiento
- Reportar problemas en equipos
- Asignar solicitudes a técnicos
- Registrar reparaciones realizadas
- Dar de baja equipos irreparables
- Seguimiento de solicitudes

#### 2.2.5 Reportes y Estadísticas
- Dashboard personalizado por rol
- Estadísticas de equipos disponibles/prestados
- Equipos próximos a vencer
- Solicitudes pendientes
- Historial de operaciones

### 2.3 Características de los Usuarios

#### 2.3.1 Administrador
- **Descripción:** Personal de IT o administración con acceso completo
- **Responsabilidades:** Gestionar usuarios, equipos, aprobar préstamos
- **Nivel técnico:** Alto
- **Frecuencia de uso:** Diaria

#### 2.3.2 Trabajador
- **Descripción:** Empleados que necesitan equipos temporalmente
- **Responsabilidades:** Solicitar equipos, reportar problemas
- **Nivel técnico:** Medio-Bajo
- **Frecuencia de uso:** Ocasional

#### 2.3.3 Técnico de Mantenimiento
- **Descripción:** Personal técnico encargado de reparaciones
- **Responsabilidades:** Atender solicitudes de mantenimiento, reparar equipos
- **Nivel técnico:** Alto
- **Frecuencia de uso:** Diaria

### 2.4 Restricciones

- El sistema debe ser accesible desde navegadores modernos (Chrome, Firefox, Edge)
- Requiere conexión a internet para acceder
- Debe funcionar en contenedores Docker
- Base de datos MySQL 8.0
- Backend en PHP 8.2 o superior
- Cumplir con las políticas de seguridad de la organización

### 2.5 Suposiciones y Dependencias

**Suposiciones:**
- Los usuarios tienen acceso a un navegador web moderno
- Existe conectividad de red estable
- Los usuarios tienen credenciales válidas
- Docker Desktop está instalado y configurado

**Dependencias:**
- Laravel 12 Framework
- Filament 4.0 Admin Panel
- MySQL 8.0 Database
- Docker y Laravel Sail
- Composer para gestión de dependencias PHP
- NPM para gestión de dependencias JavaScript

---

## 3. Requisitos Específicos

### 3.1 Requisitos Funcionales

#### RF-01: Gestión de Usuarios

**RF-01.1:** El sistema debe permitir al administrador crear nuevos usuarios.
- **Entrada:** Nombre, email, contraseña, rol
- **Proceso:** Validar datos, encriptar contraseña, guardar en BD
- **Salida:** Confirmación de creación o mensaje de error

**RF-01.2:** El sistema debe permitir al administrador modificar usuarios existentes.
- **Entrada:** ID de usuario, campos a modificar
- **Proceso:** Validar cambios, actualizar BD
- **Salida:** Confirmación de actualización

**RF-01.3:** El sistema debe permitir al administrador desactivar usuarios.
- **Entrada:** ID de usuario
- **Proceso:** Marcar usuario como inactivo
- **Salida:** Confirmación de desactivación

**RF-01.4:** El sistema debe asignar roles a usuarios (Admin, Trabajador, Mantenimiento).
- **Entrada:** ID de usuario, rol a asignar
- **Proceso:** Actualizar rol en BD
- **Salida:** Confirmación de cambio de rol

#### RF-02: Autenticación y Autorización

**RF-02.1:** El sistema debe autenticar usuarios mediante email y contraseña.
- **Entrada:** Email, contraseña
- **Proceso:** Validar credenciales contra BD
- **Salida:** Token de sesión o mensaje de error

**RF-02.2:** El sistema debe cerrar sesión de usuarios.
- **Entrada:** Token de sesión
- **Proceso:** Invalidar token
- **Salida:** Redirección a login

**RF-02.3:** El sistema debe restringir acceso según rol del usuario.
- **Entrada:** Rol de usuario, recurso solicitado
- **Proceso:** Verificar permisos
- **Salida:** Acceso concedido o denegado

#### RF-03: Gestión de Equipos

**RF-03.1:** El sistema debe permitir al administrador registrar nuevos equipos.
- **Entrada:** Nombre, código único, categoría, descripción
- **Proceso:** Validar código único, guardar en BD
- **Salida:** Confirmación de registro

**RF-03.2:** El sistema debe permitir consultar equipos por estado.
- **Entrada:** Estado (disponible, prestado, mantenimiento, baja)
- **Proceso:** Filtrar equipos en BD
- **Salida:** Lista de equipos filtrados

**RF-03.3:** El sistema debe permitir actualizar información de equipos.
- **Entrada:** ID de equipo, campos a modificar
- **Proceso:** Validar y actualizar BD
- **Salida:** Confirmación de actualización

**RF-03.4:** El sistema debe permitir cambiar el estado de un equipo.
- **Entrada:** ID de equipo, nuevo estado
- **Proceso:** Validar estado, actualizar BD
- **Salida:** Confirmación de cambio

**RF-03.5:** El sistema debe mantener historial de cada equipo.
- **Entrada:** ID de equipo
- **Proceso:** Consultar préstamos y mantenimientos
- **Salida:** Lista histórica de operaciones

#### RF-04: Gestión de Préstamos

**RF-04.1:** El sistema debe permitir a trabajadores solicitar préstamos.
- **Entrada:** ID de equipo, motivo, fecha estimada
- **Proceso:** Validar disponibilidad, crear solicitud
- **Salida:** Confirmación de solicitud creada

**RF-04.2:** El sistema debe permitir al administrador aprobar solicitudes.
- **Entrada:** ID de solicitud, fecha de devolución, notas
- **Proceso:** Cambiar estado a "activo", actualizar equipo a "prestado"
- **Salida:** Confirmación de aprobación

**RF-04.3:** El sistema debe permitir al administrador rechazar solicitudes.
- **Entrada:** ID de solicitud, motivo de rechazo
- **Proceso:** Cambiar estado a "rechazado"
- **Salida:** Confirmación de rechazo

**RF-04.4:** El sistema debe permitir asignación directa de equipos.
- **Entrada:** ID de equipo, ID de usuario, fechas, notas
- **Proceso:** Crear préstamo activo sin solicitud previa
- **Salida:** Confirmación de asignación

**RF-04.5:** El sistema debe permitir devolver equipos.
- **Entrada:** ID de préstamo
- **Proceso:** Marcar como "devuelto", cambiar equipo a "disponible"
- **Salida:** Confirmación de devolución

**RF-04.6:** El sistema debe notificar préstamos próximos a vencer.
- **Entrada:** Fecha actual
- **Proceso:** Buscar préstamos con fecha de devolución en 7 días
- **Salida:** Lista de préstamos próximos a vencer

#### RF-05: Gestión de Mantenimiento

**RF-05.1:** El sistema debe permitir reportar problemas en equipos.
- **Entrada:** ID de equipo, descripción del problema
- **Proceso:** Crear solicitud de mantenimiento, cambiar equipo a "mantenimiento"
- **Salida:** Confirmación de reporte

**RF-05.2:** El sistema debe permitir a técnicos tomar solicitudes.
- **Entrada:** ID de solicitud
- **Proceso:** Asignar técnico, cambiar estado a "en_proceso"
- **Salida:** Confirmación de asignación

**RF-05.3:** El sistema debe permitir registrar reparaciones.
- **Entrada:** ID de solicitud, descripción de solución
- **Proceso:** Cambiar estado a "completado", equipo a "disponible"
- **Salida:** Confirmación de reparación

**RF-05.4:** El sistema debe permitir dar de baja equipos.
- **Entrada:** ID de solicitud, motivo de baja
- **Proceso:** Cambiar estado a "completado", equipo a "baja"
- **Salida:** Confirmación de baja

**RF-05.5:** El sistema debe permitir al administrador asignar técnicos.
- **Entrada:** ID de solicitud, ID de técnico
- **Proceso:** Asignar técnico a solicitud
- **Salida:** Confirmación de asignación

#### RF-06: Reportes y Dashboard

**RF-06.1:** El sistema debe mostrar estadísticas personalizadas por rol.
- **Entrada:** Rol de usuario autenticado
- **Proceso:** Calcular estadísticas relevantes
- **Salida:** Dashboard con widgets personalizados

**RF-06.2:** El sistema debe mostrar equipos disponibles.
- **Entrada:** Ninguna
- **Proceso:** Contar equipos con estado "disponible"
- **Salida:** Número de equipos disponibles

**RF-06.3:** El sistema debe mostrar equipos prestados.
- **Entrada:** Ninguna
- **Proceso:** Contar equipos con estado "prestado"
- **Salida:** Número de equipos prestados

**RF-06.4:** El sistema debe mostrar solicitudes pendientes (Admin).
- **Entrada:** Ninguna
- **Proceso:** Contar solicitudes con estado "pendiente"
- **Salida:** Número de solicitudes pendientes

**RF-06.5:** El sistema debe mostrar mis préstamos activos (Trabajador).
- **Entrada:** ID de usuario autenticado
- **Proceso:** Buscar préstamos activos del usuario
- **Salida:** Lista de préstamos activos

**RF-06.6:** El sistema debe mostrar gráficos de equipos por estado.
- **Entrada:** Ninguna
- **Proceso:** Agrupar equipos por estado
- **Salida:** Gráfico de barras o torta

### 3.2 Requisitos No Funcionales

#### RNF-01: Rendimiento

**RNF-01.1:** El sistema debe responder a solicitudes en menos de 2 segundos.
**RNF-01.2:** El sistema debe soportar al menos 50 usuarios concurrentes.
**RNF-01.3:** La carga de páginas debe completarse en menos de 3 segundos.
**RNF-01.4:** Las consultas a la base de datos deben optimizarse con índices.

#### RNF-02: Seguridad

**RNF-02.1:** Las contraseñas deben almacenarse encriptadas (bcrypt).
**RNF-02.2:** El sistema debe proteger contra ataques CSRF.
**RNF-02.3:** Las sesiones deben expirar después de 2 horas de inactividad.
**RNF-02.4:** El sistema debe validar todas las entradas de usuario.
**RNF-02.5:** Las comunicaciones deben usar HTTPS en producción.

#### RNF-03: Usabilidad

**RNF-03.1:** La interfaz debe ser intuitiva y fácil de usar.
**RNF-03.2:** El sistema debe ser accesible desde dispositivos móviles.
**RNF-03.3:** Los mensajes de error deben ser claros y descriptivos.
**RNF-03.4:** El sistema debe soportar múltiples idiomas (ES, EN).
**RNF-03.5:** La navegación debe requerir máximo 3 clics para cualquier función.

#### RNF-04: Confiabilidad

**RNF-04.1:** El sistema debe tener una disponibilidad del 99%.
**RNF-04.2:** Los datos deben respaldarse diariamente.
**RNF-04.3:** El sistema debe recuperarse de fallos en menos de 5 minutos.
**RNF-04.4:** Las transacciones deben ser atómicas (ACID).

#### RNF-05: Mantenibilidad

**RNF-05.1:** El código debe seguir estándares PSR-12 para PHP.
**RNF-05.2:** El sistema debe estar documentado completamente.
**RNF-05.3:** Las migraciones de BD deben ser reversibles.
**RNF-05.4:** El código debe tener cobertura de tests del 70%.
**RNF-05.5:** El sistema debe usar control de versiones (Git).

#### RNF-06: Portabilidad

**RNF-06.1:** El sistema debe funcionar en contenedores Docker.
**RNF-06.2:** El sistema debe ser independiente del sistema operativo host.
**RNF-06.3:** El sistema debe funcionar en navegadores Chrome, Firefox y Edge.

---

## 4. Apéndices

### 4.1 Modelo de Datos

#### Tabla: users
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | Identificador único |
| name | VARCHAR(255) | Nombre del usuario |
| email | VARCHAR(255) | Email único |
| password | VARCHAR(255) | Contraseña encriptada |
| role_id | BIGINT | Relación con tabla roles |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

#### Tabla: roles
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | Identificador único |
| code | VARCHAR(50) | Código del rol (admin, trabajador, mantenimiento) |
| name | VARCHAR(100) | Nombre del rol |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

#### Tabla: equipment
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | Identificador único |
| name | VARCHAR(255) | Nombre del equipo |
| codigo | VARCHAR(100) | Código único |
| categoria | VARCHAR(100) | Categoría del equipo |
| description | TEXT | Descripción |
| status | ENUM | Estado (disponible, prestado, mantenimiento, baja) |
| user_id | BIGINT | Usuario asignado (nullable) |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

#### Tabla: loans
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | Identificador único |
| equipment_id | BIGINT | Relación con equipo |
| user_id | BIGINT | Usuario solicitante |
| assigned_by | BIGINT | Admin que aprobó |
| status | ENUM | Estado (pendiente, activo, devuelto, rechazado) |
| fecha_solicitud | DATE | Fecha de solicitud |
| fecha_prestamo | DATETIME | Fecha/hora de préstamo |
| fecha_devolucion | DATE | Fecha estimada de devolución |
| fecha_devolucion_real | DATE | Fecha real de devolución |
| motivo | TEXT | Motivo del préstamo |
| notas | TEXT | Notas adicionales |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

#### Tabla: maintenance_requests
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | Identificador único |
| equipment_id | BIGINT | Relación con equipo |
| requested_by | BIGINT | Usuario que reportó |
| assigned_to | BIGINT | Técnico asignado (nullable) |
| status | ENUM | Estado (pendiente, en_proceso, completado, rechazado) |
| descripcion_problema | TEXT | Descripción del problema |
| solucion | TEXT | Solución aplicada |
| resultado | ENUM | Resultado (reparado, dado_de_baja) |
| fecha_solicitud | DATETIME | Fecha/hora de solicitud |
| fecha_completado | DATETIME | Fecha/hora de completado |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

### 4.2 Casos de Uso Detallados

#### CU-01: Login de Usuario

**Actor Principal:** Cualquier usuario  
**Precondiciones:** El usuario tiene credenciales válidas  
**Flujo Principal:**
1. Usuario accede a la página de login
2. Sistema muestra formulario de login
3. Usuario ingresa email y contraseña
4. Usuario hace clic en "Iniciar Sesión"
5. Sistema valida credenciales
6. Sistema crea sesión
7. Sistema redirige al dashboard según rol

**Flujo Alternativo:**
- 5a. Credenciales inválidas: Sistema muestra error

#### CU-02: Solicitar Préstamo de Equipo

**Actor Principal:** Trabajador  
**Precondiciones:** Usuario autenticado como trabajador  
**Flujo Principal:**
1. Usuario navega a "Mis Solicitudes"
2. Usuario hace clic en "Nueva Solicitud"
3. Sistema muestra formulario
4. Usuario selecciona equipo disponible
5. Usuario ingresa motivo (opcional)
6. Usuario envía solicitud
7. Sistema crea solicitud con estado "pendiente"
8. Sistema muestra confirmación

**Flujo Alternativo:**
- 4a. No hay equipos disponibles: Sistema muestra mensaje

#### CU-03: Aprobar Solicitud de Préstamo

**Actor Principal:** Administrador  
**Precondiciones:** Existe solicitud pendiente  
**Flujo Principal:**
1. Admin navega a "Gestión de Préstamos"
2. Admin selecciona solicitud pendiente
3. Admin hace clic en "Aprobar"
4. Sistema muestra formulario de aprobación
5. Admin define fecha de devolución
6. Admin agrega notas (opcional)
7. Admin confirma aprobación
8. Sistema cambia solicitud a "activo"
9. Sistema cambia equipo a "prestado"
10. Sistema registra fecha/hora de préstamo
11. Sistema muestra confirmación

**Flujo Alternativo:**
- 7a. Admin cancela: Sistema vuelve a listado

#### CU-04: Reportar Problema en Equipo

**Actor Principal:** Trabajador  
**Precondiciones:** Trabajador tiene equipo asignado  
**Flujo Principal:**
1. Usuario navega a "Mis Equipos"
2. Usuario selecciona equipo con problema
3. Usuario hace clic en "Reportar Problema"
4. Sistema muestra formulario
5. Usuario describe el problema
6. Usuario confirma reporte
7. Sistema crea solicitud de mantenimiento
8. Sistema cambia equipo a "mantenimiento"
9. Sistema devuelve el equipo automáticamente
10. Sistema muestra confirmación

#### CU-05: Tomar Solicitud de Mantenimiento

**Actor Principal:** Técnico de Mantenimiento  
**Precondiciones:** Existe solicitud pendiente  
**Flujo Principal:**
1. Técnico navega a "Mantenimiento"
2. Técnico visualiza solicitudes pendientes
3. Técnico selecciona una solicitud
4. Técnico hace clic en "Tomar"
5. Sistema asigna al técnico automáticamente
6. Sistema cambia estado a "en_proceso"
7. Sistema muestra confirmación

### 4.3 Glosario de Estados

#### Estados de Equipment
- **disponible:** Equipo listo para ser prestado
- **prestado:** Equipo asignado a un trabajador
- **mantenimiento:** Equipo en reparación
- **baja:** Equipo dado de baja, no disponible

#### Estados de Loans
- **pendiente:** Solicitud esperando aprobación
- **activo:** Equipo prestado y en uso
- **devuelto:** Equipo devuelto
- **rechazado:** Solicitud rechazada por admin

#### Estados de Maintenance_Requests
- **pendiente:** Esperando que técnico la tome
- **en_proceso:** Técnico trabajando en reparación
- **completado:** Reparación finalizada
- **rechazado:** Solicitud rechazada (opcional)

### 4.4 Referencias

- Laravel 12 Documentation: https://laravel.com/docs/12.x
- Filament 4.0 Documentation: https://filamentphp.com/docs/4.x
- MySQL 8.0 Documentation: https://dev.mysql.com/doc/
- IEEE Std 830-1998: IEEE Recommended Practice for Software Requirements Specifications

### 4.5 Matriz de Trazabilidad de Requisitos

Esta matriz establece la relación entre los requisitos especificados y su implementación en el sistema.

#### Requisitos Funcionales

| ID | Requisito | Implementación | Archivo/Componente | Estado |
|----|-----------|----------------|-------------------|--------|
| RF-01 | Autenticación de usuarios | Laravel Authentication + Filament | `config/auth.php`, Filament Auth | ✅ Implementado |
| RF-02 | Gestión de roles y permisos | Sistema de Roles + Políticas | `app/Models/Role.php`, `app/Policies/*` | ✅ Implementado |
| RF-03 | CRUD de equipos | Filament Resource | `app/Filament/Resources/EquipmentResource.php` | ✅ Implementado |
| RF-04 | Control de estados de equipos | Modelo + Migraciones | `app/Models/Equipment.php`, `database/migrations/*equipment*` | ✅ Implementado |
| RF-05 | Solicitud de préstamo (Trabajador) | Filament Resource | `app/Filament/Resources/SolicitudPrestamoResource.php` | ✅ Implementado |
| RF-06 | Aprobación de préstamos (Admin) | Filament Resource + Actions | `app/Filament/Resources/GestionSolicitudesResource.php` | ✅ Implementado |
| RF-07 | Devolución de equipos | Lógica en Resource + Actions | `app/Filament/Resources/MisEquiposResource.php` | ✅ Implementado |
| RF-08 | Reporte de problemas | Formulario + Modelo | `MaintenanceRequest` model + Resource | ✅ Implementado |
| RF-09 | Gestión de mantenimiento | Filament Resource | `app/Filament/Resources/MantenimientoResource.php` | ✅ Implementado |
| RF-10 | Reparación de equipos | Estados + Workflow | `MaintenanceRequest` + Actions | ✅ Implementado |
| RF-11 | Baja de equipos | Estado + Transición | Equipment model status transition | ✅ Implementado |
| RF-12 | Historial de préstamos | Relaciones + Timestamps | `loans` table con timestamps | ✅ Implementado |
| RF-13 | Dashboard personalizado por rol | Widgets condicionales | `app/Filament/Widgets/*` | ✅ Implementado |
| RF-14 | Estadísticas en tiempo real | Widgets con queries | `StatsOverview`, `EquipmentChart`, etc. | ✅ Implementado |
| RF-15 | Búsqueda y filtrado | Filament Tables | Todos los Resources con `searchable()` | ✅ Implementado |
| RF-16 | Gestión de usuarios (Admin) | Filament Resource | `app/Filament/Resources/Users/UserResource.php` | ✅ Implementado |
| RF-17 | Asignación de técnicos | Select + Validación | `MantenimientoResource` con filtros | ✅ Implementado |
| RF-18 | Notificaciones de estado | Filament Notifications | Notifications en Actions | ✅ Implementado |

#### Requisitos No Funcionales

| ID | Requisito | Implementación | Validación | Estado |
|----|-----------|----------------|-----------|--------|
| RNF-01 | Seguridad - Autenticación | Laravel Sanctum + Sessions | Login funcional | ✅ Implementado |
| RNF-02 | Seguridad - Autorización | Políticas Laravel | `app/Policies/*` | ✅ Implementado |
| RNF-03 | Seguridad - Encriptación | Bcrypt passwords | `User` model | ✅ Implementado |
| RNF-04 | Usabilidad - Interfaz intuitiva | Filament UI/UX | Interface Filament | ✅ Implementado |
| RNF-05 | Usabilidad - Responsive | Tailwind CSS | Layout responsivo | ✅ Implementado |
| RNF-06 | Compatibilidad - Navegadores | HTML5 + CSS3 moderno | Chrome, Firefox, Edge | ✅ Implementado |
| RNF-07 | Rendimiento - Queries optimizadas | Eloquent + Índices | `database/migrations/*` | ✅ Implementado |
| RNF-08 | Rendimiento - Caché | Laravel Cache | `config/cache.php` | ✅ Implementado |
| RNF-09 | Mantenibilidad - Código limpio | PSR-12 | Código organizado | ✅ Implementado |
| RNF-10 | Mantenibilidad - Documentación | Markdown docs | `docs/*` | ✅ Implementado |
| RNF-11 | Portabilidad - Docker | Docker Compose + Sail | `docker-compose.yml` | ✅ Implementado |
| RNF-12 | Escalabilidad - Arquitectura | MVC + Resources | Estructura Laravel | ✅ Implementado |

#### Cobertura de Requisitos

| Categoría | Total | Implementados | Porcentaje |
|-----------|-------|---------------|------------|
| Requisitos Funcionales | 18 | 18 | 100% |
| Requisitos No Funcionales | 12 | 12 | 100% |
| **TOTAL** | **30** | **30** | **100%** |

---
