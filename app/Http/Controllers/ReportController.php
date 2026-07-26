<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRecord;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show maintenance report form
     * GET /reports
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('reports.index', compact('vehicles'));
    }

    /**
     * Generate maintenance report with filters
     * GET /reports/generate
     */
    public function generate(Request $request)
    {
        $query = MaintenanceRecord::with(['vehicle', 'mechanic']);

        // Filter by date range
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('maintenance_date', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // Filter by vehicle
        if ($request->vehicle_id) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        // Filter by service type
        if ($request->service_type) {
            $query->where('service_type', $request->service_type);
        }

        $records = $query->latest()->get();

        // Calculate statistics
        $totalCost = $records->sum('cost');
        $totalRecords = $records->count();
        $averageCost = $totalRecords > 0 ? $totalCost / $totalRecords : 0;

        return view('reports.generate', compact(
            'records',
            'totalCost',
            'totalRecords',
            'averageCost'
        ));
    }

    /**
     * Export maintenance report (example: CSV)
     */
    public function export(Request $request)
    {
        $query = MaintenanceRecord::with(['vehicle', 'mechanic']);

        // Apply same filters as generate()
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('maintenance_date', [
                $request->start_date,
                $request->end_date
            ]);
        }

        if ($request->vehicle_id) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->service_type) {
            $query->where('service_type', $request->service_type);
        }

        $records = $query->latest()->get();

        // Create CSV content with proper quoting
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, [
            'Tanggal Pemeliharaan',
            'Kendaraan',
            'Nomor Polisi',
            'Tipe Servis',
            'Biaya',
            'Mekanik',
        ]);

        foreach ($records as $record) {
            fputcsv($handle, [
                $record->maintenance_date->format('Y-m-d H:i:s'),
                $record->vehicle->model,
                $record->vehicle->registration_number,
                $record->service_type,
                'Rp. ' . number_format($record->cost, 0, ',', '.'),
                $record->mechanic->name,
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="maintenance_report_' . now()->format('Y-m-d') . '.csv"');
    }

    /**
     * Get vehicle maintenance cost summary
     */
    public function vehicleCostSummary()
    {
        $vehicles = Vehicle::with('records')
                          ->get()
                          ->map(function ($vehicle) {
                              return [
                                  'id' => $vehicle->id,
                                  'registration_number' => $vehicle->registration_number,
                                  'model' => $vehicle->model,
                                  'total_cost' => $vehicle->records->sum('cost'),
                                  'maintenance_count' => $vehicle->records->count(),
                              ];
                          })
                          ->sortByDesc('total_cost');

        return view('reports.vehicle-cost-summary', compact('vehicles'));
    }

    /**
     * Get mechanic performance report
     */
    public function mechanicPerformance()
    {
        $mechanics = \App\Models\User::byRole('mechanic')
                                    ->with('maintenanceRecords')
                                    ->get()
                                    ->map(function ($mechanic) {
                                        return [
                                            'id' => $mechanic->id,
                                            'name' => $mechanic->name,
                                            'total_maintenance' => $mechanic->maintenanceRecords->count(),
                                            'total_cost' => $mechanic->maintenanceRecords->sum('cost'),
                                            'average_cost' => $mechanic->maintenanceRecords->count() > 0
                                                ? $mechanic->maintenanceRecords->sum('cost') / $mechanic->maintenanceRecords->count()
                                                : 0,
                                        ];
                                    })
                                    ->sortByDesc('total_maintenance');

        return view('reports.mechanic-performance', compact('mechanics'));
    }
}
