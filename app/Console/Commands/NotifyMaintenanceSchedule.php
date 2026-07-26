<?php

namespace App\Console\Commands;

use App\Models\MaintenanceSchedule;
use App\Notifications\MaintenanceScheduleReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\Support\Carbon;

class NotifyMaintenanceSchedule extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'notify:maintenance-schedule';

    /**
     * The console command description.
     */
    protected $description = 'Kirim reminder WhatsApp untuk jadwal servis armada berdasarkan aturan H-7, H-3, H-1, dan OVERDUE.';

    public function handle(): int
    {
        // Ambil tanggal hari ini pada awal hari untuk perhitungan selisih hari
        $today = Carbon::now()->startOfDay();

        $schedules = MaintenanceSchedule::with('vehicle')
            ->whereIn('status', ['pending', 'in_progress'])
            ->whereDate('scheduled_date', '<=', $today->copy()->addDays(7))
            ->get();

        if ($schedules->isEmpty()) {
            $this->info('Tidak ada jadwal servis aktif yang memerlukan reminder hari ini.');
            return 0;
        }

        foreach ($schedules as $schedule) {
            $daysRemaining = $today->diffInDays($schedule->scheduled_date, false);

            if ($daysRemaining === 7 || $daysRemaining === 3 || $daysRemaining === 1) {
                $this->sendReminderNotifications($schedule, $daysRemaining);
                continue;
            }

            if ($daysRemaining < 0) {
                $this->sendOverdueNotifications($schedule, abs($daysRemaining));
            }
        }

        $this->info('Proses pengiriman reminder jadwal servis selesai.');

        return 0;
    }

    /**
     * Kirim reminder H-7, H-3, H-1 ke sopir dan mekanik.
     */
    protected function sendReminderNotifications(MaintenanceSchedule $schedule, int $daysRemaining): void
    {
        $notification = new MaintenanceScheduleReminder($schedule, 'reminder', $daysRemaining);

        $this->sendToPhone($schedule->driver_phone, $notification, 'driver', $schedule->driver_name);
        $this->sendToPhone($schedule->mechanic_phone, $notification, 'mechanic', $schedule->mechanic_name);
    }

    /**
     * Kirim notifikasi overdue ke sopir dan mekanik.
     */
    protected function sendOverdueNotifications(MaintenanceSchedule $schedule, int $daysLate): void
    {
        $notification = new MaintenanceScheduleReminder($schedule, 'overdue', $daysLate);

        $this->sendToPhone($schedule->driver_phone, $notification, 'driver', $schedule->driver_name);
        $this->sendToPhone($schedule->mechanic_phone, $notification, 'mechanic', $schedule->mechanic_name);
    }

    /**
     * Kirim notifikasi WhatsApp ke nomor tujuan dan catat log.
     */
    protected function sendToPhone(?string $phone, MaintenanceScheduleReminder $notification, string $recipientType, ?string $recipientName): void
    {
        if (empty($phone)) {
            Log::warning('Tidak dapat mengirim notifikasi WhatsApp, nomor tidak tersedia.', [
                'recipient_type' => $recipientType,
                'recipient_name' => $recipientName,
                'schedule_id' => $notification->schedule->id,
            ]);
            return;
        }

        try {
            NotificationFacade::route('whatsapp', $phone)->notify($notification);

            Log::info('WhatsApp reminder dikirim dari command.', [
                'recipient_type' => $recipientType,
                'recipient_name' => $recipientName,
                'phone' => $phone,
                'schedule_id' => $notification->schedule->id,
                'message_type' => $notification->type,
            ]);
        } catch (\Throwable $exception) {
            Log::error('Gagal mengirim notifikasi WhatsApp dari command.', [
                'recipient_type' => $recipientType,
                'recipient_name' => $recipientName,
                'phone' => $phone,
                'schedule_id' => $notification->schedule->id,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
