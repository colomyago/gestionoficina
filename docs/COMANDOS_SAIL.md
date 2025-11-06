# ⚡ Guía Rápida de Comandos Sail

> Referencia rápida para trabajar con Laravel Sail y Docker Desktop

---

## 🔧 Configuración Inicial

### Crear Alias (Recomendado)

```bash
# Linux/Mac/WSL
echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc
source ~/.bashrc

# O para zsh
echo "alias sail='./vendor/bin/sail'" >> ~/.zshrc
source ~/.zshrc
```

Después de crear el alias, puedes usar `sail` en lugar de `./vendor/bin/sail`

---

## 🐳 Gestión de Contenedores

```bash
# Iniciar contenedores en segundo plano
sail up -d

# Iniciar sin segundo plano (ver logs en vivo)
sail up

# Detener contenedores
sail down

# Detener y eliminar volúmenes (⚠️ BORRA LA BASE DE DATOS)
sail down -v

# Ver contenedores activos
sail ps

# Ver logs de todos los servicios
sail logs

# Ver logs en tiempo real
sail logs -f

# Ver logs de un servicio específico
sail logs mysql
sail logs -f laravel.test
```

---

## 🎨 Artisan Commands

```bash
# Comandos más comunes
sail artisan migrate                    # Ejecutar migraciones
sail artisan migrate:fresh              # Limpiar BD y migrar
sail artisan migrate:fresh --seed       # Limpiar, migrar y seedear
sail artisan migrate:rollback           # Revertir última migración
sail artisan migrate:status             # Ver estado de migraciones

# Limpieza de caché
sail artisan cache:clear                # Limpiar caché
sail artisan config:clear               # Limpiar config
sail artisan route:clear                # Limpiar rutas
sail artisan view:clear                 # Limpiar vistas
sail artisan optimize:clear             # Limpiar todo

# Optimización (producción)
sail artisan config:cache               # Cachear config
sail artisan route:cache                # Cachear rutas
sail artisan view:cache                 # Cachear vistas
sail artisan optimize                   # Optimizar todo

# Base de datos
sail artisan db:seed                    # Ejecutar todos los seeders
sail artisan db:seed --class=RoleSeeder # Ejecutar seeder específico
sail artisan tinker                     # REPL de Laravel

# Filament
sail artisan make:filament-resource Equipment --generate
sail artisan make:filament-user         # Crear usuario admin
sail artisan filament:upgrade           # Actualizar Filament

# Generadores
sail artisan make:model Equipment -mfs  # Model + migration + factory + seeder
sail artisan make:controller EquipmentController
sail artisan make:migration create_equipment_table
sail artisan make:seeder EquipmentSeeder
sail artisan make:factory EquipmentFactory
sail artisan make:policy EquipmentPolicy --model=Equipment
```

---

## 📦 Composer

```bash
# Instalar todas las dependencias
sail composer install

# Instalar paquete específico
sail composer require nombre/paquete

# Instalar paquete de desarrollo
sail composer require --dev nombre/paquete

# Actualizar dependencias
sail composer update

# Actualizar paquete específico
sail composer update nombre/paquete

# Eliminar paquete
sail composer remove nombre/paquete

# Limpiar caché de composer
sail composer clear-cache

# Dumpautoload
sail composer dump-autoload

# Ver paquetes instalados
sail composer show

# Ver información de un paquete
sail composer show nombre/paquete
```

---

## 📦 NPM / Node

```bash
# Instalar dependencias
sail npm install

# Instalar paquete
sail npm install nombre-paquete

# Instalar como dependencia de desarrollo
sail npm install --save-dev nombre-paquete

# Actualizar dependencias
sail npm update

# Eliminar paquete
sail npm uninstall nombre-paquete

# Compilar assets para desarrollo
sail npm run dev

# Compilar assets para producción
sail npm run build

# Limpiar caché
sail npm cache clean --force

# Ver versión de Node
sail node -v

# Ver versión de NPM
sail npm -v
```

---

## 🗄️ Base de Datos

```bash
# Acceder a MySQL
sail mysql

# Ejecutar query directo
sail mysql -e "SELECT * FROM users;"

# Ver bases de datos
sail mysql -e "SHOW DATABASES;"

# Ver tablas
sail mysql -e "USE oficina_db; SHOW TABLES;"

# Backup de base de datos
sail exec mysql mysqldump -u sail -ppassword oficina_db > backup.sql

# Restaurar backup
sail exec -T mysql mysql -u sail -ppassword oficina_db < backup.sql

# Backup comprimido
sail exec mysql mysqldump -u sail -ppassword oficina_db | gzip > backup.sql.gz

# Restaurar backup comprimido
gunzip < backup.sql.gz | sail exec -T mysql mysql -u sail -ppassword oficina_db
```

---

## 🧪 Testing

```bash
# Ejecutar todos los tests
sail artisan test

# Ejecutar tests con cobertura
sail artisan test --coverage

# Ejecutar test específico
sail artisan test --filter NombreDelTest

# Ejecutar tests de una carpeta
sail artisan test tests/Feature

# Tests con más información
sail artisan test --verbose

# Tests paralelos (más rápido)
sail artisan test --parallel

# Crear test
sail artisan make:test EquipmentTest
sail artisan make:test EquipmentTest --unit
```

---

## 🔧 Contenedor y Shell

```bash
# Acceder al shell del contenedor principal
sail shell

# Ejecutar comando en el contenedor
sail exec app php -v
sail exec app ls -la

# Acceder a bash de MySQL
sail exec mysql bash

# Ver procesos en el contenedor
sail exec app ps aux

# Ver uso de recursos
docker stats
```

---

## 🌐 Queue y Jobs

```bash
# Trabajar con colas
sail artisan queue:work               # Procesar cola
sail artisan queue:listen             # Procesar cola (con reload)
sail artisan queue:restart            # Reiniciar workers
sail artisan queue:failed             # Ver jobs fallidos
sail artisan queue:retry all          # Reintentar todos los jobs
sail artisan queue:flush              # Limpiar cola

# Crear job
sail artisan make:job ProcessEquipment
```

---

##  Debugging

```bash
# Ver configuración actual
sail artisan config:show

# Ver rutas
sail artisan route:list

# Ver rutas filtradas
sail artisan route:list --path=admin

# Ver eventos
sail artisan event:list

# Ver variables de entorno
sail artisan env

# Información de la aplicación
sail artisan about

# Ver logs en tiempo real
sail logs -f

# Ver logs del servidor web
sail logs laravel.test

# Ver logs de MySQL
sail logs mysql
```

---

## 🔄 Actualizaciones

```bash
# Actualizar proyecto después de git pull
git pull origin main
sail composer install
sail npm install
sail artisan migrate
sail npm run build

# Limpiar todo después de actualización
sail artisan optimize:clear
sail artisan cache:clear
sail composer dump-autoload
```

---

## 🚀 Comandos Completos Frecuentes

### Instalación desde cero:

```bash
git clone [repo-url]
cd gestionoficina
cp .env.example .env
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs
sail up -d
sail artisan key:generate
sail artisan migrate:fresh --seed
sail npm install
sail npm run dev
```

### Reset completo de la aplicación:

```bash
sail down -v
sail up -d
sail artisan migrate:fresh --seed
sail artisan cache:clear
sail artisan config:clear
sail artisan route:clear
sail artisan view:clear
sail npm run dev
```

### Backup completo:

```bash
# Código
git push origin main

# Base de datos
sail exec mysql mysqldump -u sail -ppassword oficina_db > backup_$(date +%Y%m%d).sql

# Comprimir
tar -czf backup_$(date +%Y%m%d).tar.gz backup_$(date +%Y%m%d).sql
```

---

## 🐛 Solución de Problemas

### Puerto ocupado:

```bash
# Cambiar puerto en .env
APP_PORT=8080

# Reiniciar
sail down
sail up -d
```

### Permisos incorrectos:

```bash
sudo chown -R $USER:$USER .
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Contenedor no inicia:

```bash
# Ver logs de error
sail logs

# Reconstruir contenedor
sail down
sail build --no-cache
sail up -d
```

### MySQL no conecta:

```bash
# Verificar que esté corriendo
sail ps

# Reiniciar servicio
sail down
sail up -d mysql
```

### Composer lento:

```bash
# Usar prestissimo (paralelo)
sail composer global require hirak/prestissimo
```

---

## 📊 Monitoreo

```bash
# Ver uso de recursos
docker stats

# Ver espacio en disco
docker system df

# Limpiar todo Docker (⚠️ CUIDADO)
docker system prune -a

# Ver imágenes
docker images

# Ver volúmenes
docker volume ls
```

---

## 🎯 Tips Pro

```bash
# Ejecutar múltiples comandos en el mismo shell
sail shell -c "php artisan migrate && php artisan db:seed"

# Usar Tinker para debugging rápido
sail tinker
>>> User::count()
>>> Equipment::where('status', 'disponible')->get()

# Crear usuario admin rápidamente
sail tinker
>>> User::factory()->create(['email' => 'admin@test.com', 'role_id' => 1])

# Ver query log
sail tinker
>>> DB::enableQueryLog()
>>> User::all()
>>> DB::getQueryLog()
```

---

**💡 Tip:** Guarda este archivo en favoritos para consulta rápida!

---

**📅 Última actualización:** Noviembre 2025  
**� Equipo:** Yago Colombo, Gaston Heinz y Tomas Mattei
