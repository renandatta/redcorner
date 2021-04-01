<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_user" />
        <form id="user_form">
            @csrf
            @if(!empty($user))
                <x-input type="hidden" name="id" :value="$user->id" />
            @endif
            <div class="row">
                <div class="col-md-6">
                    <x-form-group id="nama" caption="Nama">
                        <x-input name="nama" :value="$user->nama ?? ''" />
                    </x-form-group>
                    <x-form-group id="email" caption="Username">
                        <x-input name="email" :value="$user->email ?? ''" />
                    </x-form-group>
                    <x-form-group id="password" caption="Password">
                        <x-input name="password" type="password" />
                        <i>*) Kosongi apabila tidak diubah</i>
                    </x-form-group>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_user()">Cancel</button>
                    @if(!empty($user))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_user({{ $user->id }})">Delete</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $user_form = $('#user_form');
    $user_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($user_form.get(0));
        $.ajax({
            url: "{{ route('admin.user.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                init_user();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_user', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    delete_user = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('admin.user.delete') }}", data, () => {
                    init_user();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_user', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }
</script>
