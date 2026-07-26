<?php

namespace Database\Seeders;

use App\Models\Komponen;
use App\Models\Pemeriksaan;
use App\Models\StatusKondisi;
use Illuminate\Database\Seeder;

class PemeriksaanSeeder extends Seeder
{
    public function run(): void
    {
        $komponens = Komponen::all();
        $statusKondisis = StatusKondisi::pluck("id");

        Pemeriksaan::factory()
            ->count(30)
            ->create()
            ->each(function (Pemeriksaan $pemeriksaan) use ($komponens, $statusKondisis) {
                foreach ($komponens as $komponen) {
                    $statusKondisiId = fake()->randomElement([
                        $statusKondisis[0], $statusKondisis[0], $statusKondisis[0],
                        $statusKondisis[1], $statusKondisis[2],
                    ]);

                    $pemeriksaan->pemeriksaanDetails()->create([
                        "komponen_id" => $komponen->id,
                        "status_kondisi_id" => $statusKondisiId,
                        "catatan" => fake()->optional(0.3)->sentence(),
                    ]);
                }
            });
    }
}
