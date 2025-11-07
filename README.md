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

### Usuarios de Prueba

| Email | Rol | Contraseña |
|-------|-----|------------|
| admin@gestionoficina.com | Admin | password123 |
| carlos@gestionoficina.com | Trabajador | password123 |
| pedro@gestionoficina.com | Mantenimiento | password123 |

---

## 📚 Documentacion

Toda la documentación está disponible en la carpeta `docs/`:

- 📖 [**Instalación Completa**](docs/installing.md) - Guía detallada con Sail
- � [**SRS - Especificación de Requisitos**](docs/srs-gestionoficina.md) - Requisitos funcionales y no funcionales (IEEE 830)
- �📘 [**Proyecto TFI**](docs/PROYECTO_TFI.md) - Documentación académica completa
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

## 🎓 Aprendizajes y Conclusiones

### ✅ Lo que Logramos

Durante el desarrollo de este proyecto, conseguimos implementar un sistema completo y funcional que cumple con todos los objetivos planteados:

- **Sistema de roles robusto:** Implementación exitosa de 3 roles (Admin, Trabajador, Mantenimiento) con permisos granulares usando Políticas de Laravel
- **Flujos completos:** Gestión end-to-end de préstamos y mantenimiento con estados bien definidos
- **Interfaz moderna:** Uso de Filament 4.0 para una UI intuitiva y responsive
- **Trazabilidad 100%:** Historial completo de todas las operaciones con timestamps y relaciones
- **Arquitectura escalable:** Código modular siguiendo principios SOLID y MVC

### 💡 Desafíos Superados

Los principales desafíos que enfrentamos y cómo los resolvimos:

1. **Integración de Filament 4.0**
   - Problema: Filament 4.0 era una versión reciente con cambios significativos en la API
   - Solución: Estudio profundo de la documentación oficial y uso de Resources personalizados

2. **Gestión de estados de equipos**
   - Problema: Múltiples estados y transiciones complejas (disponible → prestado → mantenimiento → baja)
   - Solución: Implementación de scopes en modelos y validaciones estrictas en las transiciones

3. **Control de permisos por rol**
   - Problema: Cada rol necesita ver y hacer cosas diferentes
   - Solución: Políticas de Laravel + métodos `canViewAny()` y `shouldRegisterNavigation()` en Resources

4. **Configuración de Docker con Sail**
   - Problema: Configuración inicial compleja para desarrollo local
   - Solución: Documentación detallada paso a paso y uso de Sail para simplificar comandos

### 🚧 Lo que Quedó Pendiente

Funcionalidades que nos gustaría implementar en futuras versiones:

- **Notificaciones en tiempo real:** Usar Laravel Broadcasting para alertas de préstamos vencidos
- **Exportación de reportes:** Generar PDFs con historial de préstamos y mantenimientos
- **Sistema de QR:** Códigos QR en equipos para escaneo rápido
- **Dashboard avanzado:** Más gráficos y estadísticas predictivas con IA
- **API REST:** Para integración con aplicaciones móviles
- **Tests automatizados:** Mayor cobertura de pruebas unitarias e integración

### 📊 Lecciones Aprendidas

- **Documentación es clave:** Una buena documentación ahorra tiempo y facilita el onboarding
- **Docker simplifica:** Sail nos permitió trabajar en entornos consistentes sin problemas de "en mi máquina funciona"
- **Filament acelera desarrollo:** Reducción del 70% en tiempo de desarrollo de CRUDs y dashboards
- **Scrum funciona:** Sprints de 2 semanas con daily standups mejoraron la coordinación del equipo
- **Git Flow es esencial:** Branching strategy clara evitó conflictos de merge

### 🎯 Cumplimiento de Objetivos

| Objetivo SMART | Estado | Métrica |
|----------------|--------|---------|
| Sistema funcional al 100% | ✅ Completado | 30/30 requisitos implementados |
| Reducir tiempo de búsqueda 80% | ✅ Completado | Sistema automático vs manual |
| Trazabilidad 100% | ✅ Completado | Historial completo con timestamps |
| 3 roles diferenciados | ✅ Completado | Admin, Trabajador, Mantenimiento |
| Deploy con Docker | ✅ Completado | Docker Compose + Sail |

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
