# CONTENIDO PARA COMPLETAR TU INFORME TFI

Este documento contiene las secciones que faltan en tu informe actual. Copia y pega cada sección en tu documento Word en el orden indicado.

---

## SECCIÓN: INTEGRANTES DEL EQUIPO
*(Página 4 aproximadamente - después de Introducción)*

### Integrantes del Equipo

#### Datos del Alumno

**Nombre completo:** [Completar con tu nombre]

**Legajo/Matrícula:** [Completar con tu número de legajo]

**Email:** [Completar con tu email]

**Carrera:** [Ejemplo: Ingeniería en Sistemas de Información / Licenciatura en Informática / etc.]

**Institución:** [Completar con el nombre de tu universidad/instituto]

**Año académico:** 2025

#### Rol en el Proyecto

Desarrollador Full Stack - Responsable de:
- Análisis de requisitos y diseño del sistema
- Implementación del backend con Laravel
- Desarrollo de la interfaz con Filament
- Diseño y optimización de base de datos
- Testing y aseguramiento de calidad
- Deployment en producción (Railway)
- Documentación técnica completa

---

## SECCIÓN: OBJETIVO Y DESCRIPCIÓN DE LA PROPUESTA
*(Ya lo tienes en tu documento, pero aquí está más detallado por si necesitas expandir)*

### Objetivo General

Desarrollar un sistema web integral para la gestión de equipos tecnológicos de oficina que permita controlar préstamos, inventario y mantenimiento mediante una plataforma centralizada con roles diferenciados y auditoría completa de operaciones.

### Objetivos Específicos

1. **Implementar un sistema de préstamos con flujo de aprobación** que permita a trabajadores solicitar equipos y a administradores aprobar o rechazar dichas solicitudes con validaciones automáticas de disponibilidad y límites.

2. **Controlar el inventario de equipos** mediante estados automatizados (disponible, prestado, mantenimiento, baja) con actualización en tiempo real según las operaciones realizadas.

3. **Gestionar solicitudes de mantenimiento** permitiendo reportar problemas, asignar técnicos, realizar reparaciones o dar de baja equipos irreparables, con trazabilidad completa del proceso.

4. **Establecer un sistema de roles y permisos** con tres niveles (Administrador, Trabajador, Mantenimiento), cada uno con acceso diferenciado a módulos y funcionalidades según sus responsabilidades.

5. **Mantener auditoría completa de operaciones** registrando automáticamente todas las acciones críticas con información de usuario, timestamps, valores anteriores y nuevos para garantizar trazabilidad.

6. **Proporcionar dashboards personalizados** con widgets específicos para cada rol que muestren información relevante y estadísticas en tiempo real.

### Descripción de la Propuesta

El Sistema de Gestión de Oficina es una aplicación web diseñada para resolver el problema de gestión manual de equipos tecnológicos en organizaciones. Tradicionalmente, este control se realiza mediante planillas Excel, correos electrónicos o incluso papel, lo que genera:

- **Pérdida de equipos:** Sin registro centralizado, los equipos se extravían frecuentemente
- **Falta de trazabilidad:** No se puede determinar quién tiene cada equipo
- **Procesos lentos:** Las aprobaciones de préstamos toman días
- **Equipos sin mantenimiento:** Problemas no se reportan o atienden adecuadamente
- **Imposibilidad de auditar:** No hay registro de operaciones realizadas

#### Solución Propuesta

El sistema proporciona:

**1. Gestión Centralizada**
- Base de datos única con toda la información
- Acceso web desde cualquier ubicación
- Información actualizada en tiempo real

**2. Flujos Automatizados**
- Validación automática de disponibilidad
- Actualización de estados al aprobar/rechazar
- Notificaciones mediante badges visuales
- Registro automático de auditoría

**3. Roles Diferenciados**
- **Administradores:** Control total, aprobaciones, configuración
- **Trabajadores:** Solicitar equipos, reportar problemas, ver sus préstamos
- **Mantenimiento:** Gestionar reparaciones, dar de baja equipos

**4. Trazabilidad Completa**
- Historial de préstamos por equipo
- Historial de mantenimientos
- Registro de auditoría con usuario, fecha, acción
- Consulta de operaciones pasadas

**5. Interfaz Intuitiva**
- Diseño moderno y limpio con Filament
- Responsive (funciona en desktop, tablet, móvil)
- Feedback visual inmediato
- Dashboards con información relevante

### Alcance del Proyecto

**Incluye:**
- ✅ Gestión completa de equipos (CRUD + estados)
- ✅ Sistema de préstamos con solicitud y aprobación
- ✅ Asignación directa de equipos (sin solicitud previa)
- ✅ Reportar problemas y crear solicitudes de mantenimiento
- ✅ Gestión de reparaciones y dar de baja equipos
- ✅ Dashboards personalizados por rol
- ✅ Sistema de auditoría automático
- ✅ Configuración de parámetros del sistema
- ✅ Deployment en producción con URL pública

**No Incluye (Fuera de Alcance):**
- ❌ Notificaciones por email/SMS
- ❌ Reservas anticipadas de equipos
- ❌ API REST pública
- ❌ App móvil nativa
- ❌ Control de costos o facturación
- ❌ Gestión de proveedores
- ❌ Control de repuestos
- ❌ Multi-idioma

### Justificación

Este proyecto demuestra la aplicación práctica de conocimientos en:
- Desarrollo web full-stack (frontend + backend)
- Diseño y normalización de bases de datos
- Arquitectura de software (patrones, separación de responsabilidades)
- Seguridad (autenticación, autorización, validación)
- Testing y aseguramiento de calidad
- DevOps y deployment en producción
- Documentación técnica exhaustiva

Además, resuelve un problema real existente en organizaciones, demostrando que no es solo un ejercicio académico sino una solución aplicable al mundo real.

---

## SECCIÓN: PLAN DE TRABAJO
*(Página 8 aproximadamente)*

### Plan de Trabajo

El proyecto fue desarrollado siguiendo una metodología ágil iterativa con entregas incrementales, dividido en 5 fases principales durante un período de aproximadamente 13 semanas.

#### Metodología Aplicada

**Enfoque Iterativo e Incremental**

Se optó por una metodología ágil que permite:
- Entregas funcionales en cada iteración
- Validación temprana de funcionalidades
- Flexibilidad para ajustar prioridades
- Reducción de riesgos mediante feedback constante

**Principios Aplicados:**
- Desarrollo guiado por pruebas (TDD) cuando fue posible
- Refactorización continua para mejorar calidad de código
- Documentación durante el desarrollo (no al final)
- Commits frecuentes con mensajes descriptivos

#### Fases del Proyecto

**FASE 1: Análisis y Diseño (2 semanas)**
*Duración: Semanas 1-2*

**Actividades:**
- Análisis del problema y relevamiento de requisitos
- Identificación de roles de usuario (Admin, Trabajador, Mantenimiento)
- Definición de casos de uso principales
- Diseño conceptual de base de datos
- Diagrama Entidad-Relación
- Definición de relaciones y cardinalidades
- Diseño de la arquitectura del sistema (capas, componentes)
- Selección de tecnologías (Laravel, Filament, MySQL, Docker)

**Entregables:**
- Documento de requisitos
- Diagrama ER de base de datos
- Diagrama de arquitectura
- Definición de roles y permisos

**FASE 2: Configuración e Implementación Core (4 semanas)**
*Duración: Semanas 3-6*

**Actividades:**
- Configuración del entorno de desarrollo (Laravel Sail + Docker)
- Inicialización del proyecto Laravel 12
- Instalación y configuración de Filament 4.0
- Creación de migraciones iniciales (users, roles, equipment)
- Implementación de modelos Eloquent con relaciones
- Sistema de autenticación con Laravel Sanctum
- Seeders para roles base (admin, trabajador, mantenimiento)
- CRUD básico de usuarios con asignación de roles
- CRUD básico de equipos con estados
- Implementación de políticas de autorización iniciales

**Entregables:**
- Proyecto Laravel configurado y funcional
- Modelos de User, Role, Equipment implementados
- Sistema de login funcional
- CRUD de usuarios y equipos operativo

**FASE 3: Módulos Principales (4 semanas)**
*Duración: Semanas 7-10*

**Actividades:**
- Implementación del modelo Loan y migraciones
- Módulo de solicitudes de préstamo (trabajador)
- Módulo de gestión de solicitudes (admin)
- Flujo completo: solicitar → aprobar → devolver
- Validaciones de negocio (límites, disponibilidad)
- Servicio LoanValidationService
- Implementación del modelo MaintenanceRequest
- Módulo de reportar problemas (trabajador)
- Módulo de gestión de mantenimiento (técnicos)
- Flujo: reportar → asignar → reparar/dar de baja
- Sistema de auditoría (AuditLog model)
- Dashboards base para cada rol
- Implementación de widgets (estadísticas, gráficos)
- Badges de notificaciones en navegación

**Entregables:**
- Sistema de préstamos completo y funcional
- Sistema de mantenimiento operativo
- Dashboards personalizados por rol
- Auditoría de operaciones implementada

**FASE 4: Optimizaciones y Testing (2 semanas)**
*Duración: Semanas 11-12*

**Actividades:**
- Identificación de queries N+1 y aplicación de eager loading
- Creación de índices en base de datos
- Implementación de caché para configuraciones
- Refactorización de código duplicado en servicios
- Creación de factories para testing
- Implementación de feature tests (flujos principales)
- Implementación de unit tests (servicios)
- Implementación de policy tests (autorización)
- Corrección de bugs detectados
- Mejoras de UX (validaciones, mensajes, navegación)
- Seeders con datos realistas (15 usuarios, 41 equipos)
- Documentación técnica inicial

**Entregables:**
- Sistema optimizado (queries < 300ms)
- 15 tests implementados (100% passing)
- Datos de demostración realistas
- Primeras versiones de documentación

**FASE 5: Deployment y Documentación Final (1 semana)**
*Duración: Semana 13*

**Actividades:**
- Configuración de cuenta en Railway
- Conexión con repositorio GitHub
- Configuración de base de datos MySQL en Railway
- Ajustes de configuración para producción (HTTPS, proxies)
- Deployment inicial y pruebas
- Configuración de variables de entorno
- Configuración de deployment automático desde GitHub
- Ejecución de seeders en producción
- Pruebas exhaustivas en producción
- Finalización de documentación técnica (15 archivos)
- Redacción del informe final
- Generación de diagramas finales
- Preparación de capturas de pantalla

**Entregables:**
- Sistema en producción: https://gestionoficina-production.up.railway.app
- Documentación técnica completa (15 archivos .md)
- Informe TFI final
- Manual de usuario con capturas

#### Cronograma Detallado

| Semana | Fase | Actividades Principales | Estado |
|--------|------|------------------------|--------|
| 1-2 | Análisis y Diseño | Requisitos, diseño de BD, arquitectura | ✅ |
| 3-4 | Setup e Implementación Core | Configuración, modelos base, CRUD | ✅ |
| 5-6 | Implementación Core | Autenticación, políticas, usuarios, equipos | ✅ |
| 7-8 | Módulos Principales | Sistema de préstamos completo | ✅ |
| 9-10 | Módulos Principales | Sistema de mantenimiento, dashboards | ✅ |
| 11-12 | Optimizaciones | Testing, refactoring, optimización | ✅ |
| 13 | Deployment | Producción, documentación final | ✅ |

#### Gestión de Riesgos

**Riesgos Identificados y Mitigación:**

| Riesgo | Probabilidad | Impacto | Estrategia de Mitigación | Resultado |
|--------|--------------|---------|--------------------------|-----------|
| Problemas de compatibilidad entre versiones | Media | Alto | Usar Docker para entorno consistente | ✅ Mitigado |
| Complejidad de relaciones de BD | Alta | Alto | Diseño detallado en fase inicial | ✅ Mitigado |
| Tiempo insuficiente | Media | Alto | Priorizar funcionalidades core | ✅ Mitigado |
| Bugs en producción | Media | Medio | Testing exhaustivo antes de deploy | ✅ Mitigado |
| Pérdida de código | Baja | Alto | Git con commits frecuentes | ✅ Mitigado |
| Problemas de performance | Media | Medio | Optimización temprana (índices, eager loading) | ✅ Mitigado |

#### Herramientas de Gestión Utilizadas

**Control de Versiones:**
- Git para versionado de código
- GitHub para repositorio remoto
- Commits descriptivos y frecuentes
- Branch main para producción

**Gestión de Tareas:**
- Lista de tareas por fase
- Revisión semanal de avance
- Ajuste de prioridades según necesidad

**Documentación:**
- Markdown para documentos técnicos
- Comentarios en código
- README.md actualizado constantemente

#### Resultados del Plan

El plan se ejecutó exitosamente cumpliendo con las 13 semanas estimadas. No se requirieron extensiones de tiempo significativas gracias a:
- Buena planificación inicial
- Uso de frameworks que aceleraron desarrollo
- Priorización efectiva de funcionalidades
- Detección temprana de problemas mediante testing

---

## SECCIÓN: MANUAL DE USUARIO
*(Esta sección va después de "Listado de Módulos Desarrollados")*
*(Tu amigo está haciendo las capturas, así que dejo el texto y tú insertas las imágenes donde dice [INSERTAR CAPTURA])*

### 15. MANUAL DE USUARIO

#### 15.1 Introducción al Sistema

El Sistema de Gestión de Oficina es una aplicación web diseñada para facilitar la gestión de equipos tecnológicos. Este manual explica cómo utilizar cada módulo según el rol de usuario.

**Acceso al Sistema:**
- URL: https://gestionoficina-production.up.railway.app/admin
- Navegadores compatibles: Chrome, Firefox, Edge, Safari
- Funciona en: Desktop, Tablet, Móvil (responsive)

**Roles de Usuario:**
- **Administrador:** Gestión completa del sistema
- **Trabajador:** Solicitar préstamos y reportar problemas
- **Mantenimiento:** Gestionar reparaciones

---

#### 15.2 Inicio de Sesión

**Paso 1:** Abrir la URL del sistema en el navegador

**Paso 2:** Ingresar credenciales:
- Email: usuario@gestionoficina.com
- Contraseña: (proporcionada por el administrador)

**Paso 3:** Hacer clic en "Iniciar Sesión"

[INSERTAR CAPTURA: 01_login.png - Pantalla de login]

**Figura 1:** Pantalla de inicio de sesión del sistema

Una vez autenticado, será redirigido al dashboard correspondiente a su rol.

---

#### 15.3 Manual para Administradores

Los administradores tienen acceso completo al sistema y son responsables de gestionar equipos, aprobar préstamos, y configurar el sistema.

##### 15.3.1 Dashboard del Administrador

Al iniciar sesión como administrador, verá el dashboard principal con:
- Estadísticas generales (total equipos, prestados, disponibles)
- Gráfico de distribución de equipos por estado
- Tabla de préstamos recientes
- Indicadores de solicitudes pendientes (badges)

[INSERTAR CAPTURA: 02_dashboard_admin.png - Dashboard completo del admin]

**Figura 2:** Dashboard principal del administrador con widgets de estadísticas

---

##### 15.3.2 Gestión de Equipos

**Ver Listado de Equipos:**

1. Clic en "Equipos" en el menú lateral
2. Se mostrará tabla con todos los equipos del sistema

La tabla incluye:
- Nombre del equipo
- Descripción
- Estado (disponible, prestado, mantenimiento, baja)
- Usuario asignado (si aplica)
- Acciones disponibles

[INSERTAR CAPTURA: 03_equipos_listado.png - Tabla de equipos]

**Figura 3:** Listado de equipos con filtros y búsqueda

**Filtrar Equipos:**
- Usar el selector "Estado" para filtrar por: disponible, prestado, mantenimiento, baja
- Usar la barra de búsqueda para buscar por nombre

---

**Crear Nuevo Equipo:**

1. Clic en botón "Nuevo Equipo"
2. Completar formulario:
   - **Nombre:** Nombre descriptivo (ej: "Laptop Dell XPS 15")
   - **Descripción:** Detalles del equipo (especificaciones, modelo)
   - **Estado:** Seleccionar estado inicial (generalmente "disponible")
   - **Imagen:** (Opcional) Subir foto del equipo
3. Clic en "Guardar"

[INSERTAR CAPTURA: 04_equipos_crear.png - Formulario crear equipo]

**Figura 4:** Formulario de creación de nuevo equipo

El sistema validará que el nombre no esté vacío y mostrará mensaje de éxito al guardar.

---

**Editar Equipo Existente:**

1. En la tabla de equipos, clic en icono de lápiz (Editar)
2. Modificar los campos necesarios
3. Clic en "Guardar"

[INSERTAR CAPTURA: 05_equipos_editar.png - Formulario editar equipo]

**Figura 5:** Formulario de edición de equipo con datos pre-cargados

---

**Asignar Equipo Directamente:**

Para asignar un equipo a un trabajador sin solicitud previa:

1. En tabla de equipos, clic en menú de 3 puntos del equipo
2. Seleccionar "Asignar a Trabajador"
3. En el modal que aparece:
   - Seleccionar usuario (lista de trabajadores)
   - Establecer fecha de devolución estimada
   - Agregar notas (opcional)
4. Clic en "Asignar"

[INSERTAR CAPTURA: 06_equipos_asignar.png - Modal asignar equipo]

**Figura 6:** Modal de asignación directa de equipo a trabajador

El sistema creará automáticamente un préstamo activo y cambiará el estado del equipo a "prestado".

---

**Ver Historial de un Equipo:**

1. En menú de acciones del equipo, seleccionar "Ver Historial de Préstamos"
2. Se mostrará tabla con todos los préstamos históricos:
   - Usuario que lo tuvo
   - Fechas de préstamo y devolución
   - Estado del préstamo
   - Admin que aprobó

[INSERTAR CAPTURA: 07_equipos_historial.png - Historial de préstamos]

**Figura 7:** Historial completo de préstamos de un equipo

---

##### 15.3.3 Gestión de Solicitudes de Préstamo

**Ver Solicitudes Pendientes:**

1. Clic en "Solicitudes" en el menú lateral
2. Observe el **badge numérico** que indica cantidad de pendientes

[INSERTAR CAPTURA: 08_solicitudes_listado.png - Tabla de solicitudes con badge]

**Figura 8:** Listado de todas las solicitudes con indicador de pendientes

La tabla muestra:
- Equipo solicitado
- Usuario solicitante
- Fecha de solicitud
- Estado (pendiente, activo, rechazado, devuelto)
- Motivo de la solicitud
- Acciones disponibles

**Filtrar Solicitudes:**
- Usar selector "Estado" para ver solo: pendientes, activas, rechazadas, o devueltas

---

**Aprobar una Solicitud:**

1. Localizar solicitud con estado "Pendiente" (badge amarillo)
2. Clic en botón "Aprobar" (ícono de check ✓)
3. En el modal de aprobación:
   - **Fecha de préstamo:** Se completa automáticamente con la fecha actual
   - **Fecha de devolución:** Seleccionar fecha estimada de devolución
   - **Notas:** (Opcional) Agregar indicaciones para el trabajador
4. Clic en "Aprobar"

[INSERTAR CAPTURA: 09_solicitudes_aprobar.png - Modal aprobar solicitud]

**Figura 9:** Modal de aprobación de solicitud con fechas y notas

**¿Qué sucede al aprobar?**
- La solicitud cambia a estado "Activo" (badge verde)
- El equipo cambia automáticamente a estado "Prestado"
- El equipo queda asignado al trabajador
- Se registra la operación en auditoría
- El trabajador puede ver el equipo en "Mis Equipos"

---

**Rechazar una Solicitud:**

1. Localizar solicitud pendiente
2. Clic en botón "Rechazar" (ícono de X)
3. En el modal:
   - **Motivo del rechazo:** Campo obligatorio, explicar por qué se rechaza
4. Clic en "Rechazar"

[INSERTAR CAPTURA: 10_solicitudes_rechazar.png - Modal rechazar solicitud]

**Figura 10:** Modal de rechazo de solicitud con motivo obligatorio

El trabajador podrá ver el motivo del rechazo en su vista de "Mis Solicitudes".

---

**Ver Detalles de una Solicitud:**

1. Clic en botón "Ver" (ícono de ojo)
2. Se muestra vista detallada con:
   - Información completa del equipo
   - Datos del solicitante
   - Motivo de la solicitud
   - Fechas relevantes
   - Notas del administrador (si las hay)
   - Estado actual
   - Admin que aprobó/rechazó (si aplica)

[INSERTAR CAPTURA: 11_solicitudes_detalle.png - Vista detalle solicitud]

**Figura 11:** Vista detallada de una solicitud de préstamo

---

**Forzar Devolución de Equipo:**

Si un equipo prestado necesita ser devuelto antes de tiempo:

1. Buscar el préstamo activo en la tabla
2. Clic en menú de acciones → "Forzar Devolución"
3. Confirmar la acción

El sistema actualizará:
- Estado de la solicitud → "Devuelto"
- Estado del equipo → "Disponible"
- Registrará fecha de devolución real

---

##### 15.3.4 Gestión de Usuarios

**Ver Listado de Usuarios:**

1. Clic en "Usuarios" en el menú lateral
2. Se muestra tabla con todos los usuarios

[INSERTAR CAPTURA: 12_usuarios_listado.png - Tabla de usuarios]

**Figura 12:** Listado de usuarios con roles identificados por badges

**Filtrar Usuarios:**
- Usar selector "Rol" para filtrar por: Admin, Trabajador, Mantenimiento
- Usar búsqueda para encontrar por nombre o email

---

**Crear Nuevo Usuario:**

1. Clic en "Nuevo Usuario"
2. Completar formulario:
   - **Nombre:** Nombre completo
   - **Email:** Email único (será usado para login)
   - **Contraseña:** Contraseña inicial (el usuario puede cambiarla después)
   - **Rol:** Seleccionar rol apropiado
3. Clic en "Guardar"

[INSERTAR CAPTURA: 13_usuarios_crear.png - Formulario crear usuario]

**Figura 13:** Formulario de creación de nuevo usuario

El sistema validará que el email no exista previamente.

---

**Editar Usuario:**

1. Clic en icono de editar del usuario
2. Modificar campos necesarios
3. Clic en "Guardar"

**Nota:** No es necesario ingresar nueva contraseña a menos que se desee cambiarla.

---

##### 15.3.5 Gestión de Mantenimiento

Los administradores también tienen acceso al módulo de mantenimiento.

1. Clic en "Mantenimiento" en el menú lateral
2. Se muestra tabla con todas las solicitudes de mantenimiento

[INSERTAR CAPTURA: 14_mantenimiento_listado_admin.png - Tabla mantenimiento admin]

**Figura 14:** Listado de solicitudes de mantenimiento

La tabla incluye:
- Equipo en mantenimiento
- Reportado por (trabajador que reportó el problema)
- Descripción del problema
- Estado (pendiente, en_proceso, completado, rechazado)
- Técnico asignado
- Resultado (reparado, dado_de_baja, pendiente)

**Acciones disponibles:**
- Ver detalles de la solicitud
- Completar mantenimiento (si no está asignado a un técnico específico)

---

##### 15.3.6 Configuración del Sistema

**Acceder a Configuración:**

1. Clic en "Configuración" en el menú lateral
2. Se muestra tabla con parámetros configurables

[INSERTAR CAPTURA: 15_configuracion_listado.png - Tabla de configuración]

**Figura 15:** Parámetros configurables del sistema

**Parámetros Disponibles:**

| Parámetro | Descripción | Valor por Defecto |
|-----------|-------------|-------------------|
| max_equipments_per_worker | Cantidad máxima de equipos que un trabajador puede tener prestados simultáneamente | 5 |
| dias_aviso_vencimiento | Días antes de la fecha de devolución para mostrar alerta de vencimiento | 7 |

**Modificar Configuración:**

1. Clic en icono de editar del parámetro
2. Modificar el valor
3. Clic en "Guardar"

[INSERTAR CAPTURA: 16_configuracion_editar.png - Modal editar configuración]

**Figura 16:** Edición de parámetro de configuración

Los cambios se aplican inmediatamente en todo el sistema.

---

#### 15.4 Manual para Trabajadores

Los trabajadores pueden solicitar equipos, ver sus préstamos activos, y reportar problemas.

##### 15.4.1 Dashboard del Trabajador

Al iniciar sesión como trabajador, verá:
- Widget "Mis Préstamos Activos" con equipos que tiene asignados
- Widget "Mis Estadísticas" con totales personales
- Alertas de vencimiento próximo (si aplica)

[INSERTAR CAPTURA: 17_dashboard_trabajador.png - Dashboard trabajador]

**Figura 17:** Dashboard personalizado del trabajador

---

##### 15.4.2 Solicitar un Préstamo

**Paso 1: Acceder al Formulario**

Dos opciones:
- Opción A: Clic en "Solicitar Préstamo" en el menú lateral
- Opción B: Desde "Mis Solicitudes", clic en botón "Nueva Solicitud"

**Paso 2: Completar el Formulario**

[INSERTAR CAPTURA: 18_trabajador_solicitar.png - Formulario solicitar préstamo]

**Figura 18:** Formulario de solicitud de préstamo

Campos del formulario:
- **Equipo:** Desplegable con equipos disponibles (solo muestra los que tienen estado "disponible")
- **Motivo:** Campo de texto explicando para qué necesita el equipo (obligatorio)

**Paso 3: Enviar Solicitud**

Clic en "Solicitar"

**Validaciones Automáticas:**
- ✅ El equipo debe estar disponible
- ✅ No puede exceder el límite de equipos configurado (default: 5)
- ✅ Debe proporcionar un motivo

Si todo está correcto, verá notificación de éxito y la solicitud quedará en estado "Pendiente" esperando aprobación del administrador.

---

##### 15.4.3 Mis Solicitudes

**Ver Estado de Solicitudes:**

1. Clic en "Mis Solicitudes" en el menú lateral
2. Se muestra tabla con SOLO sus solicitudes

[INSERTAR CAPTURA: 19_trabajador_mis_solicitudes.png - Tabla mis solicitudes]

**Figura 19:** Listado de solicitudes del trabajador con diferentes estados

**Estados Posibles:**

| Estado | Color | Significado |
|--------|-------|-------------|
| Pendiente | 🟡 Amarillo | Esperando aprobación del administrador |
| Activo | 🟢 Verde | Aprobado y equipo en su poder |
| Rechazado | 🔴 Rojo | Solicitud denegada por el administrador |
| Devuelto | ⚪ Gris | Préstamo finalizado, equipo devuelto |

**Ver Motivo de Rechazo:**

Si una solicitud fue rechazada:

1. Clic en botón "Ver" de la solicitud rechazada
2. El motivo del rechazo estará visible claramente

[INSERTAR CAPTURA: 20_trabajador_solicitud_rechazada.png - Vista solicitud rechazada]

**Figura 20:** Detalle de solicitud rechazada con motivo visible

**Cancelar Solicitud Pendiente:**

Si cambió de opinión sobre una solicitud que aún está pendiente:

1. Localizar solicitud en estado "Pendiente"
2. Clic en botón "Cancelar"
3. Confirmar cancelación

La solicitud se eliminará y el administrador no la verá.

---

##### 15.4.4 Mis Equipos

Este módulo muestra los equipos que ACTUALMENTE tiene en su poder.

**Acceder:**

Clic en "Mis Equipos" en el menú lateral

[INSERTAR CAPTURA: 21_trabajador_mis_equipos.png - Tabla mis equipos]

**Figura 21:** Equipos actualmente asignados al trabajador

**Información Mostrada:**
- Nombre del equipo
- Descripción
- Fecha en que se le asignó (fecha de préstamo)
- Fecha estimada de devolución
- **Alerta de vencimiento** si la fecha está próxima (7 días o menos por defecto)

**Alertas de Vencimiento:**

Si un equipo tiene fecha de devolución próxima, verá:
- Badge amarillo/naranja con "Vence en X días"
- Recomendación de planificar la devolución

---

##### 15.4.5 Reportar Problema en un Equipo

Si un equipo tiene algún problema técnico:

**Paso 1:** En la tabla "Mis Equipos", ubicar el equipo con problema

**Paso 2:** Clic en botón "Reportar Problema"

**Paso 3:** En el modal que aparece, completar:
- **Descripción del problema:** Explicar detalladamente qué está fallando

[INSERTAR CAPTURA: 22_trabajador_reportar_problema.png - Modal reportar problema]

**Figura 22:** Formulario para reportar problema en un equipo

**Paso 4:** Clic en "Reportar"

**¿Qué sucede al reportar?**
- Se crea automáticamente una solicitud de mantenimiento
- El equipo cambia a estado "Mantenimiento"
- Su préstamo activo se marca como "Devuelto" automáticamente
- El personal de mantenimiento recibe notificación (badge)
- El equipo sale de su lista "Mis Equipos"

**Importante:** Una vez reportado el problema, el equipo ya no estará bajo su responsabilidad. El equipo será atendido por mantenimiento y luego quedará disponible para otros usuarios.

---

#### 15.5 Manual para Personal de Mantenimiento

El personal de mantenimiento gestiona las reparaciones de equipos reportados con problemas.

##### 15.5.1 Dashboard de Mantenimiento

Al iniciar sesión, verá:
- Widget "Solicitudes Pendientes" con listado de equipos esperando atención
- Badge en el menú "Mantenimiento" indicando cantidad de pendientes

[INSERTAR CAPTURA: 23_dashboard_mantenimiento.png - Dashboard mantenimiento]

**Figura 23:** Dashboard del personal de mantenimiento con pendientes

---

##### 15.5.2 Gestión de Solicitudes de Mantenimiento

**Acceder:**

Clic en "Mantenimiento" en el menú lateral

[INSERTAR CAPTURA: 24_mantenimiento_listado.png - Tabla solicitudes mantenimiento]

**Figura 24:** Listado de todas las solicitudes de mantenimiento

**Información Visible:**
- Equipo en mantenimiento
- Reportado por (nombre del trabajador)
- Descripción del problema
- Estado actual
- Técnico asignado
- Fecha de solicitud
- Resultado

**Estados:**
- **Pendiente:** Recién reportado, sin asignar
- **En Proceso:** Técnico trabajando en ello
- **Completado:** Reparado o dado de baja
- **Rechazado:** No requería mantenimiento

---

**Asignarse una Solicitud:**

Para tomar responsabilidad de una reparación:

1. Localizar solicitud en estado "Pendiente"
2. Clic en botón "Asignarme"
3. La solicitud quedará asignada a usted

Ahora su nombre aparecerá en la columna "Técnico asignado".

[INSERTAR CAPTURA: 25_mantenimiento_asignarse.png - Solicitud asignada]

**Figura 25:** Solicitud asignada a un técnico

---

**Cambiar Estado a "En Proceso":**

Cuando comience a trabajar en la reparación:

1. En menú de acciones, seleccionar "Cambiar a En Proceso"
2. La solicitud cambiará de "Pendiente" a "En Proceso"

Esto informa a otros que está trabajando en ello.

---

**Completar Mantenimiento - Equipo Reparado:**

Cuando haya reparado exitosamente el equipo:

1. Clic en botón "Completar" de la solicitud
2. En el modal que aparece:
   - **Solución aplicada:** Describir qué se hizo para reparar
   - **Resultado:** Seleccionar "Reparado"
3. Clic en "Completar"

[INSERTAR CAPTURA: 26_mantenimiento_completar_reparado.png - Modal completar reparado]

**Figura 26:** Formulario de completar mantenimiento marcando como reparado

**¿Qué sucede?**
- La solicitud cambia a estado "Completado"
- El resultado se marca como "Reparado"
- El equipo vuelve automáticamente a estado "Disponible"
- Queda registrado en el historial del equipo

---

**Completar Mantenimiento - Dar de Baja:**

Si el equipo no es reparable o no es conveniente repararlo:

1. Clic en botón "Completar"
2. En el modal:
   - **Solución aplicada:** Explicar por qué no es reparable
   - **Resultado:** Seleccionar "Dado de baja"
3. Clic en "Completar"

[INSERTAR CAPTURA: 27_mantenimiento_completar_baja.png - Modal dar de baja]

**Figura 27:** Formulario de completar mantenimiento marcando como dado de baja

**¿Qué sucede?**
- La solicitud cambia a "Completado"
- El resultado se marca como "Dado de baja"
- El equipo cambia a estado "Baja" PERMANENTEMENTE
- El equipo ya no aparecerá en listados de disponibles

---

**Ver Detalles de Solicitud:**

Para revisar información completa:

1. Clic en botón "Ver"
2. Se muestra vista con:
   - Equipo afectado
   - Usuario que reportó
   - Descripción completa del problema
   - Técnico asignado
   - Estado y resultado
   - Solución aplicada (si está completado)
   - Fechas de solicitud y finalización

[INSERTAR CAPTURA: 28_mantenimiento_detalle.png - Detalle solicitud mantenimiento]

**Figura 28:** Vista detallada de solicitud de mantenimiento

---

**Rechazar Solicitud:**

Si después de revisar, determina que no requiere mantenimiento:

1. Clic en botón "Rechazar"
2. Ingresar motivo del rechazo
3. Confirmar

El equipo volverá automáticamente a estado "Disponible".

---

#### 15.6 Preguntas Frecuentes (FAQ)

**P: ¿Puedo solicitar múltiples equipos a la vez?**
R: Sí, pero debe hacer una solicitud por cada equipo. Hay un límite de equipos simultáneos (configurable, default 5).

**P: ¿Qué hago si necesito un equipo que ya está prestado?**
R: Debe esperar a que se devuelva o solicitar otro equipo disponible. Los administradores pueden ver cuándo se espera la devolución.

**P: ¿Puedo extender la fecha de devolución de un equipo?**
R: Debe contactar al administrador. Actualmente no hay función de auto-extensión.

**P: ¿Cómo sé si mi solicitud fue aprobada?**
R: Verá el cambio de estado en "Mis Solicitudes" y el equipo aparecerá en "Mis Equipos".

**P: Si reporto un problema, ¿quién me devolverá el equipo?**
R: Al reportar un problema, el equipo automáticamente sale de su responsabilidad y pasa a mantenimiento. No necesita devolverlo físicamente a menos que se lo soliciten.

**P: ¿Puedo cancelar una solicitud ya aprobada?**
R: No, una vez aprobada debe contactar al administrador para que registre la devolución.

**P: ¿Los administradores pueden ver mis datos personales?**
R: Solo ven nombre, email, y rol. No hay información sensible adicional en el sistema.

---

**Fin del Manual de Usuario**

*Para asistencia técnica o dudas, contactar al administrador del sistema.*

---

## SECCIÓN: GLOSARIO (Al final del documento, antes de Apéndices)

### GLOSARIO DE TÉRMINOS

**API (Application Programming Interface):** Interfaz de programación de aplicaciones que permite la comunicación entre diferentes sistemas de software.

**Arquitectura MVC:** Patrón de diseño que separa la aplicación en tres componentes: Modelo (datos), Vista (interfaz), Controlador (lógica).

**Auditoría:** Registro sistemático de todas las operaciones realizadas en el sistema, incluyendo quién, qué, cuándo y desde dónde.

**Badge:** Indicador visual numérico que muestra cantidades (ej: contador de notificaciones o solicitudes pendientes).

**Backend:** Parte del sistema que maneja la lógica de negocio, base de datos y procesamiento en el servidor.

**Bcrypt:** Algoritmo de encriptación utilizado para proteger contraseñas mediante hash irreversible.

**CRUD:** Acrónimo de Create (Crear), Read (Leer), Update (Actualizar), Delete (Eliminar). Operaciones básicas de base de datos.

**CSRF (Cross-Site Request Forgery):** Ataque informático que fuerza a un usuario a ejecutar acciones no deseadas. El sistema incluye protección contra esto.

**Dashboard:** Panel de control que muestra información resumida y relevante al usuario.

**DevOps:** Prácticas que combinan desarrollo de software (Dev) y operaciones de TI (Ops) para acortar el ciclo de vida del desarrollo.

**Docker:** Plataforma de contenedorización que permite empaquetar aplicaciones con todas sus dependencias en contenedores portátiles.

**Eager Loading:** Técnica de optimización que carga relaciones de base de datos en una sola consulta en lugar de múltiples consultas (evita problema N+1).

**Eloquent:** ORM (Object-Relational Mapping) de Laravel que permite interactuar con la base de datos usando objetos PHP en lugar de SQL directo.

**Enum (Enumeration):** Tipo de dato que restringe valores a un conjunto predefinido (ej: estado = 'disponible' | 'prestado' | 'mantenimiento' | 'baja').

**Filament:** Framework de administración para Laravel que proporciona interfaz completa de gestión sin escribir código frontend.

**Foreign Key:** Clave foránea que establece relación entre dos tablas de base de datos, garantizando integridad referencial.

**Framework:** Estructura de software que proporciona funcionalidades comunes para facilitar el desarrollo de aplicaciones.

**Frontend:** Parte visible del sistema con la que interactúa el usuario (interfaz gráfica).

**Git:** Sistema de control de versiones que registra cambios en archivos y permite colaboración entre desarrolladores.

**HTTPS (Hypertext Transfer Protocol Secure):** Versión segura de HTTP que encripta la comunicación entre navegador y servidor.

**Índice (Database Index):** Estructura que mejora la velocidad de búsqueda en tablas de base de datos.

**Laravel:** Framework PHP de código abierto para desarrollo de aplicaciones web siguiendo el patrón MVC.

**Livewire:** Framework de Laravel para crear interfaces reactivas sin escribir JavaScript.

**Middleware:** Capa de software que filtra peticiones HTTP antes de que lleguen al controlador.

**Migración (Database Migration):** Archivo que define cambios en el esquema de base de datos de forma versionada y reversible.

**Modal:** Ventana emergente que se muestra sobre el contenido principal para mostrar información o solicitar entrada del usuario.

**ORM (Object-Relational Mapping):** Técnica que permite trabajar con bases de datos relacionales usando objetos de programación.

**PaaS (Platform as a Service):** Modelo de cloud computing que proporciona plataforma para desarrollar, ejecutar y gestionar aplicaciones sin gestionar infraestructura.

**Policy (Política):** Clase que define reglas de autorización para determinar si un usuario puede realizar cierta acción sobre un recurso.

**Railway:** Plataforma PaaS para desplegar aplicaciones web con deployment automático desde GitHub.

**Responsive Design:** Diseño web que se adapta automáticamente a diferentes tamaños de pantalla (desktop, tablet, móvil).

**Sanctum:** Paquete de Laravel para autenticación de SPAs (Single Page Applications) y APIs mediante tokens.

**Seeder:** Archivo que inserta datos de prueba en la base de datos para desarrollo y demostración.

**Soft Delete:** Borrado lógico que marca registros como eliminados sin borrarlos físicamente de la base de datos.

**SQL (Structured Query Language):** Lenguaje estándar para gestionar bases de datos relacionales.

**Tailwind CSS:** Framework de CSS que proporciona clases utilitarias para diseñar interfaces sin escribir CSS personalizado.

**TDD (Test-Driven Development):** Metodología de desarrollo donde se escriben tests antes de implementar funcionalidades.

**Transacción (Database Transaction):** Conjunto de operaciones de base de datos que se ejecutan atómicamente (todo o nada).

**UX (User Experience):** Experiencia del usuario al interactuar con el sistema, incluyendo facilidad de uso e intuitividad.

**Validación:** Proceso de verificar que los datos ingresados cumplen con reglas específicas antes de procesarlos.

**Widget:** Componente visual pequeño que muestra información específica en el dashboard (ej: estadísticas, gráficos).

---

## NOTA FINAL

Este contenido está listo para copiar y pegar en tu documento Word. 

**Recuerda:**
1. Insertar las capturas de pantalla donde dice [INSERTAR CAPTURA]
2. Actualizar los números de figura si es necesario
3. Ajustar el texto a tu estilo personal si lo deseas
4. Completar tus datos personales en "Integrantes del Equipo"

¡Con esto tu informe estará completo! 🎉
