<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class DueMaintenanceReminder extends Notification
{
    public function __construct(
        protected Collection $schedules
    ) {
    }

    public function via($notifiable)
    {
        return [\App\Notifications\Channels\WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        $lines = [
            'Daftar armada yang perlu segera servis:',
        ];

        foreach ($this->schedules as $schedule) {
            $lines[] = sprintf(
                '%s — %s (%s) %s',
                $schedule->vehicle->registration_number,
                $schedule->service_type,
                $schedule->scheduled_date->format('d M Y'),
                $schedule->assigned_mechanic ? 'Mekanik: '.$schedule->assigned_mechanic : ''
            );
        }

        return implode("\n", $lines);
    }
}
