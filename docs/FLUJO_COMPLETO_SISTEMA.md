# 📋 SISTEMA COMPLETO DE SOLICITUDES Y MANTENIMIENTO

## 🎯 FLUJO COMPLETO IMPLEMENTADO

Este documento explica cómo funciona el sistema de solicitudes de préstamos y mantenimiento implementado en tu proyecto.

---

## 👥 ROLES Y FUNCIONALIDADES

### 1. **TRABAJADOR** (role: 'trabajador')

#### ✅ **Puede ver:**
- **Mis Equipos** (MisEquiposResource)
  - Solo los equipos que tiene asignados actualmente
  - Estadísticas: equipos activos, por vencer, vencidos
  - Estado de cada equipo

- **Mis Solicitudes** (SolicitudPrestamoResource)
  - Sus propias solicitudes de préstamos
  - Estado de cada solicitud (pendiente, rechazado, activo, devuelto)
  - Historial completo de préstamos

#### ✅ **Puede hacer:**
1. **Desde "Mis Equipos":**
   - **Devolver equipo:**
     - Click en equipo → "Devolver Equipo"
     - Confirma la devolución
     - El equipo vuelve a disponible
     - El préstamo cambia a devuelto
   
   - **Reportar problema:**
     - Click en equipo → "Reportar Problema"
     - Describe el problema
     - El equipo se devuelve automáticamente
     - Se crea solicitud de mantenimiento
     - El equipo cambia a mantenimiento

2. **Solicitar un equipo:**
   - Navegar a "Equipos" → Click en equipo disponible → "Solicitar Préstamo"
   - O ir a "Mis Solicitudes" → "Nueva Solicitud"
   - Llena el formulario:
     - Selecciona el equipo (solo muestra disponibles)
     - Escribe el motivo
   - La solicitud queda en estado `pendiente`

3. **Ver estadísticas en tiempo real:**
   - Equipos en mi poder
   - Equipos por vencer (próximos 7 días)
   - Equipos vencidos (pasó fecha de devolución)
   - Total de préstamos históricos

---

### 2. **ADMIN** (role: 'admin')

#### ✅ **Puede ver:**
- **Gestión de Préstamos** (GestionSolicitudesResource)
  - Todas las solicitudes de todos los usuarios
  - Filtrar por estado
  - Ver historial completo

- **Mantenimiento** (MantenimientoResource)
  - Todas las solicitudes de mantenimiento
  - Asignar técnicos
  - Ver estado de reparaciones

#### ✅ **Puede hacer:**
1. **Gestionar solicitudes de préstamos:**
   - **Aprobar:**
     - Click en "Aprobar" en solicitud pendiente
     - Sistema registra fecha/hora automáticamente
     - Define fecha estimada de devolución
     - Agrega notas (opcional)
     - El equipo cambia a `prestado`
     - La solicitud cambia a `activo`
     - Se asigna el equipo al usuario

   - **Rechazar:**
     - Click en "Rechazar"
     - Indica el motivo
     - La solicitud cambia a `rechazado`
     - El equipo NO se asigna

   - **Editar:**
     - Modificar fechas, notas, estado

2. **Asignar equipos directamente (SIN solicitud previa):**
   - Desde la tabla de **Equipos**: Click en "Asignar Equipo"
   - Desde la tabla de **Usuarios**: Click en "Asignar Equipo"
   - Selecciona trabajador/equipo
   - Define fecha estimada de devolución
   - Agrega notas
   - El equipo se asigna inmediatamente como `activo`
   - No requiere solicitud ni aprobación previa

3. **Gestionar mantenimiento:**
   - Asignar técnicos a solicitudes
   - Ver estado de reparaciones
   - Dar de baja equipos irreparables

4. **CRUD completo:**
   - Equipos: crear, editar, eliminar
   - Usuarios: crear, editar, eliminar, asignar roles

---

### 3. **MANTENIMIENTO** (role: 'mantenimiento')

#### ✅ **Puede ver:**
- **Mantenimiento** (MantenimientoResource)
  - Solicitudes de mantenimiento pendientes
  - Solicitudes asignadas a él
  - Historial de reparaciones

#### ✅ **Puede hacer:**
1. **Tomar una solicitud:**
   - Click en "Tomar" en solicitud pendiente
   - La solicitud cambia a `en_proceso`
   - Se auto-asigna como técnico responsable

2. **Reparar equipo:**
   - Click en "Marcar como Reparado"
   - Describe la solución aplicada
   - El equipo vuelve a `disponible`
   - La solicitud cambia a `completado` con resultado `reparado`

3. **Dar de baja equipo:**
   - Click en "Dar de Baja"
   - Explica el motivo (irreparable, obsoleto, etc.)
   - El equipo cambia a `baja`
   - La solicitud cambia a `completado` con resultado `dado_de_baja`

---

## 🔄 FLUJOS COMPLETOS

### **FLUJO 1: Préstamo de Equipo**

```
1. TRABAJADOR solicita equipo
   ↓
2. Solicitud creada (status: pendiente)
   ↓
3. ADMIN revisa solicitud
   ↓
4a. ADMIN APRUEBA                    4b. ADMIN RECHAZA
    - Solicitud → activo                  - Solicitud → rechazado
    - Equipo → prestado                   - Equipo → disponible
    - Se asigna al trabajador             - No se asigna
    ↓
5. TRABAJADOR usa el equipo
   ↓
6. TRABAJADOR devuelve
    - Solicitud → devuelto
    - Equipo → disponible
```

### **FLUJO 2: Mantenimiento de Equipo**

```
1. TRABAJADOR/ADMIN envía equipo a mantenimiento
   ↓
2. Solicitud de mantenimiento creada (status: pendiente)
   Equipo → mantenimiento
   ↓
3. TÉCNICO toma la solicitud
   - Solicitud → en_proceso
   - Se asigna a sí mismo
   ↓
4a. TÉCNICO REPARA                   4b. TÉCNICO DA DE BAJA
    - Solicitud → completado              - Solicitud → completado
    - Resultado → reparado                - Resultado → dado_de_baja
    - Equipo → disponible                 - Equipo → baja
```

---

## 📊 ESTADOS DE LAS TABLAS

### **Tabla: loans**
- `pendiente` → Esperando aprobación del admin
- `rechazado` → Rechazado por el admin
- `activo` → Equipo prestado y en uso
- `devuelto` → Equipo devuelto

### **Tabla: equipment**
- `disponible` → Listo para ser solicitado
- `prestado` → Asignado a un trabajador
- `mantenimiento` → En reparación
- `baja` → Dado de baja (no se puede usar)

### **Tabla: maintenance_requests**
**Status:**
- `pendiente` → Esperando que un técnico la tome
- `en_proceso` → Técnico trabajando en la reparación
- `completado` → Reparación finalizada
- `rechazado` → Solicitud rechazada (opcional)

**Resultado:**
- `pendiente` → Aún sin resultado
- `reparado` → Equipo reparado exitosamente
- `dado_de_baja` → Equipo no reparable

---

## 🗂️ RECURSOS FILAMENT CREADOS

1. **SolicitudPrestamoResource**
   - Navegación: "Mis Solicitudes"
   - Visible para: `trabajador`
   - Funciones: Crear solicitudes, ver historial, devolver equipos

2. **GestionSolicitudesResource**
   - Navegación: "Gestión de Préstamos"
   - Visible para: `admin`
   - Funciones: Aprobar/rechazar solicitudes, gestionar préstamos

3. **MantenimientoResource**
   - Navegación: "Mantenimiento"
   - Visible para: `mantenimiento` y `admin`
   - Funciones: Tomar solicitudes, reparar, dar de baja

4. **EquipmentResource** (actualizado)
   - Navegación: "Equipos"
   - Visible para: todos
   - Acciones añadidas:
     - Solicitar préstamo (trabajadores)
     - Enviar a mantenimiento (trabajadores y admin)

---

## 🚀 PRÓXIMOS PASOS PARA USAR EL SISTEMA

### 1. **Ejecutar las migraciones:**
```bash
php artisan migrate:fresh --seed
```

Esto creará:
- 6 usuarios de prueba (2 admin, 2 trabajadores, 2 mantenimiento)
- 10 equipos de ejemplo

### 2. **Iniciar sesión:**
- Admin: `admin@example.com` / `password`
- Trabajador: `trabajador@example.com` / `password`
- Mantenimiento: `mantenimiento@example.com` / `password`

### 3. **Probar el flujo completo:**

**Como TRABAJADOR:**
1. Login como trabajador
2. Ir a "Mis Solicitudes" → "Nueva Solicitud"
3. Seleccionar equipo, llenar motivo y fecha
4. Crear solicitud

**Como ADMIN:**
1. Login como admin
2. Ir a "Gestión de Préstamos"
3. Ver la solicitud pendiente
4. Click en "Aprobar"
5. Definir fechas y aprobar

**Como TRABAJADOR (devolución):**
1. Ir a "Mis Solicitudes"
2. Ver solicitud activa
3. Click en "Devolver"

**Como TRABAJADOR (mantenimiento):**
1. Ir a "Equipos"
2. Seleccionar un equipo
3. Click en "Enviar a Mantenimiento"
4. Describir el problema

**Como MANTENIMIENTO:**
1. Login como técnico
2. Ir a "Mantenimiento"
3. Ver solicitud pendiente
4. Click en "Tomar"
5. Click en "Marcar como Reparado" o "Dar de Baja"

---

## 🎓 VENTAJAS DE ESTA IMPLEMENTACIÓN

✅ **Separación de responsabilidades:** Cada rol tiene su propia vista
✅ **Trazabilidad completa:** Historial de todas las solicitudes
✅ **Flujo claro:** Estados bien definidos
✅ **Escalable:** Fácil agregar notificaciones, reportes, etc.
✅ **Sin dependencias externas:** Solo usa Filament y Laravel
✅ **Validaciones automáticas:** Filament valida los formularios
✅ **UI profesional:** Interfaz moderna y responsive

---

## 📝 CAMPOS IMPORTANTES

### **Tabla loans:**
- `user_id`: Quién solicita/tiene el equipo
- `equipment_id`: Qué equipo
- `assigned_by`: Qué admin aprobó (nullable)
- `status`: Estado de la solicitud
- `fecha_solicitud`: Cuándo se solicitó
- `fecha_prestamo`: Cuándo se aprobó/entregó
- `fecha_devolucion`: Cuándo debe devolverse
- `motivo`: Por qué lo necesita
- `notas`: Notas del admin

### **Tabla maintenance_requests:**
- `equipment_id`: Qué equipo
- `requested_by`: Quién lo envió a mantenimiento
- `assigned_to`: Qué técnico lo atiende (nullable)
- `status`: Estado (pendiente, en_proceso, completado)
- `resultado`: Qué pasó (reparado, dado_de_baja, pendiente)
- `descripcion_problema`: Qué tiene el equipo
- `solucion`: Qué se hizo
- `fecha_solicitud`: Cuándo se reportó
- `fecha_completado`: Cuándo se terminó

---

¡Ahora tu sistema está completo y funcional! 🎉
