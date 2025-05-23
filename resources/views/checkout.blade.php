@extends('includes.app')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Checkout</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="{{ route('checkout') }}">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--  -->

<!--================Checkout Area =================-->
<section class="checkout_area section_gap">
    <div class="container">
        <div class="cupon_area">
            <div class="check_title">
                <h2>Have a coupon?</h2>
            </div>

            @php
            $appliedCoupon = session('applied_coupon');
            $discount = session('discount') ?? 0;
            @endphp

            @if ($appliedCoupon)
            <div class="my-3 gap-3">
                <strong>Applied Coupon:</strong> <span id="applied-code">{{ $appliedCoupon }}</span>
                <button type="button" class="btn btn-sm btn-danger" id="removeCouponBtn" onclick="removeCouponBtn()"><i class="bi bi-trash"></i></button>
            </div>
            @else
            <input type="text" id="coupon_code" placeholder="Enter coupon code">
            <a class="tp_btn" id="applyCouponBtn" href="javascript:void(0)">Apply Coupon</a>
            <p id="coupon-message" style="margin-top: 10px;"></p>
            @endif
        </div>


        <form class="checkout_form" action="javascript:void(0)" method="post" novalidate="novalidate">
            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>Delivery Address</h3>
                        <div class="row">
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name ?? '') }}">
                                <span class="placeholder" placeholder="Full Name"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone ?? '') }}">
                                <span class="placeholder" placeholder="Number"></span>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email ?? '') }}">
                                <span class="placeholder" placeholder="Email Address"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <select class="form-control country_select">
                                    <option value="India">India</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <select name="state" id="state" class="form-control">
                                    <option value="">Select State</option>
                                    <option value="Andhra Pradesh"
                                        {{ isset($address) && $address->state == 'Andhra Pradesh' ? 'selected' : '' }}>
                                        Andhra Pradesh
                                    </option>
                                    <option value="Arunachal Pradesh"
                                        {{ isset($address) && $address->state == 'Arunachal Pradesh' ? 'selected' : ''}}>
                                        Arunachal Pradesh</option>
                                    <option value="Assam"
                                        {{ isset($address) && $address->state == 'Assam' ? 'selected' : ''}}>Assam</option>
                                    <option value="Bihar"
                                        {{ isset($address) && $address->state == 'Bihar' ? 'selected' : ''}}>Bihar</option>
                                    <option value="Chhattisgarh"
                                        {{ isset($address) && $address->state == 'Chhattisgarh' ? 'selected' : ''}}>
                                        Chhattisgarh</option>
                                    <option value="Gujarat"
                                        {{ isset($address) && $address->state == 'Gujarat' ? 'selected' : ''}}>Gujarat
                                    </option>
                                    <option value="Haryana"
                                        {{ isset($address) && $address->state == 'Haryana' ? 'selected' : ''}}>Haryana
                                    </option>
                                    <option value="Himachal Pradesh"
                                        {{ isset($address) && $address->state == 'Himachal Pradesh' ? 'selected' : ''}}>
                                        Himachal Pradesh</option>
                                    <option value="Jammu and Kashmir"
                                        {{ isset($address) && $address->state == 'Jammu and Kashmir' ? 'selected' : ''}}>
                                        Jammu and Kashmir</option>
                                    <option value="Goa" {{ isset($address) && $address->state == 'Goa' ? 'selected' : ''}}>
                                        Goa</option>
                                    <option value="Jharkhand"
                                        {{ isset($address) && $address->state == 'Jharkhand' ? 'selected' : ''}}>Jharkhand
                                    </option>
                                    <option value="Karnataka"
                                        {{ isset($address) && $address->state == 'Karnataka' ? 'selected' : ''}}>Karnataka
                                    </option>
                                    <option value="Kerala"
                                        {{ isset($address) && $address->state == 'Kerala' ? 'selected' : ''}}>Kerala
                                    </option>
                                    <option value="Madhya Pradesh"
                                        {{ isset($address) && $address->state == 'Madhya Pradesh' ? 'selected' : ''}}>
                                        Madhya Pradesh</option>
                                    <option value="Maharashtra"
                                        {{ isset($address) && $address->state == 'Maharashtra' ? 'selected' : ''}}>
                                        Maharashtra</option>
                                    <option value="Manipur"
                                        {{ isset($address) && $address->state == 'Manipur' ? 'selected' : ''}}>Manipur
                                    </option>
                                    <option value="Meghalaya"
                                        {{ isset($address) && $address->state == 'Meghalaya' ? 'selected' : ''}}>Meghalaya
                                    </option>
                                    <option value="Mizoram"
                                        {{ isset($address) && $address->state == 'Mizoram' ? 'selected' : ''}}>Mizoram
                                    </option>
                                    <option value="Nagaland"
                                        {{ isset($address) && $address->state == 'Nagaland' ? 'selected' : ''}}>Nagaland
                                    </option>
                                    <option value="Odisha"
                                        {{ isset($address) && $address->state == 'Odisha' ? 'selected' : ''}}>Odisha
                                    </option>
                                    <option value="Punjab"
                                        {{ isset($address) && $address->state == 'Punjab' ? 'selected' : ''}}>Punjab
                                    </option>
                                    <option value="Rajasthan"
                                        {{ isset($address) && $address->state == 'Rajasthan' ? 'selected' : ''}}>Rajasthan
                                    </option>
                                    <option value="Sikkim"
                                        {{ isset($address) && $address->state == 'Sikkim' ? 'selected' : ''}}>Sikkim
                                    </option>
                                    <option value="Tamil Nadu"
                                        {{ isset($address) && $address->state == 'Tamil Nadu' ? 'selected' : ''}}>Tamil
                                        Nadu</option>
                                    <option value="Telangana"
                                        {{ isset($address) && $address->state == 'Telangana' ? 'selected' : ''}}>Telangana
                                    </option>
                                    <option value="Tripura"
                                        {{ isset($address) && $address->state == 'Tripura' ? 'selected' : ''}}>Tripura
                                    </option>
                                    <option value="Uttarakhand"
                                        {{ isset($address) && $address->state == 'Uttarakhand' ? 'selected' : ''}}>
                                        Uttarakhand</option>
                                    <option value="Uttar Pradesh"
                                        {{ isset($address) && $address->state == 'Uttar Pradesh' ? 'selected' : ''}}>Uttar
                                        Pradesh</option>
                                    <option value="West Bengal"
                                        {{ isset($address) && $address->state == 'West Bengal' ? 'selected' : ''}}>West
                                        Bengal</option>
                                    <option value="Andaman and Nicobar Islands"
                                        {{ isset($address) && $address->state == 'Andaman and Nicobar Islands' ? 'selected' : ''}}>
                                        Andaman and Nicobar Islands</option>
                                    <option value="Chandigarh"
                                        {{ isset($address) && $address->state == 'Chandigarh' ? 'selected' : ''}}>
                                        Chandigarh</option>
                                    <option value="Dadra and Nagar Haveli"
                                        {{ isset($address) && $address->state == 'Dadra and Nagar Haveli' ? 'selected' : ''}}>
                                        Dadra and Nagar Haveli</option>
                                    <option value="Daman and Diu"
                                        {{ isset($address) && $address->state == 'Daman and Diu' ? 'selected' : ''}}>Daman
                                        and Diu</option>
                                    <option value="Delhi"
                                        {{ isset($address) && $address->state == 'Delhi' ? 'selected' : ''}}>Delhi</option>
                                    <option value="Lakshadweep"
                                        {{ isset($address) && $address->state == 'Lakshadweep' ? 'selected' : ''}}>
                                        Lakshadweep</option>
                                    <option value="Puducherry"
                                        {{ isset($address) && $address->state == 'Puducherry' ? 'selected' : ''}}>
                                        Puducherry</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ old('address', $address->address ?? '') }}">
                                <span class="placeholder" placeholder="Full Address"></span>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="city" name="city"
                                    value="{{ old('city', $address->city ?? '') }}">
                                <span class="placeholder" placeholder="Town/City"></span>
                            </div>

                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" id="pincode" name="pincode"
                                    placeholder="Postcode/ZIP" value="{{ old('pincode', $address->pincode ?? '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            <ul class="list">
                                <li><a href="#">Product <span>Total</span></a></li>
                                @php $subtotal = 0; @endphp
                                @foreach ($cartItems as $item)
                                <li><a href="#">{{ $item->title }}
                                        <span class="middle">x {{ $item->qty }}</span>
                                        <span class="last">₹{{ number_format($item->new_price * $item->qty, 2) }}</span>
                                    </a></li>
                                @php $subtotal += $item->new_price * $item->qty; @endphp
                                @endforeach
                                @php
                                $discount = session('discount') ?? 0;
                                $shipping = 0;
                                $total = $subtotal - $discount + $shipping;
                                @endphp
                            </ul>
                            <ul class="list list_2">
                                <li><a href="#">Subtotal <span>₹{{ number_format($subtotal, 2) }}</span></a></li>
                                <li><a href="javascript:void(0)">Discount: <span
                                            id="discount-amount">₹{{ number_format($discount, 2) }}</span></a></li>
                                <li><a href="#">Shipping <span>Flat rate: ₹{{ number_format($shipping, 2) }}</span></a>
                                </li>
                                <li><a href="#">Total <span id="total-amount">₹{{ number_format($total, 2) }}</span></a>
                                </li>
                            </ul>
                            <div class="creat_account">
                                <input type="checkbox" id="f-option4" name="selector">
                                <label for="f-option4">I’ve read and accept the </label>
                                <a href="#">terms & conditions*</a>
                            </div>
                            <button class="primary-btn" id="rzp-button1">Proceed to Payment</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--================End Checkout Area =================-->

@endsection

@section('customJS')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.getElementById('rzp-button1').addEventListener('click', function() {
    var amount = {{
            $subtotal + 50
        }};


    // Save Order Before Initiating Payment
    $.ajax({
        url: "{{ route('checkout.store') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            name: $('#name').val(),
            phone: $('#phone').val(),
            email: $('#email').val(),
            address: $('#address').val(),
            cartItems: @json($cartItems),
            subtotal: amount
        },
        success: function() {
            // console.log("Order stored, now initiating payment...");

            $.ajax({
                url: "{{ route('razorpay-initiate') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    amount: amount
                },
                success: function(data) {
                    if (!data.order_id) {
                        // console.error("Order ID missing from Razorpay response.");
                        return;
                    }
                    // console.log("Payment initiation successful");

                    var options = {
                        key: "{{ env('RAZORPAY_KEY') }}",
                        amount: amount * 100,
                        currency: "INR",
                        name: "Your Store",
                        description: "Order Payment",
                        order_id: data.order_id,
                        handler: function(response) {
                            // console.log("Payment Success, updating backend...");

                            $.ajax({
                                url: "{{ route('razorpay-payment') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    razorpay_payment_id: response
                                        .razorpay_payment_id
                                },
                                success: function() {
                                    console.log(
                                        "Payment recorded in DB, redirecting..."
                                    );
                                    // console.log("Server Response:",data);
                                    window.location.href =
                                        "{{ route('order.success') }}";
                                },
                                error: function(xhr) {
                                    console.error(
                                        "Payment update failed:",
                                        xhr.responseText);
                                    alert(
                                        "Payment verification failed. Please contact support."
                                    );
                                }
                            });
                        },
                        prefill: {
                            name: "{{ Auth::user()->name ?? 'Guest' }}",
                            email: "{{ Auth::user()->email ?? '' }}",
                            contact: "{{ Auth::user()->phone ?? '' }}"
                        },
                        theme: {
                            color: "#007bff"
                        }
                    };

                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                },
                error: function(xhr) {
                    console.error("Payment initiation error:", xhr.responseText);
                    alert("Failed to initiate payment. Try again.");
                }
            });
        },
        error: function(xhr) {
            console.error("Order storage error:", xhr.responseText);
            alert("Order could not be saved. Try again.");
        }
    });
});

$('#applyCouponBtn').on('click', function() {
    let code = $('#coupon_code').val();

    $.ajax({
        url: "{{ route('applycoupon') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            coupon_code: code
        },
        success: function(response) {
            if (response.success) {
                notyf.success(response.message)
                location.reload();
            } else {
                notyf.error(response.message);
            }
        }
    });
})

function removeCouponBtn(){
    $.ajax({
        url: "{{ route('removeCoupon') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
        },
        success: function (response) {
            if (response.success) {
                notyf.success(response.message);
                location.reload(); 
            }
        },
        error: function () {
            notyf.error("Something went wrong while removing the coupon.");
        }
    });
}

</script>
@endsection

