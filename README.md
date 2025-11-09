# Sistema de Gestión de Oficina

Sistema web para gestionar equipos de oficina, préstamos y mantenimiento. Proyecto final para la materia Gestión de Desarrollo de Software.

## Qué hace

Un sistema donde los trabajadores pueden pedir prestados equipos (notebooks, proyectores, etc), los admins los aprueban y los técnicos se encargan del mantenimiento cuando algo se rompe.

**Funcionalidades:**
- Trabajadores piden equipos prestados
- Admins aprueban o rechazan pedidos  
- Sistema de mantenimiento cuando algo falla
- Dashboard distinto para cada rol
- Historial completo de todo

## 🚀 Demo en línea

**URL de producción:** https://gestionoficina-production.up.railway.app/admin

El sistema está desplegado en Railway con base de datos MySQL incluida.

**Usuarios de prueba:**
- admin@gestionoficina.com / password123 (Admin)
- carlos@gestionoficina.com / password123 (Trabajador)  
- pedro@gestionoficina.com / password123 (Mantenimiento)


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

**Usuarios de prueba:**
- admin@gestionoficina.com / password123 (Admin)
- carlos@gestionoficina.com / password123 (Trabajador)  
- pedro@gestionoficina.com / password123 (Mantenimiento)

## Tecnologías usadas

- **Laravel 12** con PHP 8.2
- **Filament 4.0** para el panel de admin
- **MySQL 8.0** para la base de datos
- **Docker** con Laravel Sail (desarrollo local)
- **Railway** para deployment en producción
- **Tailwind CSS** para estilos

## Documentación

Tenemos documentación detallada en la carpeta `docs/`:

- [Instalación completa](docs/installing.md) - Si el proceso rápido no te funciona
- [Deployment en Railway](docs/RAILWAY_DEPLOYMENT.md) - Guía paso a paso para producción
- [Especificación de requisitos](docs/srs-gestionoficina.md) - Qué hace el sistema
- [Sistema de roles](docs/SISTEMA_ROLES.md) - Quién puede hacer qué
- [Flujos del sistema](docs/FLUJO_COMPLETO_SISTEMA.md) - Cómo funciona todo
- [Comandos útiles](docs/COMANDOS_SAIL.md) - Referencia rápida de comandos

## Cómo funciona

**Roles:**
- **Admin:** Puede hacer todo - aprobar préstamos, gestionar usuarios, ver estadísticas
- **Trabajador:** Pide equipos prestados, los devuelve, reporta problemas
- **Mantenimiento:** Repara equipos rotos o los da de baja si no se pueden arreglar

**Flujos principales:**
1. Trabajador pide un equipo → Admin lo aprueba → Trabajador lo usa → Trabajador lo devuelve
2. Algo se rompe → Alguien reporta → Técnico lo agarra → Lo repara o lo da de baja

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
