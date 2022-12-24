<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Member</th>
        <th>Tanggal</th>
        <th class="text-right">Nominal</th>
        <th class="text-right">Bunga</th>
    </tr>
    </thead>
    <tbody>
        @php($no = (($pembayaran->currentPage()-1) * $pembayaran->perPage()) + 1)
        @foreach($pembayaran as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->pinjaman->member->nama }}</td>
                <td class="text-nowrap">{{ format_date($value->tanggal) }}</td>
                <td class="text-nowrap text-right">{{ format_number($value->nominal) }}</td>
                <td class="text-nowrap text-right">{{ format_number($value->pinjaman->bunga_rupiah) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $pembayaran->links('vendor.pagination.custom', ['function' => 'search_pembayaran']) }}
