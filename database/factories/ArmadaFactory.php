<?php

namespace Database\Factories;

use App\Models\StatusArmada;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArmadaFactory extends Factory
{
    public function definition(): array
    {
        $merkTipe = fake()->randomElement([
            ["merk" => "Hino", "tipe" => "RK8 R260"],
            ["merk" => "Mercedes-Benz", "tipe" => "OH 1626"],
            ["merk" => "Scania", "tipe" => "K360IB"],
            ["merk" => "Isuzu", "tipe" => "NQR71"],
            ["merk" => "Hyundai", "tipe" => "Universe"],
        ]);

        return [
            "status_armada_id" => fn () => StatusArmada::query()->inRandomOrder()->value("id")
                ?? StatusArmada::query()->create(["nama_status" => "Operasional"])->id,
            "kode_armada" => "DMR-" . fake()->unique()->numerify("####"),
            "registration_number" => strtoupper(fake()->bothify("B #### ??")),
            // "nomor_lambung" => fake()->unique()->numerify("BUS-#####"),
            "nomor_polisi" => strtoupper(fake()->bothify("B #### ??")),
            "nomor_rangka" => strtoupper(fake()->unique()->bothify("MHF#############")),
            "nomor_mesin" => strtoupper(fake()->unique()->bothify("ENG###########")),
            "merk" => $merkTipe["merk"],
            "model" => $merkTipe["tipe"],
            "tipe" => $merkTipe["tipe"],
            "tahun_pembuatan" => fake()->numberBetween(2012, 2025),
            "tahun" => fake()->numberBetween(2012, 2025),
            "kapasitas_penumpang" => fake()->randomElement([30, 35, 40, 45, 59]),
            "kapasitas" => fake()->randomElement([30, 35, 40, 45, 59]),
            "date_operation_started" => fake()->dateTimeBetween('-10 years', 'now'),
            "odometer_terakhir" => fake()->numberBetween(10000, 350000),
            "status" => fake()->randomElement(["good", "maintenance", "damaged"]),
            "notes" => fake()->optional()->sentence(),
        ];
    }
}
