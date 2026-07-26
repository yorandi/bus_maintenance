<?php

namespace Database\Seeders;

use App\Models\MaintenanceSchedule;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class TestNotificationSeeder extends Seeder
{
    public function run(): void
    {
        // pastikan ada user penerima
        $user = User::updateOrCreate(
            ['email' => 'notify-test@example.com'],
            [
                'name' => 'Notify Tester',
                'whatsapp_number' => env('WHATSAPP_NOTIFICATION_NUMBER', '+6281311975186'),
                'password' => bcrypt('password'),
                'role' => 'mechanic',
                'is_active' => true,
            ]
        );

        // ambil kendaraan pertama, atau buat baru jika belum ada
        $vehicle = Vehicle::first();
        if (! $vehicle) {
            $vehicle = Vehicle::create([
                'registration_number' => 'B TEST 001',
                'nomor_rangka' => 'TEST1234567890',
                'merk' => 'TestMake',
                'model' => 'TestModel',
                'tahun_pembuatan' => 2020,
                'kapasitas_penumpang' => 20,
                'status' => 'good',
                'date_operation_started' => now()->subYears(1),
            ]);
        }

        // buat schedule untuk hari esok jika belum ada
        $scheduledDate = now()->addDay()->startOfDay();

        $exists = MaintenanceSchedule::where('vehicle_id', $vehicle->id)
            ->whereDate('scheduled_date', $scheduledDate->toDateString())
            ->exists();

        if (! $exists) {
            MaintenanceSchedule::create([
                'vehicle_id' => $vehicle->id,
                'service_type' => 'Rutin',
                'scheduled_date' => $scheduledDate,
                'status' => 'pending',
                'description' => 'Test notification schedule (tomorrow)',
                'assigned_mechanic' => $user->name,
            ]);
        }

        echo "\n✓ TestNotificationSeeder completed.\n";
    }
}
