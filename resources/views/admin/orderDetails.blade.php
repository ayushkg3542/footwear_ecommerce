@extends('admin.includes.app')
@section('content')

<style>
    p{
        text-transform: capitalize;
    }
</style>

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Components</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Customer Details</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        @if ($orderDetails)
        <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="position-relative">
                            <img src="{{url('public/admin/assets/images/gallery/18.png')}}" class="img-fluid rounded"
                                alt="">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{url('public/admin/assets/images/avatars/11.png')}}" width="100" height="100"
                                    class="rounded-circle raised p-1 bg-white" alt="">
                            </div>
                        </div>

                        <div class="text-center mt-5 pt-4">
                            <h4 class="mb-1">{{ $orderDetails->user->name }}</h4>
                            <p class="mb-0">Customer</p>
                        </div>

                    </div>
                    @php
                    $address = json_decode($orderDetails->address, true);
                    @endphp
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-top">
                            <b>Address</b>
                            <br>
                            {{ $address['address'] ?? '-' }}, {{ $address['locality'] ?? '-' }},
                            {{ $address['city'] ?? '-' }},
                            {{ $address['state'] ?? '-' }},
                            {{ $address['country'] ?? '-' }} - {{ $address['pincode'] ?? '-' }}
                        </li>
                        <li class="list-group-item">
                            <b>Email</b>
                            <br>
                            {{ $orderDetails->user->email ?? '-' }}
                        </li>
                        <li class="list-group-item">
                            <b>Phone</b>
                            <br>
                            Mobile : {{ $orderDetails->user->phone ?? '-' }}
                        </li>
                    </ul>


                </div>
            </div>

            <div class="col-12 col-lg-8 d-flex">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Orders ID:-<span class="fw-light ms-2">{{ $orderDetails->id }}</span></h5>
                        <div class="product-table">

                            @php
                            $item = $orderDetails->orderItems->first();
                            $product = $item?->product;

                            $images = json_decode($product->images, true);
                            $firstImage = $images[0]['images'] ?? null;
                            @endphp

                            @if($item && $product)
                            <img src="{{ url('public/product_images/' . $firstImage) }}" alt="{{ $product->name }}"
                                width="80" height="80" class="rounded border">
                            @endif

                            <p><strong>Total Order:</strong> {{ $orderDetails->user()->count() }}</p>
                            <p><strong>Placed On:</strong> {{ $orderDetails->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Discount Coupon:</strong> {{ $orderDetails->coupon_id ?? 'N/A' }}</p>
                            <p><strong>Coupon Code:</strong> {{ $orderDetails->coupon_code ?? 'N/A' }}</p>
                            <p><strong>Discount Got:</strong> {{ $orderDetails->discount ?? 'N/A' }}</p>
                            <p><strong>Total Amount:</strong> ${{ number_format($orderDetails->total_amount, 2) }}</p>

                            <p><strong>Payment Status:</strong>
                                @if($orderDetails->payment_status === 'paid')
                                <span
                                    class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">
                                    Paid <i class="bi bi-check2 ms-2"></i>
                                </span>
                                @else
                                <span
                                    class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">
                                    Unpaid <i class="bi bi-x ms-2"></i>
                                </span>
                                @endif
                            </p>
                            <p><strong>Payment Method:</strong> {{ $orderDetails->payment_method }}</p>
                            
                            <p><strong>Order Status:</strong> {{ $orderDetails->status }}</p>
                            <p><strong>Shipping Date:</strong> {{ $orderDetails->shipped_date ?? 'N/A' }}</p>
                            <p><strong>Delivery Date:</strong>{{ $orderDetails->delivery_date ?? 'N/A' }}</p>


                            <h6 class="mt-4">Products:</h6>
                            <div class="table-responsive white-space-nowrap">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orderDetails->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->title ?? 'N/A' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format($item->price, 2) }}</td>
                                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                            <td>{{ $item->grand_total }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!--end row-->




        <div class="card mt-4">
            <div class="card-body">
                <h5 class="mb-3 fw-bold">Wishlist<span class="fw-light ms-2">(46)</span></h5>
                <div class="product-table">
                    <div class="table-responsive white-space-nowrap">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>

                                    <th>Product Name</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="product-box">
                                                <img src="assets/images/top-products/06.png" width="55"
                                                    class="rounded-3" alt="">
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:;" class="product-title">Women Pink Floral
                                                    Printed</a>
                                                <p class="mb-0 product-category">Category : Fashion</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Blue</td>
                                    <td>Large</td>
                                    <td>2</td>
                                    <td>$59</td>
                                    <td>189</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="product-box">
                                                <img src="assets/images/top-products/05.png" width="55"
                                                    class="rounded-3" alt="">
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:;" class="product-title">Women Pink Floral
                                                    Printed</a>
                                                <p class="mb-0 product-category">Category : Fashion</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Blue</td>
                                    <td>Large</td>
                                    <td>2</td>
                                    <td>$59</td>
                                    <td>189</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="product-box">
                                                <img src="assets/images/top-products/04.png" width="55"
                                                    class="rounded-3" alt="">
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:;" class="product-title">Women Pink Floral
                                                    Printed</a>
                                                <p class="mb-0 product-category">Category : Fashion</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Blue</td>
                                    <td>Large</td>
                                    <td>2</td>
                                    <td>$59</td>
                                    <td>189</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="product-box">
                                                <img src="assets/images/top-products/03.png" width="55"
                                                    class="rounded-3" alt="">
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:;" class="product-title">Women Pink Floral
                                                    Printed</a>
                                                <p class="mb-0 product-category">Category : Fashion</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Blue</td>
                                    <td>Large</td>
                                    <td>2</td>
                                    <td>$59</td>
                                    <td>189</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="product-box">
                                                <img src="assets/images/top-products/02.png" width="55"
                                                    class="rounded-3" alt="">
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:;" class="product-title">Women Pink Floral
                                                    Printed</a>
                                                <p class="mb-0 product-category">Category : Fashion</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Blue</td>
                                    <td>Large</td>
                                    <td>2</td>
                                    <td>$59</td>
                                    <td>189</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="product-box">
                                                <img src="assets/images/top-products/01.png" width="55"
                                                    class="rounded-3" alt="">
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:;" class="product-title">Women Pink Floral
                                                    Printed</a>
                                                <p class="mb-0 product-category">Category : Fashion</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Blue</td>
                                    <td>Large</td>
                                    <td>2</td>
                                    <td>$59</td>
                                    <td>189</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--end main wrapper-->
@endsection