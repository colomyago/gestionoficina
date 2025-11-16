# Sistema de Gestión de Oficina

Sistema web para gestionar equipos de oficina, préstamos y mantenimiento. Proyecto final para la materia Gestión de Desarrollo de Software.

## Qué hace

Un sistema donde los trabajadores pueden pedir prestados equipos (notebooks, proyectores, etc), los admins los aprueban y los técnicos se encargan del mantenimiento cuando algo se rompe.

**Funcionalidades principales:**
- ✅ **Gestión de préstamos**: Trabajadores solicitan equipos, admins aprueban/rechazan
- ✅ **Control de inventario**: 41 equipos de ejemplo (laptops, tablets, proyectores, cámaras, monitores, audio, redes)
- ✅ **Sistema de mantenimiento**: Reportes de problemas, reparaciones y equipos dados de baja
- ✅ **Roles y permisos**: 3 roles (Admin, Trabajador, Mantenimiento) con dashboards personalizados
- ✅ **Historial completo**: Auditoría de préstamos, devoluciones, aprobaciones y rechazos
- ✅ **Optimizaciones**: Eager loading, índices de BD, caché, validaciones centralizadas
- ✅ **Imágenes de equipos**: Upload de fotos con editor integrado
- ✅ **Datos realistas**: Seeders con 15 usuarios y 41 equipos simulando oficina real

## 🚀 Demo en línea

**URL de producción:** https://gestionoficina-production.up.railway.app/admin

El sistema está desplegado en Railway con base de datos MySQL incluida.

**Usuarios de prueba (todos con contraseña: `password123`):**

| Rol | Email | Descripción |
|-----|-------|-------------|
| **Admin** | admin@gestionoficina.com | Administrador principal |
| **Admin** | laura@gestionoficina.com | Administradora adicional |
| **Admin** | roberto@gestionoficina.com | Administrador adicional |
| **Trabajador** | carlos@gestionoficina.com | Desarrollador |
| **Trabajador** | maria@gestionoficina.com | Marketing |
| **Trabajador** | sofia@gestionoficina.com | Desarrolladora |
| **Trabajador** | diego@gestionoficina.com | Diseñador |
| **Trabajador** | valentina@gestionoficina.com | Marketing |
| **Trabajador** | lucas@gestionoficina.com | Ventas |
| **Mantenimiento** | pedro@gestionoficina.com | Técnico principal |
| **Mantenimiento** | ana@gestionoficina.com | Técnica |
| **Mantenimiento** | fernando@gestionoficina.com | Técnico de redes |
| **Mantenimiento** | patricia@gestionoficina.com | Técnica de hardware |


## Instalación rápida

Necesitas Docker y WSL2 instalados.

```bash
git clone https://github.com/colomyago/gestionoficina.git
cd gestionoficina
cp .env.example .env

# Instalar composer (primera vez)
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

Después entrás en http://localhost y http://localhost/admin

**15 usuarios de prueba creados** (contraseña: `password123`):
- **3 Admins**: admin, laura, roberto
- **8 Trabajadores**: carlos, maria, juan, sofia, diego, valentina, lucas, camila
- **4 Técnicos**: pedro, ana, fernando, patricia

Ver lista completa arriba en la sección "Demo en línea".

## Tecnologías usadas

- **Laravel 12** con PHP 8.2
- **Filament 4.0** para el panel de admin
- **MySQL 8.0** para la base de datos
- **Docker** con Laravel Sail (desarrollo local)
- **Railway** para deployment en producción
- **Tailwind CSS** para estilos

## Documentación

Tenemos documentación detallada en la carpeta `docs/`:

### 🚀 Deployment y Producción
- **[Railway Deployment - Guía Completa](docs/RAILWAY_DEPLOYMENT.md)** - Tutorial paso a paso para desplegar en Railway
- **[Railway Quickstart](docs/RAILWAY_QUICKSTART.md)** - Guía rápida de 15 minutos para deployment

### 📖 Documentación del Sistema
- [Instalación completa](docs/installing.md) - Si el proceso rápido no te funciona
- [Especificación de requisitos](docs/srs-gestionoficina.md) - Qué hace el sistema
- [Sistema de roles](docs/SISTEMA_ROLES.md) - Quién puede hacer qué
- [Flujos del sistema](docs/FLUJO_COMPLETO_SISTEMA.md) - Cómo funciona todo
- **[Datos de Demostración](docs/DATOS_DEMO.md)** - Detalle completo de los 15 usuarios y 41 equipos creados por los seeders

### 🔧 Referencia Técnica
- [Comandos Sail útiles](docs/COMANDOS_SAIL.md) - Referencia rápida de comandos Docker/Sail
- [Optimizaciones del sistema](docs/OPTIMIZACIONES_SISTEMA.md) - Mejoras de rendimiento implementadas
- [Proyecto TFI](docs/PROYECTO_TFI.md) - Documentación del trabajo final integrador

## Cómo funciona

**Roles del sistema:**

| Rol | Permisos | Funcionalidades |
|-----|----------|-----------------|
| **Admin** | Acceso total | Aprobar/rechazar préstamos, asignar equipos directamente, gestionar usuarios, ver todas las estadísticas, administrar inventario completo |
| **Trabajador** | Vista limitada | Solicitar préstamos, devolver equipos, reportar problemas, ver solo sus equipos asignados |
| **Mantenimiento** | Técnico | Recibir solicitudes de reparación, diagnosticar problemas, reparar o dar de baja equipos, actualizar estado de mantenimiento |

**Flujos principales:**

1. **Flujo de préstamo estándar:**
   - Trabajador solicita equipo → Admin revisa y aprueba → Equipo cambia a "prestado" → Trabajador usa el equipo → Trabajador devuelve → Equipo vuelve a "disponible"

2. **Asignación directa (sin solicitud):**
   - Admin asigna equipo directamente a trabajador → Se crea préstamo automáticamente en estado "activo"

3. **Flujo de mantenimiento:**
   - Usuario reporta problema → Equipo cambia a "mantenimiento" (préstamo activo se devuelve automáticamente) → Técnico diagnostica → Repara o da de baja según análisis costo/beneficio

4. **Rechazo de solicitudes:**
   - Trabajador solicita equipo → Admin revisa → Admin rechaza con motivo → Equipo sigue "disponible"

**Datos de demostración:**
- 15 equipos disponibles en inventario
- 10 equipos actualmente prestados
- 6 solicitudes pendientes de aprobación
- 5 equipos en mantenimiento
- 5 equipos dados de baja (con historial)
- 6 préstamos históricos (devueltos y rechazados)

## Comandos útiles

```bash
# Crear alias para no escribir ./vendor/bin/sail siempre
echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc
source ~/.bashrc

# Arrancar/parar
sail up -d
sail down

# Ver logs si algo falla
sail logs -f

# Comandos de Laravel
sail artisan migrate
sail artisan tinker

# Base de datos
sail mysql
```

## Lo que aprendimos

Desarrollar este proyecto fue un buen desafío. Algunas cosas que nos dimos cuenta:

**Lo que salió bien:**
- Filament 4.0 es genial para hacer CRUDs rápido
- Sail simplifica mucho el setup con Docker
- Las Políticas de Laravel funcionan bárbaro para manejar permisos
- Documentar todo desde el principio ahorra dolores de cabeza
- Railway hace que el deployment sea sencillo y gratuito

**Lo que nos costó:**
- Filament 4.0 era nuevo y cambió varias cosas de la v3
- Manejar los estados de los equipos (disponible/prestado/mantenimiento/baja) 
- Hacer que cada rol vea solo lo que tiene que ver
- Configurar correctamente proxies y cookies para HTTPS en producción

**Para el futuro nos gustaría agregar:**
- Notificaciones por email cuando se vence un préstamo
- Consultas con un ChatBot usando IA
- Generación de reportes en PDF
- App móvil con React Native

## Autores

Proyecto desarrollado por:
- **Yago Colombo** - colomboyago0@gmail.com
- **Gaston Heinz** - gastonheinz88@gmail.com
- **Tomas Mattei** - tomasmattei@hotmail.com

Para la materia Gestión de Desarrollo de Software.

## Problemas?

Si algo no funciona:
1. Revisá la [documentación](docs/)
2. Fijate en los [issues](https://github.com/colomyago/gestionoficina/issues) 
3. Creá un issue nuevo si es necesario
