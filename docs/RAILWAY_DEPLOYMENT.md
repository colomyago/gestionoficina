# 🚀 Guía Completa: Desplegar Gestión de Oficina en Railway

Esta guía te llevará paso a paso para desplegar tu Sistema de Gestión de Oficina en Railway con base de datos MySQL incluida.

---

## 📋 Requisitos Previos

- ✅ Cuenta de GitHub (tu proyecto ya está en: `colomyago/gestionoficina`)
- ✅ Cuenta de Railway (gratuita): https://railway.app
- ✅ Tu proyecto debe estar pusheado a GitHub

---

## 🎯 PASO 1: Preparar tu Repositorio

### 1.1 Verificar archivos creados
Asegúrate que estos archivos nuevos estén en tu proyecto:
- ✅ `Procfile` 
- ✅ `railway-deploy.sh`
- ✅ `.env.example` (actualizado)

### 1.2 Commitear y pushear cambios

```bash
# Desde tu proyecto en WSL
cd /home/yago/proyecto/gestionoficina

# Ver cambios
git status

# Agregar archivos nuevos
git add Procfile railway-deploy.sh .env.example

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

Click en **"+ Add Variable"** y agrega cada una de estas:

```bash
# APP Configuration
APP_NAME="Gestion Oficina"
APP_ENV=production
APP_DEBUG=false

# APP_KEY - GENERAR UNO NUEVO (ver paso 4.3)
APP_KEY=base64:TU_KEY_GENERADO_AQUI

# Database - Railway las completa automáticamente, pero verifica:
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Filesystem
FILESYSTEM_DISK=local

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Mail (opcional - por ahora usa log)
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@gestionoficina.com"
MAIL_FROM_NAME="${APP_NAME}"

# Gemini API (opcional - si lo usas)
GEMINI_API_KEY=tu_api_key_aqui
```

### 4.3 Generar APP_KEY

Necesitas generar un APP_KEY único. Tienes 2 opciones:

**Opción A - Desde tu máquina local:**
```bash
# En WSL
cd /home/yago/proyecto/gestionoficina
php artisan key:generate --show
```

**Opción B - Usar generador online:**
- Ve a: https://generate-random.org/laravel-key-generator
- Copia el key generado (empieza con `base64:...`)

Pega este key en la variable `APP_KEY` en Railway.

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
Railway debería hacer deploy automáticamente cuando agregues las variables. Si no:

1. Ve a la pestaña **"Deployments"**
2. Click en **"Deploy"** o espera el deploy automático

### 5.2 Monitorear el proceso

Verás logs en tiempo real:
```
🚀 Iniciando deployment en Railway...
📊 Ejecutando migraciones...
🌱 Verificando seeders...
🌱 Base de datos vacía, ejecutando seeders...
⚡ Optimizando aplicación...
✅ Deployment completado exitosamente!
```

⏱️ **Tiempo estimado:** 3-5 minutos

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
3. Deberías ver las tablas: `users`, `equipment`, `loans`, `maintenance_requests`, etc.

---

## 🔧 Comandos Útiles en Railway

Railway no tiene acceso directo a terminal, pero puedes:

### Ver logs en tiempo real:
1. Ve a tu servicio Laravel
2. Click en **"Deployments"**
3. Selecciona el deployment actual
4. Click en **"View Logs"**

### Forzar un nuevo deploy:
1. Opción A: Push un cambio a GitHub
2. Opción B: En Railway > Settings > Click **"Redeploy"**

---

## 🐛 Solución de Problemas

### ❌ Error: "No application encryption key"
**Solución:** No configuraste `APP_KEY`. Ve al Paso 4.3

### ❌ Error: "SQLSTATE[HY000] [2002] Connection refused"
**Solución:** Las variables de base de datos están mal. Verifica:
- Que MySQL esté corriendo en Railway
- Que las variables usen `${{MySQL.VARIABLE}}`

### ❌ Error: "419 Page Expired" al iniciar sesión
**Solución:** 
1. Verifica que `APP_URL` coincida con tu dominio
2. Limpia cache: En Railway > Settings > Redeploy

### ❌ Página en blanco o error 500
**Solución:**
1. Ve a Variables y cambia: `APP_DEBUG=true` temporalmente
2. Redeploy
3. Lee los errores en los logs
4. Una vez arreglado, vuelve a `APP_DEBUG=false`

### ❌ Assets CSS/JS no cargan
**Solución:**
- Verifica que `APP_URL` sea correcto y use `https://`
- En local, asegúrate de haber corrido: `npm run build`

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

## 🎉 ¡Listo!

Tu Sistema de Gestión de Oficina está funcionando en la nube. 

**URLs importantes:**
- 🏠 Aplicación: `https://tu-dominio.up.railway.app`
- 👨‍💼 Panel Admin: `https://tu-dominio.up.railway.app/admin`
- 📊 Dashboard Railway: https://railway.app/dashboard

---

## 📞 Soporte

Si algo no funciona:
1. Revisa los logs en Railway
2. Consulta la sección "Solución de Problemas"
3. Abre un issue en: https://github.com/colomyago/gestionoficina/issues

---

**Desarrollado por:**
- Yago Colombo
- Gaston Heinz  
- Tomas Mattei

*Materia: Gestión de Desarrollo de Software*
