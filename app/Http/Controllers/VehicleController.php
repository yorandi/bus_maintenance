<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of all vehicles
     * GET /vehicles
     */
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle
     * GET /vehicles/create
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created vehicle in database
     * POST /vehicles
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'registration_number' => 'required|string|unique:armadas,registration_number',
            'nomor_rangka' => 'required|string|unique:armadas,nomor_rangka',
            'merk' => 'required|string',
            'model' => 'required|string',
            'tahun_pembuatan' => 'required|integer|min:1900|max:' . now()->year,
            'kapasitas_penumpang' => 'required|integer|min:1',
            'date_operation_started' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Create vehicle
        $validated['status'] = $validated['status'] ?? 'good';

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')
                       ->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    /**
     * Display a specific vehicle
     * GET /vehicles/{id}
     */
    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing a vehicle
     * GET /vehicles/{id}/edit
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle
     * PUT /vehicles/{id}
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string|unique:armadas,registration_number,' . $vehicle->id,
            'nomor_rangka' => 'required|string|unique:armadas,nomor_rangka,' . $vehicle->id,
            'merk' => 'required|string',
            'model' => 'required|string',
            'tahun_pembuatan' => 'required|integer|min:1900|max:' . now()->year,
            'kapasitas_penumpang' => 'required|integer|min:1',
            'date_operation_started' => 'required|date',
            'status' => 'required|in:good,maintenance,damaged',
            'notes' => 'nullable|string',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.show', $vehicle)
                       ->with('success', 'Kendaraan berhasil diperbarui!');
    }

    /**
     * Delete a vehicle
     * DELETE /vehicles/{id}
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
                       ->with('success', 'Kendaraan berhasil dihapus!');
    }

    /**
     * Get vehicle status summary
     * Used for dashboard statistics
     */
    public static function getStatusSummary()
    {
        return [
            'total' => Vehicle::count(),
            'good' => Vehicle::byStatus('good')->count(),
            'maintenance' => Vehicle::byStatus('maintenance')->count(),
            'damaged' => Vehicle::byStatus('damaged')->count(),
        ];
    }
}
