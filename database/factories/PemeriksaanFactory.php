<?php

namespace Database\Factories;

use App\Models\Armada;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PemeriksaanFactory extends Factory
{
    public function definition(): array
    {
        $jenis = fake()->randomElement(["AT3", "AT4"]);

        return [
            "nomor_laporan" => strtoupper($jenis) . "-" . now()->format("Ymd") . "-" . fake()->unique()->numerify("#####"),
            "armada_id" => fn () => Armada::query()->inRandomOrder()->value("id"),
            "user_id" => fn () => User::query()
                ->whereHas("role", fn ($q) => $q->where("nama_role", "Sopir"))
                ->inRandomOrder()
                ->value("id") ?? User::query()->inRandomOrder()->value("id"),
            "jenis" => $jenis,
            "tanggal" => fake()->dateTimeBetween("-2 months", "now"),
            "jam" => fake()->time("H:i:s"),
            "odometer_terakhir" => fake()->numberBetween(10000, 350000),
            "catatan" => fake()->optional()->sentence(),
            "status" => fake()->randomElement(["Draft", "Diajukan", "Disetujui", "Ditolak"]),
        ];
    }
}
