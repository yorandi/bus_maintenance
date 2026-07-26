<?php

namespace Database\Seeders;

use App\Models\StatusArmada;
use Illuminate\Database\Seeder;

class StatusArmadaSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ["nama_status" => "Operasional", "deskripsi" => "Armada dalam kondisi baik dan sedang beroperasi"],
            ["nama_status" => "Servis", "deskripsi" => "Armada sedang menjalani proses servis/perbaikan"],
            ["nama_status" => "Rusak", "deskripsi" => "Armada mengalami kerusakan dan tidak dapat dioperasikan"],
            ["nama_status" => "Tidak Beroperasi", "deskripsi" => "Armada nonaktif sementara di luar servis atau kerusakan"],
        ];

        foreach ($statuses as $status) {
            StatusArmada::query()->updateOrCreate(["nama_status" => $status["nama_status"]], $status);
        }
    }
}
