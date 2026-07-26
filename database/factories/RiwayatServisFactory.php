<?php

namespace Database\Factories;

use App\Models\Armada;
use App\Models\JadwalServis;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiwayatServisFactory extends Factory
{
    public function definition(): array
    {
        return [
            "vehicle_id" => fn () => Armada::query()->inRandomOrder()->value("id"),
            "schedule_id" => fn () => JadwalServis::query()->inRandomOrder()->value("id"),
            "jadwal_servis_id" => fn () => JadwalServis::query()->inRandomOrder()->value("id"),
            "mechanic_id" => fn () => User::query()
                ->whereHas("role", fn ($q) => $q->where("nama_role", "Mekanik"))
                ->inRandomOrder()
                ->value("id") ?? User::query()->inRandomOrder()->value("id"),
            "mekanik_id" => fn () => User::query()
                ->whereHas("role", fn ($q) => $q->where("nama_role", "Mekanik"))
                ->inRandomOrder()
                ->value("id") ?? User::query()->inRandomOrder()->value("id"),
            "maintenance_date" => fake()->dateTimeBetween("-2 months", "now"),
            "tanggal_servis" => fake()->dateTimeBetween("-2 months", "now"),
            "service_type" => fn () => JadwalServis::query()->inRandomOrder()->value("service_type") ?? "Servis Berkala",
            "description" => fake()->sentence(10),
            "cost" => fake()->randomFloat(2, 150000, 5000000),
            "biaya" => fake()->randomFloat(2, 150000, 5000000),
            "parts_used" => fake()->optional()->words(3, true),
            "odometer_reading" => fake()->numberBetween(10000, 350000),
            "pekerjaan" => fake()->sentence(10),
            "notes" => fake()->optional()->sentence(),
            "catatan" => fake()->optional()->sentence(),
        ];
    }
}
