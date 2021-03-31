<tr>
    <td>{{ $is_parent == true ? $no : '-' }}</td>
    <td class="text-nowrap">{{ $value->nama }}</td>
    <td class="text-nowrap">{{ $value->slug }}</td>
    <td class="py-1 vertical-middle text-left text-nowrap">
        <button class="btn btn-info py-1 px-2" type="button" onclick="kategori_info({{ $value->id }})">
            <i class="mdi mdi-arrow-right text-white"></i>
        </button>
        @if($is_parent == true)
            <button class="btn btn-secondary py-1 px-2" type="button" onclick="sub_kategori('{{ $value->kode }}')">
                <i class="mdi mdi-plus text-white"></i>
            </button>
        @endif
    </td>
</tr>
