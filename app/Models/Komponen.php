<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komponen extends Model
{
    protected $fillable = [
        "kategori_komponen_id",
        "nama_komponen",
        "keterangan",
    ];

    public function kategoriKomponen(): BelongsTo
    {
        return $this->belongsTo(KategoriKomponen::class);
    }

    public function pemeriksaanDetails(): HasMany
    {
        return $this->hasMany(PemeriksaanDetail::class);
    }
}
