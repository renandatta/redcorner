@extends('layouts.index')

@section('title')
    Simpanan -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Simpanan</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="simpanan_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="simpanan_info"></div>
    <div class="card">
        <div class="card-body">
            <form id="simpanan_search" class="mb-2">
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
            <div id="simpanan_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        init_form_element();

        let _token = '{{ csrf_token() }}',
            paginate = 10;
        let $simpanan_info = $('#simpanan_info'),
            $simpanan_table = $('#simpanan_table'),
            $simpanan_search = $('#simpanan_search');

        let selected_page = 1;
        search_simpanan = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            let data = get_form_data($simpanan_search);
            data.paginate = 10;
            $.post("{{ route('admin.simpanan.search') }}?page=" + selected_page, data, (result) => {
                $simpanan_table.html(result);
            }).fail((xhr) => {
                $simpanan_table.html(xhr.responseText);
            });
        }

        init_simpanan = () => {
            $simpanan_info.html('');
            search_simpanan(selected_page);
        }

        simpanan_info = (id = '', member_id = '') => {
            $.post("{{ route('admin.simpanan.info') }}", {_token, id, member_id}, (result) => {
                $simpanan_info.html(result);
            }).fail((xhr) => {
                $simpanan_info.html(xhr.responseText);
            });
        }

        $simpanan_search.submit((e) => {
            e.preventDefault();
            search_simpanan(1);
        });

        cetak = () => {
            let data = get_form_data($simpanan_search);
            delete data._token;
            let params = $.param(data);
            window.open("{{ route('admin.simpanan.cetak') }}?" + params, '_blank');
        }

        init_simpanan();
    </script>
@endpush
