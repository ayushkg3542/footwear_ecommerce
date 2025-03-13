@extends('includes.app')
@section('content')

<style>
.cart-image {
    height: 100px;
}
</style>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartProducts as $cart)

                        <tr class="cart-box">
                            <td>
                                <div class="media">
                                    <div class="d-flex cart-image">
                                        <img src="{{ url('public/product_images/' . ($cart->product->images->first()->images ?? 'default.png')) }}"
                                            alt="">
                                    </div>
                                    <div class="media-body">
                                        <p>{{ $cart->product->title ?? 'No Title' }}</p>
                                        <p>Size: {{ $cart->product->size ?? '' }}</p>
                                        <a href="#" class="remove-product btn-danger p-1"
                                            data-cart-id="{{ $cart->id }}">Remove <i class="bi bi-trash"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>₹{{ $cart->product->new_price ?? '0.00'}}</h5>
                            </td>
                            <td>
                                <div class="product_count">
                                    <input type="text" name="qty" maxlength="12" value="{{ $cart->qty }}"
                                        title="Quantity:" class="input-text qty" data-cart-id="{{ $cart->id }}"
                                        readonly>
                                    <button class="increase items-count" type="button"><i
                                            class="lnr lnr-chevron-up"></i></button>
                                    <button class="reduced items-count" type="button"><i
                                            class="lnr lnr-chevron-down"></i></button>
                                </div>
                            </td>
                            <td>
                                <h5 class="total-price">
                                    ₹{{ number_format(floatval($cart->product->new_price ?? 0) * intval($cart->qty ?? 1), 2) }}
                                </h5>
                            </td>
                        </tr>

                        @endforeach
                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td><h5>Subtotal</h5></td>
                            <td><h5>₹<span id="subtotal-amount">{{ number_format($cartProducts->sum(fn($cart) => $cart->product->new_price * $cart->qty), 2) }}</span></h5></td>
                            </tr>
                        <tr class="out_button_area">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="checkout_btn_inner d-flex justify-content-end align-items-center">
                                    <a class="gray_btn" href="{{ route('products') }}">Continue Shopping</a>
                                    <a class="primary-btn" href="{{ route('checkout') }}">Proceed to checkout</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!--  -->

@endsection

@section('customJS')

<script>
$(document).on('click', '.increase, .reduced', function(e) {
    e.preventDefault();

    let input = $(this).closest('.product_count').find('.qty');
    let cartId = input.data('cart-id');
    let currentQty = parseInt(input.val());
    let priceText = input.closest('tr').find('td:eq(1) h5').text().replace('₹', '').replace(/,/g, '').trim();
    let price = parseFloat(priceText);


    let newQty = $(this).hasClass('increase') ? currentQty + 1 : currentQty - 1;

    if (newQty < 1) {
        removeProduct(cartId, input.closest('.cart-box'));
        return;
    }

    input.val(newQty);

    $.ajax({
        url: "{{ route('cart.updateQuantity') }}",
        type: 'POST',
        data: {
            cart_id: cartId,
            quantity: newQty,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.status === 'success') {
                input.closest('tr').find('.total-price').text('₹' + response.total_price);
                updateCartCount(response.cart_count);
                updateSubtotal();
                notyf.success(response.message);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Error updating product quantity.');
        }
    });
});

$(document).on('click', '.remove-product', function(e) {
    e.preventDefault();

    let cartId = $(this).data('cart-id');
    let row = $(this).closest('.cart-box');

    removeProduct(cartId, row);
});

function removeProduct(cartId, row) {
    $.ajax({
        url: "{{ route('cart.remove') }}",
        type: "POST",
        data: {
            cart_id: cartId,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.status === 'success') {
                row.fadeOut(300, function() {
                    $(this).remove();
                });

                updateSubtotal();
                updateCartCount(response.cart_count);
                notyf.success(response.message);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Error removing product from cart.');
        }
    });
}


function updateSubtotal() {
    let subtotal = 0;

    $('.cart-box').each(function() {
        let priceText = $(this).find('.total-price').text().replace('₹', '').replace(/,/g, '').trim();
        let totalPrice = parseFloat(priceText) || 0;
        subtotal += totalPrice;
    });

    $('#subtotal-amount').text(subtotal.toFixed(2));
}


</script>

@endsection

<!--  -->