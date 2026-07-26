<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KondisiArmada extends Pemeriksaan
{
    protected $table = 'pemeriksaans';

    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class, 'armada_id');
    }

    public function getKondisiAttribute(): ?string
    {
        return match ($this->attributes['status'] ?? null) {
            'Draft', 'Diajukan' => 'baik',
            'Disetujui' => 'perlu_perbaikan',
            'Ditolak' => 'rusak',
            default => $this->attributes['kondisi'] ?? null,
        };
    }

    public function getTanggalPemeriksaanAttribute()
    {
        return $this->attributes['tanggal_pemeriksaan'] ?? $this->tanggal ?? null;
    }

    public function getCatatanKerusakanAttribute(): ?string
    {
        return $this->attributes['catatan_kerusakan'] ?? $this->catatan ?? null;
    }

    public function scopeKondisi($query, ?string $kondisi)
    {
        if (! filled($kondisi)) {
            return $query;
        }

        return $query->where('status', ucfirst(str_replace('_', ' ', $kondisi)));
    }

    public function scopeTanggal($query, ?string $tanggal)
    {
        if (! filled($tanggal)) {
            return $query;
        }

        return $query->whereDate('tanggal', $tanggal);
    }
}
