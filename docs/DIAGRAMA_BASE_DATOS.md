# Diagrama de Base de Datos - Sistema de Gestión de Oficina

## Esquema Visual para Diagramar (Draw.io, Lucidchart, etc.)

### ENTIDADES Y ATRIBUTOS

```
┌─────────────────────────────────────┐
│              USERS                  │
├─────────────────────────────────────┤
│ PK  id: BIGINT                      │
│     name: VARCHAR(255)              │
│     email: VARCHAR(255) UNIQUE      │
│     email_verified_at: TIMESTAMP    │
│     password: VARCHAR(255)          │
│ FK  role_id: BIGINT                 │
│     remember_token: VARCHAR(100)    │
│     created_at: TIMESTAMP           │
│     updated_at: TIMESTAMP           │
└─────────────────────────────────────┘
           │
           │ 1:N
           ▼
┌─────────────────────────────────────┐
│              ROLES                  │
├─────────────────────────────────────┤
│ PK  id: BIGINT                      │
│     code: VARCHAR(255) UNIQUE       │
│     name: VARCHAR(255)              │
│     created_at: TIMESTAMP           │
│     updated_at: TIMESTAMP           │
└─────────────────────────────────────┘

Valores:
- code: 'admin', 'trabajador', 'mantenimiento'
- name: 'Administrador', 'Trabajador', 'Mantenimiento'


┌─────────────────────────────────────┐
│            EQUIPMENT                │
├─────────────────────────────────────┤
│ PK  id: BIGINT                      │
│     name: VARCHAR(255)              │
│     description: TEXT               │
│     status: ENUM                    │
│ FK  user_id: BIGINT (nullable)      │
│     image: VARCHAR(255)             │
│     created_at: TIMESTAMP           │
│     updated_at: TIMESTAMP           │
└─────────────────────────────────────┘

status: 'disponible' | 'prestado' | 'mantenimiento' | 'baja'


┌─────────────────────────────────────┐
│              LOANS                  │
├─────────────────────────────────────┤
│ PK  id: BIGINT                      │
│ FK  equipment_id: BIGINT            │
│ FK  user_id: BIGINT                 │
│ FK  assigned_by: BIGINT (nullable)  │
│     status: ENUM                    │
│     fecha_solicitud: DATE           │
│     fecha_prestamo: DATETIME        │
│     fecha_devolucion: DATE          │
│     fecha_devolucion_real: DATETIME │
│     motivo: TEXT                    │
│     notas: TEXT                     │
│     created_at: TIMESTAMP           │
│     updated_at: TIMESTAMP           │
└─────────────────────────────────────┘

status: 'pendiente' | 'rechazado' | 'activo' | 'devuelto'


┌─────────────────────────────────────┐
│       MAINTENANCE_REQUESTS          │
├─────────────────────────────────────┤
│ PK  id: BIGINT                      │
│ FK  equipment_id: BIGINT            │
│ FK  requested_by: BIGINT            │
│ FK  assigned_to: BIGINT (nullable)  │
│     status: ENUM                    │
│     descripcion_problema: TEXT      │
│     solucion: TEXT                  │
│     resultado: ENUM                 │
│     fecha_solicitud: TIMESTAMP      │
│     fecha_completado: TIMESTAMP     │
│     created_at: TIMESTAMP           │
│     updated_at: TIMESTAMP           │
└─────────────────────────────────────┘

status: 'pendiente' | 'en_proceso' | 'completado' | 'rechazado'
resultado: 'reparado' | 'dado_de_baja' | 'pendiente'


┌─────────────────────────────────────┐
│           AUDIT_LOGS                │
├─────────────────────────────────────┤
│ PK  id: BIGINT                      │
│     event: VARCHAR(255)             │
│     auditable_type: VARCHAR(255)    │
│     auditable_id: BIGINT            │
│ FK  user_id: BIGINT                 │
│     old_values: JSON                │
│     new_values: JSON                │
│     description: TEXT               │
│     ip_address: VARCHAR(45)         │
│     user_agent: VARCHAR(255)        │
│     created_at: TIMESTAMP           │
│     updated_at: TIMESTAMP           │
└─────────────────────────────────────┘


┌─────────────────────────────────────┐
│        SYSTEM_SETTINGS              │
├─────────────────────────────────────┤
│ PK  id: BIGINT                      │
│     key: VARCHAR(255) UNIQUE        │
│     value: TEXT                     │
│     type: VARCHAR(255)              │
│     description: VARCHAR(255)       │
│     created_at: TIMESTAMP           │
│     updated_at: TIMESTAMP           │
└─────────────────────────────────────┘

type: 'string' | 'integer' | 'boolean' | 'json'
```

---

## RELACIONES (CARDINALIDAD)

### 1. users → roles (N:1)
```
users.role_id → roles.id
- Muchos usuarios pueden tener el mismo rol
- Un usuario tiene UN SOLO rol
- ON DELETE: SET NULL (si se borra rol, user.role_id = NULL)
```

### 2. users → equipment (1:N)
```
equipment.user_id → users.id
- Un usuario puede tener MUCHOS equipos asignados
- Un equipo pertenece a UN SOLO usuario (o ninguno si está disponible)
- ON DELETE: SET NULL (si se borra usuario, equipo queda disponible)
```

### 3. users → loans como solicitante (1:N)
```
loans.user_id → users.id
- Un usuario puede tener MUCHOS préstamos
- Un préstamo pertenece a UN SOLO usuario solicitante
- ON DELETE: CASCADE (si se borra usuario, se borran sus préstamos)
```

### 4. users → loans como aprobador (1:N)
```
loans.assigned_by → users.id
- Un admin puede aprobar MUCHOS préstamos
- Un préstamo fue aprobado por UN SOLO admin (o ninguno si está pendiente)
- ON DELETE: SET NULL (si se borra admin, préstamo conserva registro pero sin referencia)
```

### 5. equipment → loans (1:N)
```
loans.equipment_id → equipment.id
- Un equipo puede tener MUCHOS préstamos (historial)
- Un préstamo está asociado a UN SOLO equipo
- ON DELETE: CASCADE (si se borra equipo, se borran sus préstamos)
```

### 6. equipment → maintenance_requests (1:N)
```
maintenance_requests.equipment_id → equipment.id
- Un equipo puede tener MUCHAS solicitudes de mantenimiento
- Una solicitud pertenece a UN SOLO equipo
- ON DELETE: CASCADE (si se borra equipo, se borran sus mantenimientos)
```

### 7. users → maintenance_requests como reportador (1:N)
```
maintenance_requests.requested_by → users.id
- Un usuario puede reportar MUCHOS problemas
- Una solicitud fue reportada por UN SOLO usuario
- ON DELETE: CASCADE (si se borra usuario, se borran reportes)
```

### 8. users → maintenance_requests como técnico (1:N)
```
maintenance_requests.assigned_to → users.id
- Un técnico puede tener MUCHAS solicitudes asignadas
- Una solicitud está asignada a UN SOLO técnico (o ninguno)
- ON DELETE: SET NULL (si se borra técnico, solicitud queda sin asignar)
```

### 9. users → audit_logs (1:N)
```
audit_logs.user_id → users.id
- Un usuario puede generar MUCHOS logs
- Un log fue generado por UN SOLO usuario
- ON DELETE: CASCADE (si se borra usuario, se borran sus logs - discutible)
```

### 10. Relación Polimórfica: audit_logs → * (N:1)
```
audit_logs.auditable_type + auditable_id → cualquier modelo
- Un log puede referenciar a cualquier modelo (Loan, Equipment, etc.)
- Muchos logs pueden referenciar a la misma entidad
- NO hay foreign key real (es polimórfica)
```

---

## DIAGRAMA VISUAL ASCII

```
                    ┌─────────────┐
                    │    roles    │
                    │─────────────│
                    │ PK id       │
                    │    code     │
                    │    name     │
                    └──────┬──────┘
                           │
                           │ 1:N
                           │
        ┌──────────────────┴──────────────────┐
        │                                     │
        ▼                                     │
┌───────────────┐                             │
│     users     │                             │
│───────────────│                             │
│ PK id         │                             │
│    name       │                             │
│    email      │                             │
│ FK role_id    │◄────────────────────────────┘
└───┬─────┬─────┘
    │     │
    │     │ 1:N (user_id en equipment)
    │     └──────────────────────┐
    │                            │
    │ 1:N (user_id, assigned_by) │
    │                            ▼
    │                    ┌───────────────┐
    │                    │   equipment   │
    │                    │───────────────│
    │                    │ PK id         │
    │                    │    name       │
    │                    │    status     │
    │                    │ FK user_id    │
    │                    └───┬───────┬───┘
    │                        │       │
    │                        │       │ 1:N
    │                        │       │
    ▼                        │       ▼
┌───────────────────┐        │   ┌────────────────────────┐
│      loans        │        │   │  maintenance_requests  │
│───────────────────│        │   │────────────────────────│
│ PK id             │        │   │ PK id                  │
│ FK equipment_id   │◄───────┘   │ FK equipment_id        │
│ FK user_id        │◄───────┐   │ FK requested_by        │
│ FK assigned_by    │◄───┐   │   │ FK assigned_to         │
│    status         │    │   │   │    status              │
│    fecha_prestamo │    │   │   │    resultado           │
│    motivo         │    │   │   └────────────────────────┘
│    notas          │    │   │            ▲
└───────────────────┘    │   │            │
                         │   │            │ FK requested_by, assigned_to
                         │   └────────────┴────────────┐
                         │                             │
                         └─────────────────────────────┘
                         (users)

┌───────────────┐
│  audit_logs   │        Relación Polimórfica
│───────────────│        (auditable_type, auditable_id)
│ PK id         │           │
│    event      │───────────┼──► loans
│ FK user_id    │           ├──► equipment
│    auditable_*│           ├──► maintenance_requests
│    old_values │           └──► users, etc.
│    new_values │
└───────────────┘

┌──────────────────┐
│ system_settings  │        Tabla independiente
│──────────────────│        (configuración global)
│ PK id            │
│    key (UNIQUE)  │
│    value         │
│    type          │
└──────────────────┘
```

---

## ÍNDICES IMPORTANTES

Para optimizar consultas, estos índices están creados:

**Tabla `users`:**
- INDEX `idx_users_role_id` (role_id)
- UNIQUE INDEX `users_email_unique` (email)

**Tabla `equipment`:**
- INDEX `idx_equipment_status` (status)
- INDEX `idx_equipment_user_id` (user_id)

**Tabla `loans`:**
- INDEX `idx_loans_status` (status)
- INDEX `idx_loans_user_id` (user_id)
- INDEX `idx_loans_equipment_id` (equipment_id)
- INDEX `idx_loans_fecha_devolucion` (fecha_devolucion)

**Tabla `maintenance_requests`:**
- INDEX `idx_maintenance_status` (status)
- INDEX `idx_maintenance_equipment_id` (equipment_id)
- INDEX `idx_maintenance_assigned_to` (assigned_to)

**Tabla `audit_logs`:**
- INDEX `idx_audit_auditable` (auditable_type, auditable_id)
- INDEX `idx_audit_event` (event)
- INDEX `idx_audit_user_id` (user_id)
- INDEX `idx_audit_created_at` (created_at)

**Tabla `system_settings`:**
- UNIQUE INDEX `system_settings_key_unique` (key)

---

## REGLAS DE INTEGRIDAD

### Foreign Keys con Acciones en Cascada

| Foreign Key | Tabla Padre | ON DELETE | Justificación |
|-------------|-------------|-----------|---------------|
| users.role_id | roles | SET NULL | Usuario puede existir sin rol temporalmente |
| equipment.user_id | users | SET NULL | Equipo puede quedar disponible |
| loans.equipment_id | equipment | CASCADE | Si se borra equipo, borrar sus préstamos |
| loans.user_id | users | CASCADE | Si se borra usuario, borrar sus préstamos |
| loans.assigned_by | users | SET NULL | Conservar préstamo aunque se borre admin |
| maintenance_requests.equipment_id | equipment | CASCADE | Si se borra equipo, borrar sus mantenimientos |
| maintenance_requests.requested_by | users | CASCADE | Si se borra usuario, borrar sus reportes |
| maintenance_requests.assigned_to | users | SET NULL | Solicitud puede quedar sin asignar |
| audit_logs.user_id | users | CASCADE | Si se borra usuario, borrar sus logs |

### Restricciones de Valores (ENUM)

**equipment.status:**
- `disponible`: Listo para prestar
- `prestado`: Actualmente asignado
- `mantenimiento`: En reparación
- `baja`: Dado de baja permanentemente

**loans.status:**
- `pendiente`: Esperando aprobación
- `rechazado`: Denegado por admin
- `activo`: Préstamo aprobado y activo
- `devuelto`: Equipo ya devuelto

**maintenance_requests.status:**
- `pendiente`: Recién reportado
- `en_proceso`: Técnico trabajando
- `completado`: Reparado o dado de baja
- `rechazado`: No requiere mantenimiento

**maintenance_requests.resultado:**
- `pendiente`: Sin resolver aún
- `reparado`: Equipo funcional de nuevo
- `dado_de_baja`: Equipo irreparable

---

## DATOS DE EJEMPLO

### Roles (3 registros)
```
1 | admin         | Administrador
2 | trabajador    | Trabajador
3 | mantenimiento | Mantenimiento
```

### Users (15 registros)
```
ID | Email                        | Role
1  | admin@gestionoficina.com     | admin
2  | laura@gestionoficina.com     | admin
3  | roberto@gestionoficina.com   | admin
4  | carlos@gestionoficina.com    | trabajador
5  | maria@gestionoficina.com     | trabajador
... (8 trabajadores total)
13 | pedro@gestionoficina.com     | mantenimiento
14 | ana@gestionoficina.com       | mantenimiento
... (4 mantenimiento total)
```

### Equipment (41 registros)
```
ID | Name                    | Status      | User ID
1  | Laptop Dell XPS 15      | disponible  | NULL
2  | MacBook Pro 16"         | prestado    | 4
3  | Proyector Epson EB-X41  | mantenimiento | NULL
4  | Tablet iPad Pro         | baja        | NULL
...
```

### System Settings (2 registros)
```
key                         | value | type
max_equipments_per_worker   | 5     | integer
dias_aviso_vencimiento      | 7     | integer
```

---

## QUERIES DE EJEMPLO

### 1. Equipos disponibles para préstamo
```sql
SELECT * FROM equipment 
WHERE status = 'disponible' 
ORDER BY name;
```

### 2. Préstamos activos de un usuario
```sql
SELECT e.name, l.fecha_prestamo, l.fecha_devolucion 
FROM loans l
JOIN equipment e ON l.equipment_id = e.id
WHERE l.user_id = 4 
  AND l.status = 'activo';
```

### 3. Solicitudes de mantenimiento pendientes
```sql
SELECT 
    mr.id,
    e.name AS equipo,
    u.name AS reportado_por,
    mr.descripcion_problema,
    mr.fecha_solicitud
FROM maintenance_requests mr
JOIN equipment e ON mr.equipment_id = e.id
JOIN users u ON mr.requested_by = u.id
WHERE mr.status = 'pendiente'
ORDER BY mr.fecha_solicitud DESC;
```

### 4. Historial de préstamos de un equipo
```sql
SELECT 
    u.name AS usuario,
    l.status,
    l.fecha_prestamo,
    l.fecha_devolucion_real,
    a.name AS aprobado_por
FROM loans l
JOIN users u ON l.user_id = u.id
LEFT JOIN users a ON l.assigned_by = a.id
WHERE l.equipment_id = 1
ORDER BY l.created_at DESC;
```

### 5. Equipos prestados por más tiempo
```sql
SELECT 
    e.name,
    u.name AS usuario,
    l.fecha_prestamo,
    DATEDIFF(NOW(), l.fecha_prestamo) AS dias_prestado
FROM loans l
JOIN equipment e ON l.equipment_id = e.id
JOIN users u ON l.user_id = u.id
WHERE l.status = 'activo'
ORDER BY dias_prestado DESC;
```

---

## HERRAMIENTAS RECOMENDADAS PARA DIAGRAMAR

### Online (Gratis)
1. **Draw.io** (diagrams.net) - https://app.diagrams.net/
2. **Lucidchart** - https://www.lucidchart.com/
3. **dbdiagram.io** - https://dbdiagram.io/ (especializado en BD)
4. **QuickDBD** - https://www.quickdatabasediagrams.com/

### Desktop
1. **MySQL Workbench** (incluye reverse engineering desde BD)
2. **DBeaver** (puede generar diagramas ER)
3. **dbForge Studio**

### Desde Laravel
```bash
# Generar diagrama desde las migraciones
./vendor/bin/sail composer require beyondcode/laravel-er-diagram-generator --dev
./vendor/bin/sail artisan generate:erd
```

---

**Fecha de creación:** Noviembre 2025  
**Versión del sistema:** 1.0  
**Base de datos:** MySQL 8.0
