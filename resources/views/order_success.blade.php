@extends('includes.app')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Order Successfull!</h1>
            </div>
        </div>
    </div>
</section>

<section class="checkout_area section_gap">
    <div class="container">
        <div class="main-cover d-flex align-items-center flex-column w3">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module">
            </script>
            <dotlottie-player src="https://lottie.host/7a9947cb-2176-4f48-bd6e-8604f5090dd2/LD6Kdh5768.json"
                background="transparent" speed="1" style="width: 150px; height: 150px" direction="1" playMode="normal"
                autoplay></dotlottie-player>
            <h5>Thank You For Purchasing This Course!</h5>


            <a href="{{ route('home') }}" class="primary-btn mt-md-5 mt-4"> <span
                    class="fa fa-arrow-left mr-2"></span> Back
                to Home</a>
        </div>
    </div>
</section>