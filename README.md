# 🏢 Sistema de Gestión de Oficina

[![Laravel](https://img.shields.io/badge/Laravel-12-red)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-4.0-orange)](https://filamentphp.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-blue)](https://mysql.com)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

> Sistema web completo para la gestión de equipos, préstamos y mantenimiento en oficinas. Proyecto desarrollado para Gestión de Desarrollo de Software.

---

## 📋 Descripción

Sistema de gestión integral que permite controlar equipos de oficina, gestionar préstamos a trabajadores y administrar solicitudes de mantenimiento. Implementa un sistema de roles con permisos diferenciados para Administradores, Trabajadores y Técnicos de Mantenimiento.

### ✨ Características Principales

- 🖥️ **Gestión de Equipos:** CRUD completo con control de estados
- 👥 **Sistema de Roles:** Admin, Trabajador, Mantenimiento
- 📋 **Préstamos:** Solicitudes, aprobaciones y devoluciones
- 🔧 **Mantenimiento:** Gestión de reparaciones y bajas
- 📊 **Dashboard:** Estadísticas y widgets personalizados por rol
- 🔐 **Seguridad:** Autenticación y autorización con políticas
- 🌐 **Multiidioma:** Soporte para Español e Inglés
- 🤖 **IA Integrada:** Google Gemini API

---

## 🚀 Inicio Rápido

### Requisitos Previos

- Docker Desktop instalado y corriendo
- WSL2 (para Windows)
- Git
- Al menos 4GB de RAM libre

### Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/colomyago/gestionoficina.git
cd gestionoficina

# 2. Copiar variables de entorno
cp .env.example .env

# 3. Instalar dependencias (primera vez)
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

# 4. Iniciar contenedores con Sail
./vendor/bin/sail up -d

# 5. Generar clave de aplicación
./vendor/bin/sail artisan key:generate

# 6. Ejecutar migraciones y seeders
./vendor/bin/sail artisan migrate:fresh --seed

# 7. Instalar dependencias de Node.js
./vendor/bin/sail npm install

# 8. Compilar assets
./vendor/bin/sail npm run dev
```

### Acceder a la Aplicación

- **Web:** http://localhost
- **Panel Admin:** http://localhost/admin
- **Mailpit:** http://localhost:8025

### Usuarios de Prueba

| Email | Rol | Contraseña |
|-------|-----|------------|
| admin@gestionoficina.com | Admin | password123 |
| carlos@gestionoficina.com | Trabajador | password123 |
| pedro@gestionoficina.com | Mantenimiento | password123 |

---

## 📚 Documentación

Toda la documentación está disponible en la carpeta `docs/`:

- 📖 [**Instalación Completa**](docs/INSTALACION.md) - Guía detallada con Sail
- 📘 [**Proyecto TFI**](docs/PROYECTO_TFI.md) - Documentación académica completa
- 🔐 [**Sistema de Roles**](docs/SISTEMA_ROLES.md) - Roles y permisos
- 🔄 [**Flujos del Sistema**](docs/FLUJO_COMPLETO_SISTEMA.md) - Diagramas y casos de uso
- 🛠️ [**Guía de Implementación**](docs/GUIA_IMPLEMENTACION.md) - Detalles técnicos

---

## 🏗️ Arquitectura

### Stack Tecnológico

**Backend:**
- Laravel 12 (PHP 8.2+)
- MySQL 8.0
- Laravel Sail (Docker)

**Frontend:**
- Filament 4.0
- Tailwind CSS 4.0
- Vite
- Alpine.js + Livewire

**Servicios:**
- Google Gemini API
- Mailpit (desarrollo)

### Estructura del Proyecto

```
gestionoficina/
├── app/
│   ├── Filament/          # Recursos y Widgets de Filament
│   ├── Models/            # Modelos Eloquent
│   ├── Policies/          # Políticas de autorización
│   └── Services/          # Servicios (Gemini)
├── database/
│   ├── migrations/        # Migraciones
│   └── seeders/           # Datos de prueba
├── docs/                  # Documentación completa
└── tests/                 # Tests unitarios
```

---

## 👥 Sistema de Roles

### 🔴 Administrador
- CRUD completo de usuarios, equipos y roles
- Aprobar/rechazar solicitudes de préstamos
- Asignar equipos directamente
- Gestionar mantenimiento
- Acceso a todas las estadísticas

### 🟡 Trabajador
- Solicitar préstamos de equipos
- Ver sus equipos asignados
- Devolver equipos
- Reportar problemas
- Ver su historial

### 🟢 Mantenimiento
- Ver solicitudes de mantenimiento
- Tomar y resolver solicitudes
- Marcar equipos como reparados
- Dar de baja equipos irreparables

---

## 🛠️ Comandos Útiles con Sail

```bash
# Crear alias (opcional pero recomendado)
echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc
source ~/.bashrc

# Gestión de contenedores
sail up -d              # Iniciar
sail down               # Detener
sail logs -f            # Ver logs

# Artisan
sail artisan migrate    # Ejecutar migraciones
sail artisan tinker     # REPL de Laravel
sail artisan test       # Ejecutar tests

# Composer y NPM
sail composer install   # Instalar dependencias PHP
sail npm install        # Instalar dependencias Node

# Base de datos
sail mysql              # Acceder a MySQL
```

---

## 🧪 Testing

```bash
# Ejecutar todos los tests
sail artisan test

# Con cobertura
sail artisan test --coverage

# Tests específicos
sail artisan test --filter NombreDelTest
```

---

## 📊 Modelos y Relaciones

- **User** → hasMany → Equipment, Loans, MaintenanceRequests
- **Role** → hasMany → Users
- **Equipment** → belongsTo → User, hasMany → Loans, MaintenanceRequests
- **Loan** → belongsTo → User, Equipment
- **MaintenanceRequest** → belongsTo → Equipment, User (requested_by, assigned_to)

---

## 🔄 Flujos Principales

### Préstamo de Equipo
```
Trabajador solicita → Admin aprueba → Equipo prestado → Trabajador devuelve
```

### Mantenimiento
```
Usuario reporta → Técnico toma → Repara/Da de baja → Equipo disponible/baja
```

---

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## 📝 Changelog

### v1.0.0 - Noviembre 2025
- ✅ Sistema de roles completo
- ✅ Gestión de equipos y préstamos
- ✅ Sistema de mantenimiento
- ✅ Dashboard personalizado
- ✅ Multiidioma (ES/EN)

---

## 👨‍💻 Autores

**Yago Colombo** - Desarrollador Principal  
**Gaston Heinz** - Desarrollador  
**Tomas Mattei** - Desarrollador  

- Email: colomboyago0@gmail.com
- GitHub: [@colomyago](https://github.com/colomyago)
- Proyecto: [gestionoficina](https://github.com/colomyago/gestionoficina)

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---

## 🙏 Agradecimientos

- [Laravel](https://laravel.com) - Framework PHP
- [Filament](https://filamentphp.com) - Admin Panel
- [Tailwind CSS](https://tailwindcss.com) - CSS Framework
- [Heroicons](https://heroicons.com) - Iconografía

---

## 📞 Soporte

Si tienes problemas o preguntas:

1. Revisa la [documentación](docs/)
2. Consulta los [issues existentes](https://github.com/colomyago/gestionoficina/issues)
3. Crea un nuevo issue si es necesario

---
