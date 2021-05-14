@extends('layouts.home')

@section('title')
    Checkout
@endsection

@section('content')
    <div class="main-content main-content-details single no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content-cart main-content col-sm-12">
                    <h3 class="custom_blog_title" style="margin-bottom: 20px;">Checkout</h3>
                    <div class="page-main-content">
                        <div class="checkout-wrapp">
                            <div class="shipping-address-form-wrapp">
                                <form action="{{ route('checkout.save') }}" method="post">
                                    @csrf
                                    <div class="shipping-address-form  checkout-form">
                                        <div class="row-col-1 row-col">
                                            <div class="shipping-address">
                                                <h3 class="title-form">
                                                    Alamat Pengiriman
                                                </h3>
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <textarea name="alamat" id="alamat" class="form-control" required>{!! $alamat->alamat ?? '' !!}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kodepos">Kodepos</label>
                                                    <input name="kodepos" id="kodepos" class="form-control" value="{{ $alamat->kodepos ?? '' }}" required />
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_penerima">Nama Penerima</label>
                                                    <input name="nama_penerima" id="nama_penerima" class="form-control" value="{{ $alamat->nama_penerima ?? '' }}" required />
                                                </div>
                                                <div class="form-group">
                                                    <label for="notelp">No.Telp (Ada Whatsapp)</label>
                                                    <input name="notelp" id="notelp" class="form-control" value="{{ $alamat->notelp ?? '' }}" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-col-2 row-col">
                                            <div class="your-order">
                                                <h3 class="title-form">
                                                    List Produk
                                                </h3>
                                                <ul class="list-product-order">
                                                    @foreach($cart as $item)
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
                                                    <span class="total-price">{{ format_number($cart->sum('total')) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="button button-payment">Proses Checkout</button>
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
