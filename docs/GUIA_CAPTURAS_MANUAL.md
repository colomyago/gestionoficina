# Guía para Capturas de Pantalla - Manual de Usuario TFI

## Objetivo
Este documento te guía paso a paso para capturar todas las pantallas necesarias para tu manual de usuario del TFI.

---

## PREPARACIÓN

### 1. Acceso al Sistema
**URL Producción:** https://gestionoficina-production.up.railway.app/admin

**Usuarios de prueba:**
- **Admin:** admin@gestionoficina.com / password123
- **Trabajador:** carlos@gestionoficina.com / password123
- **Mantenimiento:** pedro@gestionoficina.com / password123

### 2. Herramientas de Captura
- **Windows:** Windows + Shift + S (Recortes)
- **Alternativa:** Snipping Tool, Lightshot, ShareX
- **Navegador:** F12 → Responsive Design Mode (para simular móvil si lo deseas)

### 3. Recomendaciones
- ✅ Pantalla completa maximizada (1920x1080 recomendado)
- ✅ Ocultar información personal si es necesario
- ✅ Asegúrate que haya datos visibles en las tablas
- ✅ Nombra los archivos de forma clara: `01_login.png`, `02_dashboard_admin.png`, etc.
- ✅ Usa anotaciones (flechas, círculos) para resaltar elementos importantes

---

## SECCIÓN 1: INICIO DE SESIÓN Y NAVEGACIÓN

### Captura 1.1: Pantalla de Login
**Pasos:**
1. Ir a URL en modo incógnito (para ver pantalla de login limpia)
2. Capturar pantalla de login ANTES de ingresar credenciales

**Elementos visibles:**
- Logo del sistema
- Formulario de login (email, password)
- Botón "Iniciar Sesión"

**Archivo sugerido:** `01_login.png`

---

### Captura 1.2: Dashboard - Vista General
**Pasos:**
1. Loguear como Admin (admin@gestionoficina.com)
2. Capturar dashboard completo con widgets visibles

**Elementos visibles:**
- Sidebar con menú de navegación
- Widgets de estadísticas (StatsOverview)
- Gráficos (EquipmentChart)
- Tabla de préstamos recientes

**Archivo sugerido:** `02_dashboard_admin.png`

---

## SECCIÓN 2: ROL ADMINISTRADOR

### Captura 2.1: Gestión de Equipos - Listado
**Pasos:**
1. Clic en "Equipos" en el sidebar
2. Asegúrate que haya varios equipos visibles
3. Capturar tabla con filtros visibles

**Elementos visibles:**
- Tabla con equipos (nombre, estado, usuario asignado)
- Filtros (por estado)
- Buscador
- Botón "Nuevo Equipo"
- Badges de estado (disponible, prestado, mantenimiento)

**Archivo sugerido:** `03_equipos_listado.png`

**Anotación recomendada:** Resaltar los filtros y badges de estado

---

### Captura 2.2: Crear Nuevo Equipo
**Pasos:**
1. Clic en "Nuevo Equipo"
2. Capturar formulario VACÍO (antes de llenar)

**Elementos visibles:**
- Campo "Nombre del equipo"
- Campo "Descripción"
- Selector de estado
- Upload de imagen
- Botones "Guardar" y "Cancelar"

**Archivo sugerido:** `04_equipos_crear_formulario.png`

---

### Captura 2.3: Editar Equipo
**Pasos:**
1. Clic en el icono de editar (lápiz) de un equipo
2. Capturar formulario CON datos

**Elementos visibles:**
- Formulario pre-llenado con datos del equipo
- Imagen cargada (si tiene)
- Botones de acción

**Archivo sugerido:** `05_equipos_editar.png`

---

### Captura 2.4: Acciones en Tabla de Equipos
**Pasos:**
1. En listado de equipos, hacer clic en el menú de 3 puntos de un equipo
2. Capturar menú desplegado con acciones

**Elementos visibles:**
- Ver
- Editar
- Asignar a Trabajador
- Liberar Equipo
- Ver Historial de Préstamos
- Ver Historial de Mantenimiento

**Archivo sugerido:** `06_equipos_acciones.png`

**Anotación:** Resaltar las acciones más importantes

---

### Captura 2.5: Asignar Equipo Directamente
**Pasos:**
1. En acciones de un equipo disponible, clic en "Asignar a Trabajador"
2. Capturar modal de asignación

**Elementos visibles:**
- Selector de usuario (trabajadores)
- Fecha de devolución estimada
- Campo de notas
- Botones "Asignar" y "Cancelar"

**Archivo sugerido:** `07_equipos_asignar_directo.png`

---

### Captura 2.6: Gestión de Solicitudes - Listado
**Pasos:**
1. Clic en "Solicitudes" en sidebar
2. Asegúrate de tener solicitudes con diferentes estados

**Elementos visibles:**
- Tabla con solicitudes
- Badge numérico en el menú (solicitudes pendientes)
- Columnas: Equipo, Usuario, Estado, Fecha, Acciones
- Filtros por estado
- Estados con colores (pendiente=amarillo, activo=verde, rechazado=rojo)

**Archivo sugerido:** `08_solicitudes_listado.png`

**Anotación:** Resaltar el badge de notificaciones

---

### Captura 2.7: Aprobar Solicitud
**Pasos:**
1. En tabla de solicitudes, clic en "Aprobar" de una solicitud pendiente
2. Capturar modal de aprobación

**Elementos visibles:**
- Información del equipo y usuario
- Fecha de préstamo (auto-rellenada con hoy)
- Fecha de devolución estimada
- Campo de notas (opcional)
- Botones "Aprobar" y "Cancelar"

**Archivo sugerido:** `09_solicitudes_aprobar.png`

---

### Captura 2.8: Rechazar Solicitud
**Pasos:**
1. En tabla de solicitudes, clic en "Rechazar" de una solicitud pendiente
2. Capturar modal de rechazo

**Elementos visibles:**
- Campo "Motivo del rechazo" (requerido)
- Botones "Rechazar" y "Cancelar"

**Archivo sugerido:** `10_solicitudes_rechazar.png`

---

### Captura 2.9: Ver Detalles de Solicitud
**Pasos:**
1. Clic en "Ver" en acciones de una solicitud
2. Capturar vista detallada

**Elementos visibles:**
- Información completa del préstamo
- Fechas
- Motivo del trabajador
- Notas del admin
- Estado actual
- Historial de cambios (si aplica)

**Archivo sugerido:** `11_solicitudes_detalle.png`

---

### Captura 2.10: Gestión de Usuarios - Listado
**Pasos:**
1. Clic en "Usuarios" en sidebar
2. Capturar tabla de usuarios

**Elementos visibles:**
- Tabla con usuarios (nombre, email, rol)
- Badges de roles con colores diferentes
- Filtros por rol
- Botón "Nuevo Usuario"

**Archivo sugerido:** `12_usuarios_listado.png`

---

### Captura 2.11: Crear Usuario
**Pasos:**
1. Clic en "Nuevo Usuario"
2. Capturar formulario

**Elementos visibles:**
- Campo "Nombre"
- Campo "Email"
- Campo "Contraseña"
- Selector de "Rol"
- Botón "Guardar"

**Archivo sugerido:** `13_usuarios_crear.png`

---

### Captura 2.12: Gestión de Roles - Listado
**Pasos:**
1. Clic en "Roles" en sidebar
2. Capturar tabla de roles

**Elementos visibles:**
- Tabla con 3 roles (Admin, Trabajador, Mantenimiento)
- Código y nombre de cada rol
- Acciones (solo Ver en esta versión)

**Archivo sugerido:** `14_roles_listado.png`

---

### Captura 2.13: Mantenimiento - Vista Admin
**Pasos:**
1. Clic en "Mantenimiento" en sidebar
2. Capturar tabla de solicitudes

**Elementos visibles:**
- Tabla con solicitudes de mantenimiento
- Badge de pendientes
- Filtros por estado
- Columnas: Equipo, Reportado por, Problema, Estado, Resultado

**Archivo sugerido:** `15_mantenimiento_listado_admin.png`

---

### Captura 2.14: Configuración del Sistema
**Pasos:**
1. Clic en "Configuración" en sidebar
2. Capturar tabla de settings

**Elementos visibles:**
- Configuración "max_equipments_per_worker"
- Configuración "dias_aviso_vencimiento"
- Valores actuales
- Acción para editar

**Archivo sugerido:** `16_configuracion_sistema.png`

---

### Captura 2.15: Editar Configuración
**Pasos:**
1. Clic en editar una configuración
2. Capturar modal

**Elementos visibles:**
- Key (solo lectura)
- Campo Value (editable)
- Descripción
- Botón "Guardar"

**Archivo sugerido:** `17_configuracion_editar.png`

---

## SECCIÓN 3: ROL TRABAJADOR

**IMPORTANTE:** Cerrar sesión de Admin y loguear como carlos@gestionoficina.com

### Captura 3.1: Dashboard Trabajador
**Pasos:**
1. Loguear como carlos@gestionoficina.com
2. Capturar dashboard completo

**Elementos visibles:**
- Sidebar con menú limitado (Mis Solicitudes, Mis Equipos)
- Widget "Mis Préstamos Activos"
- Widget "Mis Estadísticas"
- Sin acceso a gestión de usuarios/equipos

**Archivo sugerido:** `18_dashboard_trabajador.png`

---

### Captura 3.2: Solicitar Préstamo - Formulario
**Pasos:**
1. Clic en "Solicitar Préstamo" en sidebar
2. O clic en botón "Nueva Solicitud"
3. Capturar formulario

**Elementos visibles:**
- Selector de equipo (solo disponibles)
- Campo "Motivo" (¿Para qué necesitas el equipo?)
- Botón "Solicitar"

**Archivo sugerido:** `19_trabajador_solicitar_prestamo.png`

---

### Captura 3.3: Mis Solicitudes - Listado
**Pasos:**
1. Clic en "Mis Solicitudes" en sidebar
2. Capturar tabla

**Elementos visibles:**
- Tabla con SOLO solicitudes del trabajador logueado
- Estados: pendiente, activo, rechazado, devuelto
- Fecha de solicitud
- Equipo solicitado
- Acción "Cancelar" solo en pendientes

**Archivo sugerido:** `20_trabajador_mis_solicitudes.png`

---

### Captura 3.4: Ver Solicitud Rechazada
**Pasos:**
1. En tabla, clic en "Ver" de una solicitud rechazada
2. Capturar detalle

**Elementos visibles:**
- Estado "Rechazado" con badge rojo
- **Motivo del rechazo** visible
- Información del equipo
- Fecha de solicitud

**Archivo sugerido:** `21_trabajador_solicitud_rechazada.png`

**Anotación:** Resaltar el motivo del rechazo

---

### Captura 3.5: Mis Equipos - Listado
**Pasos:**
1. Clic en "Mis Equipos" en sidebar
2. Capturar tabla

**Elementos visibles:**
- Equipos que ACTUALMENTE tiene el trabajador
- Fecha de préstamo
- Fecha de devolución estimada
- Alerta si está próximo a vencer (badge amarillo)
- Acción "Reportar Problema"

**Archivo sugerido:** `22_trabajador_mis_equipos.png`

---

### Captura 3.6: Reportar Problema en Equipo
**Pasos:**
1. En tabla "Mis Equipos", clic en "Reportar Problema"
2. Capturar modal

**Elementos visibles:**
- Nombre del equipo (solo lectura)
- Campo "Descripción del problema" (textarea)
- Botones "Reportar" y "Cancelar"

**Archivo sugerido:** `23_trabajador_reportar_problema.png`

---

### Captura 3.7: Alerta de Vencimiento Próximo
**Pasos:**
1. Asegúrate de tener un equipo con fecha de devolución próxima (7 días o menos)
2. Capturar tabla "Mis Equipos" con la alerta visible

**Elementos visibles:**
- Badge amarillo o naranja indicando "Vence en X días"
- O mensaje de alerta

**Archivo sugerido:** `24_trabajador_alerta_vencimiento.png`

**Anotación:** Resaltar el indicador de alerta

---

### Captura 3.8: Widget "Mis Préstamos Activos"
**Pasos:**
1. En dashboard trabajador, hacer scroll si es necesario
2. Capturar widget

**Elementos visibles:**
- Lista de equipos actualmente prestados
- Fechas
- Alertas (si aplica)

**Archivo sugerido:** `25_trabajador_widget_prestamos.png`

---

## SECCIÓN 4: ROL MANTENIMIENTO

**IMPORTANTE:** Cerrar sesión de Trabajador y loguear como pedro@gestionoficina.com

### Captura 4.1: Dashboard Mantenimiento
**Pasos:**
1. Loguear como pedro@gestionoficina.com
2. Capturar dashboard

**Elementos visibles:**
- Sidebar con menú (Mantenimiento, Equipos - solo lectura)
- Widget "Solicitudes Pendientes de Mantenimiento"
- Badge con contador en menú "Mantenimiento"

**Archivo sugerido:** `26_dashboard_mantenimiento.png`

---

### Captura 4.2: Mantenimiento - Listado Completo
**Pasos:**
1. Clic en "Mantenimiento" en sidebar
2. Capturar tabla

**Elementos visibles:**
- Todas las solicitudes de mantenimiento
- Badge de pendientes
- Columnas: Equipo, Reportado por, Problema, Estado, Resultado, Técnico asignado
- Filtros por estado
- Acciones: Ver, Asignarme, Completar, Rechazar

**Archivo sugerido:** `27_mantenimiento_listado.png`

---

### Captura 4.3: Asignarse Solicitud
**Pasos:**
1. En tabla, buscar solicitud pendiente sin asignar
2. Clic en "Asignarme"
3. Capturar confirmación o cambio en tabla

**Elementos visibles:**
- Modal de confirmación (si aplica)
- O captura DESPUÉS de asignar, mostrando nombre del técnico en tabla

**Archivo sugerido:** `28_mantenimiento_asignarse.png`

---

### Captura 4.4: Cambiar Estado a "En Proceso"
**Pasos:**
1. En acciones, clic en acción para cambiar estado
2. Capturar opción

**Elementos visibles:**
- Modal o botón "Cambiar a En Proceso"

**Archivo sugerido:** `29_mantenimiento_en_proceso.png`

---

### Captura 4.5: Completar Mantenimiento - Reparado
**Pasos:**
1. En tabla, clic en "Completar" de una solicitud en proceso
2. Capturar modal

**Elementos visibles:**
- Campo "Solución aplicada" (textarea)
- Radio buttons:
  - ⚪ Reparado (equipo vuelve a disponible)
  - ⚪ Dado de baja (equipo queda fuera de servicio)
- Botones "Completar" y "Cancelar"

**Archivo sugerido:** `30_mantenimiento_completar_reparado.png`

---

### Captura 4.6: Completar Mantenimiento - Dar de Baja
**Pasos:**
1. Igual que anterior, pero seleccionar "Dado de baja"
2. Capturar modal

**Elementos visibles:**
- Opción "Dado de baja" seleccionada
- Campo de solución

**Archivo sugerido:** `31_mantenimiento_completar_baja.png`

---

### Captura 4.7: Ver Detalle de Solicitud de Mantenimiento
**Pasos:**
1. Clic en "Ver" en acciones
2. Capturar vista detallada

**Elementos visibles:**
- Información completa:
  - Equipo
  - Reportado por (trabajador)
  - Descripción del problema
  - Estado actual
  - Técnico asignado
  - Solución (si está completado)
  - Resultado (reparado/baja)
  - Fechas

**Archivo sugerido:** `32_mantenimiento_detalle.png`

---

### Captura 4.8: Rechazar Solicitud de Mantenimiento
**Pasos:**
1. En tabla, clic en "Rechazar"
2. Capturar modal

**Elementos visibles:**
- Campo "Motivo del rechazo"
- Botones "Rechazar" y "Cancelar"

**Archivo sugerido:** `33_mantenimiento_rechazar.png`

---

## SECCIÓN 5: FLUJOS COMPLETOS (OPCIONAL)

Estas capturas son para demostrar flujos de principio a fin:

### Flujo 1: Solicitud → Aprobación → Devolución

1. **Captura:** Trabajador solicita equipo (formulario)
2. **Captura:** Solicitud aparece como "Pendiente" en tabla trabajador
3. **Captura:** Admin ve solicitud con badge de notificación
4. **Captura:** Admin aprueba solicitud
5. **Captura:** Equipo cambia a estado "Prestado" en tabla equipos
6. **Captura:** Trabajador ve equipo en "Mis Equipos"
7. **Captura:** Admin fuerza devolución
8. **Captura:** Equipo vuelve a "Disponible"

### Flujo 2: Reportar Problema → Mantenimiento → Reparación

1. **Captura:** Trabajador reporta problema
2. **Captura:** Solicitud de mantenimiento creada (estado Pendiente)
3. **Captura:** Equipo cambia a "Mantenimiento"
4. **Captura:** Técnico se asigna la solicitud
5. **Captura:** Técnico cambia a "En Proceso"
6. **Captura:** Técnico completa como "Reparado"
7. **Captura:** Equipo vuelve a "Disponible"

---

## SECCIÓN 6: ELEMENTOS DE INTERFAZ

### Captura 6.1: Sidebar Completo (Admin)
**Pasos:**
1. Loguear como admin
2. Capturar sidebar completo

**Elementos visibles:**
- Logo del sistema
- Dashboard
- Equipos
- Usuarios
- Roles
- Solicitudes (con badge)
- Mantenimiento (con badge)
- Configuración
- Perfil de usuario

**Archivo sugerido:** `34_sidebar_admin.png`

---

### Captura 6.2: Sidebar Limitado (Trabajador)
**Archivo sugerido:** `35_sidebar_trabajador.png`

---

### Captura 6.3: Notificación de Éxito
**Pasos:**
1. Realizar cualquier acción exitosa (ej: crear equipo)
2. Capturar notificación verde que aparece

**Elementos visibles:**
- Toast notification
- Mensaje de éxito
- Icono de check

**Archivo sugerido:** `36_notificacion_exito.png`

---

### Captura 6.4: Validación de Errores
**Pasos:**
1. Intentar crear solicitud sin seleccionar equipo
2. Capturar mensajes de error

**Elementos visibles:**
- Campos con borde rojo
- Mensajes de error bajo los campos

**Archivo sugerido:** `37_validacion_errores.png`

---

## SECCIÓN 7: ESTADÍSTICAS Y REPORTES

### Captura 7.1: Widget de Estadísticas Generales (Admin)
**Archivo sugerido:** `38_widget_stats_general.png`

### Captura 7.2: Gráfico de Equipos por Estado
**Archivo sugerido:** `39_grafico_equipos.png`

### Captura 7.3: Tabla de Préstamos Recientes
**Archivo sugerido:** `40_tabla_prestamos_recientes.png`

---

## CHECKLIST FINAL

Antes de terminar, verifica que tengas capturas de:

**Autenticación:**
- [ ] Pantalla de login

**Dashboard:**
- [ ] Dashboard Admin
- [ ] Dashboard Trabajador
- [ ] Dashboard Mantenimiento

**Equipos:**
- [ ] Listado
- [ ] Crear
- [ ] Editar
- [ ] Acciones (menú desplegable)
- [ ] Asignar directamente

**Solicitudes (Admin):**
- [ ] Listado con badge
- [ ] Aprobar
- [ ] Rechazar
- [ ] Ver detalle

**Mis Solicitudes (Trabajador):**
- [ ] Formulario solicitar
- [ ] Listado mis solicitudes
- [ ] Ver solicitud rechazada
- [ ] Cancelar solicitud

**Mis Equipos (Trabajador):**
- [ ] Listado
- [ ] Reportar problema
- [ ] Alerta de vencimiento

**Mantenimiento:**
- [ ] Listado con badge
- [ ] Asignarse solicitud
- [ ] Completar (reparado)
- [ ] Completar (dar de baja)
- [ ] Ver detalle
- [ ] Rechazar

**Usuarios y Roles:**
- [ ] Listado usuarios
- [ ] Crear usuario
- [ ] Listado roles

**Configuración:**
- [ ] Listado settings
- [ ] Editar setting

**Interfaz:**
- [ ] Sidebar completo (admin)
- [ ] Sidebar limitado (trabajador)
- [ ] Notificación éxito
- [ ] Validación errores

**Widgets:**
- [ ] Stats overview
- [ ] Gráficos
- [ ] Préstamos recientes
- [ ] Mantenimiento pendiente

---

## TIPS PARA EL MANUAL

1. **Organiza por Rol:**
   - Sección 1: Administradores
   - Sección 2: Trabajadores
   - Sección 3: Personal de Mantenimiento

2. **Usa Números en las Imágenes:**
   - Agrega números/flechas con herramientas como:
     - Snagit
     - ShareX
     - Paint / Paint 3D
     - Online: Photopea, Pixlr

3. **Descripción Clara:**
   - Cada captura debe tener:
     - Título descriptivo
     - Breve explicación (1-2 líneas)
     - Indicación de elementos importantes

4. **Formato Profesional:**
   - PNG para capturas (mejor calidad)
   - Resolución consistente
   - Crop para eliminar información innecesaria

---

## EJEMPLO DE PÁGINA DE MANUAL

```markdown
### 3.2 Aprobar Solicitud de Préstamo

Cuando un trabajador solicita un equipo, este aparecerá en la sección 
"Solicitudes" con estado "Pendiente". Para aprobarlo:

1. Ir a **Solicitudes** en el menú lateral
2. Localizar la solicitud pendiente (badge amarillo)
3. Hacer clic en el botón **"Aprobar"** (✓)
4. Completar el formulario:
   - Fecha de préstamo: Se completa automáticamente
   - Fecha de devolución: Seleccionar fecha estimada
   - Notas: Opcional, agregar indicaciones
5. Hacer clic en **"Aprobar"** para confirmar

![Aprobar Solicitud](capturas/09_solicitudes_aprobar.png)
*Figura 9: Modal de aprobación de solicitud*

**Resultado:**
- La solicitud cambia a estado "Activo" (verde)
- El equipo cambia a estado "Prestado"
- El trabajador puede ver el equipo en "Mis Equipos"
- Se registra en el historial de auditoría
```

---

**¡Listo!** Con esta guía tendrás todas las capturas necesarias para un manual de usuario completo y profesional.

**Fecha de creación:** Noviembre 2025  
**Sistema:** Gestión de Oficina v1.0
