@extends('layouts.print')

@section('content')
    <img src="{{ asset('logo_bpek.png') }}" alt="" style="height: 2cm;position: absolute;">
    <div class="container-fluid">
        <h4 class="text-center">LAPORAN PINJAMAN</h4>
        <p class="text-right">Nama : <b>{{ $pinjaman[0]->member->nama }}</b></p>
        <p class="text-right">No.Member : <b>{{ $pinjaman[0]->member->no_member }}</b></p>
        <p class="text-right">No.Telp : <b>{{ $pinjaman[0]->member->notelp }}</b></p>
    </div>
    <div class="container-fluid mt-5 d-flex justify-content-center w-100">
        <div class="table-responsive w-100">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th class="text-right">Nominal</th>
                    <th class="text-right">Bunga</th>
                    <th class="text-right">Angsuran</th>
                    <th class="text-right">Dibayar</th>
                    <th class="text-right">Sisa</th>
                    <th class="text-right">Bunga Dibayar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pinjaman as $key => $value)
                <tr class="text-right">
                    <td class="text-left">{{ $key+1 }}</td>
                    <td class="text-left">{{ format_date($value->tanggal) }}</td>
                    <td>{{ format_number($value->nominal) }}</td>
                    <td>{{ format_number($value->bunga_rupiah) }}</td>
                    <td>{{ format_number($value->angsuran) }}</td>
                    <td>{{ format_number($value->pembayaran_pinjaman->sum('angsuran_pokok')) }}</td>
                    <td>{{ format_number($value->nominal-$value->pembayaran_pinjaman->sum('angsuran_pokok')) }}</td>
                    <td>{{ format_number($value->bunga_rupiah*$value->pembayaran_pinjaman->count()) }}</td>
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
                        <tr>
                            <td class="text-bold-800"><b>Total Pinjaman</b></td>
                            <td class="text-bold-800 text-right"><b>Rp. {{ format_number($pinjaman->sum('nominal')) }}</b></td>
                        </tr>
                        <tr>
                            <td class="text-bold-800"><b>Total Dibayar</b></td>
                            <td class="text-bold-800 text-right"><b>Rp. {{ format_number($pinjaman->sum('dibayar_pokok')) }}</b></td>
                        </tr>
                        <tr class="bg-light">
                            <td class="text-bold-800"><b>Sisa Pinjaman</b></td>
                            <td class="text-bold-800 text-right"><b>Rp. {{ format_number($pinjaman->sum('nominal')-$pinjaman->sum('dibayar_pokok')) }}</b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
