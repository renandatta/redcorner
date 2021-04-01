@extends('layouts.index')

@section('title')
    Ruangan -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Ruangan</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="ruangan_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="ruangan_info"></div>
    <div class="card">
        <div class="card-body">
            <div id="ruangan_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}', paginate = 10;
        let $ruangan_info = $('#ruangan_info'),
            $ruangan_table = $('#ruangan_table');

        search_ruangan = () => {
            $.post("{{ route('admin.ruangan.search') }}", {_token, paginate}, (result) => {
                $ruangan_table.html(result);
            }).fail((xhr) => {
                $ruangan_table.html(xhr.responseText);
            });
        }

        init_ruangan = () => {
            $ruangan_info.html('');
            search_ruangan();
        }

        ruangan_info = (id = '') => {
            $.post("{{ route('admin.ruangan.info') }}", {_token, id}, (result) => {
                $ruangan_info.html(result);
            }).fail((xhr) => {
                $ruangan_info.html(xhr.responseText);
            });
        }

        sub_ruangan = (parent_kode) => {
            $.post("{{ route('admin.ruangan.info') }}", {_token, parent_kode}, (result) => {
                $ruangan_info.html(result);
            }).fail((xhr) => {
                $ruangan_info.html(xhr.responseText);
            });
        }

        init_ruangan();
    </script>
@endpush
