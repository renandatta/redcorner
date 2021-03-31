<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Nama</th>
        <th>Slug</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
        @php($no = 1)
        @foreach($kategori as $value)
            @include('kategori._item_table', ['value' => $value, 'is_parent' => true, 'no' => $no++])
            @foreach($value->children as $child)
                @include('kategori._item_table', ['value' => $child, 'is_parent' => false])
            @endforeach
        @endforeach
    </tbody>
</table>
