<?php

namespace App\Notifications;

use App\Models\MaintenanceSchedule;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\WhatsAppChannel; // Import channel yang benar

class MaintenanceScheduleReminder extends Notification
{
    public function __construct(
        public readonly MaintenanceSchedule $schedule,
        public readonly string $type, // 'reminder' atau 'overdue'
        public readonly int $days
    ) {
    }

    public function via($notifiable): array
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable): string
    {
        return $this->type === 'overdue'
            ? $this->buildOverdueMessage()
            : $this->buildReminderMessage();
    }

    protected function buildReminderMessage(): string
    {
        // Menggunakan optional chaining dan null coalescing lebih aman
        $regNumber = $this->schedule->vehicle->registration_number ?? 'Data tidak tersedia';
        $mechanic  = $this->schedule->mechanic_name ?? 'Belum ditentukan';
        $date      = $this->schedule->scheduled_date?->format('d-m-Y') ?? '-';

        return "🚍 *REMINDER JADWAL SERVIS ARMADA*\n\n" .
               "No Polisi : {$regNumber}\n" .
               "Jenis Servis : {$this->schedule->service_type}\n" .
               "Tanggal Servis : {$date}\n" .
               "Mekanik : {$mechanic}\n\n" .
               "Sisa waktu servis: {$this->days} hari.\n\n" .
               "Mohon segera melakukan pemeliharaan sesuai jadwal.";
    }

    protected function buildOverdueMessage(): string
    {
        $regNumber = $this->schedule->vehicle->registration_number ?? 'Data tidak tersedia';
        $date      = $this->schedule->scheduled_date?->format('d-m-Y') ?? '-';

        return "⚠️ *JADWAL SERVIS TERLAMBAT*\n\n" .
               "No Polisi : {$regNumber}\n" .
               "Jenis Servis : {$this->schedule->service_type}\n" .
               "Tanggal Servis : {$date}\n\n" .
               "Servis terlambat {$this->days} hari.\n\n" .
               "Segera lakukan pemeliharaan armada.";
    }
}
