<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class RiwayatServis extends Model
{
    use HasFactory;

    protected $table = 'riwayat_servis';

    protected $fillable = [
        "jadwal_servis_id",
        "schedule_id",
        "vehicle_id",
        "mekanik_id",
        "mechanic_id",
        "tanggal_servis",
        "maintenance_date",
        "service_type",
        "biaya",
        "cost",
        "pekerjaan",
        "description",
        "parts_used",
        "odometer_reading",
        "catatan",
        "notes",
    ];

    protected function casts(): array
    {
        return [
            "tanggal_servis" => "date",
            "biaya" => "decimal:2",
        ];
    }

    public function jadwalServis(): BelongsTo
    {
        return $this->belongsTo(JadwalServis::class);
    }

    public function mekanik(): BelongsTo
    {
        return $this->belongsTo(User::class, "mechanic_id");
    }

    public function getScheduleIdAttribute(): ?int
    {
        return $this->attributes['schedule_id'] ?? $this->attributes['jadwal_servis_id'] ?? null;
    }

    public function setScheduleIdAttribute($value): void
    {
        $this->attributes['schedule_id'] = $value;
        $this->attributes['jadwal_servis_id'] = $value;
    }

    public function getMechanicIdAttribute(): ?int
    {
        return $this->attributes['mechanic_id'] ?? $this->attributes['mekanik_id'] ?? null;
    }

    public function setMechanicIdAttribute($value): void
    {
        $this->attributes['mechanic_id'] = $value;
        $this->attributes['mekanik_id'] = $value;
    }

    public function getMaintenanceDateAttribute()
    {
        $value = $this->attributes['maintenance_date'] ?? $this->attributes['tanggal_servis'] ?? null;

        return $value ? Carbon::parse($value) : null;
    }

    public function setMaintenanceDateAttribute($value): void
    {
        $this->attributes['maintenance_date'] = $value;
        $this->attributes['tanggal_servis'] = $value;
    }

    public function getCostAttribute()
    {
        return $this->attributes['cost'] ?? $this->attributes['biaya'] ?? 0;
    }

    public function setCostAttribute($value): void
    {
        $this->attributes['cost'] = $value;
        $this->attributes['biaya'] = $value;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->attributes['description'] ?? $this->attributes['pekerjaan'] ?? null;
    }

    public function setDescriptionAttribute(?string $value): void
    {
        $this->attributes['description'] = $value;
        $this->attributes['pekerjaan'] = $value;
    }

    public function getNotesAttribute(): ?string
    {
        return $this->attributes['notes'] ?? $this->attributes['catatan'] ?? null;
    }

    public function setNotesAttribute(?string $value): void
    {
        $this->attributes['notes'] = $value;
        $this->attributes['catatan'] = $value;
    }

    public function getTanggalPemeliharaanAttribute()
    {
        return $this->maintenance_date;
    }

    public function getJenisPemeliharaanAttribute(): ?string
    {
        return $this->attributes['jenis_pemeliharaan'] ?? $this->service_type ?? null;
    }

    public function getDeskripsiPekerjaanAttribute(): ?string
    {
        return $this->description;
    }

    public function getStatusPekerjaanAttribute(): ?string
    {
        if (! empty($this->attributes['status_pekerjaan'])) {
            return $this->attributes['status_pekerjaan'];
        }

        $status = $this->jadwalServis?->status;

        return match ($status) {
            'completed' => 'selesai',
            'cancelled' => 'ditunda',
            'in_progress', 'pending' => 'dalam_proses',
            default => null,
        };
    }

    public function getStatusPemeliharaanAttribute(): ?string
    {
        return $this->status_pekerjaan;
    }

    public function scopeTanggal($query, ?string $tanggal)
    {
        if (! filled($tanggal)) {
            return $query;
        }

        return $query->where(function ($subQuery) use ($tanggal) {
            $subQuery->whereDate('maintenance_date', $tanggal)
                ->orWhereDate('tanggal_servis', $tanggal);
        });
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(JadwalServis::class, 'jadwal_servis_id');
    }
}
