<?php

namespace App\Http\Controllers;

use App\Models\OperationalInspection;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperationalInspectionController extends Controller
{
    private const AT3_ITEMS = [
        'stnk' => 'I. STNK',
        'pajak_tahunan' => 'I. Pajak Tahunan',
        'keur' => 'I. Keur',
        'kps' => 'I. KPS',
        'lampu_dekat' => 'II. Lampu Utama Dekat',
        'lampu_jauh' => 'II. Lampu Utama Jauh',
        'lampu_sein' => 'II. Lampu Sein',
        'lampu_rem' => 'II. Lampu Rem',
        'sistem_pengereman' => 'II. Sistem Pengereman',
        'kondisi_rem_utama' => 'II. Kondisi Rem Utama',
        'kondisi_ban_depan' => 'II. Kondisi Ban Depan',
        'kondisi_ban_belakang' => 'II. Kondisi Ban Belakang',
        'penghapus_kaca' => 'II. Penghapus Kaca (Wiper)',
        'apar' => 'III. Apar',
        'kotak_obat' => 'III. Kotak Obat / PK3',
        'kunci_roda' => 'III. Kunci Roda',
        'dongkrak' => 'III. Dongkrak',
        'ban_serep' => 'III. Ban Serep',
        'kaki_seat' => 'IV. Kaki Seat',
        'jok_duduk' => 'IV. Jok Duduk',
        'jok_sandaran' => 'IV. Jok Sandaran',
        'bagasi_kanan' => 'IV. Bagasi Samping Kanan',
        'bagasi_kiri' => 'IV. Bagasi Samping Kiri',
        'semua_kaca' => 'IV. Semua Kaca-Kaca',
        'bodi_luar' => 'IV. Bodi Luar Kendaraan',
        'air_radiator' => 'V. Air Radiator',
        'oli_mesin' => 'V. Oli Mesin',
        'minyak_rem_kopling' => 'V. Minyak Rem & Kopling',
        'minyak_steering' => 'V. Minyak Steering',
        'starter_motor' => 'VI. Starter Motor',
        'bunyi_mesin' => 'VI. Bunyi Mesin',
        'klakson' => 'VI. Klakson',
        'gejala_abnormal' => 'VI. Gejala Rusak Abnormal',
        'indikator_mesin' => 'VII. Indikator Mesin Panas',
        'meter_oli' => 'VII. Meter Oli',
        'meter_bahan_bakar' => 'VII. Meter Bahan Bakar',
        'meter_pengisian_battery' => 'VII. Meter Pengisian Battery',
        'tachometer' => 'VII. Tachometer / RPM',
        'tekanan_angin' => 'VII. Tekanan Angin / Vacum',
        'speedometer' => 'VII. Speedometer',
        'odometer_instrument' => 'VII. Odometer',
        'lampu_bawah_kiri_depan' => 'VIII. Lampu Seri Bawah Kiri Depan',
        'lampu_bawah_kanan_depan' => 'VIII. Lampu Seri Bawah Kanan Depan',
        'lampu_atas_kiri_depan' => 'VIII. Lampu Seri Atas Kiri Depan',
        'lampu_atas_kanan_depan' => 'VIII. Lampu Seri Atas Kanan Depan',
        'lampu_samping_kiri_depan' => 'VIII. Lampu Seri Samping Kiri Depan',
        'lampu_samping_kanan_depan' => 'VIII. Lampu Seri Samping Kanan Depan',
        'lampu_kiri_belakang' => 'VIII. Lampu Seri Kiri Belakang',
        'lampu_kanan_belakang' => 'VIII. Lampu Seri Kanan Belakang',
        'lampu_kiri_depan' => 'VIII. Lampu Seri Kiri Depan',
        'lampu_kanan_depan' => 'VIII. Lampu Seri Kanan Depan',
        'lampu_dashboard' => 'VIII. Lampu Dashboard',
        'lampu_interior' => 'VIII. Lampu Interior',
    ];

    private const AT4_ITEMS = [
        'mesin' => 'Mesin',
        'sistem_rem' => 'Sistem Rem',
        'sistem_kemudi' => 'Sistem Kemudi (Steer)',
        'sistem_pending' => 'Sistem Pending',
        'suspensi' => 'Suspensi',
        'elektrikal' => 'Elektrikal',
        'sistem_kopling' => 'Sistem Kopling',
        'transmisi' => 'Transmisi',
        'roda_roda' => 'Roda - roda',
        'kebersihan' => 'Kebersihan Keseluruhan',
        'body_kendaraan' => 'Body Kendaraan',
        'sistem_ac' => 'Sistem AC',
    ];

    public function index(Request $request)
    {
        $inspections = OperationalInspection::with(['vehicle', 'driver'])
            ->when($request->filled('type'), fn ($query) => $query->where('jenis', $request->type === 'at4' ? 'AT4' : 'AT3'))
            ->when($request->filled('condition_result'), fn ($query) => $query->where('condition_result', $request->condition_result))
            ->when($this->currentUserIsSopir(), fn ($query) => $query->where('user_id', Auth::id()))
            ->orderByDesc('tanggal')
            ->orderByDesc('jam')
            ->paginate(10)
            ->withQueryString();

        return view('operational-inspections.index', compact('inspections'));
    }

    public function createAt3()
    {
        return $this->create(OperationalInspection::TYPE_AT3);
    }

    public function createAt4()
    {
        return $this->create(OperationalInspection::TYPE_AT4);
    }

    public function storeAt3(Request $request)
    {
        return $this->store($request, OperationalInspection::TYPE_AT3);
    }

    public function storeAt4(Request $request)
    {
        return $this->store($request, OperationalInspection::TYPE_AT4);
    }

    public function edit(OperationalInspection $inspection)
    {
        $this->authorizeDriverAccess($inspection);

        $inspection->loadMissing(['vehicle', 'driver']);
        $vehicles = Vehicle::orderBy('registration_number')->get();
        $items = $inspection->type === OperationalInspection::TYPE_AT3 ? self::AT3_ITEMS : self::AT4_ITEMS;
        $title = $inspection->type === OperationalInspection::TYPE_AT3 ? 'Edit AT/3 Digital' : 'Edit AT/4 Digital';
        $type = $inspection->type;

        return view('operational-inspections.form', compact('vehicles', 'items', 'inspection', 'title', 'type'));
    }

    public function update(Request $request, OperationalInspection $inspection)
    {
        $this->authorizeDriverAccess($inspection);

        $items = $inspection->type === OperationalInspection::TYPE_AT3 ? self::AT3_ITEMS : self::AT4_ITEMS;

        $validated = $request->validate([
            'vehicle_id' => 'required|exists:armadas,id',
            'odometer' => 'required|integer|min:0',
            'checklist' => 'required|array',
            'checklist.*' => 'required|in:baik,perlu_perbaikan,rusak',
            'complaint' => 'nullable|string|max:2000',
        ]);

        foreach (array_keys($items) as $key) {
            if (!array_key_exists($key, $validated['checklist'])) {
                return back()
                    ->withErrors(['checklist' => 'Seluruh checklist pemeriksaan wajib diisi.'])
                    ->withInput();
            }
        }

        $condition = $this->calculateCondition($validated['checklist'], $validated['complaint'] ?? null);

        $inspection->update([
            'vehicle_id' => $validated['vehicle_id'],
            'driver_id' => Auth::id(),
            'odometer' => $validated['odometer'],
            'checklist' => $validated['checklist'],
            'complaint' => $validated['complaint'] ?? null,
            'condition_result' => $condition,
            'inspected_at' => now(),
        ]);

        $inspection->vehicle?->update([
            'status' => match ($condition) {
                'tidak_layak' => 'damaged',
                'perlu_perbaikan' => 'maintenance',
                default => 'good',
            },
        ]);

        return redirect()
            ->route('inspections.show', $inspection)
            ->with('success', $inspection->type_label . ' berhasil diperbarui.');
    }

    public function show(OperationalInspection $inspection)
    {
        $this->authorizeDriverAccess($inspection);

        $inspection->loadMissing(['vehicle', 'driver']);

        return view('operational-inspections.show', compact('inspection'));
    }

    private function create(string $type)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $vehicles = Vehicle::orderBy('registration_number')->get();
        $items = $type === OperationalInspection::TYPE_AT3 ? self::AT3_ITEMS : self::AT4_ITEMS;
        $title = $type === OperationalInspection::TYPE_AT3 ? 'AT/3 Digital - Sebelum Operasional' : 'AT/4 Digital - Setelah Operasional';

        return view('operational-inspections.form', compact('vehicles', 'items', 'type', 'title'))->with('inspection', null);
    }

    private function store(Request $request, string $type)
    {
        if (! $this->currentUserIsSopir()) {
            abort(403);
        }

        $items = $type === OperationalInspection::TYPE_AT3 ? self::AT3_ITEMS : self::AT4_ITEMS;

        $validated = $request->validate([
            'vehicle_id' => 'required|exists:armadas,id',
            'odometer' => 'required|integer|min:0',
            'checklist' => 'required|array',
            'checklist.*' => 'required|in:baik,perlu_perbaikan,rusak',
            'complaint' => 'nullable|string|max:2000',
        ]);

        foreach (array_keys($items) as $key) {
            if (!array_key_exists($key, $validated['checklist'])) {
                return back()
                    ->withErrors(['checklist' => 'Seluruh checklist pemeriksaan wajib diisi.'])
                    ->withInput();
            }
        }

        $condition = $this->calculateCondition($validated['checklist'], $validated['complaint'] ?? null);

        $inspection = OperationalInspection::create([
            'vehicle_id' => $validated['vehicle_id'],
            'driver_id' => Auth::id(),
            'type' => $type,
            'odometer' => $validated['odometer'],
            'checklist' => $validated['checklist'],
            'complaint' => $validated['complaint'] ?? null,
            'condition_result' => $condition,
            'inspected_at' => now(),
        ]);

        $inspection->vehicle->update([
            'status' => match ($condition) {
                'tidak_layak' => 'damaged',
                'perlu_perbaikan' => 'maintenance',
                default => 'good',
            },
        ]);

        return redirect()
            ->route('inspections.show', $inspection)
            ->with('success', $inspection->type_label . ' berhasil disimpan dan status kendaraan diperbarui.');
    }

    private function calculateCondition(array $checklist, ?string $complaint): string
    {
        if (in_array('rusak', $checklist, true)) {
            return 'tidak_layak';
        }

        if (in_array('perlu_perbaikan', $checklist, true) || filled($complaint)) {
            return 'perlu_perbaikan';
        }

        return 'siap_operasi';
    }

    private function authorizeDriverAccess(OperationalInspection $inspection): void
    {
        if ($this->currentUserIsSopir() && $inspection->driver_id !== Auth::id()) {
            abort(403);
        }
    }

    private function currentUserIsSopir(): bool
    {
        return Auth::user()?->role?->nama_role === 'Sopir';
    }
}
