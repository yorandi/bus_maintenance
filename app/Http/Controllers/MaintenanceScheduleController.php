<?php

namespace App\Http\Controllers;

use App\Models\JenisServis;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use App\Models\Vehicle;
use App\Notifications\MaintenanceScheduleAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class MaintenanceScheduleController extends Controller
{
    public function index()
    {
        $schedules = MaintenanceSchedule::with(['vehicle', 'jenisServis'])
            ->latest()
            ->paginate(10);

        return view('maintenance.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $vehicles = Vehicle::orderBy('registration_number')->get();

        return view('maintenance.schedules.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:armadas,id',
            'service_type' => 'required|string|max:100',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'keterangan' => 'nullable|string',
            'assigned_mechanic' => 'nullable|string|max:255',
        ]);

        $jenisServis = JenisServis::query()->firstOrCreate(
            ['jenis_servis' => $validated['service_type']],
            ['keterangan' => null]
        );

        $schedule = MaintenanceSchedule::create([
            'vehicle_id' => $validated['vehicle_id'],
            'armada_id' => $validated['vehicle_id'],
            'jenis_servis_id' => $jenisServis->id,
            'service_type' => $validated['service_type'],
            'scheduled_date' => $validated['scheduled_date'],
            'tanggal_servis' => $validated['scheduled_date'],
            'keterangan' => $validated['keterangan'] ?? null,
            'assigned_mechanic' => $validated['assigned_mechanic'] ?? null,
            'status' => 'pending',
            'prioritas' => 'Sedang',
        ]);

        $recipients = User::query()
            ->whereHas('role', function ($query) {
                $query->whereIn('nama_role', ['Admin', 'Mekanik', 'Manager Teknik']);
            })
            ->where('status', true)
            ->whereNotNull('no_hp')
            ->get();

        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new MaintenanceScheduleAlert($schedule));
        }

        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal servis berhasil dibuat!');
    }

    public function show(MaintenanceSchedule $schedule)
    {
        return view('maintenance.schedules.show', compact('schedule'));
    }

    public function edit(MaintenanceSchedule $schedule)
    {
        $vehicles = Vehicle::orderBy('registration_number')->get();

        return view('maintenance.schedules.edit', compact('schedule', 'vehicles'));
    }

    public function update(Request $request, MaintenanceSchedule $schedule)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:armadas,id',
            'service_type' => 'required|string|max:100',
            'scheduled_date' => 'required|date',
            'keterangan' => 'nullable|string',
            'assigned_mechanic' => 'nullable|string|max:255',
            'status' => 'required|in:pending,in_progress,completed,cancelled'
        ]);

        $jenisServis = JenisServis::query()->firstOrCreate(
            ['jenis_servis' => $validated['service_type']],
            ['keterangan' => null]
        );

        $schedule->update([
            'vehicle_id' => $validated['vehicle_id'],
            'armada_id' => $validated['vehicle_id'],
            'jenis_servis_id' => $jenisServis->id,
            'service_type' => $validated['service_type'],
            'scheduled_date' => $validated['scheduled_date'],
            'tanggal_servis' => $validated['scheduled_date'],
            'keterangan' => $validated['keterangan'] ?? null,
            'assigned_mechanic' => $validated['assigned_mechanic'] ?? null,
            'status' =>$validated['status'],
            'prioritas' => $schedule->prioritas ?? 'Sedang',
        ]);

        return redirect()->route('schedules.show', $schedule)
            ->with('success', 'Jadwal servis berhasil diperbarui!');
    }

    public function destroy(MaintenanceSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal servis berhasil dihapus!');
    }
}
