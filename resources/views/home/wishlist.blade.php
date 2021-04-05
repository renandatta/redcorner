@extends('layouts.home')

@section('title')
    Wishlist
@endsection

@section('content')
    <div class="main-content main-content-details single no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content-cart main-content col-sm-12">
                    <h3 class="custom_blog_title" style="margin-bottom: 20px;">
                        Wishlist
                    </h3>
                    <div class="page-main-content">
                        <div class="shoppingcart-content">
                            <div class="cart-form">
                                <table class="shop_table">
                                    <tbody>
                                    @foreach($wishlist as $item)
                                    <tr class="cart_item">
                                        <td class="product-remove">
                                            <a href="javascript:void(0)" class="remove" onclick="delete_wishlist({{ $item->id }})"></a>
                                        </td>
                                        <td class="product-thumbnail">
                                            <a href="#">
                                                <img src="{{ asset('assets/' . $item->produk->gambar[0]->file) }}" alt="img"
                                                     class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">
                                            </a>
                                        </td>
                                        <td class="product-name" data-title="Product">
                                            <a href="{{ route('produk.detail', $item->produk->slug) }}" class="title">{{ $item->produk->nama }}</a>
                                            Rp.{{ format_number($item->produk->harga) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
        delete_wishlist = (id) => {
            $.post("{{ route('wishlist.delete') }}", {
                _token: '{{ csrf_token() }}', id
            }, () => {
                window.location.reload();
            });
        }
    </script>
@endpush
