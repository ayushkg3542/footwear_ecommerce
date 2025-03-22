@extends('includes.app')
@section('content')

<style>
.status-progress-wrap {
    display: flex;
    max-width: 500px;
    margin: 50px auto;
    padding: 30px 0px 0px;
    position: relative;
}

.status-progress-bar-wrap {
    position: absolute;
    width: 100%;
    top: 0px;
    height: 6px;
    background: #dfdfdf;
    border-radius: 10px;
}

.status-progress-bar {
    background: #03A9F4;
    height: 100%;
    width: 10%;
    border-radius: 10px;
    display: inline-flex;
    vertical-align: top;
    justify-content: flex-end;
    transition: width 1s linear;
}

.status-wrap {
    display: inline-flex;
    flex-direction: column;
    background: #fff;
    width: 25%;
    align-items: center;
    position: relative;
}

.status-wrap span {
    color: #ddd;
    transition: all ease 0.25s;
}

.status-wrap:hover span {
    color: #03A9F4;
    transition: all ease 0.3s;
}

.status-wrap::after {
    content: "";
    width: 12px;
    height: 12px;
    margin-top: -33px;
    background: #dfdfdf;
    display: inline-block;
    vertical-align: top;
    transform: scale(1.25);
    transform-origin: center;
    border-radius: 50%;
    position: absolute;
    top: 0;
}

.status-wrap::before {
    content: "";
    width: 12px;
    height: 12px;
    margin-top: -33px;
    background: #03A9F4;
    display: inline-block;
    vertical-align: top;
    transform: scale(0);
    transform-origin: center;
    border-radius: 50%;
    position: absolute;
    top: 0;
    z-index: 2;
    transition: all ease .7s;
}

.status-wrap.active::before {
    transform: scale(1.25);
    transition: all ease .7s;
}

.status-wrap:nth-child(2) {
    align-items: flex-start;
}

.status-wrap:last-child {
    align-items: flex-end;
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                @foreach($order->orderItems as $item)
                                <h5>{{ $item->product->title }} </h5>
                                <h6><b>₹{{ number_format($item->price, 2) }} x {{ $item->quantity }}</b></h6>
                                <!-- <p>Color: <strong>{{ $item->productColorDetails->name ?? 'N/A' }}</strong></p> -->
                                @endforeach

                                <div class="status-progress-wrap">
                                    <div class="status-progress-bar-wrap">
                                        <div style="width:10%;" class="status-progress-bar">
                                        </div>
                                    </div>
                                    <div class="status-wrap">
                                        Ordered
                                        <span>21-02-2019</span>
                                    </div>
                                    <div class="status-wrap">
                                        Packed
                                        <span>21-02-2019</span>
                                    </div>
                                    <div class="status-wrap">
                                        Shipped
                                        <span>21-02-2019</span>
                                    </div>
                                    <div class="status-wrap">
                                        Delivered
                                        <span>21-02-2019</span>
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

            </div>
        </div>
    </div>

</section>

<!-- -->

<!-- <div class="card">
    <div class="card-body">
        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
        <p><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
        <p><strong>Payment Status:</strong> <span class="badge bg-success">{{ ucfirst($order->status) }}</span></p>
        <h4>Products:</h4>
        <ul>
            @foreach($order->orderItems as $item)
            <li>
                <img src="{{ url('public/product_images/' . $item->product->images->first()->images ?? 'default.png') }}"
                    style="height: 50px;" alt="{{ $item->product->title }}">
                {{ $item->product->title }} - ₹{{ number_format($item->price, 2) }} x {{ $item->quantity }}
            </li>
            @endforeach
        </ul>
    </div>
</div> -->