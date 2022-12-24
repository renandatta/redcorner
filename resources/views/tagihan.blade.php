@extends('layouts.print')

@section('title')
    Tagihan Member -
@endsection

@section('content')
    <h1 class="text-center">Tagihan Simpanan Wajib Anggota</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="3%">No.</th>
            <th>Nama</th>
            <th>No.Anggota</th>
            <th colspan="2">Pembayaran Terakhir</th>
            <th>Durasi Tagihan</th>
            <th>Nominal Tagihan</th>
        </tr>
        </thead>
        <tbody>
        @foreach($result as $key => $value)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $value->nama }}</td>
                <td>{{ $value->no_member }}</td>
                <td>{{ format_date($value->terakhir->tanggal) }}</td>
                <td class="text-right">{{ format_number($value->terakhir->nominal) }}</td>
                <td class="text-center">{{ $value->durasi }}</td>
                <td class="text-right">{{ format_number($value->tagihan) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')

@endpush
