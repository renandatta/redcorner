<div class="product-inner equal-element">
    <div class="product-top">
        <div class="flash">
            <span class="onnew"><span class="text">baru</span></span>
        </div>
    </div>
    <div class="product-thumb">
        <div class="thumb-inner">
            <a href="{{ route('produk.detail', $item->slug) }}">
                <img src="{{ asset('assets/' . $item->gambar[0]->file) }}" alt="img">
            </a>
            <div class="thumb-group">
                @if(empty($item->is_wishlist))
                <div class="yith-wcwl-add-to-wishlist">
                    <div class="yith-wcwl-add-button"><a href="javascript:void(0)" onclick="add_wislist({{ $item->id }})">Add to Wishlist</a></div>
                </div>
                @endif
                <a href="#" class="button quick-wiew-button" produk-id="{{ $item->id }}">Quick View</a>
                <div class="loop-form-add-to-cart">
                    <button class="single_add_to_cart_button button" onclick="add_cart({{ $item->id }})">Add to cart</button>
                </div>
            </div>
        </div>
    </div>
    <div class="product-info">
        <h5 class="product-name product_title">
            <a href="{{ route('produk.detail', $item->slug) }}">{{ $item->nama }}</a>
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
