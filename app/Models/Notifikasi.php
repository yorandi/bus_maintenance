<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $fillable = [
        "user_id",
        "jadwal_servis_id",
        "judul",
        "pesan",
        "status",
        "dikirim_pada",
        // "dibaca",
    ];

    protected function casts(): array
    {
        return [
            "status" => "string",
            "dikirim_pada" => "datetime",
            // "dibaca" => "boolean",
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalServis(): BelongsTo
    {
        return $this->belongsTo(JadwalServis::class);
    }
}
