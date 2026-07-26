<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();

        $vehiclesQuery = Vehicle::query()
            ->withCount(['schedules as active_schedules_count' => function ($query) {
                $query->whereIn('status', ['Menunggu', 'Proses']);
            }])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('registration_number', 'like', '%' . $search . '%')
                        ->orWhere('nomor_polisi', 'like', '%' . $search . '%')
                        ->orWhere('merk', 'like', '%' . $search . '%')
                        ->orWhere('model', 'like', '%' . $search . '%')
                        ->orWhere('tipe', 'like', '%' . $search . '%');
                });
            });

        $vehicles = $vehiclesQuery->orderBy('registration_number')->get();

        $stats = [
            'ready' => Vehicle::byStatus('good')->count(),
            'service' => Vehicle::byStatus('maintenance')->count(),
            'repair' => Vehicle::byStatus('damaged')->count(),
        ];

        return view('monitoring.index', compact('vehicles', 'stats', 'search'));
    }
}
