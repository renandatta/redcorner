@extends('layouts.index')

@section('title')
    User -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">User</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="user_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="user_info"></div>
    <div class="card">
        <div class="card-body">
            <div id="user_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}',
            paginate = 10;
        let $user_info = $('#user_info'),
            $user_table = $('#user_table');

        let selected_page = 1;
        search_user = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            $.post("{{ route('admin.user.search') }}?page=" + selected_page, {_token, paginate}, (result) => {
                $user_table.html(result);
            }).fail((xhr) => {
                $user_table.html(xhr.responseText);
            });
        }

        init_user = () => {
            $user_info.html('');
            search_user();
        }

        user_info = (id = '') => {
            $.post("{{ route('admin.user.info') }}", {_token, id}, (result) => {
                $user_info.html(result);
            }).fail((xhr) => {
                $user_info.html(xhr.responseText);
            });
        }

        init_user();
    </script>
@endpush
