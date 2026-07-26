<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Vehicle;
use App\Models\MaintenanceSchedule;

$vehicle = Vehicle::first();
if (! $vehicle) {
    echo "NO_VEHICLE\n";
    exit(1);
}

$schedule = MaintenanceSchedule::create([
    'vehicle_id' => $vehicle->id,
    'service_type' => 'Berkala',
    'scheduled_date' => now()->addDays(7)->toDateString(),
    'status' => 'pending',
    'description' => 'Contoh jadwal servis untuk uji WhatsApp reminder',
    'assigned_mechanic' => 'Mekanik Test',
    'driver_name' => 'Sopir Test',
    'driver_phone' => '+6281218498293',
    'mechanic_name' => 'Mekanik Pendukung',
    'mechanic_phone' => '+6281218498293',
]);

echo "CREATED:" . $schedule->id . "\n";
