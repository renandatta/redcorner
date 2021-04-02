@extends('layouts.home')

@section('content')
    <div class="fullwidth-template">
        @if(!empty($ruangan) && count($ruangan->gambar) > 0)
            <div class="banner-wrapp rows-space-65">
                <div class="container">
                    <div class="banner">
                        <div class="item-banner style17">
                            <div class="inner" style="background: linear-gradient(rgb(255 255 255 / 70%),rgb(255 255 255 / 70%)),url('{{ asset("assets/" . $ruangan->gambar[0]->file) }}') no-repeat;background-size: cover">
                                <div class="banner-content">
                                    <h3 class="title">{{ $ruangan->nama }} </h3>
                                    <br><br><br>
                                    <div class="banner-price">
                                        <b class="text-black">Harga mulai:</b>
                                        <span class="number-price">Rp. {{ format_number($ruangan->harga) }}</span>
                                    </div>
                                    <a href="#" class="button btn-shop-now">Reservasi Sekarang</a>
                                    <a href="{{ route('ruangan.detail', $ruangan->slug) }}" class="button btn-view-collection">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="moorabi-tabs  default rows-space-40">
            <div class="container">
                <ul class="row list-products auto-clear equal-container product-grid">
                    @foreach($produk as $item)
                        <li class="product-item  col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-12 style-1">
                            @include('home.produk._item', ['item' => $item])
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@include('home.produk._quickview_script')
