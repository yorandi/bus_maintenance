<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemeliharaan extends RiwayatServis
{
    protected $table = 'riwayat_servis';

    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class, 'vehicle_id');
    }

    public function mekanik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mechanic_id');
    }
}
