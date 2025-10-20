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
        'role_id',
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

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function activeLoans()
    {
        return $this->hasMany(Loan::class)->where('status', 'activo');
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'requested_by');
    }

    public function assignedMaintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'assigned_to');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $code): bool
    {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }
        return $this->role && $this->role->code === $code;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isTrabajador(): bool
    {
        return $this->hasRole('trabajador');
    }

    public function isMantenimiento(): bool
    {
        return $this->hasRole('mantenimiento');
    }

    public function hasAnyRole(array $codes): bool
    {
        return is_object($this->role) && in_array($this->role?->code, $codes);
    }

    public function getRoleName(): ?string
    {
        return is_object($this->role) ? $this->role?->name : null;
    }
}