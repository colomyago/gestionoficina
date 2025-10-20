<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Corregir el nombre del método a equipments() en plural
    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    // Préstamos activos del usuario
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // Préstamos activos
    public function activeLoans()
    {
        return $this->hasMany(Loan::class)->where('status', 'activo');
    }

    // Solicitudes de mantenimiento creadas por el usuario
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'requested_by');
    }

    // Solicitudes de mantenimiento asignadas al usuario (si es de mantenimiento)
    public function assignedMaintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'assigned_to');
    }

    // Métodos helper para verificar roles
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTrabajador()
    {
        return $this->role === 'trabajador';
    }

    public function isMantenimiento()
    {
        return $this->role === 'mantenimiento';
    }
}
