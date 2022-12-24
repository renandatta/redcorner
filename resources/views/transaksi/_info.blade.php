<div class="card mb-3">
    <div class="card-body">
        <x-alert type="error" id="alert_transaksi" />
        <form id="transaksi_form">
            @csrf
            @if(!empty($transaksi))
                <x-input type="hidden" name="id" :value="$transaksi->id" />
            @endif
            <div class="row">
                <div class="col-md-4">
                    <x-form-group id="no_transaksi" caption="No.Transaksi">
                        <x-input name="no_transaksi" :value="$transaksi->no_transaksi ?? ''" readonly />
                    </x-form-group>
                    <x-form-group id="tanggal" caption="Tanggal">
                        <x-input name="tanggal" :value="$transaksi->tanggal ?? ''" readonly />
                    </x-form-group>
                    <x-form-group id="pembeli" caption="Pembeli">
                        <x-input name="pembeli" :value="$transaksi->user->nama ?? ''" readonly />
                    </x-form-group>
                    <x-form-group id="alamat_pengiriman" caption="Alamat Pengiriman">
                        <x-textarea name="alamat_pengiriman" rows="4" :value="$transaksi->alamat_pengiriman ?? ''" readonly />
                    </x-form-group>
                    <x-form-group id="kodepos" caption="Kodepos">
                        <x-input name="kodepos" :value="$transaksi->kodepos ?? ''" readonly />
                    </x-form-group>
                    <x-form-group id="nama_penerima" caption="Nama Penerima">
                        <x-input name="nama_penerima" :value="$transaksi->nama_penerima ?? ''" readonly />
                    </x-form-group>
                    <x-form-group id="notelp" caption="No.Telp">
                        <x-input name="notelp" :value="$transaksi->notelp ?? ''" readonly />
                    </x-form-group>
                </div>
                <div class="col-md-4">
                    <x-form-group id="biaya_pengiriman" caption="Biaya Pengiriman">
                        <x-input
                            name="biaya_pengiriman"
                            class="autonumeric"
                            :value="$transaksi->biaya_pengiriman ?? 0"
                        />
                    </x-form-group>
                    <x-form-group id="diskon" caption="Diskon (Rp.)">
                        <x-input
                            name="diskon"
                            class="autonumeric"
                            :value="$transaksi->diskon ?? 0"
                        />
                    </x-form-group>
                    <x-form-group id="no_resi" caption="No.Resi">
                        <x-input name="no_resi" :value="$transaksi->no_resi ?? ''" />
                    </x-form-group>
                </div>
                <div class="col-md-4">
                    <x-form-group id="rekening_bank" caption="Bank">
                        <x-input name="rekening_bank" :value="$transaksi->rekening_bank ?? ''" readonly />
                    </x-form-group>
                    <x-form-group id="rekening_no" caption="No.Rekening">
                        <x-input name="rekening_no" :value="$transaksi->rekening_no ?? ''" readonly />
                    </x-form-group>
                    <x-form-group id="rekening_nama" caption="Nama Rekening">
                        <x-input name="rekening_nama" :value="$transaksi->rekening_nama ?? ''" readonly />
                    </x-form-group>
                    <x-form-group id="nominal_transafer" caption="Nominal Transfer">
                        <x-input name="nominal_transafer" class="autonumeric" :value="$transaksi->nominal_transfer ?? ''" readonly />
                    </x-form-group>
                    <x-form-group id="bukti_transfer" caption="Bukti Transfer">
                        <img src="{{ asset('assets/' . ($transaksi->file_bukti ?? '')) }}" alt="" class="img-fluid">
                    </x-form-group>
                </div>
                <div class="col-12">
                    <x-input type="hidden" name="status" :value="$transaksi->status ?? ''" />
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <button class="btn btn-light ml-2" type="button" onclick="init_transaksi()">Kembali</button>
                    @if(($transaksi->status ?? '') == 'Proses Pengiriman')
                        <button class="btn btn-primary ml-5" type="submit" onclick="pengiriman_selesai()">Pengiriman Selesai</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    init_form_element();

    $transaksi_form = $('#transaksi_form');
    $transaksi_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($transaksi_form.get(0));
        $.ajax({
            url: "{{ route('admin.transaksi.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function() {
                init_transaksi();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                display_error('alert_transaksi', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });

    @if(($transaksi->status ?? '') != 'Menunggu Validasi Toko')
        $('#biaya_pengiriman').attr('readonly', 'readonly');
        $('#diskon').attr('readonly', 'readonly');
    @endif

    @if(($transaksi->status ?? '') != 'Menunggu Validasi Pembayaran')
        $('#no_resi').attr('readonly', 'readonly');
    @endif

    pengiriman_selesai = () => {
        $('#status').val('Selesai');
    }
</script>
