<?php

namespace Database\Seeders;

use App\Models\JenisServis;
use Illuminate\Database\Seeder;

class JenisServisSeeder extends Seeder
{
    public function run(): void
    {
        $jenisServis = [
            ["jenis_servis" => "Servis Berkala", "keterangan" => "Servis terjadwal sesuai interval armada"],
            ["jenis_servis" => "Ganti Oli", "keterangan" => "Penggantian oli mesin dan filter"],
            ["jenis_servis" => "Tune Up", "keterangan" => "Pemeriksaan dan penyetelan performa mesin"],
            ["jenis_servis" => "Overhaul", "keterangan" => "Perbaikan besar komponen utama"],
            ["jenis_servis" => "Perbaikan", "keterangan" => "Perbaikan umum atas kerusakan armada"],
        ];

        foreach ($jenisServis as $jenis) {
            JenisServis::query()->updateOrCreate(["jenis_servis" => $jenis["jenis_servis"]], $jenis);
        }
    }
}
