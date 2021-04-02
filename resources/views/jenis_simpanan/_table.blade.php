<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Nama</th>
        <th>Tipe</th>
        <th>Nominal</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = (($jenis_simpanan->currentPage()-1) * $jenis_simpanan->perPage()) + 1)
        @foreach($jenis_simpanan as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->nama }}</td>
                <td class="text-nowrap">{{ $value->tipe }}</td>
                <td class="text-nowrap">{{ format_number($value->nominal) }}</td>
                <td class="py-1 vertical-middle text-center">
                    <button class="btn btn-info py-1 px-2" type="button" onclick="jenis_simpanan_info({{ $value->id }})">
                        <i class="mdi mdi-arrow-right text-white"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $jenis_simpanan->links('vendor.pagination.custom', ['function' => 'search_jenis_simpanan']) }}
