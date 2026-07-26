<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisServis extends Model
{
    protected $fillable = ['jenis_servis', 'keterangan'];

    public function jadwalServis(): HasMany
    {
        return $this->hasMany(JadwalServis::class);
    }
}
