@extends('admin.includes.app')
@section('content')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Orders</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="product-count d-flex align-items-center gap-3 gap-lg-4 mb-4 fw-medium flex-wrap font-text1">
            <a href="javascript:;"><span class="me-1">All</span><span class="text-secondary">({{ $totalOrderCount }})</span></a>
            <a href="javascript:;"><span class="me-1">Order Pending Status</span><span class="text-secondary">({{ $pendingOrder }})</span></a>
            <a href="javascript:;"><span class="me-1">Order Delivered</span><span class="text-secondary">({{ $completedOrder }})</span></a>
            <a href="javascript:;"><span class="me-1">Refunded</span><span class="text-secondary">({{ $orderRefunded }})</span></a>
        </div>

        <div class="row g-3">
            <div class="col-auto">
                <div class="position-relative">
                    <input class="form-control px-5" type="search" placeholder="Search Customers">
                    <span
                        class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                </div>
            </div>
            <div class="col-auto flex-grow-1 overflow-auto">
                <div class="btn-group position-static">
                    <div class="btn-group position-static">
                        <button type="button" class="btn border btn-filter dropdown-toggle px-4"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Payment Status
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                    <div class="btn-group position-static">
                        <button type="button" class="btn border btn-filter dropdown-toggle px-4"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Completed
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <button class="btn btn-filter px-4"><i class="bi bi-box-arrow-right me-2"></i>Export</button>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="card mt-4">
            <div class="card-body">
                <div class="customer-table">
                    <div class="table-responsive white-space-nowrap">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <input class="form-check-input" type="checkbox">
                                    </th>
                                    <th>Order Id</th>
                                    <th>Price</th>
                                    <th>Customer</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Payment Type</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox">
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('order.details', ['order' => encrypt($order->id)]) }}">#{{ $order->id }}</a>
                                    </td>
                                    <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <a class="d-flex align-items-center gap-3" href="javascript:;">
                                            <p class="mb-0 customer-name fw-bold">{{ $order->user->name }}</p>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="lable-table bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}-subtle 
                                    text-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} rounded 
                                    border border-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}-subtle 
                                    font-text2 fw-bold">
                                            {{ ucfirst($order->payment_status) }}
                                            <i
                                                class="bi bi-{{ $order->payment_status == 'paid' ? 'check2' : 'exclamation-lg' }} ms-2"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="lable-table bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}-subtle 
                                    text-{{ $order->status == 'pending' ? 'warning' : 'success' }} rounded 
                                    border border-{{ $order->status == 'pending' ? 'warning' : 'success' }}-subtle 
                                    font-text2 fw-bold">
                                            {{ ucfirst($order->status) }}
                                            <i
                                                class="bi bi-{{ $order->status == 'pending' ? 'x-lg' : 'check2' }} ms-2"></i>
                                        </span>
                                    </td>
                                    <td>{{ ucfirst($order->payment_method == 'prepaid' ? 'Net Banking' : '') }}</td>
                                    <td>{{ $order->created_at->format('M d, h:i A') }}</td>
                                </tr>
                                @endforeach
                                



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