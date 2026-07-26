<table>
    <thead>
        <tr>
            <th>Nomor Armada</th>
            <th>Nomor Polisi</th>
            <th>Servis Terakhir</th>
            <th>Jadwal Servis Berikutnya</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jadwalServis as $jadwal)
            <tr>
                <td>{{ $jadwal->armada->kode_armada }}</td>
                <td>{{ $jadwal->armada->nomor_polisi }}</td>
                <td>{{ $jadwal->tanggal_servis_terakhir?->format('Y-m-d') ?? '-' }}</td>
                <td>{{ $jadwal->jadwal_servis_berikutnya->format('Y-m-d') }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $jadwal->status_servis)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
