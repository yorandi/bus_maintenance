<?php

namespace Database\Seeders;

use App\Models\JadwalServis;
use Illuminate\Database\Seeder;

class JadwalServisSeeder extends Seeder
{
    public function run(): void
    {
        JadwalServis::factory()->count(15)->create();
    }
}
