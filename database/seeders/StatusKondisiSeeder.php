<?php

namespace Database\Seeders;

use App\Models\StatusKondisi;
use Illuminate\Database\Seeder;

class StatusKondisiSeeder extends Seeder
{
    public function run(): void
    {
        $kondisis = [
            ["nama_status" => "Baik", "deskripsi" => "Kondisi armada masih layak operasi"],
            ["nama_status" => "Kurang Baik", "deskripsi" => "Perlu pemantauan atau perbaikan ringan"],
            ["nama_status" => "Rusak", "deskripsi" => "Tidak layak operasi dan perlu perbaikan"],
        ];

        foreach ($kondisis as $kondisi) {
            StatusKondisi::query()->updateOrCreate(["nama_status" => $kondisi["nama_status"]], $kondisi);
        }
    }
}
