<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Nama</th>
        <th>No.Member</th>
        <th>L / P</th>
        <th>No.Telp</th>
        <th>Alamat</th>
        <th>Foto</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = (($member->currentPage()-1) * $member->perPage()) + 1)
        @foreach($member as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->nama }}</td>
                <td class="text-nowrap">{{ $value->no_member }}</td>
                <td class="text-nowrap">{{ $value->jenis_kelamin }}</td>
                <td class="text-nowrap">{{ $value->notelp }}</td>
                <td>{{ $value->alamat }}</td>
                <td class="py-0 vertical-middle">
                    @if($value->foto != '')
                        <img src="{{ asset("assets/$value->foto") }}" alt="" class="img-td">
                    @endif
                </td>
                <td class="py-1 vertical-middle text-center">
                    <button class="btn btn-info py-1 px-2" type="button" onclick="member_info({{ $value->id }})">
                        <i class="mdi mdi-arrow-right text-white"></i>
                    </button>
                    <a class="btn btn-primary py-1 px-2" href="{{ route('admin.member.cetak.kartu', ['id' => $value->id]) }}">
                        <i class="mdi mdi-card-account-details text-white"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $member->links('vendor.pagination.custom', ['function' => 'search_member']) }}
