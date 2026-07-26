<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        "role_id",
        "nama",
        "username",
        "username",
        "email",
        "no_hp",
        "password",
        "status",
    ];

    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected $casts = [
        "password" => "hashed",
        "status" => "boolean",
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? $this->attributes['nama'] ?? null;
    }

    public function setNameAttribute(?string $value): void
    {
        $this->attributes['name'] = $value;
        $this->attributes['nama'] = $value;
    }

    public function getWhatsappNumberAttribute(): ?string
    {
        return $this->attributes['whatsapp_number'] ?? $this->attributes['no_hp'] ?? null;
    }

    public function setWhatsappNumberAttribute(?string $value): void
    {
        $this->attributes['whatsapp_number'] = $value;
        $this->attributes['no_hp'] = $value;
    }

    public function getIsActiveAttribute(): bool
    {
        return (bool) ($this->attributes['is_active'] ?? $this->attributes['status'] ?? false);
    }

    public function setIsActiveAttribute($value): void
    {
        $this->attributes['is_active'] = (bool) $value;
        $this->attributes['status'] = (bool) $value;
    }

    public function getRoleLabelAttribute(): ?string
    {
        return $this->role?->nama_role;
    }

    public function isAdmin(): bool
    {
        return $this->role?->nama_role === 'Admin';
    }

    public function isManager(): bool
    {
        return in_array($this->role?->nama_role, ['Manager Teknik', 'Manager'], true);
    }

    public function isSopir(): bool
    {
        return $this->role?->nama_role === 'Sopir';
    }

    public function isMechanic(): bool
    {
        return $this->role?->nama_role === 'Mekanik';
    }

    public function scopeByRole($query, string $role)
    {
        $roleName = match (strtolower($role)) {
            'admin' => 'Admin',
            'manager', 'manager teknik' => 'Manager Teknik',
            'mechanic', 'mekanik' => 'Mekanik',
            'driver', 'sopir' => 'Sopir',
            default => $role,
        };

        return $query->whereHas('role', function ($roleQuery) use ($roleName) {
            $roleQuery->whereRaw('LOWER(nama_role) = ?', [strtolower($roleName)]);
        });
    }

    public function pemeriksaans(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(RiwayatServis::class, 'mekanik_id');
    }

    public function riwayatServisSebagaiMekanik(): HasMany
    {
        return $this->hasMany(RiwayatServis::class, "mekanik_id");
    }

    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }
}
