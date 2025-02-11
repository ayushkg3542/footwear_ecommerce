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
</head>

<body>
    @include('includes.header')

    @yield('content')

    @include('includes.footer')

    @yield('customJS')


    
</body>


</html>