<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_pinjaman" />
        <form id="pinjaman_form">
            @csrf
            @if(!empty($pinjaman))
                <x-input type="hidden" name="id" :value="$pinjaman->id" />
            @endif
            <div class="row">
                <div class="col-md-4">
                    <x-form-group id="member_id" caption="Member">
                        <x-select name="member_id"
                                  :value="$pinjaman->member_id ?? $member_id"
                                  :options="$list_member"
                                  class="select2"
                        />
                    </x-form-group>
                    <x-form-group id="no_pinjaman" caption="No.Pinjaman">
                        <x-input name="no_pinjaman" :value="$no_pinjaman ?? ''" />
                    </x-form-group>
                    <x-form-group id="tanggal" caption="Tanggal">
                        <x-input name="tanggal" :value="$pinjaman->tanggal ?? date('d-m-Y')" class="datepicker" autocomplete="off" />
                    </x-form-group>
                    <x-form-group id="nominal" caption="Nominal">
                        <x-input name="nominal" :value="$pinjaman->nominal ?? ''" class="autonumeric text-right" />
                    </x-form-group>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <x-form-group id="bunga" caption="Bunga (%)">
                                <x-input name="bunga" :value="$pinjaman->bunga ?? ''" class="autonumeric text-right" />
                            </x-form-group>
                        </div>
                        <div class="col-md-6">
                            <x-form-group id="bunga_rupiah" caption="Bunga (Rp.)">
                                <x-input name="bunga_rupiah" :value="$pinjaman->bunga_rupiah ?? ''" class="autonumeric text-right" />
                            </x-form-group>
                        </div>
                    </div>
                    <x-form-group id="tenor" caption="Tenor">
                        <x-input name="tenor" :value="$pinjaman->tenor ?? ''" class="autonumeric text-right" />
                    </x-form-group>
                    <x-form-group id="angsuran" caption="Angsuran">
                        <x-input name="angsuran" :value="$pinjaman->angsuran ?? ''" class="autonumeric text-right" readonly />
                    </x-form-group>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_pinjaman()">Back</button>
                    @if(!empty($pinjaman))
                        <button class="btn btn-danger float-right" type="button" onclick="delete_pinjaman({{ $pinjaman->id }})">Delete</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element()

    $pinjaman_form = $('#pinjaman_form');
    $pinjaman_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($pinjaman_form.get(0));
        $.ajax({
            url: "{{ route('admin.pinjaman.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                init_pinjaman();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_pinjaman', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    delete_pinjaman = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value === true) {
                let data = {_token: '{{ csrf_token() }}', id};
                $.post("{{ route('admin.pinjaman.delete') }}", data, () => {
                    init_pinjaman();
                }).fail((xhr) => {
                    let error = JSON.parse(xhr.responseText);
                    if (error.errors) {
                        display_error('alert_pinjaman', error.errors);
                    } else {
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }

    $nominal = $('#nominal');
    $bunga_rupiah = $('#bunga_rupiah');
    $bunga = $('#bunga');
    hitung_bunga = (mode) => {
        let nominal = $nominal.val();
        nominal = (nominal !== '') ? parseFloat(remove_commas(nominal)) : 0;
        let bunga = $bunga.val();
        bunga = (bunga !== '') ? parseFloat(remove_commas(bunga)) : 0;
        let bunga_rupiah = $bunga_rupiah.val();
        bunga_rupiah = (bunga_rupiah !== '') ? parseFloat(remove_commas(bunga_rupiah)) : 0;
        if (nominal > 0) {
            if (bunga > 0 && mode === 'persen') {
                bunga_rupiah = (bunga / 100) * nominal;
                $bunga_rupiah.val(add_commas(bunga_rupiah));
            }
            if (bunga_rupiah > 0 && mode === 'rupiah') {
                bunga = (bunga_rupiah / nominal) * 100;
                $bunga.val(bunga.toString().replace('.', ','));
            }
        }
    }
    $bunga.change(() => {
        hitung_bunga('persen');
    });
    $bunga_rupiah.change(() => {
        hitung_bunga('rupiah');
    });

    $tenor = $('#tenor');
    $tenor.change(() => {
        let tenor = $tenor.val(),
            nominal = $nominal.val(),
            bunga_rupiah = $bunga_rupiah.val();
        tenor = (tenor !== '') ? parseFloat(remove_commas(tenor)) : 0;
        nominal = (nominal !== '') ? parseFloat(remove_commas(nominal)) : 0;
        bunga_rupiah = (bunga_rupiah !== '') ? parseFloat(remove_commas(bunga_rupiah)) : 0;
        let angsuran = ((nominal / tenor) + bunga_rupiah).toFixed(0);
        $('#angsuran').val(add_commas(angsuran));
    });
</script>
