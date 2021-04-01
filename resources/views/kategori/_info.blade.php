<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_kategori" />
        <form id="kategori_form">
            @csrf
            <x-input type="hidden" name="kode" :value="$kode" />
            <x-input type="hidden" name="parent_kode" :value="$parent_kode" />
            @if(!empty($kategori))
                <x-input type="hidden" name="id" :value="$kategori->id" />
            @endif
            <div class="row">
                <div class="col-md-6">
                    <x-form-group id="nama" caption="Nama">
                        <x-input name="nama" :value="$kategori->nama ?? ''" />
                    </x-form-group>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_kategori()">Cancel</button>
                    @if(!empty($kategori))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_kategori({{ $kategori->id }})">Delete</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $kategori_form = $('#kategori_form');
    $kategori_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($kategori_form.get(0));
        $.ajax({
            url: "{{ route('admin.kategori.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                init_kategori();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_kategori', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    delete_kategori = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('admin.kategori.delete') }}", data, () => {
                    init_kategori();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_kategori', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }
</script>
