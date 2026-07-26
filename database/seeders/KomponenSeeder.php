<?php

namespace Database\Seeders;

use App\Models\KategoriKomponen;
use App\Models\Komponen;
use Illuminate\Database\Seeder;

class KomponenSeeder extends Seeder
{
    public function run(): void
    {
        $daftarKomponen = [
            "Mesin" => ["Mesin", "Sistem Kopling", "Transmisi"],
            "Kelistrikan" => ["Elektrikal"],
            "Body" => ["Body Kendaraan", "Kebersihan Kendaraan"],
            "Interior" => ["Sistem AC"],
            "Ban" => ["Roda-roda"],
            "Rem" => ["Sistem Rem"],
            "Keselamatan" => ["Sistem Kemudi (Steer)", "Sistem Pendingin", "Suspensi"],
        ];

        foreach ($daftarKomponen as $namaKategori => $komponens) {
            $kategori = KategoriKomponen::query()->where("nama_kategori", $namaKategori)->first();

            if (! $kategori) {
                continue;
            }

            foreach ($komponens as $namaKomponen) {
                Komponen::query()->updateOrCreate([
                    "kategori_komponen_id" => $kategori->id,
                    "nama_komponen" => $namaKomponen,
                ]);
            }
        }
    }
}
