<form id="form_items">
    @csrf
    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="3%">No.</th>
            <th width="40%">Produk</th>
            <th>Harga</th>
            <th width="5%">Qty</th>
            <th>Total</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>#</td>
            <td class="p-0 align-middle"><x-select class="select2" name="produk_id" :options="$products" /></td>
            <td class="p-0 align-middle"><x-input name="harga" class="autonumeric text-right" /></td>
            <td class="p-0 align-middle"><x-input name="qty" class="autonumeric text-right" /></td>
            <td class="p-0 align-middle"><x-input name="total" class="autonumeric text-right" /></td>
            <td class="p-0 align-middle text-center">
                <button type="submit" class="btn btn-primary btn-icon btn-sm"><i class="fa fa-save"></i></button>
            </td>
        </tr>
        @php($no = 1)
        @foreach($list_items as $item)
            @if(!empty($item['produk_id']) && $item['produk_id'] != '')
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item['produk']->nama ?? '' }}</td>
                <td class="text-right">{{ format_number($item['harga']) }}</td>
                <td class="text-right">{{ format_number($item['qty']) }}</td>
                <td class="text-right">{{ format_number($item['harga'] * $item['qty']) }}</td>
                <td class="p-0 align-middle text-center">
                    @if(!empty($item['uuid']))
                        <button type="button" class="btn btn-danger btn-icon btn-sm" onclick="delete_item_uuid('{{ $item['uuid'] }}')"><i class="fa fa-times"></i></button>
                    @endif
                </td>
            </tr>
            @endif
        @endforeach
        @if(!empty($transaksi))
            @foreach($transaksi->detail as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->produk->nama ?? '' }}</td>
                    <td class="text-right">{{ format_number($item->harga) }}</td>
                    <td class="text-right">{{ format_number($item->qty) }}</td>
                    <td class="text-right">{{ format_number($item->total) }}</td>
                    <td class="p-0 align-middle text-center">

                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <x-input type="hidden" name="harga_beli" />
</form>

<script>
    init_form_element();

    $('#produk_id').change(() => {
        let id = $('#produk_id').find('option:selected').val();
        $.post("{{ route('admin.produk.info') }}", {
            _token, id, ajax: true
        }, (result) => {
            $('#harga').val(add_commas(result.harga));
            $('#harga_beli').val(add_commas(result.harga_beli));
            $('#qty').focus();
        });
    });

    $('#harga, #qty').change(() => {
        let harga = $('#harga').val(),
            qty = $('#qty').val();
        harga = harga === '' ? 0 : parseInt(remove_commas(harga));
        qty = qty === '' ? 0 : parseInt(remove_commas(qty));
        let total = harga * qty;
        $('#total').val(add_commas(total));
    });

    $('#form_items').submit((e) => {
        e.preventDefault();

        let data = get_form_data($('#form_items'));
        $.post("{{ route('admin.kasir.save_item') }}", data, () => {
            search_items();
        }).fail((xhr) => {
            console.log(xhr.responseText);
        });
    });

    delete_item_uuid = (uuid) => {
        $.post("{{ route('admin.kasir.delete_item') }}", {
            _token, id: uuid
        }, () => {
            search_items();
        }).fail((xhr) => {
            console.log(xhr.responseText);
        });
    }
</script>
