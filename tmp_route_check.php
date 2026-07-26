<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
echo route('schedules.create', ['vehicle_id' => 1]) . PHP_EOL;
echo route('records.create', ['vehicle_id' => 1]) . PHP_EOL;
