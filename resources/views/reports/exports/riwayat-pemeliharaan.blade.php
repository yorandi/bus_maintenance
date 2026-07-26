<table>
    <thead>
        <tr>
            <th>Nomor Armada</th>
            <th>Tanggal Pemeliharaan</th>
            <th>Jenis Pemeliharaan</th>
            <th>Deskripsi</th>
            <th>Mekanik</th>
            <th>Status Pekerjaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($riwayat as $item)
            <tr>
                <td>{{ $item->armada->kode_armada }}</td>
                <td>{{ $item->tanggal_pemeliharaan->format('Y-m-d') }}</td>
                <td>{{ $item->jenis_pemeliharaan }}</td>
                <td>{{ $item->deskripsi_pekerjaan }}</td>
                <td>{{ $item->mekanik?->name ?? '-' }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $item->status_pemeliharaan)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
