# 🚀 Guía Completa: Desplegar Gestión de Oficina en Railway

Esta guía te llevará paso a paso para desplegar tu Sistema de Gestión de Oficina en Railway con base de datos MySQL incluida.

**🌐 Deployment Activo:** https://gestionoficina-production.up.railway.app/admin

---

## 📋 Requisitos Previos

- ✅ Cuenta de GitHub (tu proyecto ya está en: `colomyago/gestionoficina`)
- ✅ Cuenta de Railway (gratuita): https://railway.app
- ✅ Tu proyecto debe estar pusheado a GitHub
- ✅ PHP 8.2+ y Composer instalados localmente (para generar `APP_KEY`)

---

## 🎯 PASO 1: Preparar tu Repositorio

### 1.1 Verificar archivos necesarios para Railway
Estos archivos ya están configurados en el proyecto:

**✅ `Procfile`** - Define cómo Railway ejecuta la aplicación:
```
web: php artisan migrate --force && php artisan db:seed --class=RoleSeeder --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=$PORT
```
Este comando automáticamente:
- Ejecuta migraciones
- Crea roles y usuarios de prueba
- Optimiza la aplicación
- Inicia el servidor en el puerto asignado por Railway

**✅ `railway-deploy.sh`** - Script auxiliar de deployment (opcional, Procfile es el principal)

**✅ `.env.example`** - Template de configuración con variables para Railway

### 1.2 Commitear y pushear cambios

```bash
# Desde tu proyecto en WSL
cd /home/yago/proyecto/gestionoficina

# Ver cambios
git status

# Agregar archivos nuevos
git add Procfile railway-deploy.sh nixpacks.toml railway.toml .env.example

# Hacer commit
git commit -m "Preparar proyecto para deployment en Railway"

# Subir a GitHub
git push origin main
```

---

## 🚂 PASO 2: Crear Proyecto en Railway

### 2.1 Iniciar sesión en Railway
1. Ve a: https://railway.app
2. Click en **"Login"**
3. Selecciona **"Login with GitHub"**
4. Autoriza Railway para acceder a tus repositorios

### 2.2 Crear nuevo proyecto
1. Click en **"New Project"**
2. Selecciona **"Deploy from GitHub repo"**
3. Busca y selecciona: **`colomyago/gestionoficina`**
4. Railway empezará a detectar tu proyecto (puede tardar 1-2 minutos)

⚠️ **IMPORTANTE:** El primer deploy FALLARÁ porque falta la base de datos. Esto es normal.

---

## 🗄️ PASO 3: Agregar Base de Datos MySQL

### 3.1 Agregar servicio MySQL
1. En tu proyecto de Railway, click en **"+ New"** (esquina superior derecha)
2. Selecciona **"Database"**
3. Elige **"Add MySQL"**
4. Railway creará automáticamente una base de datos MySQL

### 3.2 Conectar la base de datos a tu app
Railway configura automáticamente las variables de entorno. No necesitas hacer nada más aquí.

---

## ⚙️ PASO 4: Configurar Variables de Entorno

### 4.1 Ir a la configuración de tu servicio Laravel
1. Click en el servicio **"gestionoficina"** (tu app Laravel)
2. Ve a la pestaña **"Variables"**

### 4.2 Agregar variables necesarias

Railway puede auto-detectar algunas variables, pero debes configurar manualmente las siguientes.

Click en **"+ New Variable"** o **"Raw Editor"** y agrega:

```bash
# ========================================
# Configuración de Aplicación (OBLIGATORIO)
# ========================================
APP_NAME="Gestion Oficina"
APP_ENV=production
APP_DEBUG=false

# APP_KEY - GENERAR UNO NUEVO (ver paso 4.3)
APP_KEY=base64:TU_KEY_GENERADO_AQUI

# URL de tu aplicación - Actualizar con tu dominio de Railway
APP_URL=https://gestionoficina-production.up.railway.app

# ========================================
# Base de Datos MySQL (AUTOMÁTICO)
# ========================================
# Railway vincula automáticamente la base de datos MySQL
# Usa estas referencias para conectar:
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

# ========================================
# Sesiones y Cache (RECOMENDADO)
# ========================================
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
CACHE_STORE=database
QUEUE_CONNECTION=database

# ========================================
# Almacenamiento de Archivos
# ========================================
FILESYSTEM_DISK=local

# ========================================
# Logs (PRODUCCIÓN)
# ========================================
LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=error
LOG_DEPRECATIONS_CHANNEL=null

# ========================================
# Email (OPCIONAL)
# ========================================
# Para desarrollo/testing, usa 'log' para ver emails en logs
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@gestionoficina.com"
MAIL_FROM_NAME="${APP_NAME}"

# ========================================
# API Keys (OPCIONAL)
# ========================================
# Solo si usas la funcionalidad de chat con Gemini AI
GEMINI_API_KEY=tu_api_key_aqui
```

**💡 Tip:** Usa el **"Raw Editor"** en Railway para pegar todas las variables de una vez.

### 4.3 Generar APP_KEY (CRÍTICO)

El `APP_KEY` es esencial para la seguridad de Laravel. Sin él, la aplicación NO funcionará.

**Opción A - Desde tu máquina local con Sail (RECOMENDADO):**
```bash
# En PowerShell (Windows) o terminal WSL
cd \\wsl.localhost\Ubuntu\home\yago\proyecto\gestionoficina

# Generar key con Sail
./vendor/bin/sail artisan key:generate --show

# Te mostrará algo como:
# base64:abcd1234EFGH5678ijkl9012MNOP3456qrst7890uvwx1234ABCD5678=
```

**Opción B - Sin Docker/Sail (si tienes PHP local):**
```bash
php artisan key:generate --show
```

**Opción C - Generador online:**
- Ve a: https://generate-random.org/laravel-key-generator
- Click en "Generate Laravel Key"
- Copia el key completo (empieza con `base64:...`)

**⚠️ IMPORTANTE:** 
- Copia el key COMPLETO incluyendo `base64:`
- Pégalo en la variable `APP_KEY` en Railway
- NO compartas este key públicamente

### 4.4 Configurar APP_URL

Railway te asigna una URL automáticamente:

1. Ve a la pestaña **"Settings"** de tu servicio
2. Busca la sección **"Networking"** o **"Domains"**
3. Copia el dominio asignado (ejemplo: `gestionoficina-production-xyz.up.railway.app`)
4. Vuelve a **"Variables"** y actualiza:
   ```bash
   APP_URL=https://tu-dominio-asignado.up.railway.app
   ```

---

## 🚀 PASO 5: Hacer Deploy

### 5.1 Activar el deploy
Railway hace deploy automáticamente cuando:
- Detecta cambios en el repositorio GitHub
- Modificas variables de entorno
- Haces click manual en "Deploy"

**Para deploy manual:**
1. Ve a la pestaña **"Deployments"**
2. Click en **"Deploy"** (botón derecho superior)
3. O bien: Settings → Click **"Redeploy"**

### 5.2 Monitorear el proceso de deployment

En la pestaña **"Deployments"**, haz click en el deployment activo para ver logs en tiempo real.

**Verás algo como esto:**

```bash
# Fase 1: Build
==> Building with Nixpacks
==> Installing PHP 8.2 and dependencies...
==> Running composer install...

# Fase 2: Deployment (desde Procfile)
==> Starting web process...
==> Running migrations...
   Migrating: 2024_01_01_create_roles_table
   Migrated:  2024_01_01_create_roles_table (45.32ms)
   Migrating: 2024_01_02_create_equipment_table
   Migrated:  2024_01_02_create_equipment_table (98.67ms)
   [... más migraciones ...]

==> Seeding database...
   Seeding: DatabaseSeeder
   Seeding: RoleSeeder
   ✓ Created roles: admin, trabajador, mantenimiento
   ✓ Created test users
   Seeded:  RoleSeeder
   Seeding: EquipmentSeeder
   ✓ Created 11 sample equipment items
   Seeded:  EquipmentSeeder

==> Caching configuration...
   Configuration cached successfully!
   Route cache cleared!
   Routes cached successfully!
   View cache cleared!
   Compiled views cleared successfully!

==> Starting server on 0.0.0.0:$PORT
   Laravel development server started: http://0.0.0.0:PORT

✅ Deployment successful!
```

⏱️ **Tiempo estimado:** 
- Primera vez: 5-8 minutos (instala dependencias)
- Deployments subsecuentes: 2-4 minutos

### 5.3 Verificar estado del deployment

Railway te mostrará el estado:
- 🟢 **Success** - Deployment exitoso
- 🔵 **Building** - Compilando aplicación
- 🟡 **Deploying** - Iniciando servicios
- 🔴 **Failed** - Error (revisa logs)

---

## ✅ PASO 6: Verificar que Funciona

### 6.1 Abrir tu aplicación
1. En Railway, click en tu servicio
2. Click en el dominio público (o ve a Settings > Networking)
3. Deberías ver tu aplicación Laravel

### 6.2 Probar el panel de administración
Ve a: `https://tu-dominio.up.railway.app/admin`

**Usuarios de prueba creados por los seeders:**

| Email | Password | Rol |
|-------|----------|-----|
| admin@gestionoficina.com | password123 | Admin |
| carlos@gestionoficina.com | password123 | Trabajador |
| pedro@gestionoficina.com | password123 | Mantenimiento |

### 6.3 Verificar la base de datos

Si quieres ver la base de datos:
1. Click en el servicio **MySQL**
2. Ve a **"Data"** o usa las credenciales en **"Variables"**
3. Deberías ver las tablas: `users`, `equipment`, `loans`, `maintenance_requests`, `roles`

**Datos de prueba creados:**
- 3 roles (admin, trabajador, mantenimiento)
- 3 usuarios (uno por cada rol)
- 11 equipos de ejemplo en diferentes categorías:
  - 2 Laptops
  - 1 Proyector
  - 1 Cámara
  - 1 Tablet
  - 1 Monitor
  - 1 Impresora
  - 1 Micrófono
  - 1 Router
  - 1 Disco Duro
  - 1 Teclado

---

## 🔧 Comandos Útiles y Gestión del Proyecto

### 🔍 Ver logs en tiempo real
1. Railway Dashboard → Tu servicio "gestionoficina"
2. Click en pestaña **"Deployments"**
3. Selecciona el deployment actual (el que está corriendo)
4. Los logs se muestran automáticamente
5. Usa el buscador para filtrar por errores, warnings, etc.

**Tipos de logs:**
- **Application logs**: Errores de Laravel, queries, etc.
- **Build logs**: Instalación de dependencias
- **Deployment logs**: Migraciones, seeders, optimizaciones

### 🔄 Forzar un nuevo deploy

**Opción A - Push a GitHub (recomendado):**
```bash
# Desde tu proyecto local
cd /home/yago/proyecto/gestionoficina

# Hacer cambios y commit
git add .
git commit -m "Descripción de cambios"
git push origin main

# Railway detecta el push y hace deploy automático
```

**Opción B - Redeploy manual (sin cambios en código):**
1. Railway → Tu servicio → **"Settings"**
2. Scroll hasta "Danger Zone"
3. Click **"Redeploy"**
4. Confirma la acción

**Opción C - Desde Railway CLI (avanzado):**
```bash
# Instalar Railway CLI
npm i -g @railway/cli

# Login
railway login

# Deploy
railway up
```

### 🗄️ Acceder a la Base de Datos

**Ver datos desde Railway:**
1. Click en el servicio **MySQL** 
2. Pestaña **"Data"** (si está disponible)
3. O usa las credenciales en **"Variables"**

**Conectar desde cliente externo (TablePlus, DBeaver, etc.):**
1. Railway → MySQL → **"Connect"**
2. Copia las credenciales:
   - Host: `viaduct.proxy.rlwy.net`
   - Port: `xxxxx`
   - Database: `railway`
   - User: `root`
   - Password: `[tu password]`
3. Configura tu cliente MySQL con estas credenciales

**Ejecutar queries SQL:**
```sql
-- Ver todos los usuarios
SELECT * FROM users;

-- Ver equipos disponibles
SELECT * FROM equipment WHERE status = 'disponible';

-- Ver préstamos activos
SELECT * FROM loans WHERE status = 'activo';
```

### 📊 Monitorear recursos

**Ver métricas de uso:**
1. Railway → Tu servicio → **"Metrics"**
2. Verás gráficos de:
   - 💻 CPU Usage
   - 🧠 Memory Usage
   - 📡 Network I/O
   - ⏱️ Response Times

**Límites del plan gratuito:**
- $5 USD de crédito mensual
- ~500 horas de runtime
- Memoria: 512MB - 1GB
- Sin backups automáticos

---

## 🐛 Solución de Problemas Comunes

### ❌ Error: "No application encryption key has been specified"
**Causa:** No configuraste o configuraste mal el `APP_KEY`

**Solución:**
1. Ve a Railway → Variables
2. Verifica que exista `APP_KEY=base64:...`
3. Si no existe o está vacío, genera uno nuevo (Paso 4.3)
4. Asegúrate de incluir el prefijo `base64:`
5. Guarda y redeploy

### ❌ Error: "SQLSTATE[HY000] [2002] Connection refused"
**Causa:** La aplicación no puede conectarse a MySQL

**Solución:**
1. Verifica que MySQL esté **Running** en Railway (debe tener círculo verde)
2. Revisa las variables de base de datos:
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=${{MySQL.MYSQLHOST}}
   DB_PORT=${{MySQL.MYSQLPORT}}
   DB_DATABASE=${{MySQL.MYSQLDATABASE}}
   DB_USERNAME=${{MySQL.MYSQLUSER}}
   DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
   ```
3. Asegúrate de usar `${{MySQL.VARIABLE}}` (con doble llave)
4. Si acabas de crear MySQL, espera 1-2 minutos a que inicie
5. Redeploy

### ❌ Error: "419 Page Expired" o "CSRF token mismatch"
**Causa:** Problema con sesiones o configuración de dominio

**Solución:**
1. Verifica que `APP_URL` coincida EXACTAMENTE con tu dominio:
   ```bash
   # Correcto:
   APP_URL=https://gestionoficina-production.up.railway.app
   
   # Incorrecto:
   APP_URL=http://gestionoficina-production.up.railway.app  # sin https
   APP_URL=https://gestionoficina-production.up.railway.app/  # con slash final
   ```
2. Verifica `SESSION_DRIVER=database`
3. Limpia las sesiones: Railway → Settings → Redeploy
4. Limpia cookies de tu navegador para ese dominio

### ❌ Página en blanco (pantalla blanca) o Error 500
**Causa:** Error no mostrado en producción

**Solución (temporalmente activar debug):**
1. Railway → Variables → Edita:
   ```bash
   APP_DEBUG=true
   LOG_LEVEL=debug
   ```
2. Guarda y redeploy
3. Recarga la página con error
4. Ve a Railway → Deployments → View Logs
5. Busca el stack trace del error
6. **IMPORTANTE:** Una vez identificado el error:
   ```bash
   APP_DEBUG=false
   LOG_LEVEL=error
   ```

**Errores comunes encontrados:**
- Clase no encontrada → Falta `composer install` o `config:cache`
- Tabla no existe → Las migraciones no corrieron
- Permiso denegado → Problema con `storage/` o permisos

### ❌ Assets CSS/JS no cargan (404 en archivos estáticos)
**Causa:** Assets no compilados o URL incorrecta

**Solución:**
1. Verifica que `APP_URL` use `https://` (no `http://`)
2. Antes de hacer deploy, asegúrate de compilar assets:
   ```bash
   # En tu proyecto local
   ./vendor/bin/sail npm run build
   
   # Commitea los archivos compilados
   git add public/build
   git commit -m "Build assets para producción"
   git push origin main
   ```
3. Verifica que exista el directorio `public/build/` en tu repo
4. Railway automáticamente sirve archivos de `public/`

### ❌ Error: "Class 'IntlDateFormatter' not found"
**Causa:** Extensión PHP `intl` no instalada

**Solución:**
Railway usa Nixpacks para detectar y construir proyectos PHP. Para Laravel, instala automáticamente las extensiones comunes. Si falta alguna:

1. Crea archivo `nixpacks.toml` en la raíz:
   ```toml
   [phases.setup]
   nixPkgs = ['php82', 'php82Extensions.intl', 'php82Extensions.zip']
   ```
2. Commit y push
3. Railway detectará el archivo y usará esas configuraciones

### ❌ Error: "The stream or file "storage/logs/laravel.log" could not be opened"
**Causa:** Permisos de escritura en storage

**Solución:**
Laravel necesita escribir en `storage/` y `bootstrap/cache/`. Railway maneja esto automáticamente, pero si falla:

1. Verifica que tu `.gitignore` NO ignore estos directorios:
   ```gitignore
   # Debe permitir:
   storage/
   storage/app/
   storage/framework/
   storage/logs/
   
   # Pero ignorar contenidos:
   storage/*.key
   storage/logs/*.log
   ```
2. Asegúrate que los directorios existan en el repo (vacíos está bien)
3. Railway ejecuta automáticamente permisos al hacer deploy

### ❌ Deployment muy lento o se cuelga
**Causa:** Instalación de dependencias pesadas o proceso bloqueado

**Solución:**
1. Revisa los logs para ver dónde se detiene
2. Si es en `composer install`:
   - Verifica que `composer.lock` esté en el repo
   - Asegúrate de no tener dependencias rotas
3. Si es en migraciones:
   - Puede que una migración esté esperando input
   - Usa `--force` en comandos (ya está en el Procfile)
4. Si supera 10 minutos, cancela y redeploy

### ❌ Los seeders no ejecutan o no hay usuarios/equipos de prueba
**Causa:** Los seeders ya se ejecutaron o hay un error en los datos

**Solución:**
El `Procfile` ejecuta: `php artisan db:seed --force`

Esto ejecuta el `DatabaseSeeder` que crea:
- **RoleSeeder:**
  - Roles: admin, trabajador, mantenimiento
  - 3 usuarios de prueba con password `password123`
- **EquipmentSeeder:**
  - 11 equipos de ejemplo en diferentes categorías

**Nota:** Los seeders tienen verificación para no duplicar datos:
- RoleSeeder solo crea datos si la tabla `roles` está vacía
- EquipmentSeeder solo crea datos si la tabla `equipment` está vacía

Si no aparecen:
1. Revisa logs del deployment para ver si hubo errores
2. Verifica que existan:
   - `database/seeders/DatabaseSeeder.php`
   - `database/seeders/RoleSeeder.php`
   - `database/seeders/EquipmentSeeder.php`
3. Si los datos ya existen, los seeders no los duplicarán (comportamiento esperado)
4. Para forzar recreación, deberías resetear la base de datos completamente

### 🆘 Último recurso: Reset completo
Si nada funciona:

1. **Elimina y recrea la base de datos:**
   - Railway → MySQL service → Settings → Delete
   - Crea nueva base de datos MySQL
   - Reconecta con la app
   - Redeploy (migraciones correrán desde cero)

2. **Elimina y recrea el servicio completo:**
   - Railway → Laravel service → Settings → Delete
   - Crea nuevo proyecto desde GitHub
   - Configura variables desde cero
   - Conecta MySQL

---

## 🎨 Personalizaciones Opcionales

### Configurar un dominio propio
1. En Railway: Settings > Networking > Custom Domain
2. Agrega tu dominio
3. Actualiza los DNS en tu proveedor de dominio
4. Actualiza `APP_URL` en Variables

### Habilitar Gemini AI
Si usas la funcionalidad de chat:
1. Obtén API Key en: https://makersuite.google.com/app/apikey
2. Agrega en Variables: `GEMINI_API_KEY=tu_key_aqui`

### Configurar email real (opcional)
Para enviar emails reales en producción:
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
```

---

## 📊 Monitoreo y Mantenimiento

### Ver métricas
Railway > Tu servicio > **"Metrics"**
- CPU usage
- Memory usage
- Request volume

### Ver uso del plan gratuito
Railway Dashboard > **"Usage"**
- $5 de créditos gratis/mes
- ~500 horas de ejecución

### Backups de base de datos
⚠️ Railway NO hace backups automáticos en el plan gratuito.

**Hacer backup manual:**
1. Railway > MySQL > Variables
2. Copia las credenciales
3. Usa cualquier cliente MySQL (TablePlus, DBeaver, etc.)
4. Exporta la base de datos

---

## 🔄 Flujo de Trabajo: Desarrollo → Producción

### Workflow recomendado

```
1. 💻 Desarrollo Local (WSL + Sail)
   ↓
2. ✅ Testing Local
   ↓
3. 📝 Git Commit + Push
   ↓
4. 🚀 Railway Auto-Deploy
   ↓
5. 🔍 Verificar en Producción
```

### Comandos típicos en desarrollo

```bash
# En PowerShell o WSL
cd \\wsl.localhost\Ubuntu\home\yago\proyecto\gestionoficina

# 1. Levantar entorno local
./vendor/bin/sail up -d

# 2. Ver logs locales
./vendor/bin/sail logs -f

# 3. Ejecutar migraciones locales
./vendor/bin/sail artisan migrate

# 4. Compilar assets
./vendor/bin/sail npm run dev  # Para desarrollo
./vendor/bin/sail npm run build  # Para producción

# 5. Testing
./vendor/bin/sail artisan test

# 6. Hacer cambios, luego:
git add .
git commit -m "Descripción de cambios"
git push origin main

# 7. Railway detecta el push y hace deploy automático
# Monitorea en: https://railway.app/dashboard
```

### Buenas prácticas

✅ **DO:**
- Hacer `npm run build` antes de deploy a producción
- Commitear `composer.lock` y `package-lock.json`
- Usar migraciones para cambios en BD (nunca editar directo en producción)
- Probar localmente antes de pushear
- Mantener `.env.example` actualizado
- Usar `APP_DEBUG=false` en producción
- Revisar logs después de cada deploy

❌ **DON'T:**
- Nunca commitear `.env` con credenciales reales
- No editar la base de datos de producción manualmente
- No usar `APP_DEBUG=true` en producción (excepto para debugging temporal)
- No hacer deploy directo sin probar localmente
- No ignorar warnings en los logs

---

## 🎉 ¡Listo!

Tu Sistema de Gestión de Oficina está funcionando en la nube. 

### 📍 URLs Importantes

**Producción Actual:**
- � **Aplicación Web:** https://gestionoficina-production.up.railway.app
- 👨‍💼 **Panel Admin:** https://gestionoficina-production.up.railway.app/admin
- 📊 **Railway Dashboard:** https://railway.app/dashboard

**Desarrollo Local:**
- 🏠 **Local:** http://localhost
- 🔧 **Admin Local:** http://localhost/admin
- 📧 **Mailpit (emails):** http://localhost:8025

### � Usuarios de Prueba (en ambos entornos)

Después del primer deploy, estos usuarios están disponibles:

| Email | Password | Rol | Permisos |
|-------|----------|-----|----------|
| admin@gestionoficina.com | password123 | Admin | Acceso total: CRUD equipos, aprobar préstamos, gestionar usuarios |
| carlos@gestionoficina.com | password123 | Trabajador | Solicitar préstamos, ver mis equipos, reportar problemas |
| pedro@gestionoficina.com | password123 | Mantenimiento | Gestionar solicitudes de mantenimiento, reparar/dar de baja equipos |

### 📚 Documentación Relacionada

- 📖 **Sistema de Roles:** `docs/SISTEMA_ROLES.md`
- 🔄 **Flujo Completo:** `docs/FLUJO_COMPLETO_SISTEMA.md`
- 🐳 **Comandos Sail:** `docs/COMANDOS_SAIL.md`
- 📋 **Proyecto Completo:** `docs/PROYECTO_TFI.md`

---

## 📞 Soporte y Ayuda

### Si encuentras problemas:

1. 🔍 **Revisa los logs:**
   - Railway → Deployments → View Logs
   - Local: `./vendor/bin/sail logs -f`

2. 📖 **Consulta la documentación:**
   - Sección "Solución de Problemas" arriba
   - Documentación en `docs/`

3. 🐛 **Reporta un bug:**
   - Abre un issue: https://github.com/colomyago/gestionoficina/issues
   - Incluye: capturas de pantalla, logs, pasos para reproducir

4. 💬 **Contacto del equipo:**
   - Yago Colombo
   - Gaston Heinz
   - Tomas Mattei

---

## 🚀 Próximos Pasos Sugeridos

Después de tener el deployment funcionando:

1. **Seguridad:**
   - [ ] Cambiar passwords de usuarios de prueba
   - [ ] Configurar email real (SMTP)
   - [ ] Configurar backups de base de datos

2. **Funcionalidades:**
   - [ ] Agregar más equipos desde el panel admin
   - [ ] Configurar Gemini API para chat (opcional)
   - [ ] Personalizar logos y colores en Filament

3. **Dominio personalizado:**
   - [ ] Comprar dominio (ej: gestionoficina.com)
   - [ ] Configurarlo en Railway
   - [ ] Actualizar `APP_URL`

4. **Monitoreo:**
   - [ ] Configurar alertas de uso en Railway
   - [ ] Implementar sistema de backups automáticos
   - [ ] Configurar logs centralizados

---

**📦 Sistema de Gestión de Oficina**  
**Desarrollado por:**
- Yago Colombo
- Gaston Heinz  
- Tomas Mattei

*Materia: Gestión de Desarrollo de Software*  
*Universidad Tecnológica Nacional - Facultad Regional Resistencia*

---

**Última actualización:** Noviembre 2025  
**Versión:** 1.0  
**Stack:** Laravel 12 + Filament 4.0 + MySQL 8.0 + Railway
