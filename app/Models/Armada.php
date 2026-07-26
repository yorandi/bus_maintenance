<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Armada extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "status_armada_id",
        "kode_armada",
        "registration_number",
        "nomor_polisi",
        "nomor_rangka",
        "nomor_mesin",
        "merk",
        "model",
        "tipe",
        "tahun_pembuatan",
        "tahun",
        "kapasitas_penumpang",
        "kapasitas",
        "date_operation_started",
        "odometer_terakhir",
        "status",
        "notes",
    ];

    protected function casts(): array
    {
        return [
            'date_operation_started' => 'date',
        ];
    }

    public function getRegistrationNumberAttribute(): ?string
    {
        return $this->attributes['registration_number'] ?? $this->attributes['nomor_polisi'] ?? null;
    }

    public function getNomorArmadaAttribute(): ?string
    {
        return $this->attributes['nomor_armada'] ?? $this->attributes['kode_armada'] ?? $this->attributes['nomor_polisi'] ?? null;
    }

    public function getStatusArmadaAttribute(): ?string
    {
        $statusName = $this->status_armada_id
            ? $this->statusArmada()->value('nama_status')
            : null;

        return match ($statusName) {
            'Operasional' => 'aktif',
            'Servis' => 'servis',
            'Rusak' => 'rusak',
            'Tidak Beroperasi' => 'tidak_beroperasi',
            default => $this->attributes['status_armada'] ?? null,
        };
    }

    public function setRegistrationNumberAttribute(?string $value): void
    {
        $this->attributes['registration_number'] = $value;
        $this->attributes['nomor_polisi'] = $value;
    }

    public function getModelAttribute(): ?string
    {
        return $this->attributes['model'] ?? $this->attributes['tipe'] ?? null;
    }

    public function setModelAttribute(?string $value): void
    {
        $this->attributes['model'] = $value;
        $this->attributes['tipe'] = $value;
    }

    public function getTahunPembuatanAttribute(): ?int
    {
        return $this->attributes['tahun_pembuatan'] ?? $this->attributes['tahun'] ?? null;
    }

    public function setTahunPembuatanAttribute(?int $value): void
    {
        $this->attributes['tahun_pembuatan'] = $value;
        $this->attributes['tahun'] = $value;
    }

    public function getKapasitasPenumpangAttribute(): ?int
    {
        return $this->attributes['kapasitas_penumpang'] ?? $this->attributes['kapasitas'] ?? null;
    }

    public function setKapasitasPenumpangAttribute(?int $value): void
    {
        $this->attributes['kapasitas_penumpang'] = $value;
        $this->attributes['kapasitas'] = $value;
    }

    public function getStatusAttribute(): ?string
    {
        if (! isset($this->attributes['status_armada_id'])) {
            return $this->attributes['status'] ?? null;
        }

        $statusName = $this->statusArmada()->value('nama_status');

        return match ($statusName) {
            'Operasional' => 'good',
            'Servis' => 'maintenance',
            'Rusak' => 'damaged',
            'Tidak Beroperasi' => 'inactive',
            default => $this->attributes['status'] ?? null,
        };
    }

    public function setStatusAttribute(?string $value): void
    {
        $statusName = match ($value) {
            'good' => 'Operasional',
            'maintenance' => 'Servis',
            'damaged' => 'Rusak',
            'inactive' => 'Tidak Beroperasi',
            default => $value,
        };

        $statusId = StatusArmada::query()->where('nama_status', $statusName)->value('id');

        if ($statusId) {
            $this->attributes['status_armada_id'] = $statusId;
        }

        $this->attributes['status'] = $value;
    }

    public function statusArmada(): BelongsTo
    {
        return $this->belongsTo(StatusArmada::class);
    }

    public function pemeriksaans(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function jadwalServis(): HasMany
    {
        return $this->hasMany(JadwalServis::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(JadwalServis::class);
    }

    public function records(): HasManyThrough
    {
        return $this->hasManyThrough(MaintenanceRecord::class, JadwalServis::class, 'armada_id', 'jadwal_servis_id');
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->whereHas('statusArmada', function ($statusQuery) use ($status) {
            $statusName = match ($status) {
                'good' => 'Operasional',
                'maintenance' => 'Servis',
                'damaged' => 'Rusak',
                'inactive' => 'Tidak Beroperasi',
                'aktif' => 'Operasional',
                'servis' => 'Servis',
                'rusak' => 'Rusak',
                'tidak_beroperasi' => 'Tidak Beroperasi',
                default => $status,
            };

            $statusQuery->where('nama_status', $statusName);
        });
    }

    public function scopeSearchNomor($query, ?string $search)
    {
        if (! filled($search)) {
            return $query;
        }

        return $query->where(function ($subQuery) use ($search) {
            $subQuery->where('kode_armada', 'like', '%' . $search . '%')
                ->orWhere('nomor_polisi', 'like', '%' . $search . '%')
                ->orWhere('registration_number', 'like', '%' . $search . '%');
        });
    }

    public function scopeStatus($query, ?string $status)
    {
        if (! filled($status)) {
            return $query;
        }

        return $this->scopeByStatus($query, $status);
    }
}
