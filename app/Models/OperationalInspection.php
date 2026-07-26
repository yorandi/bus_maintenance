<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class OperationalInspection extends Model
{
    use HasFactory;

    public const TYPE_AT3 = 'at3';
    public const TYPE_AT4 = 'at4';

    protected $table = 'pemeriksaans';

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'type',
        'odometer',
        'checklist',
        'complaint',
        'condition_result',
        'inspected_at',
    ];

    protected $casts = [
        'checklist' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $inspection): void {
            if (empty($inspection->nomor_laporan)) {
                $prefix = strtoupper($inspection->jenis ?? ($inspection->type === self::TYPE_AT4 ? 'AT4' : 'AT3'));
                $inspection->nomor_laporan = $prefix . '-' . now()->format('YmdHis') . '-' . random_int(100, 999);
            }

            $inspection->jenis = $inspection->jenis ?? strtoupper($inspection->type ?? self::TYPE_AT3);
            $inspection->tanggal = $inspection->tanggal ?? now()->toDateString();
            $inspection->jam = $inspection->jam ?? now()->format('H:i:s');
            $inspection->status = $inspection->status ?? json_encode($inspection->checklist ?? [], JSON_UNESCAPED_UNICODE);
        });
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'armada_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getVehicleIdAttribute(): ?int
    {
        return $this->attributes['vehicle_id'] ?? $this->attributes['armada_id'] ?? null;
    }

    public function setVehicleIdAttribute(?int $value): void
    {
        $this->attributes['vehicle_id'] = $value;
        $this->attributes['armada_id'] = $value;
    }

    public function getDriverIdAttribute(): ?int
    {
        return $this->attributes['driver_id'] ?? $this->attributes['user_id'] ?? null;
    }

    public function setDriverIdAttribute(?int $value): void
    {
        $this->attributes['driver_id'] = $value;
        $this->attributes['user_id'] = $value;
    }

    public function getTypeAttribute(): string
    {
        $jenis = strtoupper($this->attributes['jenis'] ?? 'AT3');

        return $jenis === 'AT4' ? self::TYPE_AT4 : self::TYPE_AT3;
    }

    public function setTypeAttribute(?string $value): void
    {
        $type = strtolower((string) $value);
        $this->attributes['type'] = $type;
        $this->attributes['jenis'] = $type === self::TYPE_AT4 ? 'AT4' : 'AT3';
    }

    public function getOdometerAttribute(): ?int
    {
        return isset($this->attributes['odometer']) ? (int) $this->attributes['odometer'] : (isset($this->attributes['odometer_terakhir']) ? (int) $this->attributes['odometer_terakhir'] : null);
    }

    public function setOdometerAttribute(?int $value): void
    {
        $this->attributes['odometer'] = $value;
        $this->attributes['odometer_terakhir'] = $value;
    }

    public function getChecklistAttribute(): array
    {
        $raw = $this->attributes['checklist'] ?? $this->attributes['status'] ?? '[]';

        if (is_array($raw)) {
            return $raw;
        }

        $decoded = json_decode((string) $raw, true);

        return is_array($decoded) ? $decoded : [];
    }

    public function setChecklistAttribute($value): void
    {
        $array = is_array($value) ? $value : [];
        $json = json_encode($array, JSON_UNESCAPED_UNICODE);

        $this->attributes['checklist'] = $json;
        $this->attributes['status'] = $json;
    }

    public function getComplaintAttribute(): ?string
    {
        return $this->attributes['complaint'] ?? $this->attributes['catatan'] ?? null;
    }

    public function setComplaintAttribute(?string $value): void
    {
        $this->attributes['complaint'] = $value;
        $this->attributes['catatan'] = $value;
    }

    public function getConditionResultAttribute(): string
    {
        return $this->attributes['condition_result'] ?? 'siap_operasi';
    }

    public function setConditionResultAttribute(?string $value): void
    {
        $this->attributes['condition_result'] = $value ?? 'siap_operasi';
    }

    public function getInspectedAtAttribute(): Carbon
    {
        if (!empty($this->attributes['inspected_at'])) {
            return Carbon::parse($this->attributes['inspected_at']);
        }

        $date = $this->attributes['tanggal'] ?? now()->toDateString();
        $time = $this->attributes['jam'] ?? '00:00:00';

        return Carbon::parse($date . ' ' . $time);
    }

    public function setInspectedAtAttribute($value): void
    {
        $dateTime = $value ? Carbon::parse($value) : now();
        $this->attributes['inspected_at'] = $dateTime;
        $this->attributes['tanggal'] = $dateTime->toDateString();
        $this->attributes['jam'] = $dateTime->format('H:i:s');
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === self::TYPE_AT4 ? 'AT/4' : 'AT/3';
    }

    public function getConditionLabelAttribute(): string
    {
        return match ($this->condition_result) {
            'perlu_perbaikan' => 'Perlu Perbaikan',
            'tidak_layak' => 'Tidak Layak',
            default => 'Siap Operasi',
        };
    }

    public function getHistoriesAttribute(): Collection
    {
        return collect();
    }

    public function getChecklistLabel(string $component): string
    {
        return str_replace('_', ' ', ucfirst($component));
    }

    public function getChecklistStatusLabel(string $status): string
    {
        return match ($status) {
            'rusak' => 'Rusak',
            'perlu_perbaikan' => 'Perlu Perbaikan',
            default => 'Baik',
        };
    }
}
