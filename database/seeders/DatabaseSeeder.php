<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            StatusArmadaSeeder::class,
            KategoriKomponenSeeder::class,
            StatusKondisiSeeder::class,
            JenisServisSeeder::class,
            UserSeeder::class,
            ArmadaSeeder::class,
            KomponenSeeder::class,
            PemeriksaanSeeder::class,
            JadwalServisSeeder::class,
            RiwayatServisSeeder::class,
            NotifikasiSeeder::class,
        ]);
    }
}
