@extends('includes.app')
@section('content')

<style>
/* .hh-grayBox {
    background-color: #F8F8F8;
    margin-bottom: 20px;
    padding: 35px;
    margin-top: 20px;
} */

.pt45 {
    padding-top: 45px;
}

.order-tracking {
    text-align: center;
    width: 33.33%;
    position: relative;
    display: block;
}

.order-tracking .is-complete {
    display: block;
    position: relative;
    border-radius: 50%;
    height: 30px;
    width: 30px;
    border: 0px solid #AFAFAF;
    background-color: #f7be16;
    margin: 0 auto;
    transition: background 0.25s linear;
    -webkit-transition: background 0.25s linear;
    z-index: 2;
}

.order-tracking .is-complete:after {
    display: block;
    position: absolute;
    content: '';
    height: 14px;
    width: 7px;
    top: -2px;
    bottom: 0;
    left: 5px;
    margin: auto 0;
    border: 0px solid #AFAFAF;
    border-width: 0px 2px 2px 0;
    transform: rotate(45deg);
    opacity: 0;
}

.order-tracking.completed .is-complete {
    border-color: #27aa80;
    border-width: 0px;
    background-color: #27aa80;
}

.order-tracking.completed .is-complete:after {
    border-color: #fff;
    border-width: 0px 3px 3px 0;
    width: 7px;
    left: 11px;
    opacity: 1;
}

.order-tracking p {
    color: #A4A4A4;
    font-size: 16px;
    margin-top: 8px;
    margin-bottom: 0;
    line-height: 20px;
}

.order-tracking p span {
    font-size: 14px;
}

.order-tracking.completed p {
    color: #000;
}

.order-tracking::before {
    content: '';
    display: block;
    height: 3px;
    width: calc(100% - 40px);
    background-color: #f7be16;
    top: 13px;
    position: absolute;
    left: calc(-50% + 20px);
    z-index: 0;
}

.order-tracking:first-child:before {
    display: none;
}

.order-tracking.completed:before {
    background-color: #27aa80;
}

.media-body i {
    font-size: 18px;
}
</style>


<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Order Details</h1>
            </div>
        </div>
    </div>
</section>

<section class="feature-area my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0" style="box-shadow: 0px 0px 2px 2px #e3e3e3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                @foreach($order->orderItems as $item)
                                <h5>{{ $item->product->title }} </h5>
                                <h6><b>₹{{ number_format($item->price, 2) }} x {{ $item->quantity }}</b></h6>
                                <!-- <p>Color: <strong>{{ $item->productColorDetails->name ?? 'N/A' }}</strong></p> -->
                                @endforeach

                                <div class="col-12 col-md-10 hh-grayBox pt45 pb20">
                                    <div class="d-flex">
                                        <div
                                            class="order-tracking {{ in_array($order->status, ['pending', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                            <span class="is-complete"></span>
                                            <p>Pending<br><span>{{ \Carbon\Carbon::parse($order->created_at)->format('D, M d') }}</span>
                                            </p>
                                        </div>

                                        <div
                                            class="order-tracking {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '' }}">
                                            <span class="is-complete"></span>
                                            <p>Shipped<br><span>{{ $order->shipped_date ? \Carbon\Carbon::parse($order->shipped_at)->format('D, M d') : '-' }}</span>
                                            </p>
                                        </div>

                                        <div
                                            class="order-tracking {{ $order->status == 'delivered' ? 'completed' : '' }}">
                                            <span class="is-complete"></span>
                                            <p>Delivered<br><span>{{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivered_at)->format('D, M d') : '-' }}</span>
                                            </p>
                                        </div>

                                        <div
                                            class="order-tracking {{ $order->status == 'cancelled' ? 'completed' : '' }}">
                                            <span class="is-complete"></span>
                                            <p>Cancelled<br><span>{{ $order->cancelled_date ? \Carbon\Carbon::parse($order->cancelled_at)->format('D, M d') : '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <img src="{{ url('public/product_images/' . $item->product->images->first()->images ?? 'default.png') }}"
                                    class="img-fluid" alt="{{ $item->product->title }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0" style="box-shadow: 0px 0px 2px 2px #e3e3e3">
                    @foreach ($order->orderItems as $item)
                    <div class="card-body">
                        @php
                        $existingReview = $existingReviews[$item->product->id] ?? null;
                        @endphp

                        @if ($existingReview)
                        <h4><b>Your Review</b></h4>
                        <div class="media-body">
                            <h5>Rated:</h5>
                            @for ($i = 1; $i <= 5; $i++) <i
                                class="fa fa-star {{ $i <= $existingReview->rating ? 'text-warning' : '' }}"></i>
                                @endfor
                        </div>
                        <p><b>Review:</b> {{ $existingReview->review ?? 'No comment provided.' }}</p>
                        @else
                        {{-- Show form if no review exists --}}
                        <form action="javascript:void(0)" class="contact_form ratingForm"
                            data-order-id="{{ $order->id }}" data-product-id="{{ $item->product->id }}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <h4><b>Rate this Product</b></h4>
                                    <div class="media-body rating" data-rating="0">
                                        <h5>Your star out of 5!</h5>
                                        @for ($i = 1; $i <= 5; $i++) <i class="fa fa-star" data-value="{{ $i }}"></i>
                                            @endfor
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control review-text" rows="1"
                                            placeholder="Review"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="primary-btn">Submit Now</button>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

</section>

@endsection

@section('customJS')
<script>
$(document).ready(function() {
    $('.rating .fa-star').on('click', function() {
        let selectedValue = $(this).data('value');
        $('.rating').attr('data-rating', selectedValue);
        $('.rating .fa-star').removeClass('text-warning');
        $('.rating .fa-star').each(function() {
            if ($(this).data('value') <= selectedValue) {
                $(this).addClass('text-warning');
            }
        })
    });
    $('#ratingForm').on('submit', function(e) {
        e.preventDefault();

        let rating = $('.rating').attr('data-rating');
        let review = $('#review').val();
        let orderId = $(this).data('order-id');
        let productId = $(this).data('product-id');

        $.ajax({
            url: "{{route('store-review')}}",
            type: 'POST',
            data: {
                rating: rating,
                review: review,
                order_id: orderId,
                product_id: productId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status == 'success') {
                    notyf.success(response.message);
                    $('#review').val('');
                    $('.fa-star').removeClass('text-warning');
                    $('.rating').attr('data-rating', 0);
                } else {
                    notyf.fail(response.message);
                }
            },
            error: function(xhr) {
                alert('Something went wrong!');
            }
        });
    });

})
</script>

@endsection