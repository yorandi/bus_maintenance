<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRecord;
use App\Models\MaintenanceSchedule;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class MaintenanceRecordController extends Controller
{
    /**
     * Display all maintenance records
     * GET /maintenance-records
     */
    public function index()
    {
        $records = MaintenanceRecord::with(['vehicle', 'mechanic'])
                                     ->latest()
                                     ->paginate(10);
        return view('maintenance.records.index', compact('records'));
    }

    /**
     * Show form for creating new record
     * GET /maintenance-records/create
     */
    public function create()
    {
        $vehicles = Vehicle::all();
        $schedules = MaintenanceSchedule::whereIn('status', ['Menunggu', 'Proses'])->get();
        $mechanics = \App\Models\User::byRole('mechanic')->where('status', true)->get();

        return view('maintenance.records.create', compact('vehicles', 'schedules', 'mechanics'));
    }

    /**
     * Store new maintenance record
     * POST /maintenance-records
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:armadas,id',
            'schedule_id' => 'nullable|exists:jadwal_servis,id',
            'mechanic_id' => 'required|exists:users,id',
            'maintenance_date' => 'required|date',
            'service_type' => 'required|string',
            'description' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'parts_used' => 'nullable|string',
            'odometer_reading' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        MaintenanceRecord::create($validated);

        // Update schedule status jika ada schedule terkait
        if ($request->schedule_id) {
            MaintenanceSchedule::find($request->schedule_id)
                              ->update(['status' => 'Selesai']);
        }

        return redirect()->route('records.index')
                       ->with('success', 'Riwayat pemeliharaan berhasil dicatat!');
    }

    /**
     * Show record details
     * GET /maintenance-records/{id}
     */
    public function show(MaintenanceRecord $record)
    {
        return view('maintenance.records.show', compact('record'));
    }

    /**
     * Show form for editing record
     * GET /maintenance-records/{id}/edit
     */
    public function edit(MaintenanceRecord $record)
    {
        $vehicles = Vehicle::all();
        $schedules = MaintenanceSchedule::whereIn('status', ['Menunggu', 'Proses'])->get();
        $mechanics = \App\Models\User::byRole('mechanic')->where('status', true)->get();

        return view('maintenance.records.edit', compact('record', 'vehicles', 'schedules', 'mechanics'));
    }

    /**
     * Update record
     * PUT /maintenance-records/{id}
     */
    public function update(Request $request, MaintenanceRecord $record)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:armadas,id',
            'schedule_id' => 'nullable|exists:jadwal_servis,id',
            'mechanic_id' => 'required|exists:users,id',
            'maintenance_date' => 'required|date',
            'service_type' => 'required|string',
            'description' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'parts_used' => 'nullable|string',
            'odometer_reading' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $record->update($validated);

        return redirect()->route('records.show', $record)
                       ->with('success', 'Riwayat pemeliharaan berhasil diperbarui!');
    }

    /**
     * Delete record
     * DELETE /maintenance-records/{id}
     */
    public function destroy(MaintenanceRecord $record)
    {
        $vehicleId = $record->vehicle_id;
        $record->delete();

        return redirect()->route('records.index')
                       ->with('success', 'Riwayat pemeliharaan berhasil dihapus!');
    }

    /**
     * Get total maintenance cost for a vehicle
     */
    public static function getTotalCostByVehicle(Vehicle $vehicle)
    {
        return MaintenanceRecord::where('vehicle_id', $vehicle->id)
                               ->sum('cost');
    }

    /**
     * Get maintenance records by date range
     */
    public static function getRecordsByDateRange($startDate, $endDate)
    {
        return MaintenanceRecord::whereBetween('maintenance_date', [$startDate, $endDate])
                               ->with(['vehicle', 'mechanic'])
                               ->latest()
                               ->get();
    }
}
