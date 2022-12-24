@extends('layouts.index')

@section('title')
    Pembayaran -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Pembayaran</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">

        </div>
    </div>
    <div id="pembayaran_info"></div>
    <div class="card">
        <div class="card-body">
            <form id="pembayaran_search" class="mb-2">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <x-input name="tanggal_awal" prefix="search" class="datepicker" caption="Tanggal Awal" />
                    </div>
                    <div class="col-md-2">
                        <x-input name="tanggal_akhir" prefix="search" class="datepicker" caption="Tanggal Akhir" />
                    </div>
                    <div class="col-md-4">
                        <x-select
                            prefix="search"
                            name="member_id"
                            class="select2"
                            caption="Semua"
                            :options="$list_member"
                        />
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-block btn-primary">Cari</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-block btn-success" onclick="cetak()">Cetak</button>
                    </div>
                </div>
            </form>
            <div id="pembayaran_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        init_form_element();

        let _token = '{{ csrf_token() }}',
            paginate = 10;
        let $pembayaran_info = $('#pembayaran_info'),
            $pembayaran_table = $('#pembayaran_table'),
            $pembayaran_search = $('#pembayaran_search');

        let selected_page = 1;
        search_pembayaran = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            let data = get_form_data($pembayaran_search);
            data.paginate = 10;
            $.post("{{ route('admin.pembayaran.search') }}?page=" + selected_page, data, (result) => {
                $pembayaran_table.html(result);
            }).fail((xhr) => {
                $pembayaran_table.html(xhr.responseText);
            });
        }

        init_pembayaran = () => {
            $pembayaran_info.html('');
            search_pembayaran(selected_page);
        }

        $pembayaran_search.submit((e) => {
            e.preventDefault();
            search_pembayaran(1);
        });

        init_pembayaran();

        cetak = () => {
            let data = get_form_data($pembayaran_search);
            delete data._token;
            let params = $.param(data);
            window.open("{{ route('admin.pembayaran.cetak') }}?" + params, '_blank');
        }
    </script>
@endpush
