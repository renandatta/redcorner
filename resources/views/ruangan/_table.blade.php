<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Nama</th>
        <th>Keterangan</th>
        <th class="text-right">Harga</th>
        <th>Gambar</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
    @php($no = (($ruangan->currentPage()-1) * $ruangan->perPage()) + 1)
    @foreach($ruangan as $value)
        <tr>
            <td>{{ $no++ }}</td>
            <td class="text-nowrap">{{ $value->nama }}</td>
            <td>{{ $value->keterangan }}</td>
            <td class="text-nowrap text-right">{{ format_number($value->harga) }}</td>
            <td class="py-0 vertical-middle">
                @foreach($value->gambar as $gambar)
                    <img src="{{ asset("assets/$gambar->file") }}" alt="" class="img-td">
                @endforeach
            </td>
            <td class="py-1 vertical-middle text-center">
                <button class="btn btn-info py-1 px-2" type="button" onclick="ruangan_info({{ $value->id }})">
                    <i class="mdi mdi-arrow-right text-white"></i>
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $ruangan->links('vendor.pagination.custom', ['function' => 'search_ruangan']) }}
