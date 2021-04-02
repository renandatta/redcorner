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
            <div id="simpanan_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}',
            paginate = 10;
        let $simpanan_info = $('#simpanan_info'),
            $simpanan_table = $('#simpanan_table');

        search_simpanan = () => {
            $.post("{{ route('admin.simpanan.search') }}", {_token, paginate}, (result) => {
                $simpanan_table.html(result);
            }).fail((xhr) => {
                $simpanan_table.html(xhr.responseText);
            });
        }

        init_simpanan = () => {
            $simpanan_info.html('');
            search_simpanan();
        }

        simpanan_info = (id = '') => {
            $.post("{{ route('admin.simpanan.info') }}", {_token, id}, (result) => {
                $simpanan_info.html(result);
            }).fail((xhr) => {
                $simpanan_info.html(xhr.responseText);
            });
        }

        init_simpanan();
    </script>
@endpush
