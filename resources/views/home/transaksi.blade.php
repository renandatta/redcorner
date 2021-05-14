@extends('layouts.home')

@section('title')
    Riwayat Transaksi
@endsection

@section('content')
    <div class="main-content main-content-details single no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content-cart main-content col-sm-12">
                    <h3 class="custom_blog_title" style="margin-bottom: 20px;">Riwayat Transaksi</h3>
                    <div class="page-main-content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No.Transaksi</th>
                                <th>Tanggal</th>
                                <th class="text-right">Harga Produk</th>
                                <th class="text-right">Total Biaya</th>
                                <th>No.Resi</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transaksi as $value)
                                <tr>
                                    <td class="vertical-middle">{{ $value->no_transaksi }}</td>
                                    <td class="vertical-middle">{{ format_date($value->tanggal) }}</td>
                                    <td class="text-right vertical-middle">{{ format_number($value->harga_produk) }}</td>
                                    <td class="text-right vertical-middle">{{ format_number($value->total_biaya) }}</td>
                                    <td class="vertical-middle">{{ $value->no_resi }}</td>
                                    <td class="text-center vertical-middle">{{ $value->status }}</td>
                                    <td class="text-center py-1">
                                        <a href="{{ route('transaksi.detail', $value->no_transaksi) }}" class="btn btn-xs btn-danger">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

    </script>
@endpush
