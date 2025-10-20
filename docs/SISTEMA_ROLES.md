# Sistema de Roles - Gestión de Oficina

## 📋 Resumen de Implementación

Se ha implementado un sistema de roles completo con **3 roles**: Admin, Trabajador y Mantenimiento.

---

## 🎯 Roles y Permisos

### 👨‍💼 **Admin**
- ✅ CRUD completo de usuarios
- ✅ CRUD completo de equipos
- ✅ Asignar/prestar equipos a usuarios
- ✅ Ver todos los reportes
- ✅ Gestionar solicitudes de mantenimiento

### 👷 **Trabajador**
- ✅ Ver equipos de otros trabajadores
- ✅ Solicitar préstamo de equipos
- ✅ Devolver equipos prestados
- ✅ Enviar equipos a mantenimiento
- ❌ No puede crear/editar/eliminar equipos
- ❌ No puede gestionar usuarios

### 🔧 **Mantenimiento**
- ✅ Ver solicitudes de reparación
- ✅ Aceptar/rechazar solicitudes de reparación
- ✅ Marcar equipos como reparados
- ✅ Dar de baja equipos irreparables
- ❌ No puede asignar equipos a usuarios
- ❌ No puede gestionar usuarios

---

## 📁 Archivos Creados/Modificados

### **Migraciones Creadas:**
1. `2025_10_20_000001_add_role_to_users_table.php` - Agrega campo role a users
2. `2025_10_20_000002_create_loans_table.php` - Tabla de préstamos
3. `2025_10_20_000003_create_maintenance_requests_table.php` - Tabla de solicitudes de mantenimiento
4. `2025_10_20_000004_update_equipment_table.php` - Actualiza tabla equipment con nuevos campos

### **Modelos Creados:**
1. `app/Models/Loan.php` - Modelo de préstamos
2. `app/Models/MaintenanceRequest.php` - Modelo de solicitudes de mantenimiento

### **Modelos Actualizados:**
1. `app/Models/User.php` - Agregados métodos de roles y relaciones
2. `app/Models/Equipment.php` - Agregados estados y relaciones

### **Seeders Creados:**
1. `database/seeders/RoleSeeder.php` - Crea usuarios de prueba con roles

---

## 🚀 Instrucciones de Instalación

### **1. Ejecutar Migraciones**
```powershell
php artisan migrate
```

### **2. Ejecutar Seeders**
```powershell
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=EquipmentSeeder
```

O ejecutar todo junto:
```powershell
php artisan migrate:fresh --seed
```

---

## 👥 Usuarios de Prueba Creados

| Nombre | Email | Contraseña | Rol |
|--------|-------|------------|-----|
| Administrador Principal | admin@gestionoficina.com | password123 | admin |
| Carlos Trabajador | carlos@gestionoficina.com | password123 | trabajador |
| María Trabajadora | maria@gestionoficina.com | password123 | trabajador |
| Juan Trabajador | juan@gestionoficina.com | password123 | trabajador |
| Pedro Mantenimiento | pedro@gestionoficina.com | password123 | mantenimiento |
| Ana Mantenimiento | ana@gestionoficina.com | password123 | mantenimiento |

---

## 📊 Estructura de Base de Datos

### **Tabla: users**
- `id`
- `name`
- `email`
- `password`
- `role` (enum: admin, trabajador, mantenimiento) ← **NUEVO**
- `email_verified_at`
- `remember_token`
- `timestamps`

### **Tabla: equipment**
- `id`
- `name`
- `codigo` (único) ← **NUEVO**
- `categoria` ← **NUEVO**
- `description`
- `status` (enum: disponible, prestado, mantenimiento, baja) ← **ACTUALIZADO**
- `user_id` (nullable)
- `fecha_prestado` (nullable)
- `fecha_devolucion` (nullable)
- `timestamps`

### **Tabla: loans** ← **NUEVA**
- `id`
- `equipment_id` (FK → equipment)
- `user_id` (FK → users) - Usuario que tiene el equipo
- `assigned_by` (FK → users, nullable) - Admin que asignó
- `status` (enum: activo, devuelto)
- `fecha_prestamo`
- `fecha_devolucion` (nullable)
- `notas` (nullable)
- `timestamps`

### **Tabla: maintenance_requests** ← **NUEVA**
- `id`
- `equipment_id` (FK → equipment)
- `requested_by` (FK → users) - Trabajador que solicitó
- `assigned_to` (FK → users, nullable) - Personal de mantenimiento
- `status` (enum: pendiente, en_proceso, completado, rechazado)
- `descripcion_problema`
- `solucion` (nullable)
- `resultado` (enum: reparado, dado_de_baja, pendiente)
- `fecha_solicitud`
- `fecha_completado` (nullable)
- `timestamps`

---

## 🔍 Métodos Útiles en Modelos

### **User Model:**
```php
$user->isAdmin()           // Verifica si es admin
$user->isTrabajador()      // Verifica si es trabajador
$user->isMantenimiento()   // Verifica si es de mantenimiento
$user->loans()             // Préstamos del usuario
$user->activeLoans()       // Préstamos activos
$user->maintenanceRequests()  // Solicitudes creadas
$user->assignedMaintenanceRequests()  // Solicitudes asignadas
```

### **Equipment Model:**
```php
$equipment->isAvailable()       // ¿Está disponible?
$equipment->isLoaned()          // ¿Está prestado?
$equipment->isInMaintenance()   // ¿Está en mantenimiento?
$equipment->isDecommissioned()  // ¿Está dado de baja?
$equipment->activeLoan()        // Préstamo actual
$equipment->pendingMaintenanceRequest()  // Solicitud pendiente
```

---

## 📝 Próximos Pasos

1. ✅ Migraciones creadas
2. ✅ Modelos creados y actualizados
3. ✅ Seeders creados
4. ⏳ Configurar recursos Filament con políticas de acceso
5. ⏳ Crear panel de gestión de préstamos en Filament
6. ⏳ Crear panel de solicitudes de mantenimiento en Filament
7. ⏳ Implementar validaciones de negocio
8. ⏳ Crear tests

---

## 🐛 Troubleshooting

**Error: Column 'role' already exists**
```powershell
php artisan migrate:rollback
php artisan migrate
```

**Resetear completamente la base de datos**
```powershell
php artisan migrate:fresh --seed
```

---

## 📞 Soporte

Para cualquier duda o problema, revisa la documentación de Laravel o Filament:
- Laravel: https://laravel.com/docs
- Filament: https://filamentphp.com/docs
