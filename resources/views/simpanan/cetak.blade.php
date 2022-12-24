@extends('layouts.print')

@section('content')
    <img src="{{ asset('logo_bpek.png') }}" alt="" style="height: 2cm;position: absolute;">
    <div class="container-fluid">
        <h4 class="text-center">LAPORAN SIMPANAN</h4>
        <p class="text-right">Nama : <b>{{ $simpanan[0]->member->nama }}</b></p>
        <p class="text-right">No.Member : <b>{{ $simpanan[0]->member->no_member }}</b></p>
        <p class="text-right">No.Telp : <b>{{ $simpanan[0]->member->notelp }}</b></p>
    </div>
    <div class="container-fluid mt-5 d-flex justify-content-center w-100">
        <div class="table-responsive w-100">
            @if($kurang_bayar > 0)
            <h5 class="mb-0">Simpanan Wajib yang Belum Dibayar : {{ format_number($kurang_bayar) }}</h5>
            @endif
                @if($kurang_bayar2 > 0)
                    <h5 class="mb-0">Simpanan Wajib yang Belum Dibayar : {{ format_number($kurang_bayar2) }}</h5>
                @endif
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Jenis Simpanan</th>
                    <th class="text-right">Nominal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($simpanan as $key => $value)
                <tr class="text-right">
                    <td class="text-left">{{ $key+1 }}</td>
                    <td class="text-left">{{ format_date($value->tanggal) }}</td>
                    <td class="text-left">{{ $value->jenis_simpanan->nama }}</td>
                    <td>{{ format_number($value->nominal) }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container-fluid w-100">
        <div class="row">
            <div class="col-md-6 ml-auto">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr class="bg-light">
                            <td class="text-bold-800"><b>Total Simpanan</b></td>
                            <td class="text-bold-800 text-right"><b>Rp. {{ format_number($simpanan->sum('nominal')) }}</b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
