<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Nama</th>
        <th>NIK</th>
        <th>L / P</th>
        <th>No.Telp</th>
        <th>Alamat</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = (($member->currentPage()-1) * $member->perPage()) + 1)
        @foreach($member as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->nama }}</td>
                <td class="text-nowrap">{{ $value->nik }}</td>
                <td class="text-nowrap">{{ $value->jenis_kelamin }}</td>
                <td class="text-nowrap">{{ $value->notelp }}</td>
                <td>{{ $value->alamat }}</td>
                <td class="py-1 vertical-middle text-center">
                    <button class="btn btn-info py-1 px-2" type="button" onclick="member_info({{ $value->id }})">
                        <i class="mdi mdi-arrow-right text-white"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $member->links('vendor.pagination.custom', ['function' => 'search_member']) }}
