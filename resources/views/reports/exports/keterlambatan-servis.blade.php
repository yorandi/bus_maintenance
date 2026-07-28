<table>
    <thead>
        <tr>
            <th>Nomor Armada</th>
            <th>Nomor Polisi</th>
            <th>Jadwal Servis</th>
            <th>Hari Ini</th>
            <th>Selisih Keterlambatan</th>
            <th>Status Armada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($keterlambatan as $item)
            <tr>
                <td>{{ $item->armada->kode_armada ?? '-' }}</td>
                <td>{{ $item->armada->nomor_polisi ?? '-' }}</td>
                <td>{{ $item->jadwal_servis_berikutnya?->format('Y-m-d') ?? '-' }}</td>
                <td>{{ now()->format('Y-m-d') }}</td>
                <td>{{ $item->keterlambatan_hari ?? 0 }} hari</td>
                <td>{{ isset($item->armada->status_armada) ? ucwords(str_replace('_', ' ', $item->armada->status_armada)) : '-' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
