<?php

namespace Database\Seeders;

use App\Models\JadwalServis;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotifikasiSeeder extends Seeder
{
    public function run(): void
    {
        $mekanikIds = User::query()->whereHas("role", fn ($q) => $q->where("nama_role", "Mekanik"))->pluck("id");

        if ($mekanikIds->isEmpty()) {
            return;
        }

        $jadwalServis = JadwalServis::query()->whereIn("status", ["Menunggu", "Proses"])->get();

        foreach ($jadwalServis as $jadwal) {
            $dikirimPada = fake()->optional(0.7)->dateTimeBetween("-1 week", "now") ?? now();

            Notifikasi::query()->create([
                "user_id" => $mekanikIds->random(),
                "jadwal_servis_id" => $jadwal->id,
                "judul" => "Reminder Jadwal Servis",
                "pesan" => "Jadwal servis armada akan dilaksanakan pada " . $jadwal->tanggal_servis->format("d-m-Y") . ".",
                "status" => fake()->randomElement(["pending", "terkirim", "gagal"]),
                "dikirim_pada" => $dikirimPada,
                // "dibaca" => fake()->boolean(40),
            ]);
        }
    }
}
