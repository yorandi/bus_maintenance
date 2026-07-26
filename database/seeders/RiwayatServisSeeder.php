<?php

namespace Database\Seeders;

use App\Models\JadwalServis;
use App\Models\RiwayatServis;
use Illuminate\Database\Seeder;

class RiwayatServisSeeder extends Seeder
{
    public function run(): void
    {
        $jadwalSelesai = JadwalServis::query()->where("status", "Selesai")->get();

        foreach ($jadwalSelesai as $jadwal) {
            RiwayatServis::factory()->create([
                "jadwal_servis_id" => $jadwal->id,
            ]);
        }

        RiwayatServis::factory()->count(5)->create();
    }
}
