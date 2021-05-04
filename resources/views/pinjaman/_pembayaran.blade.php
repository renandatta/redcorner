<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_pembayaran" />
        <form id="pembayaran_form">
            @csrf
            @if(!empty($pembayaran))
                <x-input type="hidden" name="id" :value="$pembayaran->id" />
            @endif
            <x-input type="hidden" name="pinjaman_id" :value="$pinjaman_id" />
            <div class="row">
                <div class="col-md-4">
                    <x-form-group id="pembayaran_ke" caption="Pembayaran Ke-">
                        <x-input name="pembayaran_ke" :value="$pembayaran_ke ?? ''" />
                    </x-form-group>
                    <x-form-group id="tanggal" caption="Tanggal">
                        <x-input name="tanggal" :value="$pembayaran->tanggal ?? date('d-m-Y')" class="datepicker" autocomplete="off" />
                    </x-form-group>
                    <x-form-group id="nominal" caption="Nominal">
                        <x-input name="nominal" :value="$pembayaran->nominal ?? $pinjaman->angsuran" class="autonumeric text-right" />
                    </x-form-group>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_pinjaman()">Back</button>
                </div>
                <div class="col-md-6">
                    <div id="table_pembayaran"></div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element();

    $pembayaran_form = $('#pembayaran_form');
    $pembayaran_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($pembayaran_form.get(0));
        $.ajax({
            url: "{{ route('admin.pinjaman.pembayaran.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                pembayaran('{{ $pinjaman_id }}');
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_pembayaran', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    $table_pembayaran = $('#table_pembayaran');
    search_pembayaran = () => {
        $table_pembayaran.html('Loading ...');
        $.post("{{ route('admin.pinjaman.pembayaran.search') }}", {
            _token: '{{ csrf_token() }}',
            pinjaman_id: '{{ $pinjaman_id }}'
        }, (result) => {
            $table_pembayaran.html(result);
        }).fail((xhr) => {
            $table_pembayaran.html(xhr.responseText);
        });
    }
    search_pembayaran();

    pembayaran_hapus = (id) => {
        $.post("{{ route('admin.pinjaman.pembayaran.delete') }}", {
            _token: '{{ csrf_token() }}', id
        }, () => {
            pembayaran('{{ $pinjaman_id }}');
        }).fail((xhr) => {
            console.log(xhr.responseText);
        });
    }
</script>
