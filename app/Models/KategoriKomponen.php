<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKomponen extends Model
{
    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function komponens(): HasMany
    {
        return $this->hasMany(Komponen::class);
    }
}
