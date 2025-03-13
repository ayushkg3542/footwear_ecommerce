<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Karma Shop</title>
    <!-- CSS ============================================= -->
    <link rel="stylesheet" href="{{url('public/front/css/linearicons.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/nouislider.min.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/ion.rangeSlider.css')}}" />
    <link rel="stylesheet" href="{{url('public/front/css/ion.rangeSlider.skinFlat.css')}}" />
    <link rel="stylesheet" href="{{url('public/front/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/main.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @include('includes.header')

    @yield('content')

    @include('includes.footer')

    @yield('customJS')

    <script>
    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'right',
            y: 'top',
        }
    });


    $(document).ready(function() {
        $('.add-to-cart').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');

            $.ajax({
                url: "{{ route('addToCart') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId
                },
                success: function(response) {
                    if (response.status === "success") {
                        updateCartCount(response.cart_count);
                        notyf.success(response.message);
                    } else {
                        notyf.error(response.message);
                    }
                },
                error: function() {
                    notyf.error('An error occured wile adding the product to cart');
                }
            });
        });

        $('.add-to-wishlist').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');

            $.ajax({
                url: "{{ route('addToWishlist') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        notyf.success(response.message);
                    } else {
                        notyf.error(response.message);
                    }
                },
                error: function() {
                    notyf.error('An error occured while adding the product to wishlist');
                }
            })

        })
    })

    function updateCartCount(count) {
        let cartIcon = $('.cart .ti-bag');

        cartIcon.siblings('.cart-count').remove();
        if (count > 0) {
            cartIcon.after('<span class="cart-count text-light bg-danger">' + count + '</span>')
        }
    }
    </script>

    <script>
        $(document).ready(function() {
            $("#searchForm").submit(function(e){
                e.preventDefault();
                let searchQuery = $("#search_input").val().trim();

                if(searchQuery !== ""){
                    window.location.href = "{{ route('products') }}?search=" + encodeURIComponent(searchQuery);
                }
            });
        })
    </script>



</body>


</html>