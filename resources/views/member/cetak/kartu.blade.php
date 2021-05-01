@extends('layouts.print')

@section('title')
    Kartu Anggota {{ $member->nama }}
@endsection

@push('styles')
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <style>
        .table.table-bordered {
            border-top: 1px solid #000000;
        }
        .table-bordered, .table-bordered td, .table-bordered th {
            border: 1px solid #000000;
        }
        .text-white {
            color: #fff;
        }
        .text-center {
            text-align: center;
        }
        td {
            padding: 0!important;
            width: 5.4cm!important;
            background-size: cover!important;
            vertical-align: top!important;
            background-position: center;
        }
        #foto_member {
            height: 2cm;
            width: 2cm;
            position: absolute;
            top: 3.3cm;
            left: 1.8cm;
        }
        h5 {
            max-width: 5cm;
            white-space: normal;
            font-size: 10pt;
        }
        p {
            line-height: 10pt;
            font-size: 9pt;
        }
        #member_informasi {
            position: absolute;
            top: 5.4cm;
            left: 0.6cm;
        }
        #qrcode_box {
            position: absolute;
            left: 6.1cm;
            top: 4cm;
            background-color: #fff;
            width: 4cm;
            height: 4cm;
        }
        #qrcode {
            position: absolute;
            left: 0.7cm;
            top: 0.4cm;
        }
        #no_member {
            position: absolute;
            top: 3.1cm;
            width: 4cm;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <table class="table table-bordered" style="width: 10.8cm;height: 8.6cm;">
        <tr>
            <td style="background: url('{{ asset('kartu_depan.png') }}') no-repeat;">
                <img src="{{ asset('assets/'.$member->foto) }}" alt="" id="foto_member">
                <div id="member_informasi">
                    <h5 style="margin-bottom: 0.2cm;"><i class="fa fa-dot-circle-o"></i> {{ $member->nama }}</h5>
                    <p style="white-space: normal;width: 4cm;"><i class="fa fa-dot-circle-o"></i> {{ $member->alamat }}</p>
                </div>
            </td>
            <td style="background: url('{{ asset('kartu_belakang.png') }}') no-repeat;">
                <div id="qrcode_box">
                    <div id="qrcode" ></div>
                    <p id="no_member">{{ $member->no_member }}</p>
                </div>
            </td>
        </tr>
    </table>
@endsection

@push('scripts')
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/130527/qrcode.js"></script>
    <script>
        $('#qrcode').qrcode({
            width: 100,
            height: 100,
            text: '{{ $member->no_member }}'
        });
    </script>
@endpush

