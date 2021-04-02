@extends('layouts.home')

@section('title')
    {{ $title }} -
@endsection

@section('content')
    <div class="main-content main-content-product no-sidebar">
        <div class="container">
            <div class="row pt-3">
                <div class="content-area shop-grid-content full-width col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <h3 class="custom_blog_title">{{ $title }}</h3>
                        <ul class="row list-products auto-clear equal-container product-grid">
                            @foreach($produk as $item)
                            <li class="product-item col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-12 style-1">
                                @include('home.produk._item', ['item' => $item])
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('home.produk._quickview_script')
