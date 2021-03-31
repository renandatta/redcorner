@extends('layouts.index')

@section('title')
    Kategori -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Kategori</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="kategori_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="kategori_info"></div>
    <div class="card">
        <div class="card-body">
            <div id="kategori_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}';
        let $kategori_info = $('#kategori_info'),
            $kategori_table = $('#kategori_table');

        search_kategori = () => {
            $.post("{{ route('admin.kategori.search') }}", {_token}, (result) => {
                $kategori_table.html(result);
            }).fail((xhr) => {
                $kategori_table.html(xhr.responseText);
            });
        }

        init_kategori = () => {
            $kategori_info.html('');
            search_kategori();
        }

        kategori_info = (id = '') => {
            $.post("{{ route('admin.kategori.info') }}", {_token, id}, (result) => {
                $kategori_info.html(result);
            }).fail((xhr) => {
                $kategori_info.html(xhr.responseText);
            });
        }

        sub_kategori = (parent_kode) => {
            $.post("{{ route('admin.kategori.info') }}", {_token, parent_kode}, (result) => {
                $kategori_info.html(result);
            }).fail((xhr) => {
                $kategori_info.html(xhr.responseText);
            });
        }

        init_kategori();
    </script>
@endpush
