<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemeriksaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "nomor_laporan",
        "armada_id",
        "user_id",
        "jenis",
        "tanggal",
        "jam",
        "odometer_terakhir",
        "catatan",
        "status",
    ];

    protected function casts(): array
    {
        return [
            "tanggal" => "date",
        ];
    }

    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class);
    }

    public function sopir(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function pemeriksaanDetails(): HasMany
    {
        return $this->hasMany(PemeriksaanDetail::class);
    }
}
