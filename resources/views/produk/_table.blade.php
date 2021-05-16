<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th class="text-right">Harga</th>
        <th class="text-right">Harga Beli</th>
        <th>Gambar</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
    @php($no = (($produk->currentPage()-1) * $produk->perPage()) + 1)
    @foreach($produk as $value)
        <tr>
            <td>{{ $no++ }}</td>
            <td class="text-nowrap">{{ $value->nama }}</td>
            <td class="text-nowrap">{{ $value->kategori->nama }}</td>
            <td class="text-nowrap text-right">{{ format_number($value->harga) }}</td>
            <td class="text-nowrap text-right">{{ format_number($value->harga_beli) }}</td>
            <td class="py-0 vertical-middle">
                @foreach($value->gambar as $gambar)
                    <img src="{{ asset("assets/$gambar->file") }}" alt="" class="img-td">
                @endforeach
            </td>
            <td class="py-1 vertical-middle text-center">
                <button class="btn btn-info py-1 px-2" type="button" id="button_info_{{ $value->id }}" onclick="produk_info({{ $value->id }})">
                    <i class="mdi mdi-arrow-right text-white"></i>
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $produk->links('vendor.pagination.custom', ['function' => 'search_produk']) }}
