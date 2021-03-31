<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Nama</th>
        <th>Username</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = (($user->currentPage()-1) * $user->perPage()) + 1)
        @foreach($user as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->nama }}</td>
                <td class="text-nowrap">{{ $value->email }}</td>
                <td class="py-1 vertical-middle text-center">
                    <button class="btn btn-info py-1 px-2" type="button" onclick="user_info({{ $value->id }})">
                        <i class="mdi mdi-arrow-right text-white"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $user->links('vendor.pagination.custom', ['function' => 'search_user']) }}
