@extends('layouts.home')

@section('title')
    Meeting Room -
@endsection

@section('content')
    <div class="main-content main-content-product no-sidebar">
        <div class="container">
            <div class="row pt-3">
                <div class="content-area shop-grid-content full-width col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <h3 class="custom_blog_title">
                            Meeting Room
                        </h3>
                        <ul class="row list-products auto-clear equal-container product-grid">
                            @foreach($ruangan as $item)
                            <li class="product-item  col-lg-6 col-md-6 col-sm-12 col-xs-12 col-ts-12 style-1">
                                <div class="product-inner equal-element">
                                    <div class="product-thumb">
                                        <div class="thumb-inner">
                                            <a href="{{ route('ruangan.detail', $item->slug) }}">
                                                @if(count($item->gambar) > 0)
                                                    <img src="{{ asset('assets/' . $item->gambar[0]->file) }}" alt="img">
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-name product_title">
                                            <a href="{{ route('ruangan.detail', $item->slug) }}">{{ $item->nama }}</a>
                                        </h5>
                                        <div class="group-info">
                                            <div class="price">
                                                Harga Mulai : <ins>Rp.{{ format_number($item->harga) }}</ins>
                                            </div>
                                        </div>
                                        <br>
                                        <a href="#" class="button btn-shop-now">Reservasi Sekarang</a>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
