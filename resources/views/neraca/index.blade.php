@extends('layouts.index')

@section('title')
    Neraca -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Neraca</h4>
        </div>
    </div>
    <div id="neraca_info"></div>
    <div class="card">
        <div class="card-body">
            <div id="neraca_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        init_form_element();

        let _token = '{{ csrf_token() }}';
        let $neraca_table = $('#neraca_table');

        search_neraca = () => {

            $.post("{{ route('admin.neraca.search') }}", {_token}, (result) => {
                $neraca_table.html(result);
            }).fail((xhr) => {
                $neraca_table.html(xhr.responseText);
            });
        }
        search_neraca();

    </script>
@endpush
