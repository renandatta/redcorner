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
            <a type="button" class="btn btn-light" href="{{ route('admin.kasir') }}">Kembali</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.kasir.save') }}" method="post">
                        @csrf
                        <x-input name="id" type="hidden" :value="$transaksi->id ?? ''" />
                        <x-form-group id="no_transaksi" caption="No.Transaksi">
                            <x-input name="no_transaksi" :value="$transaksi->no_transaksi ?? 'Otomatis'" />
                        </x-form-group>
                        <x-form-group id="tanggal" caption="Tanggal">
                            <x-input name="tanggal" class="datepicker" :value="format_date($transaksi->tanggal ?? date('Y-m-d'))" />
                        </x-form-group>
                        <br>
                        <button class="btn btn-primary btn-block" type="submit">Simpan Transaksi</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body" id="data_items">

                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        init_form_element();

        let _token = '{{ csrf_token() }}';
        let transaksi_id = '{{ $transaksi->id ?? '' }}';
        let $data_items = $('#data_items');
        let search_items = () => {
            $.post("{{ route('admin.kasir.search_item') }}", {_token, transaksi_id}, (result) => {
                $data_items.html(result);
            }).fail((xhr) => {
                $data_items.html(xhr.responseText);
            })
        }

        search_items();
    </script>
@endpush
