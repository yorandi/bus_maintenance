@php
    $labels = [
        'aktif' => ['Aktif', 'success'],
        'servis' => ['Servis', 'warning'],
        'tidak_beroperasi' => ['Tidak Beroperasi', 'danger'],
        'tepat_waktu' => ['Tepat Waktu', 'success'],
        'mendekati_jatuh_tempo' => ['Mendekati Jatuh Tempo', 'warning'],
        'terlambat' => ['Terlambat', 'danger'],
        'selesai' => ['Selesai', 'success'],
        'dalam_proses' => ['Dalam Proses', 'info'],
        'ditunda' => ['Ditunda', 'warning'],
        'baik' => ['Baik', 'success'],
        'perlu_perbaikan' => ['Perlu Perbaikan', 'warning'],
        'rusak' => ['Rusak', 'danger'],
    ];
    [$label, $color] = $labels[$value] ?? [ucwords(str_replace('_', ' ', $value)), 'secondary'];
@endphp

<span class="badge bg-{{ $color }}">{{ $label }}</span>
