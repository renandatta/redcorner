@extends('layouts.index')

@section('title')
    Produk -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Produk</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="produk_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="produk_info"></div>
    <div class="card">
        <div class="card-body">
            <div id="produk_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10;
        let $produk_info = $('#produk_info'),
            $produk_table = $('#produk_table');

        let selected_page = 1;
        let search_produk = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('admin.produk.search') }}?page=" + selected_page, {_token, paginate}, (result) => {
                $produk_table.html(result);
            }).fail((xhr) => {
                $produk_table.html(xhr.responseText);
            });
        }

        let init_produk = () => {
            $produk_info.html('');
            search_produk();
        }

        let produk_info = (id = '') => {
            $('#button_info_' + id).html('<i class="fa fa-spinner fa-spin"></i>');
            $.post("{{ route('admin.produk.info') }}", {_token, id}, (result) => {
                $produk_info.html(result);
                $('#button_info_' + id).html('<i class="mdi mdi-arrow-right text-white"></i>');
            }).fail((xhr) => {
                $produk_info.html(xhr.responseText);
            });
        }

        let sub_produk = (parent_kode) => {
            $.post("{{ route('admin.produk.info') }}", {_token, parent_kode}, (result) => {
                $produk_info.html(result);
            }).fail((xhr) => {
                $produk_info.html(xhr.responseText);
            });
        }

        init_produk();
    </script>
@endpush
