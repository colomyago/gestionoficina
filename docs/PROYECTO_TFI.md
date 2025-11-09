# 📘 Proyecto Final - Gestión de Desarrollo de Software

## 📋 Información del Proyecto

**Nombre del Proyecto:** Sistema de Gestión de Oficina  
**Tipo:** Aplicación Web para Control de Equipos y Recursos  
**Curso:** Gestión de Desarrollo de Software  
**Fecha:** Noviembre 2025  
**Autores:** Yago Colombo, Gaston Heinz y Tomas Mattei  

---

## 🎯 1. Descripción del Proyecto

### 1.1 Contexto / Problema

En muchas oficinas y organizaciones, el control del equipamiento tecnológico (computadoras, tablets, impresoras, etc.) se realiza mediante métodos tradicionales como:

- 📄 Planillas de Excel
- 📝 Papeles y formularios físicos
- 💬 Mensajes informales (email, WhatsApp)
- 📋 Registros manuales sin trazabilidad

**Problemas identificados:**

❌ **Pérdida de tiempo:** Búsqueda manual de información sobre equipos  
❌ **Falta de control:** No se sabe con certeza quién tiene qué equipo  
❌ **Extravío de equipos:** Sin trazabilidad adecuada  
❌ **Falta de historial:** No hay registro de préstamos anteriores  
❌ **Problemas de mantenimiento:** Equipos rotos sin seguimiento  
❌ **Gastos extras:** Por falta de organización y control  

### 1.2 Solución Propuesta

Desarrollar un **Sistema Web de Gestión de Oficina** que permita:

✅ Registrar y controlar todos los equipos de la organización  
✅ Gestionar préstamos de equipos a empleados  
✅ Controlar el estado de cada equipo (disponible, prestado, en mantenimiento)  
✅ Gestionar solicitudes de mantenimiento y reparaciones  
✅ Generar reportes y estadísticas en tiempo real  
✅ Implementar un sistema de roles (Admin, Trabajador, Mantenimiento)  
✅ Mantener historial completo de todas las operaciones  

---

## 🎯 2. Objetivos SMART

### Específico (Specific)
Crear un sistema web completo para registrar, controlar y gestionar equipos de oficina, préstamos y mantenimiento, con diferentes niveles de acceso según roles de usuario.

### Medible (Measurable)
- ✅ 100% de préstamos registrados en el sistema
- ✅ Reducción del 80% en tiempo de búsqueda de equipos
- ✅ Trazabilidad completa de todos los equipos
- ✅ Registro automático de fechas y responsables
- ✅ Reportes en tiempo real

### Alcanzable (Achievable)
Utilizar tecnologías conocidas y probadas:
- Laravel 12 (Framework PHP)
- Filament 4.0 (Panel de administración)
- MySQL 8.0 (Base de datos)
- Docker Desktop (Contenedores)
- Git (Control de versiones)

### Relevante (Relevant)
- Mejora la organización interna de la empresa
- Reduce costos operativos
- Aumenta la productividad del personal
- Previene pérdidas de equipamiento
- Facilita auditorías y control

### Temporal (Time-bound)
- Entrega de MVP funcional: 4 semanas
- Implementación de roles y permisos: 2 semanas
- Sistema de préstamos: 1 semana
- Sistema de mantenimiento: 1 semana
- Testing y documentación: 1 semana

---

## 📦 3. Alcance del Proyecto

### 3.1 Funcionalidades Incluidas ✅

#### Gestión de Equipos:
- Alta, baja, modificación y consulta de equipos
- Campos: nombre, código, categoría, descripción, estado
- Estados: disponible, prestado, mantenimiento, baja
- Asignación de equipos a usuarios
- Historial completo de cada equipo

#### Sistema de Roles:
- **Administrador:** Control total del sistema
- **Trabajador:** Solicitar y devolver equipos
- **Mantenimiento:** Gestionar reparaciones

#### Gestión de Préstamos:
- Solicitudes de préstamos por trabajadores
- Aprobación/rechazo por administradores
- Asignación directa por administradores
- Control de fechas de préstamo y devolución
- Devolución de equipos
- Historial de préstamos por usuario y equipo

#### Gestión de Mantenimiento:
- Reporte de problemas por usuarios
- Asignación de técnicos
- Estados: pendiente, en proceso, completado
- Reparación o baja de equipos
- Registro de soluciones aplicadas

#### Dashboard y Reportes:
- Estadísticas personalizadas por rol
- Equipos disponibles vs prestados
- Solicitudes pendientes
- Equipos en mantenimiento
- Gráficos y widgets informativos

#### Seguridad y Permisos:
- Sistema de autenticación
- Políticas de acceso por rol
- Validaciones de negocio
- Protección de rutas

### 3.2 Funcionalidades Excluidas ❌

**No incluidas en esta versión:**

- ❌ Integración con sistemas contables
- ❌ Aplicación móvil nativa
- ❌ Predicciones avanzadas con IA
- ❌ Notificaciones push
- ❌ Escaneo de códigos QR/Barras
- ❌ Integración con Active Directory
- ❌ Firma digital de documentos
- ❌ Reservas anticipadas de equipos

**Posibles mejoras futuras:**

- 🔮 Sistema de notificaciones por email
- 🔮 Generación de reportes en PDF
- 🔮 Integración con calendario
- 🔮 API REST para integraciones
- 🔮 App móvil con React Native
- 🔮 Sistema de códigos QR
- 🔮 Análisis predictivo con IA

---

## 🏗️ 4. Arquitectura del Sistema

### 4.1 Stack Tecnológico

#### Backend:
- **Framework:** Laravel 12
- **Lenguaje:** PHP 8.2+
- **Base de Datos:** MySQL 8.0
- **ORM:** Eloquent
- **Autenticación:** Laravel Breeze + Filament Auth

#### Frontend:
- **Panel Admin:** Filament 4.0
- **CSS Framework:** Tailwind CSS 4.0
- **Build Tool:** Vite
- **Icons:** Heroicons

#### DevOps:
- **Contenedores:** Docker Desktop + Laravel Sail
- **Control de versiones:** Git
- **Plataforma:** GitHub
- **Sistema operativo:** WSL2 (Ubuntu)

#### Servicios Adicionales:
- **AI Integration:** Google Gemini API
- **Package Manager:** Composer, NPM

### 4.2 Estructura de Directorios

```
gestionoficina/
├── app/
│   ├── Filament/
│   │   ├── Resources/         # Recursos CRUD
│   │   │   ├── Equipment/     # Gestión de equipos
│   │   │   ├── Users/         # Gestión de usuarios
│   │   │   ├── Roles/         # Gestión de roles
│   │   │   ├── SolicitudPrestamoResource.php
│   │   │   ├── GestionSolicitudesResource.php
│   │   │   ├── MantenimientoResource.php
│   │   │   └── MisEquiposResource.php
│   │   └── Widgets/           # Widgets del dashboard
│   ├── Models/                # Modelos Eloquent
│   ├── Policies/              # Políticas de autorización
│   ├── Services/              # Servicios (GeminiService)
│   └── Providers/             # Service Providers
├── database/
│   ├── migrations/            # Migraciones de BD
│   └── seeders/               # Seeders de prueba
├── docs/                      # Documentación
│   ├── INSTALACION.md
│   ├── PROYECTO_TFI.md
│   ├── SISTEMA_ROLES.md
│   └── FLUJO_COMPLETO_SISTEMA.md
├── resources/
│   ├── views/                 # Vistas Blade
│   └── lang/                  # Traducciones
├── routes/                    # Rutas
├── tests/                     # Tests unitarios
├── docker-compose.yml         # Configuración Docker
├── .env.example               # Variables de entorno
└── composer.json              # Dependencias PHP
```

### 4.3 Modelo de Base de Datos

#### Tablas Principales:

**users**
- Gestión de usuarios del sistema
- Campos: name, email, password, role_id

**roles**
- Roles del sistema
- Campos: code, name

**equipment**
- Equipos de la oficina
- Campos: name, codigo, categoria, description, status, user_id

**loans**
- Préstamos de equipos
- Campos: equipment_id, user_id, assigned_by, status, fecha_prestamo, fecha_devolucion

**maintenance_requests**
- Solicitudes de mantenimiento
- Campos: equipment_id, requested_by, assigned_to, status, descripcion_problema, solucion

#### Relaciones:

```
users (1) ---< (N) equipment
users (1) ---< (N) loans
users (1) ---< (N) maintenance_requests (requested_by)
users (1) ---< (N) maintenance_requests (assigned_to)
equipment (1) ---< (N) loans
equipment (1) ---< (N) maintenance_requests
roles (1) ---< (N) users
```

---

## 🔄 5. Flujos del Sistema

### 5.1 Flujo de Préstamo

```
┌─────────────┐
│ Trabajador  │ Solicita equipo
└──────┬──────┘
       │
       ▼
┌─────────────────────────────┐
│ Solicitud creada (pendiente)│
└──────┬──────────────────────┘
       │
       ▼
┌─────────────┐
│    Admin    │ Revisa solicitud
└──────┬──────┘
       │
   ┌───┴───┐
   │       │
   ▼       ▼
Aprueba  Rechaza
   │       │
   │       └──> Solicitud rechazada
   │
   └──> Equipo prestado
        │
        ▼
┌─────────────┐
│ Trabajador  │ Usa el equipo
└──────┬──────┘
       │
       ▼
   Devuelve
       │
       ▼
 Equipo disponible
```

### 5.2 Flujo de Mantenimiento

```
┌─────────────┐
│   Usuario   │ Reporta problema
└──────┬──────┘
       │
       ▼
┌──────────────────────────────────┐
│ Solicitud creada (pendiente)     │
│ Equipo → estado mantenimiento    │
└──────┬───────────────────────────┘
       │
       ▼
┌─────────────┐
│   Técnico   │ Toma solicitud
└──────┬──────┘
       │
       ▼
Solicitud en proceso
       │
   ┌───┴───┐
   │       │
   ▼       ▼
Repara   Da de baja
   │       │
   │       └──> Equipo → baja
   │
   └──> Equipo → disponible
```

---

## 👥 6. Casos de Uso

### 6.1 Actor: Administrador

**CU-01:** Gestionar Equipos
- Crear, editar, eliminar equipos
- Ver lista completa de equipos
- Cambiar estado de equipos

**CU-02:** Gestionar Usuarios
- Crear, editar, eliminar usuarios
- Asignar roles a usuarios
- Ver lista de usuarios

**CU-03:** Aprobar Solicitudes
- Ver solicitudes pendientes
- Aprobar o rechazar solicitudes
- Definir fechas de devolución

**CU-04:** Asignar Equipos Directamente
- Asignar equipo sin solicitud previa
- Definir usuario y fechas
- Agregar notas

**CU-05:** Gestionar Mantenimiento
- Ver todas las solicitudes
- Asignar técnicos
- Ver estado de reparaciones

### 6.2 Actor: Trabajador

**CU-06:** Solicitar Préstamo
- Ver equipos disponibles
- Crear solicitud de préstamo
- Especificar motivo

**CU-07:** Ver Mis Equipos
- Ver equipos asignados
- Ver fechas de devolución
- Ver estado de préstamos

**CU-08:** Devolver Equipo
- Seleccionar equipo a devolver
- Confirmar devolución
- Equipo vuelve a disponible

**CU-09:** Reportar Problema
- Seleccionar equipo con problema
- Describir el problema
- Crear solicitud de mantenimiento

### 6.3 Actor: Técnico de Mantenimiento

**CU-10:** Tomar Solicitud
- Ver solicitudes pendientes
- Tomar una solicitud
- Auto-asignarse como responsable

**CU-11:** Reparar Equipo
- Trabajar en la reparación
- Describir solución aplicada
- Marcar como reparado

**CU-12:** Dar de Baja Equipo
- Evaluar equipo irreparable
- Justificar baja
- Cambiar estado a baja

---

## 📊 7. Metodología de Desarrollo

### 7.1 Metodología Aplicada: SCRUM Adaptado

**Sprints:** 1 semana cada uno

#### Sprint 1: Configuración Inicial
- ✅ Setup de Laravel y Filament
- ✅ Configuración de Docker
- ✅ Creación de modelos base
- ✅ Migraciones iniciales

#### Sprint 2: Sistema de Roles
- ✅ Implementación de roles
- ✅ Políticas de autorización
- ✅ Seeders con usuarios de prueba

#### Sprint 3: Gestión de Equipos
- ✅ CRUD de equipos
- ✅ Estados de equipos
- ✅ Asignación a usuarios

#### Sprint 4: Sistema de Préstamos
- ✅ Solicitudes de préstamos
- ✅ Aprobación/rechazo
- ✅ Devolución de equipos

#### Sprint 5: Sistema de Mantenimiento
- ✅ Solicitudes de mantenimiento
- ✅ Asignación de técnicos
- ✅ Reparación y baja

#### Sprint 6: Dashboard y Widgets
- ✅ Widgets por rol
- ✅ Estadísticas
- ✅ Gráficos

#### Sprint 7: Testing y Documentación
- ✅ Documentación técnica
- ✅ Guías de usuario
- ✅ Tests unitarios

### 7.2 Control de Versiones

**Estrategia de Branching:**
- `main`: Rama principal (producción)
- `develop`: Rama de desarrollo
- `feature/*`: Ramas para nuevas funcionalidades
- `hotfix/*`: Correcciones urgentes

**Commits:**
- Mensajes descriptivos en español
- Prefijos: feat, fix, docs, refactor, test

---

## 🧪 8. Testing

### 8.1 Tipos de Tests

#### Tests Unitarios:
- Validación de modelos
- Métodos de negocio
- Relaciones entre modelos

#### Tests de Integración:
- Flujos completos
- Interacción entre componentes
- Políticas de autorización

#### Tests de Aceptación:
- Casos de uso principales
- Flujo de usuario completo
- Validaciones de UI

### 8.2 Cobertura de Tests

```bash
# Ejecutar tests
sail artisan test

# Con cobertura
sail artisan test --coverage
```

---

## 📈 9. Métricas y Resultados Esperados

### 9.1 KPIs del Sistema

**Eficiencia Operativa:**
- ⏱️ Reducción del 80% en tiempo de búsqueda
- 📊 100% de trazabilidad de equipos
- ✅ 100% de préstamos registrados

**Control y Seguridad:**
- 🔒 Acceso controlado por roles
- 📝 Historial completo de operaciones
- 🔍 Auditoría de todas las acciones

**Satisfacción de Usuarios:**
- 👍 Interfaz intuitiva (Filament)
- 🚀 Respuesta rápida del sistema
- 📱 Accesible desde cualquier dispositivo

### 9.2 Indicadores de Éxito

✅ Sistema desplegado y funcional  
✅ Usuarios de prueba creados  
✅ Todas las funcionalidades implementadas  
✅ Documentación completa  
✅ Tests pasando correctamente  
✅ Sin errores críticos  

---

## 🚀 10. Entregables

### 10.1 Código Fuente
- ✅ Repositorio en GitHub
- ✅ Código comentado y organizado
- ✅ Commits descriptivos

### 10.2 Documentación
- ✅ `INSTALACION.md` - Guía de instalación
- ✅ `PROYECTO_TFI.md` - Documentación del proyecto
- ✅ `SISTEMA_ROLES.md` - Sistema de roles
- ✅ `FLUJO_COMPLETO_SISTEMA.md` - Flujos del sistema
- ✅ `README.md` - Información general

### 10.3 Base de Datos
- ✅ Diagrama ER (docs/der.png)
- ✅ Migraciones documentadas
- ✅ Seeders con datos de prueba

### 10.4 Sistema Funcional
- ✅ Aplicación web desplegada localmente
- ✅ Usuarios de prueba configurados
- ✅ Datos de ejemplo cargados

---

## 📚 11. Referencias y Recursos

### 11.1 Documentación Técnica
- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Filament 4.0 Documentation](https://filamentphp.com/docs/4.x)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Docker Desktop](https://docs.docker.com/desktop/)

### 11.2 Herramientas Utilizadas
- **IDE:** Visual Studio Code
- **Control de versiones:** Git + GitHub
- **Base de datos:** MySQL Workbench
- **API Testing:** Postman (si aplica)
- **Documentación:** Markdown

---

## 👨‍💻 12. Información de los Desarrolladores

**Equipo de Desarrollo:**

- **Yago Colombo** - Desarrollador Principal
- **Gaston Heinz** - Desarrollador
- **Tomas Mattei** - Desarrollador

**Contacto:** colomboyago0@gmail.com  
**GitHub:** [@colomyago](https://github.com/colomyago)  
**Repositorio:** [gestionoficina](https://github.com/colomyago/gestionoficina)  

**Curso:** Gestión de Desarrollo de Software  
**Institución:** [Tu Institución]  
**Fecha de Entrega:** Noviembre 2025  

---

## 📄 13. Licencia

Este proyecto es de código abierto bajo la licencia MIT.

```
MIT License

Copyright (c) 2025 Yago Colom

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction...
```

---

## 🚀 14. Deployment y Producción

### 14.1 Entorno de Producción

El sistema está desplegado en **Railway** (https://railway.app), una plataforma moderna de deployment que ofrece:

- ✅ Deployment automático desde GitHub
- ✅ Base de datos MySQL incluida
- ✅ HTTPS automático
- ✅ Escalado vertical sencillo
- ✅ $5 USD de créditos gratuitos mensuales (~500 horas)

**URL de producción:** https://gestionoficina-production.up.railway.app

### 14.2 Arquitectura de Producción

```
┌─────────────────────────────────────────┐
│         Railway Platform                │
│                                          │
│  ┌────────────────────────────────────┐ │
│  │   Aplicación Laravel (Container)    │ │
│  │   - PHP 8.2                         │ │
│  │   - Laravel 12                      │ │
│  │   - Filament 4.0                    │ │
│  │   - HTTPS forzado                   │ │
│  │   - Trust Proxies configurado       │ │
│  └──────────────┬─────────────────────┘ │
│                 │                        │
│  ┌──────────────▼─────────────────────┐ │
│  │   MySQL 8.0 Database               │ │
│  │   - Backup manual                  │ │
│  │   - Optimizado para producción     │ │
│  └────────────────────────────────────┘ │
│                                          │
│  ┌────────────────────────────────────┐ │
│  │   CDN / Static Assets              │ │
│  │   - CSS/JS compilados              │ │
│  │   - Vite build                     │ │
│  └────────────────────────────────────┘ │
└─────────────────────────────────────────┘
```

### 14.3 Configuraciones de Seguridad

#### Proxies y HTTPS
Para que Laravel funcione correctamente detrás del proxy de Railway:

**`bootstrap/app.php`:**
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->trustProxies(at: '*', headers: Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB);
})
```

**`AppServiceProvider.php`:**
```php
if (config('app.env') === 'production') {
    URL::forceScheme('https');
    
    config([
        'session.secure' => true,
        'session.http_only' => true,
        'session.same_site' => 'lax',
    ]);
}
```

### 14.4 Proceso de Deploy

#### Automático desde GitHub
1. Push a rama `main` en GitHub
2. Railway detecta cambios automáticamente
3. Ejecuta build: `composer install` + `npm run build`
4. Ejecuta Procfile: migraciones + seeders + optimizaciones
5. Deploy completo en ~2-3 minutos

#### Procfile
```bash
web: php artisan migrate --force && 
     php artisan db:seed --class=RoleSeeder --force && 
     php artisan config:clear && 
     php artisan cache:clear && 
     php artisan serve --host=0.0.0.0 --port=$PORT
```

### 14.5 Variables de Entorno en Producción

```bash
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
DB_CONNECTION=mysql
SESSION_DRIVER=database
CACHE_STORE=database
LOG_LEVEL=error
```

### 14.6 Monitoreo

Railway proporciona:
- 📊 Métricas de CPU y memoria
- 📝 Logs en tiempo real
- 🔔 Alertas de fallos
- 📈 Uso de créditos mensuales

### 14.7 Backup y Recuperación

**Estrategia de Backup:**
- Manual: Exportar base de datos MySQL via Railway dashboard
- Frecuencia recomendada: Semanal
- Almacenamiento: Local + Git (estructura)

**Recuperación ante desastres:**
1. Railway mantiene snapshots de contenedores
2. Redeploy desde commit anterior en GitHub
3. Restaurar backup de base de datos si es necesario

### 14.8 Documentación de Deployment

Para deployment detallado, consultar:
- [RAILWAY_DEPLOYMENT.md](RAILWAY_DEPLOYMENT.md) - Guía paso a paso completa
- [README.md](../README.md) - Quickstart y enlaces

---

## 🎓 15. Conclusiones

### 15.1 Aprendizajes Clave

Durante el desarrollo de este proyecto se aplicaron conocimientos de:

- ✅ Arquitectura de software (MVC, Repository Pattern)
- ✅ Gestión de proyectos (SCRUM adaptado)
- ✅ Control de versiones (Git Flow)
- ✅ Bases de datos relacionales (MySQL)
- ✅ Contenedorización (Docker)
- ✅ Frameworks modernos (Laravel, Filament)
- ✅ Seguridad (Autenticación, Autorización, Políticas)
- ✅ Testing y calidad de código
- ✅ Deployment y DevOps (Railway, CI/CD)
- ✅ Configuración de producción (HTTPS, Proxies, Sesiones)

### 15.2 Resultados Obtenidos

El sistema cumple con todos los objetivos planteados:

✅ **Funcional:** Todas las funcionalidades implementadas y operativas  
✅ **Escalable:** Arquitectura preparada para crecer  
✅ **Seguro:** Sistema de roles y permisos robusto  
✅ **Mantenible:** Código limpio y documentado  
✅ **Eficiente:** Respuesta rápida y optimizada  
✅ **Desplegado:** Sistema en producción accesible 24/7  

### 15.3 Trabajo Futuro

Posibles mejoras y extensiones:

- 🔮 Sistema de notificaciones por email/SMS
- 🔮 Generación de reportes en PDF/Excel
- 🔮 App móvil nativa
- 🔮 Integración con códigos QR
- 🔮 Dashboard analítico avanzado
- 🔮 API REST pública
- 🔮 Integración con sistemas de inventario
- 🔮 Sistema de reservas anticipadas

---

**📅 Última actualización:** 9 de noviembre de 2025  
**📌 Versión del documento:** 1.1.0  
**👥 Equipo:** Yago Colombo, Gaston Heinz y Tomas Mattei  
**🌐 Producción:** https://gestionoficina-production.up.railway.app
