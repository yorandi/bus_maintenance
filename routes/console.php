<?php

use App\Models\MaintenanceSchedule;
use App\Models\User;
use App\Notifications\DueMaintenanceReminder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('notify:due-maintenance', function () {
    $schedules = MaintenanceSchedule::with('vehicle')
                                    ->whereIn('status', ['pending', 'in_progress'])
                                    ->whereBetween('scheduled_date', [now()->startOfDay(), now()->addDays(1)->endOfDay()])
                                    ->get();

    if ($schedules->isEmpty()) {
        return $this->comment('Tidak ada jadwal servis mendatang untuk hari ini atau besok.');
    }

    $recipients = User::whereIn('role', ['admin', 'mechanic'])
                      ->where('is_active', true)
                      ->whereNotNull('whatsapp_number')
                      ->get();

    if ($recipients->isEmpty()) {
        return $this->comment('Tidak ada pengguna dengan nomor WhatsApp yang terdaftar.');
    }

    Notification::send($recipients, new DueMaintenanceReminder($schedules));

    $this->comment('Notifikasi WhatsApp dikirim untuk jadwal servis mendatang.');
})->purpose('Send WhatsApp reminders for upcoming maintenance schedules');
