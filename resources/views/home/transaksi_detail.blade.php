@extends('layouts.home')

@section('title')
    Detail Transaksi
@endsection

@section('content')
    <div class="main-content main-content-details single no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content-cart main-content col-sm-12">
                    <h3 class="custom_blog_title" style="margin-bottom: 20px;">Detail Transaksi</h3>
                    <div class="page-main-content">
                        <div class="checkout-wrapp">
                            <div class="shipping-address-form-wrapp">
                                <form @if($transaksi->status == 'Pembelian Divalidasi') action="{{ route('transaksi.save') }}" method="post" @endif enctype="multipart/form-data">
                                    @csrf
                                    <div class="shipping-address-form  checkout-form">
                                        <div class="row-col-1 row-col">
                                            <div class="shipping-address">
                                                <h3 class="title-form">
                                                    Alamat Pengiriman
                                                </h3>
                                                <h5><small>Alamat</small><br>{{ $transaksi->alamat_pengiriman }}</h5>
                                                <h5><small>Kodepos</small><br>{{ $transaksi->kodepos }}</h5>
                                                <h5><small>Nama Penerima</small><br>{{ $transaksi->nama_penerima }}</h5>
                                                <h5><small>No.Telp</small><br>{{ $transaksi->notelp }}</h5>
                                                <h5><small>Status</small><br>{{ $transaksi->status }}</h5>
                                                <h5><small>No.Resi</small><br>{{ $transaksi->no_resi }}</h5>
                                                @if($transaksi->status != 'Menunggu Validasi Toko')
                                                    <br><br>
                                                    <h3 class="title-form">
                                                        Pembayaran
                                                    </h3>
                                                    @if($transaksi->status == 'Pembelian Divalidasi')
                                                        <input type="hidden" name="id" value="{{ $transaksi->id }}">
                                                        <div class="form-group">
                                                            <label for="rekening_bank">Bank</label>
                                                            <input name="rekening_bank" id="rekening_bank" class="form-control" value="{{ $transaksi->rekening_bank ?? '' }}" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="rekening_no">No.Rekening</label>
                                                            <input name="rekening_no" id="rekening_no" class="form-control" value="{{ $transaksi->rekening_no ?? '' }}" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="rekening_nama">Nama Rekening</label>
                                                            <input name="rekening_nama" id="rekening_nama" class="form-control" value="{{ $transaksi->rekening_nama ?? '' }}" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nominal_transfer">Nominal Transfer</label>
                                                            <input name="nominal_transfer" id="nominal_transfer" class="form-control autonumeric" value="{{ $transaksi->nominal_transfer ?? '' }}" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="bukti_transfer">Bukti Transfer</label>
                                                            <input type="file" name="bukti_transfer" id="bukti_transfer" class="form-control" value="{{ $transaksi->file_bukti ?? '' }}" required />
                                                        </div>
                                                        <button type="submit" class="btn btn-danger">Simpan</button>
                                                    @else
                                                        <h5><small>Bank</small><br>{{ $transaksi->rekening_bank }}</h5>
                                                        <h5><small>No.Rekening</small><br>{{ $transaksi->rekening_no }}</h5>
                                                        <h5><small>Nama Rekening</small><br>{{ $transaksi->rekening_nama }}</h5>
                                                        <h5><small>Nominal Transfer</small><br>{{ format_number($transaksi->nominal_transfer) }}</h5>
                                                        <h5 style="margin-bottom: 0;"><small>Bukti Transfer</small></h5>
                                                        <img src="{{ asset('assets/'.$transaksi->file_bukti) }}" alt="" style="width: 100%;height: auto;">
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row-col-2 row-col">
                                            <div class="your-order">
                                                <h3 class="title-form">
                                                    List Produk
                                                </h3>
                                                <ul class="list-product-order">
                                                    @foreach($transaksi->detail as $item)
                                                        <li class="product-item-order">
                                                            <div class="product-thumb">
                                                                <a href="{{ route('produk.detail', $item->produk->slug) }}">
                                                                    <img src="{{ asset('assets/' . $item->produk->gambar[0]->file) }}" alt="img">
                                                                </a>
                                                            </div>
                                                            <div class="product-order-inner">
                                                                <h5 class="product-name">
                                                                    <a href="{{ route('produk.detail', $item->produk->slug) }}" class="title">{{ $item->produk->nama }}</a>
                                                                </h5>
                                                                <div class="price">
                                                                    @ {{ format_number($item->produk->harga) }} x <span id="jumlah_{{ $item->produk->id }}">{{ format_number($item->qty) }}</span> <br>
                                                                    <b id="total_{{ $item->produk->id }}">Rp. {{ format_number($item->total) }}</b>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="order-total">
                                                    <span class="title">Total Harga Produk:</span>
                                                    <span class="total-price" style="float: right;">{{ format_number($transaksi->detail->sum('total')) }}</span>
                                                </div>
                                                @if($transaksi->status != 'Menunggu Validasi Toko')
                                                    <div class="order-total">
                                                        <span class="title">Biaya Pengiriman:</span>
                                                        <span class="total-price" style="float: right;">{{ format_number($transaksi->biaya_pengiriman) }}</span>
                                                    </div>
                                                    <div class="order-total">
                                                        <span class="title">Diskon:</span>
                                                        <span class="total-price" style="float: right;">{{ format_number($transaksi->diskon) }}</span>
                                                    </div>
                                                    <div class="order-total">
                                                        <span class="title">Total Biaya:</span>
                                                        <span class="total-price" style="float: right;">{{ format_number($transaksi->total_biaya) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
