<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRecord extends RiwayatServis
{
    protected $table = 'riwayat_servis';

    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mechanic_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Armada::class, 'vehicle_id');
    }
}
