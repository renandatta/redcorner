@extends('layouts.print')

@section('content')
    <img src="{{ asset('logo_bpek.png') }}" alt="" style="height: 2cm;position: absolute;">
    <div class="container-fluid">
        <h4 class="text-center">LAPORAN PINJAMAN</h4>
    </div>
    <div class="container-fluid mt-5 w-100">
        <br>
        <div class="row">
            <div class="col-md-4">
                <table class="table table-bordered">
                    <tr>
                        <td width="10%">Nama</td>
                        <td width="5%">:</td>
                        <td>{{ $pinjaman->member->nama }}</td>
                    </tr>
                    <tr>
                        <td width="10%">No.Member</td>
                        <td width="5%">:</td>
                        <td>{{ $pinjaman->member->no_member }}</td>
                    </tr>
                    <tr>
                        <td width="10%">No.Telp</td>
                        <td width="5%">:</td>
                        <td>{{ $pinjaman->member->notelp }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <table class="table table-bordered">
                    <tr>
                        <td width="10%">Tenor</td>
                        <td width="5%">:</td>
                        <td>{{ $pinjaman->tenor }}</td>
                    </tr>
                    <tr>
                        <td width="10%">Bunga</td>
                        <td width="5%">:</td>
                        <td>{{ $pinjaman->bunga }} %</td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Pembayaran Ke</th>
                <th>Bulan</th>
                <th class="text-right">Angsuran Pokok</th>
                <th class="text-right">Bunga</th>
                <th class="text-right">Total Angsuran</th>
                <th class="text-right">Sisa Pinjaman</th>
            </tr>
            </thead>
            <tbody>
            @php($sisa = $pinjaman->nominal)
            @for($i = 1; $i <= $pinjaman->tenor; $i++)
                <tr class="text-right">
                    <td class="text-left">{{ $i }}</td>
                    <td class="text-left">{{ date('Y-m', strtotime('+' .$i . 'month ' . $pinjaman->tanggal))  }}</td>
                    <td>{{ format_number($pinjaman->angsuran) }}</td>
                    <td>{{ format_number($pinjaman->bunga_rupiah2) }}</td>
                    <td>{{ format_number($pinjaman->total_angsuran) }}</td>
                    @php($sisa = $sisa - $pinjaman->angsuran)
                    <td>{{ format_number($sisa) }}</td>
                </tr>
            @endfor
            <tr>
                <td class="text-right" colspan="2"><b>Total</b></td>
                <td class="text-right"><b>{{ format_number($pinjaman->angsuran * $pinjaman->tenor) }}</b></td>
                <td class="text-right"><b>{{ format_number($pinjaman->bunga_rupiah2 * $pinjaman->tenor) }}</b></td>
                <td class="text-right"><b>{{ format_number($pinjaman->total_angsuran * $pinjaman->tenor) }}</b></td>
            </tr>
{{--            @foreach($pinjaman->pembayaran_pinjaman as $key => $value)--}}
{{--                <tr class="text-right">--}}
{{--                    <td class="text-left">{{ $key+1 }}</td>--}}
{{--                    <td class="text-left">{{ format_date($value->tanggal) }}</td>--}}
{{--                    <td>{{ format_number($value->nominal) }}</td>--}}
{{--                    <td>{{ format_number($value->nominal + $value->pinjaman->bunga_rupiah) }}</td>--}}
{{--                    @php($sisa -= $value->nominal)--}}
{{--                    <td>{{ format_number($sisa) }}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
            </tbody>
        </table>
    </div>
@endsection
