<?php

namespace Database\Factories;

use App\Models\Armada;
use App\Models\JenisServis;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalServisFactory extends Factory
{
    public function definition(): array
    {
        return [
            "vehicle_id" => fn () => Armada::query()->inRandomOrder()->value("id"),
            "armada_id" => fn () => Armada::query()->inRandomOrder()->value("id"),
            "jenis_servis_id" => fn () => JenisServis::query()->inRandomOrder()->value("id"),
            "service_type" => fn () => JenisServis::query()->inRandomOrder()->value("jenis_servis") ?? "Servis Berkala",
            "scheduled_date" => fake()->dateTimeBetween("-1 month", "+2 months"),
            "tanggal_servis" => fake()->dateTimeBetween("-1 month", "+2 months"),
            "km_servis" => fake()->numberBetween(10000, 350000),
            "status" => fake()->randomElement(["Menunggu", "Proses", "Selesai", "Dibatalkan"]),
            "prioritas" => fake()->randomElement(["Rendah", "Sedang", "Tinggi"]),
            "assigned_mechanic" => fake()->optional()->name(),
            "keterangan" => fake()->optional()->sentence(),
        ];
    }
}
