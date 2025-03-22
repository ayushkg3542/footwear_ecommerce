@forelse ($products as $item)
<div class="col-lg-4 col-md-6">
    <div class="single-product">
        <a href="{{ route('productDetails', ['slug' => $item->slug]) }}">
            <img class="img-fluid"
                src="{{ url('public/product_images/' . ($item->images->first()->images ?? 'default.png')) }}"
                alt="{{ $item->slug }}">
        </a>
        <div class="product-details">
            <h6>{{ $item->title }}</h6>
            <div class="price">
                <h6>₹{{ $item->new_price }}</h6>
                <h6 class="l-through">₹{{ $item->old_price }}</h6>
            </div>
            <div class="prd-bottom">
                <a href="javascript:void(0)" data-id="{{ $item->id }}" class="social-info add-to-cart">
                    <span class="ti-bag"></span>
                    <p class="hover-text">add to bag</p>
                </a>
                <a href="javascript:void(0)" data-id="{{ $item->id }}" class="social-info add-to-wishlist">
                    <span class="lnr lnr-heart"></span>
                    <p class="hover-text">Wishlist</p>
                </a>
            </div>
        </div>
    </div>
</div>
@empty
<p class="text-center w-100">No Product found</p>
@endforelse
