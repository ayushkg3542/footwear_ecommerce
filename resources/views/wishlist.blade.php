@extends('includes.app')
@section('content')
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Wishlist</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- start wishlist Area -->
<section class="section_gap">
    <div class="single-product-slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Favourites</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- single product -->
                @if ($wishlistItems->count() > 0)
                @foreach ($wishlistItems as $item)
                <div class="col-lg-3 col-md-6">
                    <div class="single-product">
                        <a href="{{ route('productDetails',['slug'=>$item->product->slug]) }}">
                            <img class="img-fluid"
                                src="{{ url('public/product_images/' . ($item->product->images->first()->images ?? 'default.png')) }}"
                                alt="">
                        </a>
                        <div class="product-details">
                            <h6>{{ $item->product->title }}</h6>
                            <div class="price">
                                <h6>₹{{ $item->product->new_price }}</h6>
                                <h6 class="l-through">₹{{ $item->product->old_price }}</h6>
                            </div>
                            <div class="prd-bottom">
                                <a href="javascript:void(0)" data-id="{{ $item->product->id }}"
                                    class="social-info add-to-cart">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                                <a href="#" class="social-infoo remove-wishlist" data-id="{{ $item->product->id }}">
                                    <span class="lnr lnr-heart"></span>
                                </a>
                                <a href="{{ route('products') }}" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">view more</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-lg-12 text-center bg-light">
                    <h2>No items in your wishlist</h2>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

@include('includes.deals-component')

<!-- end wishlist Area -->
@endsection

@section('customJS')

<script>
$(document).on("click", ".remove-wishlist", function(e) {
    e.preventDefault();

    let productId = $(this).data("id");
    let button = $(this);

    $.ajax({
        url: "{{ route('removeFromWishlist') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: productId
        },
        success: function(response) {
            if (response.status === "success") {
                button.closest(".col-lg-3").remove();

                notyf.success("Product removed from wishlist successfully!");
                if ($(".col-lg-3").length === 0) {
                    $(".row").append("<p class='text-center w-100'>Your wishlist is empty</p>");
                }
            } else {
                notyf.error(response.message);
            }
        },
        error: function() {
            notyf.error("Something went wrong! Please try again.");
        }
    })
})
</script>

@endsection

<!--  -->