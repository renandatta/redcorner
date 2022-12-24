@extends('layouts.print')

@section('content')
    <img src="{{ asset('logo_bpek.png') }}" alt="" style="height: 2cm;position: absolute;">
    <div class="container-fluid">
        <h4 class="text-center">LAPORAN PEMBAYARAN</h4>
    </div>
    <div class="container-fluid mt-5 d-flex justify-content-center w-100">
        <div class="table-responsive w-100">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Member</th>
                    <th>Tanggal</th>
                    <th class="text-right">Nominal</th>
                    <th class="text-right">Bunga</th>
                </tr>
                </thead>
                <tbody>
                @php($no = 1)
                @foreach($pembayaran as $value)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td class="text-nowrap">{{ $value->pinjaman->member->nama }}</td>
                        <td class="text-nowrap">{{ format_date($value->tanggal) }}</td>
                        <td class="text-nowrap text-right">{{ format_number($value->nominal) }}</td>
                        <td class="text-nowrap text-right">{{ format_number($value->pinjaman->bunga_rupiah) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
