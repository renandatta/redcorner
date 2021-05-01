<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_member" />
        <form id="member_form">
            @csrf
            @if(!empty($member))
                <x-input type="hidden" name="id" :value="$member->id" />
            @endif
            <div class="row">
                <div class="col-md-6">
                    <x-form-group id="nama" caption="Nama">
                        <x-input name="nama" :value="$member->nama ?? ''" />
                    </x-form-group>
                    <div class="row">
                        <div class="col-md-6">
                            <x-form-group id="nik" caption="NIK">
                                <x-input name="nik" :value="$member->nik ?? ''" />
                            </x-form-group>
                        </div>
                        <div class="col-md-6">
                            <x-form-group id="no_member" caption="No.Member">
                                <x-input name="no_member" :value="$no_member ?? ''" />
                            </x-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-form-group id="notelp" caption="No.Telp">
                                <x-input name="notelp" :value="$member->notelp ?? ''" />
                            </x-form-group>
                        </div>
                        <div class="col-md-6">
                            <x-form-group id="jenis_kelamin" caption="Jenis Kelamin">
                                <x-select name="jenis_kelamin"
                                          :value="$member->jenis_kelamin ?? ''"
                                          :options="$list_jenis_kelamin"
                                          class="select2"
                                />
                            </x-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-form-group id="tempat_lahir" caption="Tempat Lahir">
                                <x-input name="tempat_lahir" :value="$member->tempat_lahir ?? ''" />
                            </x-form-group>
                        </div>
                        <div class="col-md-6">
                            <x-form-group id="tanggal_lahir" caption="Tanggal Lahir">
                                <x-input name="tanggal_lahir" class="datepicker" :value="format_date($member->tanggal_lahir ?? '')" />
                            </x-form-group>
                        </div>
                    </div>
                    <x-form-group id="alamat" caption="Alamat">
                        <x-input name="alamat" :value="$member->alamat ?? ''" />
                    </x-form-group>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_member()">Back</button>
                    @if(!empty($member))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_member({{ $member->id }})">Delete</button>
                    @endif
                </div>
                <div class="col-md-3">
                    <x-form-group id="file" caption="Foto">
                        <x-input
                            type="file"
                            name="file"
                            class="dropify"
                            accept="image/jpeg, image/png"
                            data-height="400"
                            data-allowed-file-extensions="png jpg jpeg"
                            :data-default-file="(($member->foto ?? '') != '') ? asset('assets/'.$member->foto) : ''"
                        />
                    </x-form-group>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element()

    $member_form = $('#member_form');
    $member_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($member_form.get(0));
        $.ajax({
            url: "{{ route('admin.member.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                init_member();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_member', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    delete_member = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('admin.member.delete') }}", data, () => {
                    init_member();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_member', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }
</script>
