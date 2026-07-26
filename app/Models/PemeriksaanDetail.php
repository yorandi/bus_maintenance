<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemeriksaanDetail extends Model
{
    protected $fillable = [
        "pemeriksaan_id",
        "komponen_id",
        "status_kondisi_id",
        "catatan",
        "foto",
    ];

    public function pemeriksaan(): BelongsTo
    {
        return $this->belongsTo(Pemeriksaan::class);
    }

    public function komponen(): BelongsTo
    {
        return $this->belongsTo(Komponen::class);
    }

    public function statusKondisi(): BelongsTo
    {
        return $this->belongsTo(StatusKondisi::class);
    }
}
