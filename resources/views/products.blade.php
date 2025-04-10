@extends('includes.app')
@section('content')

<style>
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
    border: 1px solid #c5c5c5;
    background: #ffa600;
    font-weight: normal;
    color: #454545;
    border-radius: 100%;
}

.ui-slider-horizontal .ui-slider-handle {
    top: -5.5px;
    margin-left: -.6em;
}
.ui-slider-horizontal {
    height: .5em;
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
                                <a href="javascript:void(0)" class="filter-subcategory"
                                    data-id="{{ $subcategory->id }}">{{ $subcategory->subcategory }}<span
                                        class="number"></span></a>
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
                    <form action="javascript:void(0)">
                        <ul>
                            @foreach ($brands as $brand)
                            <li class="filter-list">
                                <input class="pixel-radio filter-brand" type="radio" id="brand{{ $brand->id }}"
                                    name="brand" data-id="{{ $brand->id }}">
                                <label for="brand{{ $brand->id }}">{{ $brand->brand }}</label>
                            </li>
                            @endforeach
                        </ul>
                    </form>

                </div>
                <div class="common-filter">
                    <div class="head">Color</div>
                    <form action="javascript:void(0)">
                        <ul>
                            @foreach ($colors as $color)
                            <li class="filter-list "><input class="pixel-radio filter-color" type="radio"
                                    id="colors{{ $color->id }}" name="colors" data-id="{{ $color->id }}"><label
                                    for="colors{{ $color->id }}">{{ $color->name }}</label></li>
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
                            <span>₹</span>
                            <div id="lower-value"></div>
                            <div class="to">to</div>
                            <span>₹</span>
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
            <section class="lattest-product-area pb-40 ">
                <div class="row product-list" style="row-gap: 85px;">
                   @include('partial-product-list')
                    <!-- single product -->
                </div>
            </section>
            <!-- End Best Seller -->
            <!-- Start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="sorting mr-auto"></div>
                <div class="pagination custom-pagination">
                @include('partial-product-pagination', ['products' => $products])
                </div>
            </div>
            <!-- End Filter Bar -->
        </div>
    </div>
</div>

<!-- Start related-product Area -->
@include('includes.deals-component')

@endsection

@section('customJS')
<script>
$(document).ready(function() {
    $(".filter-subcategory").click(function() {
        var subcategoryId = $(this).data("id");

        $.ajax({
            url: "{{ route('filterProductsBySubcategory') }}",
            method: "GET",
            data: {
                subcategory: subcategoryId
            },
            success: function(response) {
                $(".lattest-product-area .row").html(response);
            },
            error: function() {
                alert("Something went wrong! Please try again.");
            }
        });
    });

    $(".filter-brand").change(function() {
        var brandId = $(this).data("id");

        $.ajax({
            url: "{{ route('filterProductsByBrand') }}",
            method: "GET",
            data: {
                brand: brandId
            },
            success: function(response) {
                $(".lattest-product-area .row").html(response);
            },
            error: function() {
                alert("Something went wrong! Please try again.");
            }
        });
    })

    $(".filter-color").change(function() {
        var colorId = $(this).data("id");

        $.ajax({
            url: "{{ route('filterProductsByColor') }}",
            method: "GET",
            data: {
                color_id: colorId
            },
            success: function(response) {
                $(".lattest-product-area .row").html(response);
            },
            error: function() {
                alert("Something went wrong! Please try again.");
            }
        });
    });

    // 
    var minPrice = 0;
    var maxPrice = 100000;

    $("#price-range").slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function(event, ui) {
            $("#lower-value").text(ui.values[0]);
            $("#upper-value").text(ui.values[1]);
        },
        change: function(event, ui) {
            filterProductsByPrice(ui.values[0], ui.values[1]);
        }
    });

    $("#lower-value").text($("#price-range").slider("values", 0));
    $("#upper-value").text($("#price-range").slider("values", 1));

    function filterProductsByPrice(minPrice, maxPrice) {
        $.ajax({
            url: "{{ route('filterProductsByPrice') }}",
            method: "GET",
            data: {
                min_price: minPrice,
                max_price: maxPrice
            },
            success: function(response) {
                $(".lattest-product-area .row").html(response);
            },
            error: function() {
                alert("Something went wrong! Please try again.");
            }
        });
    }
});
$(document).on('click', '.custom-pagination a', function (e) {
    e.preventDefault();
    var page = $(this).data('page');
    if (!page) return;

    $.ajax({
        url: '?page=' + page,
        type: 'GET',
        success: function (res) {
            $('.product-list').html(res.products);
            $('.custom-pagination').html(res.pagination);
        }
    });
});
</script>

@endsection

<!--  -->