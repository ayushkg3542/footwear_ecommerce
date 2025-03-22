@extends('includes.app')
@section('content')

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Order Failed!</h1>
            </div>
        </div>
    </div>
</section>

<section class="checkout_area section_gap">
    <div class="container">
        <div class="main-cover d-flex align-items-center flex-column w3">
            <img src="{{ url('public/front/img/remove.png') }}" style="height: 150px; width: 150px;" class="img-fluid mb-5" alt="">
            <h5>Your Transaction is failed, Please try again</h5>


            <a href="{{ route('home') }}" class="primary-btn mt-md-3 mt-3"> <span
                    class="fa fa-arrow-left mr-2"></span> Back
                to Home</a>
        </div>
    </div>
</section>