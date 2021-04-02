<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_jenis_simpanan" />
        <form id="jenis_simpanan_form">
            @csrf
            @if(!empty($jenis_simpanan))
                <x-input type="hidden" name="id" :value="$jenis_simpanan->id" />
            @endif
            <div class="row">
                <div class="col-md-6">
                    <x-form-group id="nama" caption="Nama">
                        <x-input name="nama" :value="$jenis_simpanan->nama ?? ''" />
                    </x-form-group>
                    <x-form-group id="tipe" caption="Tipe">
                        <x-select name="tipe"
                                  class="select2"
                                  :value="$jenis_simpanan->tipe ?? ''"
                                  :options="$list_tipe"
                        />
                    </x-form-group>
                    <x-form-group id="nominal" caption="Nominal">
                        <x-input name="nominal" :value="$jenis_simpanan->nominal ?? ''" class="autonumeric text-right" />
                    </x-form-group>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_jenis_simpanan()">Back</button>
                    @if(!empty($jenis_simpanan))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_jenis_simpanan({{ $jenis_simpanan->id }})">Delete</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element()

    $jenis_simpanan_form = $('#jenis_simpanan_form');
    $jenis_simpanan_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($jenis_simpanan_form.get(0));
        $.ajax({
            url: "{{ route('admin.jenis_simpanan.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                init_jenis_simpanan();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_jenis_simpanan', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    delete_jenis_simpanan = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('admin.jenis_simpanan.delete') }}", data, () => {
                    init_jenis_simpanan();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_jenis_simpanan', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }
</script>
