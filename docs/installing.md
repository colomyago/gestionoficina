# Guía de Instalación - Sistema de Gestión de Oficina

**Requisitos:** Docker Desktop y WSL2

---

## Paso 0: Instalar Prerrequisitos

### 🐧 Instalar WSL2 (Windows Subsystem for Linux)

**Método Recomendado - Desde la página de Microsoft:**

**1. Ir a la página oficial:**
- Andá a: https://learn.microsoft.com/es-es/windows/wsl/install
- O buscá "WSL Microsoft" en Google

**2. Seguir las instrucciones oficiales:**

Opción más fácil - abrí PowerShell como Administrador y ejecutá:

```powershell
wsl --install
```

Esto automáticamente:
- Habilita WSL
- Instala WSL2
- Descarga Ubuntu (distribución por defecto)

**3. Reiniciar Windows** (obligatorio)

**4. Configurar Ubuntu:**
- Abrí Ubuntu desde el menú inicio
- Configurá tu usuario y contraseña cuando te lo pida

**Verificar:** Abrí PowerShell y ejecutá `wsl -l -v`. Deberías ver Ubuntu con VERSION 2.

---

### 🐳 Instalar Docker Desktop

**1. Descargar Docker Desktop:**

- Andá a: https://www.docker.com/products/docker-desktop/
- Descargá "Docker Desktop for Windows"

**2. Instalar Docker Desktop:**

- Ejecutá el instalador descargado
- Durante la instalación, asegurate de marcar "Use WSL 2 instead of Hyper-V"
- Reiniciá Windows cuando termine

**3. Configurar Docker con WSL2:**

- Abrí Docker Desktop
- Andá a Settings (⚙️) → General
- Verificá que esté marcado "Use the WSL 2 based engine"
- Andá a Resources → WSL Integration
- Habilitá "Enable integration with my default WSL distro"
- Habilitá tu distribución Ubuntu

**4. Probar la instalación:**

Abrí tu terminal Ubuntu (WSL) y ejecutá:

```bash
docker --version
docker-compose --version
```

Deberías ver las versiones instaladas.

---

## Paso 1: Clonar el Proyecto

Abrí tu terminal WSL y ejecutá:

```bash
# Andá a tu carpeta de proyectos
cd ~

# Cloná el repo
git clone https://github.com/colomyago/gestionoficina.git

# Entrá al proyecto
cd gestionoficina
```

**Verificar:** Ejecutá `pwd` y deberías ver algo como `/home/tu_usuario/gestionoficina`

---

## Paso 2: Configurar Variables de Entorno

```bash
# Copiá el archivo de configuración
cp .env.example .env
```

Ahora editá el archivo `.env` (podés usar `nano .env` o VS Code):

```env
APP_NAME="Gestion Oficina"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Base de Datos
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=oficina2_db
DB_USERNAME=oficina_user
DB_PASSWORD=Oficina2025!

# Dejá el resto como está...
```

La `APP_KEY` se genera automáticamente en el paso 5.

---

## Paso 3: Instalar Dependencias

Como es la primera vez, necesitamos instalar Composer sin tener PHP instalado:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

Esto va a tardar unos minutos la primera vez.

**Verificar:** Debe aparecer la carpeta `vendor/`

---

## Paso 4: Iniciar Docker

```bash
./vendor/bin/sail up -d
```

Esto levanta:
- PHP 8.4
- MySQL 8.0

Esperá unos 30 segundos la primera vez mientras descarga las imágenes.

**Verificar:** Ejecutá `./vendor/bin/sail ps` y vas a ver los contenedores corriendo

---

## Paso 5: Generar APP_KEY

```bash
./vendor/bin/sail artisan key:generate
```

---

## Paso 6: Crear la Base de Datos

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

Esto crea:
- Todas las tablas
- 3 roles (admin, trabajador, mantenimiento)
- 6 usuarios de prueba
- Equipos de ejemplo

---

## Paso 7: Instalar Dependencias de Node

```bash
./vendor/bin/sail npm install
```

Va a tardar un par de minutos.

---

## Paso 8: Compilar CSS y JS

Tenés dos opciones:

### Opción A: Modo desarrollo (recomendado)

Abrí otra terminal y dejá esto corriendo:

```bash
cd gestionoficina
./vendor/bin/sail npm run dev
```

Dejá esta terminal abierta. Va a recompilar automáticamente cuando hagas cambios.

### Opción B: Compilar una vez

```bash
./vendor/bin/sail npm run build
```

---

## Paso 9: Acceder al Sistema

Abrí tu navegador:

- **Aplicación:** http://localhost
- **Panel Admin:** http://localhost/admin

---

## Paso 10: Iniciar Sesión

Usuarios de prueba:

| Email | Contraseña | Rol |
|-------|------------|-----|
| admin@gestionoficina.com | password123 | Administrador |
| carlos@gestionoficina.com | password123 | Trabajador |
| pedro@gestionoficina.com | password123 | Mantenimiento |

---

## Paso 11 (Opcional): Crear Alias

Para no escribir `./vendor/bin/sail` cada vez:

```bash
# Si usás bash
echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc
source ~/.bashrc

# Si usás zsh
# echo "alias sail='./vendor/bin/sail'" >> ~/.zshrc
# source ~/.zshrc
```

Después podés usar directamente:
```bash
sail up -d
sail artisan migrate
sail npm run dev
```

El alias funciona cuando estás dentro de la carpeta del proyecto.

---

## Comandos Útiles

### Para arrancar cada día:
```bash
cd gestionoficina
sail up -d
sail npm run dev    # en otra terminal si querés
```

### Para apagar:
```bash
sail down
```

### Ver qué está pasando si algo falla:
```bash
sail logs -f
```

### Limpiar la caché:
```bash
sail artisan cache:clear
sail artisan config:clear
```

### Entrar a MySQL:
```bash
sail mysql
```

---

## Problemas Comunes

### El puerto 80 está ocupado

Cambiá el puerto en `.env`:

```env
APP_PORT=8080
```

Después:
```bash
sail down
sail up -d
```

Ahora entrá por: http://localhost:8080

---

### No conecta a MySQL

```bash
sail down
# Verificá que Docker Desktop esté andando
sail up -d
# Esperá 30 segundos
sail ps
```

---

### Error de permisos

```bash
# Desde la carpeta del proyecto
sudo chown -R $USER:$USER .
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

### npm run dev no funciona

```bash
sail npm cache clean --force
rm -rf node_modules
sail npm install
sail npm run dev
```

---

## Actualizar el Proyecto

Después de hacer `git pull`:

```bash
git pull origin main
sail composer install
sail npm install
sail artisan migrate
sail npm run build
```

---

## Desinstalar

```bash
# Esto borra la base de datos también
sail down -v

# Si querés borrar todo
rm -rf vendor node_modules
```

---

## Ayuda

1. Chequeá que Docker Desktop esté corriendo
2. Mirá los logs: `sail logs -f`
3. Leé [COMANDOS_SAIL.md](COMANDOS_SAIL.md) para más comandos
4. Revisá [FLUJO_COMPLETO_SISTEMA.md](FLUJO_COMPLETO_SISTEMA.md) para entender cómo funciona

---

**Desarrollado por:** Yago Colombo, Gaston Heinz y Tomas Mattei  
**Contacto:** colomboyago0@gmail.com  
**Última actualización:** Noviembre 2025
sail npm run dev     # En otra terminal (opcional)
```

### Detener el proyecto:
```bash
sail down
```

### Ver logs si algo falla:
```bash
sail logs -f
```

### Limpiar caché:
```bash
sail artisan cache:clear
sail artisan config:clear
```

### Acceder a la base de datos:
```bash
sail mysql
```

---

## ❌ Problemas Comunes

### ⚠️ "Puerto 80 ya está en uso"

**Solución:** Cambia el puerto en el archivo `.env`:

```env
APP_PORT=8080
```

Luego reinicia:
```bash
sail down
sail up -d
```

Accede en: http://localhost:8080

---

### ⚠️ "No se puede conectar a MySQL"

**Solución:**

```bash
# Detener todo
sail down

# Verificar que Docker Desktop esté corriendo
# Luego reinicia
sail up -d

# Espera 30 segundos y verifica
sail ps
```

---

### ⚠️ "Error de permisos en storage/"

**Solución:**

```bash
# Desde la carpeta del proyecto
sudo chown -R $USER:$USER .
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

### ⚠️ "npm run dev no funciona"

**Solución:**

```bash
# Limpiar e instalar de nuevo
sail npm cache clean --force
rm -rf node_modules
sail npm install
sail npm run dev
```

---

## 🔄 Actualizar el Proyecto

Si haces `git pull` para obtener cambios:

```bash
git pull origin main
sail composer install
sail npm install
sail artisan migrate
sail npm run build
```

---

## 🛑 Desinstalar / Limpiar Todo

```bash
# Detener y eliminar contenedores (⚠️ BORRA LA BASE DE DATOS)
sail down -v

# Eliminar dependencias (si quieres)
rm -rf vendor node_modules
```

---

## � ¿Necesitas Ayuda?

1. Verifica que Docker Desktop esté corriendo
2. Revisa los logs: `sail logs -f`
3. Consulta [COMANDOS_SAIL.md](COMANDOS_SAIL.md) para más comandos
4. Consulta [FLUJO_COMPLETO_SISTEMA.md](FLUJO_COMPLETO_SISTEMA.md) para entender el sistema

---

**👨‍💻 Desarrollado por:** Yago Colombo
**📅 Fecha:** Noviembre 2025  
**⚡ Versión:** 2.1 - Generalizada
