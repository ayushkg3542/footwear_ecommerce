@extends('includes.app')
@section('content')


<!-- start banner Area -->
<section class="banner-area">
    <div class="container">
        <div class="row fullscreen align-items-center justify-content-start">
            <div class="col-lg-12">
                <div class="active-banner-slider owl-carousel">
                    <!-- single-slide -->
                    <div class="row single-slide align-items-center d-flex">
                        <div class="col-lg-5 col-md-6">
                            <div class="banner-content">
                                <h1>Nike New <br>Collection!</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                                <div class="add-bag d-flex align-items-center">
                                    <a class="add-btn" href="#"><span class="lnr lnr-cross"></span></a>
                                    <span class="add-text text-uppercase">Add to Bag</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="banner-img">
                                <img class="img-fluid" src="{{url('public/front/img/banner/banner-img.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- single-slide -->
                    <div class="row single-slide">
                        <div class="col-lg-5">
                            <div class="banner-content">
                                <h1>Nike New <br>Collection!</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                                <div class="add-bag d-flex align-items-center">
                                    <a class="add-btn" href="#"><span class="lnr lnr-cross"></span></a>
                                    <span class="add-text text-uppercase">Add to Bag</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="banner-img">
                                <img class="img-fluid" src="{{url('public/front/img/banner/banner-img.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End banner Area -->

<!-- start features Area -->
<section class="features-area section_gap">
    <div class="container">
        <div class="row features-inner">
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="{{url('public/front/img/features/f-icon1.png')}}" alt="">
                    </div>
                    <h6>Free Delivery</h6>
                    <p>Free Shipping on all order</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="{{url('public/front/img/features/f-icon2.png')}}" alt="">
                    </div>
                    <h6>Return Policy</h6>
                    <p>Free Shipping on all order</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="{{url('public/front/img/features/f-icon3.png')}}" alt="">
                    </div>
                    <h6>24/7 Support</h6>
                    <p>Free Shipping on all order</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-features">
                    <div class="f-icon">
                        <img src="{{url('public/front/img/features/f-icon4.png')}}" alt="">
                    </div>
                    <h6>Secure Payment</h6>
                    <p>Free Shipping on all order</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end features Area -->

<!-- Start category Area -->
<section class="category-area">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($categories as $index => $category)
            <div class="{{ $index == 0 || $index == 3 ? 'col-lg-8 col-md-8' : 'col-lg-4 col-md-4' }}">
                <div class="single-deal">
                    <div class="overlay"></div>
                    <img class="img-fluid w-100" src="{{ url('public/front/img/category/c' . ($index + 1) . '.jpg') }}"
                        alt="">
                    <a href="javascript:void(0)" class="img-pop-up">
                        <div class="deal-details">
                            <h6 class="deal-title">{{ $category->category }}</h6>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End category Area -->

<!-- start product Area -->
<section class="owl-carousel section_gap">
    <!-- single product slide -->
    <div class="single-product-slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Latest Products</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut labore et
                            dolore
                            magna aliqua.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($allProduct->count() > 0)
                @foreach ($allProduct as $product)
                <!-- single product -->
                <div class="col-lg-3 col-md-6">
                    <div class="single-product position-relative">
                        <a href="{{ route('productDetails',['slug'=>$product->slug]) }}">
                            <img class="img-fluid"
                                src="{{ url('public/product_images/' . ($product->images->first()->images ?? 'default.png')) }}"
                                alt="{{ $product->slug }}">
                        </a>
                        <div class="product-details">
                            <h6>{{ $product->title }}</h6>
                            <div class="price">
                                <h6>₹{{ $product->new_price }}</h6>
                                <h6 class="l-through">₹{{ $product->old_price }}</h6>
                            </div>
                            <div class="prd-bottom">
                                <a href="javascript:void(0)" data-id="{{ $product->id }}"
                                    class="social-info add-to-cart">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">add to bag</p>
                                </a>
                                <a href="javascript:void(0)" data-id="{{ $product->id }}"
                                    class="social-info add-to-wishlist">
                                    <span class="lnr lnr-heart"></span>
                                    <p class="hover-text">Wishlist</p>
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
            </div>
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center align-items-center py-5 bg-light text-center">
                    <h2 class="mb-0">Latest Product Will Be Available Soon!</h2>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- end product Area -->


<!-- Start brand Area -->
<section class="brand-area section_gap">
    <div class="container">
        <div class="row">
            <a class="col single-img" href="#">
                <img class="img-fluid d-block mx-auto" src="{{url('public/front/img/brand/1.png')}}" alt="">
            </a>
            <a class="col single-img" href="#">
                <img class="img-fluid d-block mx-auto" src="{{url('public/front/img/brand/2.png')}}" alt="">
            </a>
            <a class="col single-img" href="#">
                <img class="img-fluid d-block mx-auto" src="{{url('public/front/img/brand/3.png')}}" alt="">
            </a>
            <a class="col single-img" href="#">
                <img class="img-fluid d-block mx-auto" src="{{url('public/front/img/brand/4.png')}}" alt="">
            </a>
            <a class="col single-img" href="#">
                <img class="img-fluid d-block mx-auto" src="{{url('public/front/img/brand/5.png')}}" alt="">
            </a>
        </div>
    </div>
</section>
<!-- End brand Area -->

<!-- Deals Component Include -->

@include('includes.deals-component')

@endsection

@section('customJS')

<script>
// $(document).ready(function() {

// })
</script>

@endsection