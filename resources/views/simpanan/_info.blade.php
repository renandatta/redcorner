<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_simpanan" />
        <form id="simpanan_form">
            @csrf
            @if(!empty($simpanan))
                <x-input type="hidden" name="id" :value="$simpanan->id" />
            @endif
            <div class="row">
                <div class="col-md-4">
                    <x-form-group id="member_id" caption="Member">
                        <x-select name="member_id"
                                  :value="$simpanan->member_id ?? $member_id"
                                  :options="$list_member"
                                  class="select2"
                        />
                    </x-form-group>
                    <x-form-group id="jenis_simpanan_id" caption="Jenis Simpanan">
                        <x-select name="jenis_simpanan_id"
                                  :value="$simpanan->jenis_simpanan_id ?? ''"
                                  :options="$list_jenis_simpanan"
                                  class="select2"
                        />
                    </x-form-group>
                    <x-form-group id="no_simpanan" caption="No.Simpanan">
                        <x-input name="no_simpanan" :value="$no_simpanan ?? ''" />
                    </x-form-group>
                    <x-form-group id="tanggal" caption="Tanggal">
                        <x-input name="tanggal" :value="$simpanan->tanggal ?? ''" class="datepicker" autocomplete="off" />
                    </x-form-group>
                    <x-form-group id="nominal" caption="Nominal">
                        <x-input name="nominal" :value="$simpanan->nominal ?? ''" class="autonumeric text-right" />
                    </x-form-group>
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_simpanan()">Back</button>
                    @if(!empty($simpanan))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_simpanan({{ $simpanan->id }})">Delete</button>
                    @endif
                </div>
                <div class="col-md-8">
                    <div id="riwayat_simpanan"></div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element()

    $simpanan_form = $('#simpanan_form');
    $simpanan_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($simpanan_form.get(0));
        $.ajax({
            url: "{{ route('admin.simpanan.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                simpanan_info('', result.member_id);
                init_simpanan();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_simpanan', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    delete_simpanan = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('admin.simpanan.delete') }}", data, () => {
                    init_simpanan();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_simpanan', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }

    _token = '{{ csrf_token() }}';
    // riwayat simapanan anggota
    $riwayat_simpanan = $('#riwayat_simpanan');
    $member_id = $('#member_id');
    $member_id.change(() => {
        let member_id = $member_id.find('option:selected').val();
        $riwayat_simpanan.html('Loading ...');
        $.post("{{ route('admin.simpanan.riwayat.anggota') }}", {
            _token, member_id
        }, (result) => {
            $riwayat_simpanan.html(result);
        }).fail((xhr) => {
            $riwayat_simpanan.html(xhr.responseText);
        });
    });
    $member_id.trigger('change');

    // jenis simpanan
    $nominal = $('#nominal');
    $jenis_simpanan_id = $('#jenis_simpanan_id');
    $jenis_simpanan_id.change(() => {
        let id = $jenis_simpanan_id.find('option:selected').val(),
            ajax = 1;
        if (id === '') $nominal.val('')
        else {
            $.post("{{ route('admin.jenis_simpanan.info') }}", {
                _token, id, ajax
            }, (result) => {
                $nominal.val(add_commas(result.nominal));
            }).fail((xhr) => {
                console.log(xhr.responseText)
            });
        }
    });
</script>
