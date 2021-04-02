@extends('layouts.index')

@section('title')
    Jenis Simpanan -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Jenis Simpanan</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="jenis_simpanan_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="jenis_simpanan_info"></div>
    <div class="card">
        <div class="card-body">
            <div id="jenis_simpanan_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}',
            paginate = 10;
        let $jenis_simpanan_info = $('#jenis_simpanan_info'),
            $jenis_simpanan_table = $('#jenis_simpanan_table');

        search_jenis_simpanan = () => {
            $.post("{{ route('admin.jenis_simpanan.search') }}", {_token, paginate}, (result) => {
                $jenis_simpanan_table.html(result);
            }).fail((xhr) => {
                $jenis_simpanan_table.html(xhr.responseText);
            });
        }

        init_jenis_simpanan = () => {
            $jenis_simpanan_info.html('');
            search_jenis_simpanan();
        }

        jenis_simpanan_info = (id = '') => {
            $.post("{{ route('admin.jenis_simpanan.info') }}", {_token, id}, (result) => {
                $jenis_simpanan_info.html(result);
            }).fail((xhr) => {
                $jenis_simpanan_info.html(xhr.responseText);
            });
        }

        init_jenis_simpanan();
    </script>
@endpush
