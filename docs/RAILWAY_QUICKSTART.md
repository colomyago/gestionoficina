# 🚀 Railway Deployment - Guía Rápida

**⏱️ Tiempo total:** 15-20 minutos  
**💰 Costo:** Gratis (plan Railway hobby)

---

## 📋 Checklist Pre-Deployment

Antes de empezar, verifica:

- [ ] Proyecto pusheado a GitHub: `colomyago/gestionoficina`
- [ ] Cuenta creada en [Railway.app](https://railway.app)
- [ ] Railway conectado con tu GitHub
- [ ] PHP instalado localmente para generar `APP_KEY`

---

## 🎯 Pasos Rápidos

### 1️⃣ Crear Proyecto en Railway (2 min)
```
1. Login en Railway → Deploy from GitHub
2. Seleccionar: colomyago/gestionoficina
3. Esperar que detecte el proyecto
```

### 2️⃣ Agregar Base de Datos MySQL (1 min)
```
1. Click "+ New" → Database → MySQL
2. Railway la crea automáticamente
3. La conexión se hace automáticamente
```

### 3️⃣ Generar APP_KEY (1 min)
```bash
# En tu máquina local (WSL)
cd /home/yago/proyecto/gestionoficina
./vendor/bin/sail artisan key:generate --show

# Copia el resultado (empieza con base64:...)
```

### 4️⃣ Configurar Variables (5 min)
```
Railway → Tu servicio Laravel → Variables → Raw Editor

Pega esto (reemplaza APP_KEY con el tuyo):
```

```bash
APP_NAME="Gestion Oficina"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:TU_KEY_AQUI
APP_URL=https://gestionoficina-production.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

LOG_CHANNEL=stack
LOG_LEVEL=error

MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@gestionoficina.com"
```

**Importante:** Actualiza `APP_URL` con tu dominio real de Railway.

### 5️⃣ Deploy y Verificar (5-10 min)
```
1. Railway hace deploy automáticamente
2. Ve a: Deployments → Ver logs
3. Espera a que muestre: "✅ Deployment successful"
4. Click en el dominio público
5. Ve a /admin
```

### 6️⃣ Login y Verificar Datos de Prueba
```
Email: admin@gestionoficina.com
Password: password123
```

---

## ✅ Verificación Rápida

¿Todo funcionó? Deberías poder:

- ✅ Acceder a `https://tu-dominio.up.railway.app/admin`
- ✅ Login con `admin@gestionoficina.com` / `password123`
- ✅ Ver el dashboard de Filament
- ✅ Ver 11 equipos de prueba ya creados en "Equipos"
- ✅ Los 3 usuarios de prueba en "Usuarios"
- ✅ Navegar por todas las secciones

---

## 🐛 Solución Rápida de Errores

| Error | Solución Rápida |
|-------|----------------|
| "No encryption key" | Falta `APP_KEY` en variables |
| "Connection refused" | MySQL no está corriendo o variables mal configuradas |
| "419 Page Expired" | `APP_URL` incorrecto |
| Página en blanco | `APP_DEBUG=true` temporalmente para ver error |
| CSS no carga | Verifica `APP_URL` use `https://` |

---

## 📖 Documentación Completa

Para información detallada, troubleshooting avanzado y mejores prácticas:

👉 **[docs/RAILWAY_DEPLOYMENT.md](RAILWAY_DEPLOYMENT.md)**

---

## 🔄 Workflow Diario

```bash
# 1. Hacer cambios localmente
./vendor/bin/sail up -d
# ... hacer cambios ...

# 2. Probar localmente
./vendor/bin/sail artisan test

# 3. Compilar assets para producción
./vendor/bin/sail npm run build

# 4. Commit y push
git add .
git commit -m "Descripción"
git push origin main

# 5. Railway hace deploy automático
# Monitorea en: https://railway.app/dashboard
```

---

## 📊 Recursos

- **Deployment activo:** https://gestionoficina-production.up.railway.app/admin
- **Railway Dashboard:** https://railway.app/dashboard
- **GitHub Repo:** https://github.com/colomyago/gestionoficina
- **Documentación completa:** [docs/](.)

---

**¿Problemas?** Consulta la [guía completa](RAILWAY_DEPLOYMENT.md) o revisa los logs en Railway.
