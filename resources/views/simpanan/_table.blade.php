<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Member</th>
        <th>Jenis Simpanan</th>
        <th>No.Simpanan</th>
        <th>Tanggal</th>
        <th class="text-right">Nominal</th>
        <th width="5%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = (($simpanan->currentPage()-1) * $simpanan->perPage()) + 1)
        @foreach($simpanan as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->member->nama }}</td>
                <td class="text-nowrap">{{ $value->jenis_simpanan->nama }}</td>
                <td class="text-nowrap">{{ $value->no_simpanan }}</td>
                <td class="text-nowrap">{{ format_date($value->tanggal) }}</td>
                <td class="text-nowrap text-right">{{ format_number($value->nominal) }}</td>
                <td class="py-1 vertical-middle text-center">
                    <button class="btn btn-info py-1 px-2" type="button" onclick="simpanan_info({{ $value->id }})">
                        <i class="mdi mdi-arrow-right text-white"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $simpanan->links('vendor.pagination.custom', ['function' => 'search_simpanan']) }}
