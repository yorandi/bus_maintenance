<table>
    <thead>
        <tr>
            <th>Nomor Armada</th>
            <th>Kondisi Kendaraan</th>
            <th>Tanggal Pemeriksaan</th>
            <th>Catatan Kerusakan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kondisiArmadas as $item)
            <tr>
                <td>{{ $item->armada->kode_armada }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $item->kondisi)) }}</td>
                <td>{{ $item->tanggal_pemeriksaan->format('Y-m-d') }}</td>
                <td>{{ $item->catatan_kerusakan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
