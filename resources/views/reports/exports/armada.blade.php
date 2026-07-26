<table>
    <thead>
        <tr>
            <th>Nomor Armada</th>
            <th>Nomor Polisi</th>
            <th>Merk</th>
            <th>Tipe</th>
            <th>Tahun</th>
            <th>Kapasitas</th>
            <th>Status Armada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($armadas as $armada)
            <tr>
                <td>{{ $armada->kode_armada }}</td>
                <td>{{ $armada->nomor_polisi }}</td>
                <td>{{ $armada->merk }}</td>
                <td>{{ $armada->tipe }}</td>
                <td>{{ $armada->tahun }}</td>
                <td>{{ $armada->kapasitas }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $armada->status_armada)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
