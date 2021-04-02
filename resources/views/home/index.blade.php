<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title'){{ env('APP_NAME') }}</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets_home/images/favicon.png') }}"/>
    <link href="https://fonts.googleapis.com/css?family=Baloo&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900&amp;display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets_home/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/chosen.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/pe-icon-7-stroke.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/js/fancybox/source/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/jquery.scrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/mobile-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/fonts/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_home/css/custom.css') }}">
</head>
<body class="home">
<header class="header style7">
    <div class="main-header py-0">
        <div class="row">
            <div class="col-lg-3 col-sm-4 col-md-3 col-xs-7 col-ts-12 header-element">
                <div class="logo">
                    <a href="{{ route('/') }}">
                        <img src="{{ asset('logo_corner.png') }}" alt="img">
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-5 col-xs-5 col-ts-12 pt-5">
                <div class="block-search-block">
                    <form class="form-search form-search-width-category">
                        <div class="form-content">
                            <div class="category">
                                <x-select
                                    :options="$list_kategori"
                                    name="kategori_id"
                                    caption="Semua Kategori"
                                    class="chosen-select"
                                    data-placeholder="All Categories"
                                    tabindex="1" />
                            </div>
                            <div class="inner">
                                <x-input class="input" name="nama" caption="Pencarian" />
                            </div>
                            <button class="btn-search" type="submit">
                                <span class="icon-search"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12 col-ts-12 pt-5">
                <div class="header-control">
                    @include('home._cart')
                    @include('home._user')
                    <a class="menu-bar mobile-navigation menu-toggle" href="#">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-nav-container rows-space-20">
        <div class="container">
            <div class="header-nav-wapper main-menu-wapper">
                <div class="header-nav">
                    @include('home._navbar')
                </div>
            </div>
        </div>
    </div>
</header>
<div class="header-device-mobile pt-0">
    <div class="wapper pl-0">
        <div class="item mobile-logo">
            <div class="logo">
                <a href="#">
                    <img src="{{ asset('logo_corner.png') }}" alt="img">
                </a>
            </div>
        </div>
        <div class="item item mobile-search-box has-sub">
            <a href="#">
                <span class="icon"><i class="fa fa-search" aria-hidden="true"></i></span>
            </a>
            <div class="block-sub">
                <a href="#" class="close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
                <div class="header-searchform-box">
                    <form class="header-searchform">
                        <div class="searchform-wrap">
                            <input type="text" class="search-input" placeholder="Pencarian produk">
                            <button type="submit" class="submit button">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="item menu-bar">
            <a class=" mobile-navigation  menu-toggle" href="#">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
    </div>
</div>
<div>
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
                                <a href="#" class="button btn-view-collection">Lihat Detail</a>
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
                        <div class="product-inner equal-element">
                            <div class="product-top">
                                <div class="flash">
                                    <span class="onnew"><span class="text">baru</span></span>
                                </div>
                            </div>
                            <div class="product-thumb">
                                <div class="thumb-inner">
                                    <a href="#">
                                        <img src="{{ asset('assets/' . $item->gambar[0]->file) }}" alt="img">
                                    </a>
                                    <div class="thumb-group">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button"><a href="#">Add to Wishlist</a></div>
                                        </div>
                                        <a href="#" class="button quick-wiew-button" produk-id="{{ $item->id }}">Quick View</a>
                                        <div class="loop-form-add-to-cart">
                                            <button class="single_add_to_cart_button button">Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-info">
                                <h5 class="product-name product_title">
                                    <a href="#">{{ $item->nama }}</a>
                                </h5>
                                <div class="group-info">
                                    <div class="stars-rating">
                                        <div class="star-rating"><span class="star-5"></span></div>
                                        <div class="count-star">(5)</div>
                                    </div>
                                    <div class="price">
                                        <ins>Rp.{{ format_number($item->harga) }}</ins>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<footer class="footer style7">
    <div class="container">
        <div class="container-wapper pt-0">
            <div class="footer-end">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="coppyright">
                            Copyright © 2021
                            <a href="#">Redcorner</a>.All rights reserved
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="footer-device-mobile">
    <div class="wapper">
        <div class="footer-device-mobile-item device-home">
            <a href="index.html">
					<span class="icon">
						<i class="fa fa-home" aria-hidden="true"></i>
					</span>
                Home
            </a>
        </div>
        <div class="footer-device-mobile-item device-home device-wishlist">
            <a href="#">
					<span class="icon">
						<i class="fa fa-heart" aria-hidden="true"></i>
					</span>
                Wishlist
            </a>
        </div>
        <div class="footer-device-mobile-item device-home device-cart">
            <a href="#">
					<span class="icon">
						<i class="fa fa-shopping-basket" aria-hidden="true"></i>
						<span class="count-icon">
							0
						</span>
					</span>
                <span class="text">Cart</span>
            </a>
        </div>
        <div class="footer-device-mobile-item device-home device-user">
            <a href="login.html">
					<span class="icon">
						<i class="fa fa-user" aria-hidden="true"></i>
					</span>
                Account
            </a>
        </div>
    </div>
</div>
<a href="#" class="backtotop">
    <i class="fa fa-angle-double-up"></i>
</a>
<script src="{{ asset('assets_home/js/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('assets_home/js/jquery.plugin-countdown.min.js') }}"></script>
<script src="{{ asset('assets_home/js/jquery-countdown.min.js') }}"></script>
<script src="{{ asset('assets_home/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets_home/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets_home/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets_home/js/isotope.min.js') }}"></script>
<script src="{{ asset('assets_home/js/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets_home/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets_home/js/mobile-menu.js') }}"></script>
<script src="{{ asset('assets_home/js/chosen.min.js') }}"></script>
<script src="{{ asset('assets_home/js/slick.js') }}"></script>
<script src="{{ asset('assets_home/js/jquery.elevateZoom.min.js') }}"></script>
<script src="{{ asset('assets_home/js/jquery.actual.min.js') }}"></script>
<script src="{{ asset('assets_home/js/fancybox/source/jquery.fancybox.js') }}"></script>
<script src="{{ asset('assets_home/js/lightbox.min.js') }}"></script>
<script src="{{ asset('assets_home/js/owl.thumbs.min.js') }}"></script>
<script src="{{ asset('assets_home/js/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets_home/js/frontend-plugin.js') }}"></script>
<script>
    let _token = '{{ csrf_token() }}';

    // ------------------------Quick view----------------------------------------
    // --------------------------------------------------------------------------
    function kt_get_scrollbar_width() {
        var $inner = jQuery('<div style="width: 100%; height:200px;">test</div>'),
            $outer = jQuery('<div style="width:200px;height:150px; position: absolute; top: 0; left: 0; visibility: hidden; overflow:hidden;"></div>').append($inner),
            inner = $inner[0],
            outer = $outer[0];
        jQuery('body').append(outer);
        var width1 = parseFloat(inner.offsetWidth);
        $outer.css('overflow', 'scroll');
        var width2 = parseFloat(outer.clientWidth);
        $outer.remove();
        return (width1 - width2);
    }
    function slick_quickview_popup() {
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: false,
            focusOnSelect: true,
            infinite: true,
            prevArrow: '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            nextArrow: '<i class="fa fa-angle-right " aria-hidden="true"></i>',
        });
    }
    function quickview_popup() {
        var window_size = parseFloat(jQuery('body').innerWidth());
        window_size += kt_get_scrollbar_width();
        if (window_size > 992) {
            $(document).on('click', '.quick-wiew-button', function () {
                let id = $(this).attr('produk-id');
                $.post("{{ route('produk.quickview') }}", {_token, id}, (result) => {
                    $.magnificPopup.open({
                        items: {
                            src: result,
                            type: 'inline'
                        }
                    });
                    slick_quickview_popup();
                    return false;
                }).fail((xhr) => {
                    console.log(xhr.responseText)
                    return false;
                })
            });
        }
    }
</script>
</body>

</html>
