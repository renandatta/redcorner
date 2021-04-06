@extends('layouts.home')

@section('title')
    {{ $produk->nama }}
@endsection

@section('content')
    <div class="main-content main-content-details single no-sidebar">
        <div class="container">
            <div class="row pt-3">
                <div class="content-area content-details full-width col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <div class="details-product">
                            <div class="details-thumd">
                                @if(count($produk->gambar) > 0)
                                    <div class="image-preview-container image-thick-box image_preview_container">
                                        <img id="img_zoom" data-zoom-image="{{ asset('assets/' . $produk->gambar[0]->file) }}"
                                             src="{{ asset('assets/' . $produk->gambar[0]->file) }}" alt="img">
                                        <a href="#" class="btn-zoom open_qv"><i class="fa fa-search" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="product-preview image-small product_preview">
                                        <div id="thumbnails" class="thumbnails_carousel owl-carousel" data-nav="true"
                                             data-autoplay="false" data-dots="false" data-loop="false" data-margin="10"
                                             data-responsive='{"0":{"items":3},"480":{"items":3},"600":{"items":3},"1000":{"items":3}}'>
                                            @foreach($produk->gambar as $gambar)
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
                                <h1 class="product-title">{{ $produk->nama }}</h1>
                                <div class="stars-rating">
                                    <div class="star-rating"><span class="star-5"></span></div>
                                    <div class="count-star">(5)</div>
                                </div>
                                <div class="price">
                                    <span>Rp.{{ format_number($produk->harga) }}</span>
                                </div>
                                <div class="product-details-description"><p>{{ $produk->keterangan }}</p></div>
                                <div class="group-button">
                                    <div class="yith-wcwl-add-to-wishlist">
                                        <div class="yith-wcwl-add-button">
                                            @if(empty($produk->is_wishlist))
                                                <a href="javascript:void(0)" onclick="add_wislist({{ $produk->id }})">Add to Wishlist</a>
                                            @else
                                                <i class="fa fa-heart"></i> Sudah Di Wishlist
                                            @endif
                                        </div>
                                    </div>
                                    <div class="quantity-add-to-cart">
                                        <div class="quantity">
                                            <div class="control">
                                                <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                                <input type="text" data-step="1" data-min="0" value="1" title="Qty"
                                                       class="input-qty qty" size="4">
                                                <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                                            </div>
                                        </div>
                                        <button class="single_add_to_cart_button button" onclick="add_cart({{ $item->id }})">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="clear: left;"></div>
                        @if(count($produk_terkait) > 0)
                            <div class="related products product-grid">
                                <h2 class="product-grid-title">Produk Terkait</h2>
                                <div class="owl-products owl-slick equal-container nav-center"  data-slick ='{"autoplay":false, "autoplaySpeed":1000, "arrows":true, "dots":false, "infinite":true, "speed":800, "rows":1}' data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":3}},{"breakpoint":"1200","settings":{"slidesToShow":2}},{"breakpoint":"992","settings":{"slidesToShow":2}},{"breakpoint":"480","settings":{"slidesToShow":1}}]'>
                                    @foreach($produk_terkait as $item)
                                        <div class="product-item style-1">
                                            @include('home.produk._item', ['item' => $item])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
