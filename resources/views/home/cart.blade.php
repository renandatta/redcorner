@extends('layouts.home')

@section('title')
    Cart
@endsection

@section('content')
    <div class="main-content main-content-details single no-sidebar">
        <div class="container">
            <div class="row">
                <div class="main-content-cart main-content col-sm-12">
                    <h3 class="custom_blog_title" style="margin-bottom: 20px;">
                        Cart
                    </h3>
                    <div class="page-main-content">
                        <div class="shoppingcart-content">
                            <div class="cart-form">
                                <table class="shop_table">
                                    <tbody>
                                    @foreach($cart as $item)
                                    <tr class="cart_item">
                                        <td class="product-remove">
                                            <a href="javascript:void(0)" class="remove" onclick="delete_cart({{ $item->id }})"></a>
                                        </td>
                                        <td class="product-thumbnail">
                                            <a href="#">
                                                <img src="{{ asset('assets/' . $item->produk->gambar[0]->file) }}" alt="img"
                                                     class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">
                                            </a>
                                        </td>
                                        <td class="product-name" data-title="Product">
                                            <a href="{{ route('produk.detail', $item->produk->slug) }}" class="title">{{ $item->produk->nama }}</a>

                                            @ {{ format_number($item->produk->harga) }} x <span id="jumlah_{{ $item->produk->id }}">{{ format_number($item->qty) }}</span> <br>
                                            <b id="total_{{ $item->produk->id }}">Rp. {{ format_number($item->total) }}</b>
                                        </td>
                                        <td>
                                            <div class="quantity">
                                                <div class="control">
                                                    <a class="btn-number qtyminus quantity-minus" href="#" onclick="ubah_cart({{ $item->produk->id }}, 'minus', '{{ $item->produk->harga }}')">-</a>
                                                    <input id="qty_{{ $item->produk->id }}" type="text" data-step="1" data-min="0" value="{{ $item->qty }}" title="Qty" class="input-qty qty" size="4" />
                                                    <a href="#" class="btn-number qtyplus quantity-plus" onclick="ubah_cart({{ $item->produk->id }}, 'plus', '{{ $item->produk->harga }}')">+</a>
                                                </div>
                                            </div>
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
        ubah_cart = (produk_id, operation, harga) => {
            harga = parseFloat(remove_commas(harga));
            let qty = $('#qty_' + produk_id).val();
            qty = parseInt(qty);
            qty = (operation === 'plus') ? qty + 1 : qty - 1;
            $.post("{{ route('cart.save') }}", {
                _token: '{{ csrf_token() }}', produk_id, qty
            }, () => {
                let total = harga * qty;
                $('#jumlah_' + produk_id).html(add_commas(qty));
                $('#total_' + produk_id).html('Rp. '+add_commas(total));
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
    </script>
@endpush
