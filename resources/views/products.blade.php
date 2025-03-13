@extends('includes.app')
@section('content')

<style>
.price-range-area .noUi-horizontal .noUi-handle {
    width: 16px;
    height: 16px;
    left: -8px;
    top: -5px;
    border-radius: 50%;
    border: 0px;
    background: #ffba00;
    box-shadow: none;
    cursor: pointer;
    -webkit-transition: ease 0.1s;
    -moz-transition: ease 0.1s;
    -o-transition: ease 0.1s;
    transition: ease 0.1s;
}

.price-range-area .noUi-connect {
    background: #eee;
    border-radius: 0px;
    box-shadow: none;
}
.price-range-area .noUi-horizontal {
    height: 6px;
}
.price-range-area .noUi-target {
    background: #eee;
    border-radius: 0px;
    border: 0px;
    box-shadow: none;
}
</style>

<section class="banner-area organic-breadcrumb mb-5">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shop Category</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="{{ route('products') }}">Shop<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Category</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->
<div class="container mt-5">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
                <div class="head">Browse Categories</div>
                <ul class="main-categories">
                    @foreach ($categories as $category)
                    <li class="main-nav-list">
                        <a data-toggle="collapse" href="#category{{ $category->id }}" aria-expanded="false"
                            aria-controls="category{{ $category->id }}"><span
                                class="lnr lnr-arrow-right"></span>{{ $category->category }}<span
                                class="number">{{ $category->subcategories->count() }}</span></a>
                        @if($category->subcategories->count() > 0)
                        <ul class="collapse" id="category{{ $category->id }}" data-toggle="collapse"
                            aria-expanded="false" aria-controls="category{{ $category->id }}">
                            @foreach ($category->subcategories as $subcategory)
                            <li class="main-nav-list child">
                                <a href="#">{{ $subcategory->subcategory }}<span class="number"></span></a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="sidebar-filter mt-50">
                <div class="top-filter-head">Product Filters</div>
                <div class="common-filter">
                    <div class="head">Brands</div>
                    <form action="#">
                        <ul>
                            @foreach ($brands as $brand)
                            <li class="filter-list"><input class="pixel-radio" type="radio" id="apple"
                                    name="brand"><label for="apple">{{ $brand->brand }}</label></li>
                            @endforeach
                        </ul>
                    </form>
                </div>
                <div class="common-filter">
                    <div class="head">Color</div>
                    <form action="#">
                        <ul>
                            @foreach ($colors as $color)
                            <li class="filter-list"><input class="pixel-radio" type="radio" id="black"
                                    name="color"><label for="black">{{ $color->name }}</label></li>
                            @endforeach
                        </ul>
                    </form>
                </div>
                <div class="common-filter">
                    <div class="head">Price</div>
                    <div class="price-range-area">
                        <div id="price-range"></div>
                        <div class="value-wrapper d-flex">
                            <div class="price">Price:</div>
                            <span>$</span>
                            <div id="lower-value"></div>
                            <div class="to">to</div>
                            <span>$</span>
                            <div id="upper-value"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- Start Best Seller -->
             @if(request()->has('search') && request()->search != "")
             <h4 class="text-end">Search Result for: {{ request()->search }}</h4>
             @endif
            <section class="lattest-product-area pb-40 category-list">
                <div class="row">
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
                    <!-- single product -->
                </div>
            </section>
            <!-- End Best Seller -->
            <!-- Start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting mr-auto"></div>
                <div class="pagination">
                    <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                    <a href="#">6</a>
                    <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
            <!-- End Filter Bar -->
        </div>
    </div>
</div>

<!-- Start related-product Area -->
@include('includes.deals-component')

@endsection

<!--  -->