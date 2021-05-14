@extends('layouts.index')

@section('title')
    Transaksi -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Transaksi</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary" onclick="transaksi_info()">
                Add New
            </button>
        </div>
    </div>
    <div id="transaksi_info"></div>
    <div class="card">
        <div class="card-body">
            <form id="transaksi_search">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <select name="status" id="status" class="form-control select2">
                            <option value="">Semua Status</option>
                            @foreach($list_status as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-block btn-primary">Cari</button>
                    </div>
                </div>
            </form>
            <div id="transaksi_table"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        init_form_element();

        let _token = '{{ csrf_token() }}';
        let $transaksi_info = $('#transaksi_info'),
            $transaksi_table = $('#transaksi_table');

        $transaksi_search = $('#transaksi_search');
        $transaksi_search.submit((e) => {
            e.preventDefault();
            search_transaksi(1);
        });

        let selected_page = 1;
        search_transaksi = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            let data = get_form_data($transaksi_search);
            data.paginate = 10;
            $.post("{{ route('admin.transaksi.search') }}?page=" + selected_page, data, (result) => {
                $transaksi_table.html(result);
            }).fail((xhr) => {
                $transaksi_table.html(xhr.responseText);
            });
        }

        init_transaksi = () => {
            $transaksi_info.html('');
            search_transaksi();
        }

        transaksi_info = (id = '') => {
            $.post("{{ route('admin.transaksi.info') }}", {_token, id}, (result) => {
                $transaksi_info.html(result);
            }).fail((xhr) => {
                $transaksi_info.html(xhr.responseText);
            });
        }

        init_transaksi();
    </script>
@endpush
