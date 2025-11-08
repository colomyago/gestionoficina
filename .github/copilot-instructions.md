# Copilot Instructions - Sistema de Gestión de Oficina

## Project Overview
Laravel 12 + Filament 4.0 office equipment management system with role-based access control. Workers request equipment loans, admins approve them, and maintenance staff handle repairs. Runs on Laravel Sail + Docker.

## Architecture & Key Components

### Role System (3 roles)
- **Admin (`admin`)**: Full CRUD, approves loans, manages users, views all data
- **Trabajador (`trabajador`)**: Requests loans, returns equipment, reports problems
- **Mantenimiento (`mantenimiento`)**: Handles maintenance requests, repairs/decommissions equipment

Role checks use model methods: `$user->isAdmin()`, `$user->isTrabajador()`, `$user->isMantenimiento()`. These check the `users.role_id` FK to the `roles` table (`roles.code` field).

### Core Domain Models
- **Equipment**: States are `disponible`, `prestado`, `mantenimiento`, `baja` (enum in migration)
- **Loan**: States are `pendiente`, `rechazado`, `activo`, `devuelto` (enum in migration)
- **MaintenanceRequest**: States are `pendiente`, `en_proceso`, `completado`, `rechazado` (enum)

Status field validation uses database-level enums. When modifying status values, update migrations and model scopes together.

### Filament Resources Structure
Resources are role-scoped via `canViewAny()` and `->visible()` modifiers:
- `MisEquiposResource`: Worker's assigned equipment (filtered by `user_id`)
- `SolicitudPrestamoResource`: Worker's loan requests (filtered by `user_id`)
- `GestionSolicitudesResource`: Admin-only, all loan requests
- `MantenimientoResource`: Maintenance staff + Admin

Use `Auth::user()->isAdmin()` in `->visible(fn () => ...)` to conditionally show form fields/actions.

### Key Workflows
1. **Loan request flow**: Worker creates Loan (`pendiente`) → Admin approves → Status changes to `activo`, Equipment becomes `prestado` → Worker returns → Equipment becomes `disponible`, Loan becomes `devuelto`
2. **Direct assignment**: Admin can assign equipment without prior request via table actions
3. **Maintenance flow**: Equipment breaks → Worker reports via "Reportar Problema" action → Creates MaintenanceRequest, Equipment becomes `mantenimiento`, auto-returns active loan → Maintenance staff repairs or decommissions

### Authorization Pattern
Policies in `app/Policies/` registered in `AppServiceProvider::boot()`. Use Laravel Gates:
```php
Gate::policy(Equipment::class, EquipmentPolicy::class);
```
Filament actions check policies automatically. Custom checks use `$user->can('update', $record)`.

## Development Workflows

### Running the Application
```bash
# Always use Sail commands (not bare php/artisan)
./vendor/bin/sail up -d
./vendor/bin/sail npm run dev

# Access points:
# - http://localhost (public view)
# - http://localhost/admin (Filament admin panel)
```

### Database Operations
```bash
# Fresh migration + seed test users
./vendor/bin/sail artisan migrate:fresh --seed

# Test users (password: password123):
# - admin@gestionoficina.com (Admin)
# - carlos@gestionoficina.com (Trabajador)
# - pedro@gestionoficina.com (Mantenimiento)
```

### Creating Filament Resources
When adding resources, follow existing patterns:
1. Create resource with table actions filtered by role
2. Add `canViewAny()` method for resource-level access
3. Use `->visible(fn () => Auth::user()->hasRole('...'))` for conditional UI
4. Register in navigation with appropriate sort order
5. Add Spanish translations to `lang/es.json`

### Testing
```bash
./vendor/bin/sail artisan test
# Or via composer script:
./vendor/bin/sail composer test
```

## Project Conventions

### Translation Keys
All UI strings use Laravel's translation system. English keys in code, Spanish values in `lang/es.json`:
```php
->label(__('Device name'))  // Resolves to "Nombre del dispositivo"
```

### Status Badge Colors (Filament)
Use consistent badge colors across resources:
- `pendiente`: warning (yellow)
- `activo`/`disponible`: success (green)
- `rechazado`/`baja`: danger (red)
- `mantenimiento`/`en_proceso`: info (blue)
- `devuelto`/`completado`: gray

### Query Scopes
Models define common query scopes:
```php
Loan::pending()->get();  // ->where('status', 'pendiente')
Loan::active()->get();   // ->where('status', 'activo')
```
Use these instead of raw where clauses.

### Table Actions Visibility
Always scope actions to current record state:
```php
->visible(fn ($record): bool => 
    $record->status === 'prestado' && Auth::user()->isAdmin()
)
```

## Important Files
- `docs/SISTEMA_ROLES.md`: Role capabilities reference
- `docs/FLUJO_COMPLETO_SISTEMA.md`: Complete workflow documentation
- `docs/COMANDOS_SAIL.md`: Sail command reference
- `app/Providers/Filament/AdminPanelProvider.php`: Panel configuration, widget registration
- `app/Policies/`: Authorization logic for all models
- `database/seeders/RoleSeeder.php`: Test user generation

## Common Gotchas
- Equipment assignment creates a Loan record even without prior request (Admin direct assignment)
- Returning equipment auto-updates both Loan (`devuelto`) and Equipment (`disponible`) status
- Reporting problems auto-returns the equipment before creating MaintenanceRequest
- Navigation badges show pending items count (role-filtered)
- Filament auto-discovery enabled; new resources/widgets appear automatically
- Spanish is the primary language; all user-facing text must have translations
