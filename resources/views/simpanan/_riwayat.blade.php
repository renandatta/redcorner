<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Jenis Simpanan</th>
        <th>No.Simpanan</th>
        <th>Tanggal</th>
        <th>Nominal</th>
    </tr>
    </thead>
    <tbody>
        @php($no = 1)
        @foreach($riwayat as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->jenis_simpanan->nama }}</td>
                <td class="text-nowrap">{{ $value->no_simpanan }}</td>
                <td class="text-nowrap">{{ format_date($value->tanggal) }}</td>
                <td class="text-nowrap">{{ format_number($value->nominal) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
