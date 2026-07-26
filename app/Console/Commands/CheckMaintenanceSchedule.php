<?php

namespace App\Console\Commands;

use App\Models\MaintenanceSchedule;
use App\Services\FonnteService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckMaintenanceSchedule extends Command
{
    protected $signature = 'maintenance:check';
    protected $description = 'Cek jadwal maintenance yang sudah waktunya dan kirim notifikasi WhatsApp ke driver & mekanik';

    public function handle(FonnteService $fonnte)
    {
        $schedules = MaintenanceSchedule::with('vehicle')
            ->whereIn('status', ['Menunggu', 'Proses'])
            ->whereDate('scheduled_date', '<=', Carbon::today())
            ->get();

        if ($schedules->isEmpty()) {
            $this->info('Tidak ada jadwal maintenance yang perlu diingatkan hari ini.');
            return self::SUCCESS;
        }

        $successCount = 0;
        $failCount = 0;

        foreach ($schedules as $schedule) {
            $vehicle  = $schedule->vehicle;
            $noPolisi = $vehicle->registration_number ?? '-';
            $tanggal  = $schedule->scheduled_date->format('d-m-Y');

            $driverOk = true;   // default true kalau memang tidak ada nomor (dianggap "tidak perlu")
            $mekanikOk = true;

            // Kirim ke Driver
            if (!empty($schedule->driver_phone)) {
                $pesanDriver = "Halo {$schedule->driver_name}, bus dengan nomor polisi {$noPolisi} sudah memasuki jadwal maintenance ({$schedule->service_type}) pada {$tanggal}. Mohon segera dibawa ke bengkel.";

                $result = $fonnte->send($schedule->driver_phone, $pesanDriver);
                $driverOk = $result['status'] ?? false;

                $this->logResult('driver', $schedule, $result, $driverOk);
            }

            // Kirim ke Mekanik
            if (!empty($schedule->mechanic_phone)) {
                $pesanMekanik = "Info: Bus {$noPolisi} (supir: {$schedule->driver_name}) memerlukan maintenance ({$schedule->service_type}) pada {$tanggal}. Deskripsi: {$schedule->description}";

                $result = $fonnte->send($schedule->mechanic_phone, $pesanMekanik);
                $mekanikOk = $result['status'] ?? false;

                $this->logResult('mechanic', $schedule, $result, $mekanikOk);
            }

            // Tidak menggunakan kolom reminder_sent/reminder_sent_at karena tidak ada di schema saat ini.
            if ($driverOk && $mekanikOk) {
                $schedule->update([
                    'status' => 'Proses',
                ]);
                $successCount++;
            } else {
                $failCount++;
                $this->warn("Schedule ID {$schedule->id} gagal terkirim sepenuhnya, akan dicoba lagi di run berikutnya.");
            }
        }

        $this->info("{$successCount} notifikasi berhasil diproses, {$failCount} gagal (akan di-retry).");

        return self::SUCCESS;
    }

    protected function logResult(string $type, MaintenanceSchedule $schedule, array $result, bool $success): void
    {
        $level = $success ? 'info' : 'warning';

        Log::$level("Maintenance reminder to {$type}: " . ($success ? 'SUCCESS' : 'FAILED'), [
            'schedule_id' => $schedule->id,
            'vehicle_id'  => $schedule->vehicle_id,
            'result'      => $result,
        ]);
    }
}
