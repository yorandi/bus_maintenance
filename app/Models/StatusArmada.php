<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusArmada extends Model
{
    protected $fillable = ['nama_status', 'deskripsi'];

    public function armadas(): HasMany
    {
        return $this->hasMany(Armada::class);
    }
}
