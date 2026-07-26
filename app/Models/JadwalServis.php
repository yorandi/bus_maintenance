<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class JadwalServis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jadwal_servis';

    protected $fillable = [
        "armada_id",
        "vehicle_id",
        "jenis_servis_id",
        "service_type",
        "tanggal_servis",
        "scheduled_date",
        "km_servis",
        "status",
        "status_penjadwalan",
        "prioritas",
        "assigned_mechanic",
        "keterangan",
        "description",
    ];

    protected function casts(): array
    {
        return [
            "tanggal_servis" => "date",
        ];
    }

    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Armada::class, 'armada_id');
    }

    public function jenisServis(): BelongsTo
    {
        return $this->belongsTo(JenisServis::class);
    }

    public function getScheduledDateAttribute()
    {
        $value = $this->attributes['scheduled_date'] ?? $this->attributes['tanggal_servis'] ?? null;

        return $value ? Carbon::parse($value) : null;
    }

    public function setScheduledDateAttribute($value): void
    {
        $this->attributes['scheduled_date'] = $value;
        $this->attributes['tanggal_servis'] = $value;
    }

    public function getServiceTypeAttribute(): ?string
    {
        return $this->attributes['service_type'] ?? $this->jenisServis?->jenis_servis ?? null;
    }

    public function getTanggalServisBerikutnyaAttribute()
    {
        return $this->getScheduledDateAttribute();
    }

    public function getTanggalServisTerakhirAttribute()
    {
        $value = $this->attributes['tanggal_servis_terakhir'] ?? null;

        return $value ? Carbon::parse($value) : null;
    }

    public function getStatusServisAttribute(): ?string
    {
        if (! empty($this->attributes['status_penjadwalan'])) {
            return match ($this->attributes['status_penjadwalan']) {
                'tepat waktu', 'tepat_waktu' => 'tepat_waktu',
                'mendekati jatuh tempo', 'mendekati_jatuh_tempo' => 'mendekati_jatuh_tempo',
                'terlambat' => 'terlambat',
                default => 'tepat_waktu',
            };
        }

        if (! $this->scheduled_date) {
            return 'tepat_waktu';
        }

        $daysDiff = now()->startOfDay()->diffInDays($this->scheduled_date->copy()->startOfDay(), false);

        if ($daysDiff < 0) {
            return 'terlambat';
        }

        if ($daysDiff <= 7) {
            return 'mendekati_jatuh_tempo';
        }

        return 'tepat_waktu';
    }

    public function setServiceTypeAttribute(?string $value): void
    {
        $this->attributes['service_type'] = $value;
    }

    public function getStatusAttribute(): ?string
    {
        return match ($this->attributes['status'] ?? null) {
            'Menunggu' => 'pending',
            'Proses' => 'in_progress',
            'Selesai' => 'completed',
            'Dibatalkan' => 'cancelled',
            default => $this->attributes['status'] ?? null,
        };
    }

    public function setStatusAttribute(?string $value): void
    {
        $this->attributes['status'] = match ($value) {
            'pending' => 'Menunggu',
            'in_progress' => 'Proses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $value,
        };
    }

    public function getAssignedMechanicAttribute(): ?string
    {
        return $this->attributes['assigned_mechanic'] ?? null;
    }

    public function setAssignedMechanicAttribute(?string $value): void
    {
        $this->attributes['assigned_mechanic'] = $value;
    }

    public function getMechanicNameAttribute(): ?string
    {
        return $this->attributes['mechanic_name'] ?? $this->attributes['assigned_mechanic'] ?? null;
    }

    public function setMechanicNameAttribute(?string $value): void
    {
        $this->attributes['mechanic_name'] = $value;
        $this->attributes['assigned_mechanic'] = $value;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->attributes['description'] ?? $this->attributes['keterangan'] ?? null;
    }

    public function setDescriptionAttribute(?string $value): void
    {
        $this->attributes['description'] = $value;
        $this->attributes['keterangan'] = $value;
    }

    public function scopeTanggal($query, ?string $tanggal)
    {
        if (! filled($tanggal)) {
            return $query;
        }

        return $query->whereDate('scheduled_date', $tanggal)->orWhereDate('tanggal_servis', $tanggal);
    }

    public function riwayatServis(): HasMany
    {
        return $this->hasMany(RiwayatServis::class);
    }

    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }
}
