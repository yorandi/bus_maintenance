<?php

namespace Database\Seeders;

use App\Models\Armada;
use Illuminate\Database\Seeder;

class ArmadaSeeder extends Seeder
{
    public function run(): void
    {
        Armada::factory()->count(20)->create();
    }
}
