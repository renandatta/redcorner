<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>No.Transaksi</th>
        <th>Pembeli</th>
        <th>Tanggal</th>
        <th>List Produk</th>
        <th class="text-center">Status</th>
        <th class="text-right">Harga Produk</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
    @php($no = (($transaksi->currentPage()-1) * $transaksi->perPage()) + 1)
    @foreach($transaksi as $value)
        <tr>
            <td>{{ $no++ }}</td>
            <td class="text-nowrap">{{ $value->no_transaksi }}</td>
            <td class="text-nowrap">{{ $value->user->nama }}</td>
            <td class="text-nowrap">{{ format_date($value->tanggal) }}</td>
            <td class="py-0 vertical-middle">
                @foreach($value->detail as $detail)
                    {{ $detail->produk->nama }} x {{ format_number($detail->qty) }} <br>
                @endforeach
            </td>
            <td class="text-nowrap text-center">{{ $value->status }}</td>
            <td class="text-nowrap text-right">{{ format_number($value->harga_produk) }}</td>
            <td class="py-1 vertical-middle text-center">
                <button class="btn btn-info py-1 px-2" type="button" onclick="transaksi_info({{ $value->id }})">
                    <i class="mdi mdi-arrow-right text-white"></i>
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $transaksi->links('vendor.pagination.custom', ['function' => 'search_transaksi']) }}
