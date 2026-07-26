<?php

namespace Database\Seeders;

use App\Models\KategoriKomponen;
use Illuminate\Database\Seeder;

class KategoriKomponenSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = ["Mesin", "Kelistrikan", "Body", "Interior", "Ban", "Rem", "Keselamatan"];

        foreach ($kategoris as $kategori) {
            KategoriKomponen::query()->updateOrCreate(["nama_kategori" => $kategori]);
        }
    }
}
