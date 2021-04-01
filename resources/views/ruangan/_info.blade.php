<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_ruangan" />
        <form id="ruangan_form">
            @csrf
            @if(!empty($ruangan))
                <x-input type="hidden" name="id" :value="$ruangan->id" />
            @endif
            <div class="row">
                <div class="col-md-6">
                    <x-form-group id="nama" caption="Nama">
                        <x-input name="nama" :value="$ruangan->nama ?? ''" />
                    </x-form-group>
                    <x-form-group id="harga" caption="Harga">
                        <x-input name="harga" :value="$ruangan->harga ?? ''" class="autonumeric text-right" />
                    </x-form-group>
                    <x-form-group id="tag" caption="Tag">
                        <x-input name="tag" :value="$ruangan->tag ?? ''" />
                    </x-form-group>
                </div>
                <div class="col-md-6">
                    <x-form-group id="keterangan" caption="Keterangan">
                        <x-textarea name="keterangan" :value="$ruangan->keterangan ?? ''" rows="13" />
                    </x-form-group>
                </div>
            </div>
            <div class="row">
                @if(!empty($ruangan))
                    @foreach($ruangan->gambar as $gambar)
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
                        :data-default-file="(($ruangan->file ?? '') != '') ? asset('assets/'.$ruangan->file) : ''"
                    />
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_ruangan()">Back</button>
                    @if(!empty($ruangan))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_ruangan({{ $ruangan->id }})">Delete</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element();

    $ruangan_form = $('#ruangan_form');
    $ruangan_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($ruangan_form.get(0));
        $.ajax({
            url: "{{ route('admin.ruangan.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                ruangan_info(result.id);
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_ruangan', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    delete_ruangan = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('admin.ruangan.delete') }}", data, () => {
                    init_ruangan();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_ruangan', error.errors);
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
                $.post("{{ route('admin.ruangan.delete_gambar') }}", data, () => {
                    ruangan_info('{{ $ruangan->id ?? '' }}');
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_ruangan', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }
</script>
