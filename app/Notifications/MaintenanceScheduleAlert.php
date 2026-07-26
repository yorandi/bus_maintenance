<?php

namespace App\Notifications;

use App\Models\MaintenanceSchedule;
use Illuminate\Notifications\Notification;

class MaintenanceScheduleAlert extends Notification
{
    public function __construct(
        protected MaintenanceSchedule $schedule
    ) {
    }

    public function via($notifiable)
    {
        return [\App\Notifications\Channels\WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        return sprintf(
            "Pemberitahuan servis armada: %s\nTipe: %s\nTanggal: %s\nStatus: %s\nMekanik: %s\nDetail: %s",
            $this->schedule->vehicle->registration_number,
            $this->schedule->service_type,
            $this->schedule->scheduled_date->format('d M Y'),
            ucfirst(str_replace('_', ' ', $this->schedule->status)),
            $this->schedule->assigned_mechanic ?: '-',
            $this->schedule->description ?: '-'
        );
    }
}
