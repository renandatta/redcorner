<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>No.Transaksi</th>
        <th>Tanggal</th>
        <th>Produk</th>
        <th class="text-right">Total</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
    @php($no = (($transaksi->currentPage()-1) * $transaksi->perPage()) + 1)
    @foreach($transaksi as $value)
        <tr>
            <td>{{ $no++ }}</td>
            <td class="text-nowrap">{{ $value->no_transaksi }}</td>
            <td class="text-nowrap">{{ format_date($value->tanggal) }}</td>
            <td class="text-nowrap">{{ $value->detail->count() }} Produk</td>
            <td class="text-nowrap text-right">{{ format_number($value->detail->sum('total')) }}</td>
            <td class="py-1 vertical-middle text-center">
                <a class="btn btn-info py-1 px-2" href="{{ route('admin.kasir.info', ['id' => $value->id]) }}">
                    <i class="mdi mdi-arrow-right text-white"></i>
                </a>
                <a class="btn btn-danger py-1 px-2" onclick="delete_transaksi({{ $value->id }})">
                    <i class="mdi mdi-close text-white"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $transaksi->links('vendor.pagination.custom', ['function' => 'search_transaksi']) }}
