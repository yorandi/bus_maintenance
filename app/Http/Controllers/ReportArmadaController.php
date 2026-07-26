<?php

namespace App\Http\Controllers;

use App\Exports\ArmadaReportExport;
use App\Models\Armada;
use App\Models\KondisiArmada;
use App\Models\JadwalServis;
use App\Models\Pemeliharaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportArmadaController extends Controller
{
    public function dashboard()
    {
        $stats = $this->dashboardStats();

        return view('reports.armada-dashboard', compact('stats'));
    }

    public function armada(Request $request)
    {
        $summary = [
            'total' => Armada::count(),
            'aktif' => Armada::byStatus('aktif')->count(),
            'servis' => Armada::byStatus('servis')->count(),
            'tidak_beroperasi' => Armada::byStatus('tidak_beroperasi')->count(),
        ];

        $armadas = $this->armadaQuery($request)->paginate(10)->withQueryString();

        return view('reports.armada.index', compact('armadas', 'summary'));
    }

    public function armadaExcel(Request $request)
    {
        return Excel::download(
            new ArmadaReportExport('reports.exports.armada', ['armadas' => $this->armadaQuery($request)->get()]),
            'laporan-data-armada-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function armadaPdf(Request $request)
    {
        $pdf = Pdf::loadView('reports.pdf.armada', [
            'title' => 'Laporan Data Armada',
            'armadas' => $this->armadaQuery($request)->get(),
            'summary' => [
                'total' => Armada::count(),
                'aktif' => Armada::byStatus('aktif')->count(),
                'servis' => Armada::byStatus('servis')->count(),
                'tidak_beroperasi' => Armada::byStatus('tidak_beroperasi')->count(),
            ],
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-data-armada-' . now()->format('Ymd') . '.pdf');
    }

    public function jadwalServis(Request $request)
    {
        $jadwalServis = $this->jadwalServisQuery($request)->paginate(10)->withQueryString();

        return view('reports.jadwal-servis.index', compact('jadwalServis'));
    }

    public function jadwalServisExcel(Request $request)
    {
        return Excel::download(
            new ArmadaReportExport('reports.exports.jadwal-servis', ['jadwalServis' => $this->jadwalServisQuery($request)->get()]),
            'laporan-jadwal-servis-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function jadwalServisPdf(Request $request)
    {
        $pdf = Pdf::loadView('reports.pdf.jadwal-servis', [
            'title' => 'Laporan Jadwal Servis',
            'jadwalServis' => $this->jadwalServisQuery($request)->get(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-jadwal-servis-' . now()->format('Ymd') . '.pdf');
    }

    public function riwayatPemeliharaan(Request $request)
    {
        $riwayat = $this->riwayatQuery($request)->paginate(10)->withQueryString();
        $jenisPemeliharaan = Pemeliharaan::query()->select('service_type')->distinct()->orderBy('service_type')->pluck('service_type');

        return view('reports.riwayat-pemeliharaan.index', compact('riwayat', 'jenisPemeliharaan'));
    }

    public function detailRiwayatArmada(Armada $armada)
    {
        $riwayat = $armada->records()->latest('maintenance_date')->paginate(10);

        return view('reports.riwayat-pemeliharaan.detail', compact('armada', 'riwayat'));
    }

    public function riwayatPemeliharaanExcel(Request $request)
    {
        return Excel::download(
            new ArmadaReportExport('reports.exports.riwayat-pemeliharaan', ['riwayat' => $this->riwayatQuery($request)->get()]),
            'laporan-riwayat-pemeliharaan-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function riwayatPemeliharaanPdf(Request $request)
    {
        $pdf = Pdf::loadView('reports.pdf.riwayat-pemeliharaan', [
            'title' => 'Laporan Riwayat Pemeliharaan',
            'riwayat' => $this->riwayatQuery($request)->get(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-riwayat-pemeliharaan-' . now()->format('Ymd') . '.pdf');
    }

    public function keterlambatanServis()
    {
        $keterlambatan = $this->keterlambatanQuery()->paginate(10);

        return view('reports.keterlambatan-servis.index', compact('keterlambatan'));
    }

    public function keterlambatanServisExcel()
    {
        return Excel::download(
            new ArmadaReportExport('reports.exports.keterlambatan-servis', ['keterlambatan' => $this->keterlambatanQuery()->get()]),
            'laporan-keterlambatan-servis-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function keterlambatanServisPdf()
    {
        $pdf = Pdf::loadView('reports.pdf.keterlambatan-servis', [
            'title' => 'Laporan Kendaraan Terlambat Servis',
            'keterlambatan' => $this->keterlambatanQuery()->get(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-keterlambatan-servis-' . now()->format('Ymd') . '.pdf');
    }

    public function kondisiArmada(Request $request)
    {
        $kondisiArmadas = $this->kondisiQuery($request)->paginate(10)->withQueryString();

        return view('reports.kondisi-armada.index', compact('kondisiArmadas'));
    }

    public function kondisiArmadaExcel(Request $request)
    {
        return Excel::download(
            new ArmadaReportExport('reports.exports.kondisi-armada', ['kondisiArmadas' => $this->kondisiQuery($request)->get()]),
            'laporan-kondisi-armada-' . now()->format('Ymd') . '.xlsx'
        );
    }

    public function kondisiArmadaPdf(Request $request)
    {
        $pdf = Pdf::loadView('reports.pdf.kondisi-armada', [
            'title' => 'Laporan Kondisi Armada',
            'kondisiArmadas' => $this->kondisiQuery($request)->get(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-kondisi-armada-' . now()->format('Ymd') . '.pdf');
    }

    public static function dashboardStats(): array
    {
        return [
            'total_armada' => Armada::count(),
            'armada_aktif' => Armada::byStatus('aktif')->count(),
            'armada_servis' => Armada::byStatus('servis')->count(),
            'armada_tidak_beroperasi' => Armada::byStatus('tidak_beroperasi')->count(),
            'total_pemeliharaan' => Pemeliharaan::count(),
            'servis_bulan_ini' => Pemeliharaan::whereMonth('maintenance_date', now()->month)->whereYear('maintenance_date', now()->year)->count(),
            'kendaraan_terlambat_servis' => JadwalServis::whereDate('scheduled_date', '<', now())->count(),
            'kendaraan_rusak' => KondisiArmada::where('status', 'Ditolak')->count(),
        ];
    }

    private function armadaQuery(Request $request): Builder
    {
        return Armada::query()
            ->searchNomor($request->string('search')->toString())
            ->status($request->string('status')->toString())
            ->orderBy('kode_armada');
    }

    private function jadwalServisQuery(Request $request): Builder
    {
        $query = JadwalServis::query()
            ->with('armada')
            ->tanggal($request->string('tanggal')->toString())
            ->orderBy('scheduled_date');

        return $query->when($request->filled('status'), function (Builder $query) use ($request) {
            $today = now()->startOfDay();
            $nextWeek = $today->copy()->addDays(7);

            return match ($request->status) {
                'terlambat' => $query->whereDate('scheduled_date', '<', $today),
                'mendekati_jatuh_tempo' => $query->whereDate('scheduled_date', '>=', $today)->whereDate('scheduled_date', '<=', $nextWeek),
                'tepat_waktu' => $query->whereDate('scheduled_date', '>', $nextWeek),
                default => $query,
            };
        });
    }

    private function riwayatQuery(Request $request): Builder
    {
        return Pemeliharaan::query()
            ->with(['armada', 'mekanik', 'jadwalServis'])
            ->tanggal($request->string('tanggal')->toString())
            ->when($request->filled('jenis_pemeliharaan'), fn (Builder $query) => $query->where('service_type', $request->jenis_pemeliharaan))
            ->when($request->filled('status'), function (Builder $query) use ($request) {
                $scheduleStatus = match ($request->status) {
                    'selesai' => 'Selesai',
                    'dalam_proses' => 'Proses',
                    'ditunda' => 'Dibatalkan',
                    default => null,
                };

                if (! $scheduleStatus) {
                    return $query;
                }

                return $query->whereHas('jadwalServis', function (Builder $jadwalQuery) use ($scheduleStatus) {
                    $jadwalQuery->where('status', $scheduleStatus);
                });
            })
            ->latest('maintenance_date');
    }

    private function keterlambatanQuery(): Builder
    {
        return JadwalServis::query()
            ->with('armada')
            ->whereDate('scheduled_date', '<', now())
            ->select('jadwal_servis.*')
            ->selectRaw('DATEDIFF(?, scheduled_date) as keterlambatan_hari', [Carbon::today()->toDateString()])
            ->orderByDesc('keterlambatan_hari');
    }

    private function kondisiQuery(Request $request): Builder
    {
        return KondisiArmada::query()
            ->with('armada')
            ->kondisi($request->string('kondisi')->toString())
            ->when($request->filled('search'), fn (Builder $query) => $query->whereHas('armada', fn (Builder $query) => $query->where('kode_armada', 'like', '%' . $request->search . '%')->orWhere('nomor_polisi', 'like', '%' . $request->search . '%')))
            ->latest('tanggal');
    }
}
