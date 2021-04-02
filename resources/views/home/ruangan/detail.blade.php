@extends('layouts.home')

@section('title')
    {{ $ruangan->nama }}
@endsection

@section('content')
    <div class="main-content main-content-details single no-sidebar">
        <div class="container">
            <div class="row pt-3">
                <div class="content-area content-details full-width col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <div class="details-product">
                            <div class="details-thumd">
                                @if(count($ruangan->gambar) > 0)
                                    <div class="image-preview-container image-thick-box image_preview_container">
                                        <img id="img_zoom" data-zoom-image="{{ asset('assets/' . $ruangan->gambar[0]->file) }}"
                                             src="{{ asset('assets/' . $ruangan->gambar[0]->file) }}" alt="img">
                                        <a href="#" class="btn-zoom open_qv"><i class="fa fa-search" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="product-preview image-small product_preview">
                                        <div id="thumbnails" class="thumbnails_carousel owl-carousel" data-nav="true"
                                             data-autoplay="false" data-dots="false" data-loop="false" data-margin="10"
                                             data-responsive='{"0":{"items":3},"480":{"items":3},"600":{"items":3},"1000":{"items":3}}'>
                                            @foreach($ruangan->gambar as $gambar)
                                            <a href="#" data-image="assets/images/details-item-1.jpg"
                                               data-zoom-image="assets/images/details-item-1.jpg" class="active">
                                                <img src="{{ asset('assets/' . $gambar->file) }}"
                                                     data-large-image="assets/images/details-item-1.jpg" alt="img">
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="details-infor">
                                <h1 class="product-title">{{ $ruangan->nama }}</h1>
                                <div class="stars-rating">
                                    <div class="star-rating"><span class="star-5"></span></div>
                                    <div class="count-star">(5)</div>
                                </div>
                                <div class="price">
                                    Harga Mulai :
                                    <span>Rp.{{ format_number($ruangan->harga) }}</span>
                                </div>
                                <div class="product-details-description"><p>{{ $ruangan->keterangan }}</p></div>
                                <div class="group-button">
                                    <button class="single_add_to_cart_button button">Reservasi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
