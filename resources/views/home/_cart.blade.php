
<a href="javascript:void(0);" class="shopcart-icon" data-moorabi="moorabi-dropdown">
    Cart
    <span class="count">{{ count($cart) }}</span>
</a>
<div class="shopcart-description moorabi-submenu">
    <div class="content-wrap">
        <h3 class="title">Cart</h3>
        <ul class="minicart-items">
            @foreach($cart as $value)
                <li class="product-cart mini_cart_item">
                    <a href="#" class="product-media">
                        <img src="{{ asset('assets/' . $value->produk->gambar[0]->file) }}" alt="img">
                    </a>
                    <div class="product-details">
                        <h5 class="product-name">
                            <a href="{{ route('produk.detail', $value->produk->slug) }}">{{ $value->produk->nama }}</a>
                        </h5>
                        <span class="product-price">
                            <span class="price"><span>Rp.{{ format_number($value->total) }}</span></span>
                        </span>
                        <span class="product-quantity">(x{{ $value->qty }})</span>
                        <div class="product-remove">
                            <a href="javascript:void(0)" onclick="delete_cart({{ $value->id }})"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </li>
            @endforeach
            <div class="subtotal">
                <span class="total-title">Total: </span>
                <span class="total-price">
                <span class="Price-amount">Rp.{{ format_number($cart->sum('total')) }}</span>
            </span>
            </div>
            <div class="actions">
                <a class="button button-viewcart" href="{{ route('cart') }}">
                    <span>View Cart</span>
                </a>
                <a href="#" class="button button-checkout">
                    <span>Checkout</span>
                </a>
            </div>
        </ul>
    </div>
</div>
