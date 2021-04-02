<div class="kt-popup-quickview">
    <div class="details-thumb">
        <div class="slider-product slider-for">
            @foreach($produk->gambar as $gambar)
            <div class="details-item"><img src="{{ asset("assets/$gambar->file") }}" alt="img" /></div>
            @endforeach
        </div>
        <div class="slider-product-button slider-nav nav-center">
            @foreach($produk->gambar as $gambar)
                <div class="details-item"><img src="{{ asset("assets/$gambar->file") }}" alt="img" /></div>
            @endforeach
        </div>
    </div>
    <div class="details-infor">
        <h1 class="product-title">Eclipse Pendant Light</h1>
        <div class="stars-rating">
            <div class="star-rating"><span class="star-5"></span></div>
            <div class="count-star">(5)</div>
        </div>
        <div class="price"><span>Rp.{{ format_number($produk->harga) }}</span></div>
        <div class="product-details-description"><p>{{ $produk->keterangan }}</p></div>
        <div class="group-button">
            <div class="yith-wcwl-add-to-wishlist">
                <div class="yith-wcwl-add-button"><a href="#">Add to Wishlist</a></div>
            </div>
            <div class="quantity-add-to-cart">
                <div class="quantity">
                    <div class="control">
                        <a class="btn-number qtyminus quantity-minus" href="#">-</a><input type="text" data-step="1" data-min="0" value="1" title="Qty" class="input-qty qty" size="4" />
                        <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                    </div>
                </div>
                <button class="single_add_to_cart_button button">Add to cart</button>
            </div>
        </div>
    </div>
</div>
