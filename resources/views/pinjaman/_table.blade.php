<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Member</th>
        <th>No.Pinjaman</th>
        <th>Tanggal</th>
        <th class="text-right">Nominal</th>
        <th class="text-right">Bunga</th>
        <th width="5%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = (($pinjaman->currentPage()-1) * $pinjaman->perPage()) + 1)
        @foreach($pinjaman as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->member->nama }}</td>
                <td class="text-nowrap">{{ $value->no_pinjaman }}</td>
                <td class="text-nowrap">{{ format_date($value->tanggal) }}</td>
                <td class="text-nowrap text-right">{{ format_number($value->nominal) }}</td>
                <td class="text-nowrap text-right">{{ format_number($value->bunga_rupiah) }} ({{ $value->bunga }}%)</td>
                <td class="py-1 vertical-middle text-center text-nowrap">
                    <button class="btn btn-info py-1 px-2" type="button" onclick="pinjaman_info({{ $value->id }})">
                        <i class="mdi mdi-arrow-right text-white"></i>
                    </button>
                    <button class="btn btn-primary py-1 px-2" type="button" onclick="pembayaran({{ $value->id }})">
                        <i class="mdi mdi-cash text-white"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $pinjaman->links('vendor.pagination.custom', ['function' => 'search_pinjaman']) }}
