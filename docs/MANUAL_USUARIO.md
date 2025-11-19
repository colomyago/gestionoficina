# MANUAL DE USUARIO
## Sistema de Gestión de Oficina

---

## ÍNDICE

- Introducción
- Acceso al Sistema
- Manual para Administradores
- Manual para Trabajadores
- Manual para Personal de Mantenimiento
- Preguntas Frecuentes

---

## INTRODUCCIÓN

### ¿Qué es el Sistema de Gestión de Oficina?

El Sistema de Gestión de Oficina es una aplicación web diseñada para facilitar la gestión de equipos tecnológicos en organizaciones. Permite:

- Solicitar y aprobar préstamos de equipos
- Controlar el inventario con estados en tiempo real
- Gestionar mantenimientos y reparaciones
- Auditar operaciones con trazabilidad completa

### Roles de Usuario

El sistema cuenta con 3 roles diferenciados:

| Rol | Descripción | Acceso Principal |
|-----|-------------|------------------|
| Administrador | Gestión completa del sistema | Todos los módulos |
| Trabajador | Solicita equipos y reporta problemas | Mis solicitudes, Mis equipos |
| Mantenimiento | Gestiona reparaciones | Mantenimiento |

### Requisitos Técnicos

- Navegador web: Chrome, Firefox, Edge o Safari (versión actualizada)
- Conexión a internet: Requerida
- Dispositivos: Compatible con Desktop, Tablet y Móvil (responsive)
- Credenciales de acceso: Proporcionadas por el administrador

---

## ACCESO AL SISTEMA

### Inicio de Sesión

Paso 1: Abrir el navegador web

Paso 2: Ingresar a la URL del sistema:
```
https://gestionoficina-production.up.railway.app/admin
```

Paso 3: Completar el formulario de login:
- Email: Su correo electrónico registrado
- Contraseña: Su contraseña personal

Paso 4: Hacer clic en el botón "Iniciar Sesión"

Nota: Si olvidó su contraseña, contacte al administrador del sistema.

### Cerrar Sesión

1. Hacer clic en su nombre de usuario (esquina superior derecha)
2. Seleccionar "Cerrar sesión"

### Navegación Básica

- Menú lateral izquierdo: Acceso a módulos según su rol
- Barra superior: Nombre de usuario y opciones de perfil
- Badges numéricos: Indican cantidad de elementos pendientes
- Dashboard: Página principal con estadísticas relevantes

---

## MANUAL PARA ADMINISTRADORES

Los administradores tienen acceso completo al sistema y son responsables de:
- Gestionar equipos, usuarios y roles
- Aprobar o rechazar préstamos
- Supervisar mantenimientos
- Configurar parámetros del sistema

### Dashboard del Administrador

Al iniciar sesión, verá el Dashboard con:

Estadísticas Generales:
- Total de equipos en el sistema
- Equipos prestados actualmente
- Equipos disponibles
- Solicitudes pendientes de aprobación
- Equipos en mantenimiento

Gráfico de Distribución:
- Visualización de equipos por estado (disponible, prestado, mantenimiento, baja)

Préstamos Recientes:
- Tabla con los últimos 5 préstamos aprobados

---

### Gestión de Equipos

#### Ver Listado de Equipos

Navegación: Menú lateral - "Equipos"

Funciones disponibles:
- Buscar: Campo de búsqueda por nombre del equipo
- Filtrar: Por estado (disponible, prestado, mantenimiento, baja)
- Ordenar: Hacer clic en encabezados de columnas

Información mostrada:
- Nombre del equipo
- Descripción
- Estado actual (con badge de color)
- Usuario asignado (si está prestado)
- Acciones disponibles

#### Crear Nuevo Equipo

Paso 1: Hacer clic en botón "Nuevo Equipo" (esquina superior derecha)

Paso 2: Completar el formulario:

| Campo | Tipo | Descripción | Obligatorio |
|-------|------|-------------|-------------|
| Nombre | Texto | Nombre descriptivo del equipo | Sí |
| Descripción | Texto largo | Especificaciones técnicas, modelo, detalles | No |
| Estado | Selector | Estado inicial del equipo | Sí |
| Imagen | Archivo | Foto del equipo (formatos: JPG, PNG) | No |

Estados disponibles:
- Disponible: Listo para prestar (opción por defecto)
- Prestado: Asignado a un usuario
- Mantenimiento: En reparación
- Baja: Dado de baja permanentemente

Paso 3: Hacer clic en "Guardar"

Validaciones:
- El nombre no puede estar vacío
- El nombre debe ser único
- La imagen no debe superar 2MB

#### Editar Equipo

Paso 1: En la tabla de equipos, localizar el equipo a editar

Paso 2: Hacer clic en el icono de lápiz (Editar)

Paso 3: Modificar los campos necesarios

Paso 4: Hacer clic en "Guardar"

Nota: Puede cambiar el estado manualmente si es necesario, pero generalmente el sistema lo actualiza automáticamente.

#### Asignar Equipo Directamente a un Trabajador

Para asignar un equipo sin solicitud previa:

Paso 1: En la tabla de equipos, hacer clic en el menú de acciones del equipo

Paso 2: Seleccionar "Asignar a Trabajador"

Paso 3: En el modal que aparece, completar:
- Usuario: Seleccionar trabajador de la lista desplegable
- Fecha de devolución: Fecha estimada de devolución
- Notas: Observaciones adicionales (opcional)

Paso 4: Hacer clic en "Asignar"

¿Qué sucede?
- Se crea un préstamo activo automáticamente
- El equipo cambia a estado "Prestado"
- El equipo aparece en "Mis Equipos" del trabajador
- Se registra la operación en auditoría

#### Ver Historial de un Equipo

Para ver todos los préstamos históricos de un equipo:

Paso 1: En el menú de acciones, seleccionar "Ver Historial de Préstamos"

Información mostrada:
- Usuario que tuvo el equipo
- Fecha de préstamo
- Fecha de devolución estimada
- Fecha de devolución real
- Estado del préstamo
- Administrador que aprobó

---

### Gestión de Solicitudes de Préstamo

#### Ver Solicitudes

Navegación: Menú lateral - "Solicitudes"

Badge de notificación: Un número indica cuántas solicitudes están pendientes de aprobación

Información de cada solicitud:
- Equipo solicitado
- Usuario que solicita
- Fecha de solicitud
- Estado (con badge de color)
- Motivo de la solicitud
- Acciones disponibles

Estados posibles:
- Pendiente: Esperando aprobación del administrador
- Activo: Aprobado, equipo en poder del trabajador
- Rechazado: Solicitud denegada
- Devuelto: Préstamo finalizado

Filtros disponibles:
- Por estado
- Por usuario
- Por equipo
- Por rango de fechas

#### Aprobar una Solicitud

Paso 1: Localizar solicitud con estado "Pendiente"

Paso 2: Hacer clic en el botón "Aprobar"

Paso 3: En el modal de aprobación, completar:

| Campo | Descripción | Obligatorio |
|-------|-------------|-------------|
| Fecha de préstamo | Se completa automáticamente con fecha actual | Sí |
| Fecha de devolución | Fecha estimada de devolución | Sí |
| Notas | Instrucciones o comentarios para el trabajador | No |

Paso 4: Hacer clic en "Aprobar"

¿Qué sucede al aprobar?
1. La solicitud cambia a estado "Activo"
2. El equipo cambia a estado "Prestado"
3. El equipo queda asignado al trabajador
4. Se registra fecha de préstamo
5. El trabajador ve el equipo en "Mis Equipos"
6. Se registra en auditoría con su nombre y timestamp

Validación automática:
- No se puede aprobar si el equipo ya está prestado
- No se puede aprobar si el trabajador excede el límite configurado

#### Rechazar una Solicitud

Paso 1: Localizar solicitud pendiente

Paso 2: Hacer clic en el botón "Rechazar"

Paso 3: En el modal que aparece:
- Motivo del rechazo: Campo obligatorio, explicar por qué se rechaza

Paso 4: Hacer clic en "Rechazar"

¿Qué sucede al rechazar?
- La solicitud cambia a estado "Rechazado"
- El equipo permanece "Disponible"
- El trabajador puede ver el motivo del rechazo
- Se registra en auditoría

Buena práctica: Ser claro en el motivo del rechazo para que el trabajador entienda la razón.

#### Ver Detalles de una Solicitud

Paso 1: Hacer clic en el botón "Ver"

Información detallada mostrada:
- Datos completos del equipo (nombre, descripción, imagen)
- Información del solicitante (nombre, email, rol)
- Motivo de la solicitud (por qué lo necesita)
- Fechas relevantes (solicitud, préstamo, devolución)
- Estado actual
- Notas del administrador
- Admin que aprobó/rechazó (si aplica)

#### Forzar Devolución de un Equipo

Si necesita recuperar un equipo antes de la fecha estimada:

Paso 1: Buscar el préstamo con estado "Activo"

Paso 2: En el menú de acciones, seleccionar "Forzar Devolución"

Paso 3: Confirmar la acción en el diálogo

¿Qué sucede?
- Estado de la solicitud cambia a "Devuelto"
- Estado del equipo cambia a "Disponible"
- Se registra fecha de devolución real
- El equipo desaparece de "Mis Equipos" del trabajador
- Se registra en auditoría

---

### Gestión de Usuarios

#### Ver Listado de Usuarios

Navegación: Menú lateral - "Usuarios"

Información mostrada:
- Nombre completo
- Email (usado para login)
- Rol (Admin, Trabajador, Mantenimiento)
- Fecha de registro
- Acciones disponibles

Filtros:
- Por rol
- Búsqueda por nombre o email

#### Crear Nuevo Usuario

Paso 1: Hacer clic en "Nuevo Usuario"

Paso 2: Completar el formulario:

| Campo | Descripción | Validación |
|-------|-------------|------------|
| Nombre | Nombre completo del usuario | Obligatorio |
| Email | Email único (será su username) | Obligatorio, formato email, único |
| Contraseña | Contraseña inicial (mínimo 8 caracteres) | Obligatorio |
| Rol | Admin, Trabajador o Mantenimiento | Obligatorio |

Paso 3: Hacer clic en "Guardar"

Nota: El usuario podrá cambiar su contraseña después del primer login.

Validaciones:
- El email no puede estar duplicado
- La contraseña debe tener al menos 8 caracteres

#### Editar Usuario

Paso 1: Hacer clic en el icono de lápiz del usuario

Paso 2: Modificar campos necesarios

Paso 3: Hacer clic en "Guardar"

Nota sobre contraseña: Si NO ingresa una nueva contraseña, se mantendrá la actual. Solo ingrese contraseña si desea cambiarla.

#### Ver Historial de Préstamos de un Usuario

En el menú de acciones:
- Seleccionar "Ver Historial de Préstamos"
- Se mostrará tabla con todos los préstamos (históricos y activos)

---

### Gestión de Mantenimiento

Los administradores también tienen acceso completo al módulo de mantenimiento.

Navegación: Menú lateral - "Mantenimiento"

Funcionalidades:
- Ver todas las solicitudes de mantenimiento
- Filtrar por estado
- Ver detalles de cada solicitud
- Completar mantenimientos (si no están asignados a un técnico)

Ver sección "Manual para Personal de Mantenimiento" para detalles completos.

---

### Configuración del Sistema

#### Acceder a Configuración

Navegación: Menú lateral - "Configuración"

#### Parámetros Configurables

| Parámetro | Descripción | Valor por Defecto |
|-----------|-------------|-------------------|
| max_equipments_per_worker | Cantidad máxima de equipos que un trabajador puede tener prestados simultáneamente | 5 |
| dias_aviso_vencimiento | Días antes de la fecha de devolución para mostrar alerta de vencimiento | 7 |

#### Modificar Configuración

Paso 1: Hacer clic en el icono de lápiz del parámetro

Paso 2: Modificar el valor

Paso 3: Hacer clic en "Guardar"

Importante: Los cambios se aplican inmediatamente en todo el sistema.

Ejemplo:
- Si cambia max_equipments_per_worker de 5 a 3
- Los trabajadores que ya tengan más de 3 equipos NO se ven afectados
- Pero NO podrán solicitar nuevos equipos hasta reducir a 3 o menos

---

## MANUAL PARA TRABAJADORES

Los trabajadores pueden:
- Solicitar préstamos de equipos
- Ver sus equipos asignados
- Reportar problemas en equipos
- Ver historial de sus solicitudes

### Dashboard del Trabajador

Al iniciar sesión, verá:

Widget "Mis Préstamos Activos":
- Lista de equipos que actualmente tiene en su poder
- Alertas de vencimiento si la devolución está próxima

Widget "Mis Estadísticas":
- Equipos prestados actualmente
- Total de préstamos históricos
- Solicitudes pendientes de aprobación

---

### Solicitar un Préstamo

#### Acceder al Formulario

Opción A: Menú lateral - "Solicitar Préstamo"

Opción B: Desde "Mis Solicitudes" - Botón "Nueva Solicitud"

#### Completar el Formulario

Campos del formulario:

| Campo | Descripción | Obligatorio |
|-------|-------------|-------------|
| Equipo | Lista desplegable con equipos disponibles | Sí |
| Motivo | Explicación de para qué necesita el equipo | Sí |

Paso 1: Seleccionar el equipo de la lista

Nota: Solo aparecen equipos con estado "Disponible"

Paso 2: Escribir motivo detallado

Ejemplos de motivos buenos:
- "Necesito laptop para presentación con cliente el viernes 25/11"
- "Proyector para capacitación en sala de reuniones, días 20-22/11"
- "Tablet para inventario en almacén durante toda la semana"

Ejemplos de motivos malos:
- "La necesito" (muy vago)

Paso 3: Hacer clic en "Solicitar"

#### Validaciones Automáticas

Al enviar la solicitud, el sistema valida:

El equipo está disponible:
- Si alguien más lo solicitó primero, verá mensaje de error

No excede límite de equipos:
- Por defecto: máximo 5 equipos simultáneos
- Incluye equipos actuales más solicitudes pendientes

Motivo no está vacío:
- Debe proporcionar justificación

#### Después de Solicitar

Si todo es correcto:
- Verá notificación de "Solicitud creada exitosamente"
- La solicitud aparece en "Mis Solicitudes" con estado "Pendiente"
- Un administrador recibirá notificación
- Debe esperar aprobación del administrador

---

### Mis Solicitudes

Navegación: Menú lateral - "Mis Solicitudes"

#### Ver Estado de Solicitudes

Información mostrada:
- Equipo solicitado
- Fecha de solicitud
- Estado actual (con badge de color)
- Motivo que proporcionó
- Notas del administrador (si las hay)
- Acciones disponibles

#### Estados Posibles

| Estado | Color | Significado | Acción del Trabajador |
|--------|-------|-------------|----------------------|
| Pendiente | Amarillo | Esperando aprobación del administrador | Esperar o cancelar |
| Activo | Verde | Aprobado, equipo en su poder | Usar y devolver a tiempo |
| Rechazado | Rojo | Solicitud denegada | Ver motivo de rechazo |
| Devuelto | Gris | Préstamo finalizado | Solo consulta |

#### Ver Motivo de Rechazo

Si una solicitud fue rechazada:

Paso 1: Localizar la solicitud rechazada

Paso 2: Hacer clic en "Ver"

Paso 3: Leer el motivo del rechazo proporcionado por el administrador

Ejemplos comunes de rechazo:
- "Equipo reservado para evento institucional"
- "Ya tiene 5 equipos asignados, devuelva alguno antes"
- "El equipo solicitado está en mantenimiento"

#### Cancelar Solicitud Pendiente

Si cambió de opinión sobre una solicitud que aún está pendiente:

Paso 1: Localizar solicitud en estado "Pendiente"

Paso 2: Hacer clic en botón "Cancelar"

Paso 3: Confirmar la cancelación

Nota: Solo puede cancelar solicitudes pendientes. Si ya fue aprobada, debe contactar al administrador.

---

### Mis Equipos

Navegación: Menú lateral - "Mis Equipos"

Este módulo muestra solo los equipos que ACTUALMENTE tiene en su poder.

#### Información Mostrada

Para cada equipo:
- Nombre del equipo
- Descripción y especificaciones
- Fecha en que se le asignó (fecha de préstamo)
- Fecha estimada de devolución
- Alerta si el vencimiento está próximo

#### Alertas de Vencimiento

Alerta: "Vence en X días"

Aparece cuando faltan 7 días o menos (configurable por admin) para la fecha de devolución.

Recomendaciones:
- Planifique devolver el equipo a tiempo
- Si necesita más tiempo, contacte al administrador
- Devolver tarde afecta a otros compañeros que puedan necesitarlo

---

### Reportar Problema en un Equipo

Si un equipo tiene algún problema técnico o falla:

#### Cuándo Reportar un Problema

Reporte si:
- El equipo no enciende
- La pantalla está rota o tiene fallas
- No carga la batería
- Hace ruidos extraños
- Botones o puertos no funcionan
- Lentitud extrema o congelamiento
- Software corrupto o con errores

NO reporte si:
- Solo necesita instalación de software (contacte a IT)
- Olvidó la contraseña (contacte a IT)
- Problema de red (contacte a IT)

#### Cómo Reportar

Paso 1: En "Mis Equipos", localizar el equipo con problema

Paso 2: Hacer clic en el botón "Reportar Problema"

Paso 3: En el modal que aparece, completar:
- Descripción del problema: Explicar detalladamente qué está fallando

Ejemplos de buenas descripciones:
- "La pantalla parpadea constantemente. Se ve una línea vertical en el lado derecho. Empeora al mover la laptop."
- "No enciende. Al presionar el botón de encendido, solo se escucha un pitido y la luz roja parpadea 3 veces."
- "El proyector muestra imagen borrosa en el lado izquierdo. Ajusté el foco pero no mejora."

Ejemplos de malas descripciones:
- "No funciona" (muy vago)

Paso 4: Hacer clic en "Reportar"

#### ¿Qué Sucede Después de Reportar?

Automáticamente:
1. Se crea una solicitud de mantenimiento
2. El equipo cambia a estado "Mantenimiento"
3. Su préstamo activo se marca como "Devuelto" automáticamente
4. El equipo sale de su lista "Mis Equipos"
5. El personal de Mantenimiento recibe notificación
6. Se registra en auditoría

Importante:
- Al reportar el problema, el equipo ya no está bajo su responsabilidad
- El equipo será atendido por mantenimiento
- Una vez reparado, quedará disponible para otros usuarios
- Si necesita el mismo equipo después de la reparación, debe solicitar un nuevo préstamo

---

## MANUAL PARA PERSONAL DE MANTENIMIENTO

El personal de mantenimiento se encarga de:
- Atender solicitudes de equipos con problemas
- Reparar equipos
- Dar de baja equipos irreparables

### Dashboard de Mantenimiento

Al iniciar sesión, verá:

Widget "Solicitudes Pendientes":
- Lista de equipos reportados con problemas
- Esperando asignación y atención

Badge en menú "Mantenimiento":
- Indica cantidad de solicitudes pendientes

---

### Gestión de Solicitudes de Mantenimiento

Navegación: Menú lateral - "Mantenimiento"

#### Información de Cada Solicitud

- Equipo: Nombre del equipo en mantenimiento
- Reportado por: Trabajador que reportó el problema
- Descripción del problema: Detalles de la falla
- Estado: Pendiente, En proceso, Completado, Rechazado
- Técnico asignado: Quién está trabajando en ello
- Fecha de solicitud: Cuándo se reportó
- Resultado: Reparado, Dado de baja, o Pendiente

#### Estados de Mantenimiento

| Estado | Descripción |
|--------|-------------|
| Pendiente | Recién reportado, sin asignar |
| En Proceso | Técnico trabajando en la reparación |
| Completado | Reparado o dado de baja |
| Rechazado | No requería mantenimiento |

#### Filtros Disponibles

- Por estado
- Por técnico asignado
- Por equipo
- Por rango de fechas

---

### Asignarse una Solicitud

Para tomar responsabilidad de una reparación:

Paso 1: Localizar solicitud en estado "Pendiente"

Paso 2: Hacer clic en el botón "Asignarme"

¿Qué sucede?
- La solicitud queda asignada a usted
- Su nombre aparece en la columna "Técnico asignado"
- Otros técnicos ven que ya está asignada

---

### Cambiar Estado a "En Proceso"

Cuando comience a trabajar en la reparación:

Paso 1: En el menú de acciones, seleccionar "Cambiar a En Proceso"

¿Qué sucede?
- Estado cambia de "Pendiente" a "En Proceso"
- Informa a otros que está trabajando activamente

---

### Completar Mantenimiento

#### Opción 1: Equipo Reparado

Cuando haya reparado exitosamente el equipo:

Paso 1: Hacer clic en el botón "Completar"

Paso 2: En el modal que aparece, completar:

| Campo | Descripción | Obligatorio |
|-------|-------------|-------------|
| Solución aplicada | Describir qué se hizo para reparar el equipo | Sí |
| Resultado | Seleccionar "Reparado" | Sí |

Ejemplos de soluciones:
- "Reemplazo de pantalla LCD. Testeo exitoso."
- "Actualización de firmware. Problema resuelto."
- "Limpieza interna y cambio de pasta térmica. Temperatura normalizada."

Paso 3: Hacer clic en "Completar"

¿Qué sucede?
- La solicitud cambia a estado "Completado"
- El resultado se marca como "Reparado"
- El equipo vuelve automáticamente a estado "Disponible"
- El equipo puede ser solicitado por trabajadores nuevamente
- Queda registrado en el historial del equipo

#### Opción 2: Dar de Baja

Si el equipo NO es reparable o no es conveniente repararlo:

Paso 1: Hacer clic en "Completar"

Paso 2: En el modal, completar:

| Campo | Descripción | Obligatorio |
|-------|-------------|-------------|
| Solución aplicada | Explicar por qué no es reparable | Sí |
| Resultado | Seleccionar "Dado de baja" | Sí |

Ejemplos:
- "Daño irreparable en placa madre. Costo de reparación supera valor del equipo. Se recomienda dar de baja."
- "Equipo obsoleto (más de 8 años). Repuestos descontinuados. No es viable reparar."
- "Múltiples componentes fallados. Económicamente no justificable."

Paso 3: Hacer clic en "Completar"

¿Qué sucede?
- La solicitud cambia a "Completado"
- El resultado se marca como "Dado de baja"
- El equipo cambia a estado "Baja" PERMANENTEMENTE
- El equipo ya NO aparecerá en listados de disponibles
- Solo visible en reportes históricos

Importante: La decisión de dar de baja es permanente. Consulte con el administrador si tiene dudas.

---

### Rechazar Solicitud de Mantenimiento

Si después de revisar determina que NO requiere mantenimiento:

Paso 1: Hacer clic en el botón "Rechazar"

Paso 2: Ingresar motivo del rechazo

Ejemplos:
- "Problema resuelto solo con reinicio. Equipo funciona correctamente."
- "Falla reportada es de configuración de software, no hardware. Contactar a IT."
- "No se replica el problema. Equipo funciona normalmente."

Paso 3: Confirmar

¿Qué sucede?
- La solicitud cambia a "Rechazado"
- El equipo vuelve automáticamente a estado "Disponible"

---

### Ver Historial de Mantenimiento de un Equipo

Para ver todos los mantenimientos anteriores:

Paso 1: En el menú de acciones, seleccionar "Ver Historial"

Información mostrada:
- Fechas de mantenimientos anteriores
- Problemas reportados
- Soluciones aplicadas
- Técnicos que trabajaron
- Resultados

Utilidad:
- Identificar problemas recurrentes
- Ver si el equipo es problemático
- Fundamentar decisión de dar de baja

---

## PREGUNTAS FRECUENTES

### Generales

P: ¿Puedo acceder desde mi celular?
R: Sí, el sistema es responsive y funciona en Desktop, Tablet y Móvil.

P: ¿Qué navegador debo usar?
R: Chrome, Firefox, Edge o Safari. Versión actualizada.

P: ¿Necesito instalar algo?
R: No, es una aplicación web. Solo necesita un navegador e internet.

P: ¿Olvidé mi contraseña, qué hago?
R: Contacte al administrador del sistema para que le restablezca la contraseña.

P: ¿Puedo cambiar mi contraseña?
R: Actualmente debe solicitarlo al administrador.

---

### Para Trabajadores

P: ¿Puedo solicitar múltiples equipos a la vez?
R: Sí, pero debe hacer una solicitud separada por cada equipo. Hay un límite de equipos simultáneos (por defecto 5).

P: ¿Qué hago si necesito un equipo que ya está prestado?
R: Debe esperar a que se devuelva o solicitar otro equipo disponible. Los administradores pueden ver cuándo se espera la devolución.

P: ¿Puedo extender la fecha de devolución?
R: Debe contactar al administrador. Actualmente no hay función de auto-extensión.

P: ¿Cómo sé si mi solicitud fue aprobada?
R: Verá el cambio de estado de "Pendiente" a "Activo" en "Mis Solicitudes", y el equipo aparecerá en "Mis Equipos".

P: ¿Qué hago si llego a la fecha de devolución y aún necesito el equipo?
R: Contacte al administrador ANTES de la fecha. Si tiene razones válidas, pueden extender el préstamo.

P: Si reporto un problema, ¿quién me devolverá el equipo?
R: Al reportar un problema, el equipo automáticamente sale de su responsabilidad y pasa a mantenimiento. No necesita devolverlo físicamente a menos que se lo soliciten.

P: ¿Puedo cancelar una solicitud ya aprobada?
R: No, una vez aprobada debe contactar al administrador para que registre la devolución.

P: ¿Qué pasa si pierdo un equipo?
R: Contacte inmediatamente al administrador. Se registrará el incidente en auditoría.

---

### Para Administradores

P: ¿Cómo cambio el límite de equipos por trabajador?
R: En el módulo "Configuración", edite el parámetro max_equipments_per_worker.

P: ¿Puedo ver quién aprobó un préstamo?
R: Sí, en los detalles del préstamo y en el historial de auditoría.

P: ¿Puedo asignar un equipo sin que el trabajador haga solicitud?
R: Sí, use la acción "Asignar a Trabajador" desde la tabla de equipos.

P: ¿Cómo sé qué equipos están próximos a vencer?
R: En el dashboard y en reportes (módulo de reportes en desarrollo futuro).

P: ¿Puedo recuperar un equipo dado de baja?
R: Técnicamente sí, editando manualmente en la base de datos, pero no es recomendable. Los equipos dados de baja deben ser permanentes.

P: ¿Los administradores pueden ver las contraseñas de los usuarios?
R: No, las contraseñas están encriptadas (hash bcrypt). Nadie puede verlas, solo restablecerlas.

---

### Para Personal de Mantenimiento

P: ¿Puedo reasignar una solicitud a otro técnico?
R: Actualmente no hay función directa. Debe rechazarla para que otro la tome, o coordinar manualmente.

P: ¿Qué hago si necesito repuestos que no tenemos?
R: Complete el mantenimiento como "Dado de baja" y explique en la solución que se requieren repuestos no disponibles.

P: ¿Puedo ver el historial de problemas de un equipo?
R: Sí, use la opción "Ver Historial" en el menú de acciones.

P: ¿Cómo identifico equipos problemáticos recurrentes?
R: Revise el historial de mantenimientos. Si un equipo tiene 3 o más reparaciones en poco tiempo, considere darlo de baja.

P: ¿Puedo cambiar el resultado después de completar?
R: No, una vez completado no se puede editar. Si cometió un error, contacte al administrador.

---

### Técnicas

P: ¿Los datos están respaldados?
R: Sí, Railway realiza backups automáticos de la base de datos.

P: ¿Es seguro el sistema?
R: Sí, usa HTTPS, contraseñas encriptadas, validación de permisos, y protección CSRF.

P: ¿Hay límite de usuarios o equipos?
R: No hay límite técnico, solo limitaciones del plan de Railway (producción).

P: ¿Puedo exportar datos a Excel?
R: Actualmente no implementado. Funcionalidad planeada para versión futura.

P: ¿Hay notificaciones por email?
R: No en la versión actual. Funcionalidad planeada para versión futura.

---

## SOPORTE TÉCNICO

Para asistencia, contactar a:

- Administrador del sistema: [Completar con datos de contacto]
- Email de soporte: [Completar con email]
- Horario de atención: [Completar con horario]

---

## ANEXO: GLOSARIO DE TÉRMINOS

Badge: Indicador numérico que muestra cantidad de elementos pendientes

Dashboard: Panel principal con estadísticas y widgets relevantes al rol del usuario

Estado del equipo: Situación actual del equipo (disponible, prestado, mantenimiento, baja)

Estado del préstamo: Situación actual de la solicitud (pendiente, activo, rechazado, devuelto)

Modal: Ventana emergente que aparece sobre el contenido para mostrar formularios o información

Préstamo activo: Equipo actualmente en poder de un trabajador

Préstamo devuelto: Equipo que ya fue devuelto y cerró el ciclo

Soft delete: Borrado lógico (el registro se marca como eliminado pero no se borra físicamente)

Widget: Componente visual del dashboard que muestra información específica (estadísticas, gráficos, tablas)

---

**FIN DEL MANUAL DE USUARIO**

*Versión 1.0 - Noviembre 2025*
