@extends('layouts.index')

@section('title')
    Member -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Member</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="member_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="member_info"></div>
    <div class="card">
        <div class="card-body">
            <div id="member_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _token = '{{ csrf_token() }}',
            paginate = 10;
        let $member_info = $('#member_info'),
            $member_table = $('#member_table');

        search_member = () => {
            $.post("{{ route('admin.member.search') }}", {_token, paginate}, (result) => {
                $member_table.html(result);
            }).fail((xhr) => {
                $member_table.html(xhr.responseText);
            });
        }

        init_member = () => {
            $member_info.html('');
            search_member();
        }

        member_info = (id = '') => {
            $.post("{{ route('admin.member.info') }}", {_token, id}, (result) => {
                $member_info.html(result);
            }).fail((xhr) => {
                $member_info.html(xhr.responseText);
            });
        }

        init_member();
    </script>
@endpush
