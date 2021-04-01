<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_produk" />
        <form id="produk_form">
            @csrf
            @if(!empty($produk))
                <x-input type="hidden" name="id" :value="$produk->id" />
            @endif
            <div class="row">
                <div class="col-md-6">
                    <x-form-group id="kategori_id" caption="Kategori">
                        <x-select
                            name="kategori_id"
                            class="select2"
                            :options="$list_kategori"
                            :value="$produk->kategori_id ?? ''" />
                    </x-form-group>
                    <x-form-group id="nama" caption="Nama">
                        <x-input name="nama" :value="$produk->nama ?? ''" />
                    </x-form-group>
                    <x-form-group id="harga" caption="Harga">
                        <x-input name="harga" :value="$produk->harga ?? ''" class="autonumeric text-right" />
                    </x-form-group>
                </div>
                <div class="col-md-6">
                    <x-form-group id="tag" caption="Tag">
                        <x-input name="tag" :value="$produk->tag ?? ''" />
                    </x-form-group>
                    <x-form-group id="keterangan" caption="Keterangan">
                        <x-textarea name="keterangan" :value="$produk->keterangan ?? ''" rows="6" />
                    </x-form-group>
                </div>
            </div>
            <div class="row">
                @if(!empty($produk))
                    @foreach($produk->gambar as $gambar)
                        <div class="col-md-2">
                            <img src="{{ asset("assets/$gambar->file") }}" alt="" class="img-fluid">
                            <button
                                class="btn btn-danger btn-xs btn-block"
                                type="button"
                                onclick="delete_gambar({{ $gambar->id }})"
                            >Hapus</button>
                        </div>
                    @endforeach
                @endif
                <div class="col-md-2">
                    <x-input
                        type="file"
                        name="file"
                        class="dropify"
                        accept="image/jpeg, image/png"
                        data-height="130"
                        data-allowed-file-extensions="png jpg jpeg"
                        :data-default-file="(($produk->file ?? '') != '') ? asset('assets/'.$produk->file) : ''"
                    />
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_produk()">Back</button>
                    @if(!empty($produk))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_produk({{ $produk->id }})">Delete</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element();

    $produk_form = $('#produk_form');
    $produk_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($produk_form.get(0));
        $.ajax({
            url: "{{ route('admin.produk.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                produk_info(result.id);
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_produk', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    delete_produk = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('admin.produk.delete') }}", data, () => {
                    init_produk();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_produk', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }

    delete_gambar = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('admin.produk.delete_gambar') }}", data, () => {
                    produk_info('{{ $produk->id ?? '' }}');
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_produk', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }
</script>
