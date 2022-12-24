@extends('layouts.index')

@section('title')
    Kasir -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Kasir</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a type="button" class="btn btn-primary" href="{{ route('admin.kasir.info') }}">Transaksi Baru</a>
        </div>
    </div>
    <div id="transaksi_info"></div>
    <div class="card">
        <div class="card-body">
            <form id="transaksi_search" style="display: none;">
                @csrf
                <div class="row">
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
            $.post("{{ route('admin.kasir.search') }}?page=" + selected_page, data, (result) => {
                $transaksi_table.html(result);
            }).fail((xhr) => {
                $transaksi_table.html(xhr.responseText);
            });
        }

        delete_transaksi = (id) => {
            $.post("{{ route('admin.kasir.delete') }}", {
                _token, id
            }, () => {
                search_transaksi();
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }

        search_transaksi();
    </script>
@endpush
