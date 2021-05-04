@extends('layouts.index')

@section('title')
    Pinjaman -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Pinjaman</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="pinjaman_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="pinjaman_info"></div>
    <div class="card">
        <div class="card-body">
            <form id="pinjaman_search" class="mb-2">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <x-select
                            prefix="search"
                            name="member_id"
                            class="select2"
                            caption="Semua"
                            :options="$list_member"
                        />
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-block btn-primary">Cari</button>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-block btn-success" onclick="cetak()">Cetak</button>
                    </div>
                </div>
            </form>
            <div id="pinjaman_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        init_form_element();

        let _token = '{{ csrf_token() }}',
            paginate = 10;
        let $pinjaman_info = $('#pinjaman_info'),
            $pinjaman_table = $('#pinjaman_table'),
            $pinjaman_search = $('#pinjaman_search');

        let selected_page = 1;
        search_pinjaman = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            let data = get_form_data($pinjaman_search);
            data.paginate = 10;
            $.post("{{ route('admin.pinjaman.search') }}?page=" + selected_page, data, (result) => {
                $pinjaman_table.html(result);
            }).fail((xhr) => {
                $pinjaman_table.html(xhr.responseText);
            });
        }

        init_pinjaman = () => {
            $pinjaman_info.html('');
            search_pinjaman(selected_page);
        }

        pinjaman_info = (id = '', member_id = '') => {
            $.post("{{ route('admin.pinjaman.info') }}", {_token, id, member_id}, (result) => {
                $pinjaman_info.html(result);
            }).fail((xhr) => {
                $pinjaman_info.html(xhr.responseText);
            });
        }

        $pinjaman_search.submit((e) => {
            e.preventDefault();
            search_pinjaman(1);
        });

        init_pinjaman();

        pembayaran = (pinjaman_id) =>{
            $.post("{{ route('admin.pinjaman.pembayaran') }}", {_token, pinjaman_id}, (result) => {
                $pinjaman_info.html(result);
            }).fail((xhr) => {
                $pinjaman_info.html(xhr.responseText);
            });
        }

        cetak = () => {
            let data = get_form_data($pinjaman_search);
            delete data._token;
            let params = $.param(data);
            window.open("{{ route('admin.pinjaman.cetak') }}?" + params, '_blank');
        }
    </script>
@endpush
