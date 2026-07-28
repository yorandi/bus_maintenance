<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\MaintenanceRecord;
use App\Models\MaintenanceSchedule;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard beserta statistiknya.
     * GET /dashboard
     */
    public function index()
    {
        $vehicleStats = Armada::statusSummary();

        $recentRecords = MaintenanceRecord::with(['vehicle', 'mechanic'])
            ->latest('maintenance_date')
            ->take(5)
            ->get();

        $pendingSchedules = MaintenanceSchedule::with('vehicle')
            ->whereIn('status', ['Menunggu', 'Proses'])
            ->orderBy('scheduled_date')
            ->take(5)
            ->get();

        $overdueSchedules = MaintenanceSchedule::with('vehicle')
            ->whereIn('status', ['Menunggu', 'Proses'])
            ->whereDate('scheduled_date', '<', now())
            ->orderBy('scheduled_date')
            ->get();

        $reportStats = $vehicleStats;

        $maintenanceByType = MaintenanceSchedule::query()
            ->whereMonth('scheduled_date', now()->month)
            ->whereYear('scheduled_date', now()->year)
            ->selectRaw('service_type, COUNT(*) as count')
            ->groupBy('service_type')
            ->get();

        return view('dashboard.index', compact(
            'vehicleStats',
            'recentRecords',
            'pendingSchedules',
            'overdueSchedules',
            'reportStats',
            'maintenanceByType'
        ));
    }
}
