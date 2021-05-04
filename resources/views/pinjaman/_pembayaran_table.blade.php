<h5 class="mb-2"># Pembayaran</h5>
<table class="table table-bordered">
    <thead>
    <tr>
        <th width="5%">Ke</th>
        <th>Tanggal</th>
        <th class="text-right">Nominal</th>
        <th width="5%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = 0)
        @foreach($pembayaran as $value)
            @php($no++)
            <tr>
                <td class="text-nowrap text-right">{{ $value->pembayaran_ke }}</td>
                <td class="text-nowrap">{{ format_date($value->tanggal) }}</td>
                <td class="text-nowrap text-right">{{ format_number($value->nominal) }}</td>
                <td class="py-1 vertical-middle text-center text-nowrap">
                    @if($no === count($pembayaran))
                        <button class="btn btn-danger py-1 px-2" type="button" onclick="pembayaran_hapus({{ $value->id }})">
                            <i class="mdi mdi-trash-can text-white"></i>
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
