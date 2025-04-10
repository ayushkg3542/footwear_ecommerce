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
            <a href="javascript:;"><span class="me-1">All</span><span
                    class="text-secondary">({{ $totalOrderCount }})</span></a>
            <a href="javascript:;"><span class="me-1">Order Pending Status</span><span
                    class="text-secondary">({{ $pendingOrder }})</span></a>
            <a href="javascript:;"><span class="me-1">Order Delivered</span><span
                    class="text-secondary">({{ $completedOrder }})</span></a>
            <a href="javascript:;"><span class="me-1">Refunded</span><span
                    class="text-secondary">({{ $orderRefunded }})</span></a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-header mb-3">
                    Search Order
                </div>
                <form id="orderSearchForm" method="GET">
                    <div class="row g-3">
                        <div class="col-3">
                            <div class="position-relative">
                                <label for="search">ID</label>
                                <input class="form-control px-5" name="id" type="search" placeholder="Search Orders"
                                    value="{{ Request::get('id') }}">
                                <span
                                    class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 fs-5"
                                    style="top: 67% !important">search</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative">
                                <label for="search">Name</label>
                                <input class="form-control" name="name" type="text" placeholder="Enter Name"
                                    value="{{ Request::get('name') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="position-relative">
                                <label for="from_date">From Date</label>
                                <input class="form-control" name="from_date" type="date"
                                    value="{{ Request::get('from_date') }}" id="from_date">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="position-relative">
                                <label for="from_date">To Date</label>
                                <input class="form-control" type="date" name="to_date" id="to_date"
                                    value="{{ Request::get('to_date') }}">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-primary w-100" type="submit">Search</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>


        <!--end row-->

        <div class="card mt-4">
            <div class="card-body">
                <div class="customer-table">
                    <div class="table-responsive white-space-nowrap" id="orderTableWrapper">
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
                            <tbody id="orderTableBody">

                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox">
                                    </td>
                                    <td>
                                        @if(isset($order->id))
                                        <a
                                            href="{{ route('order.details', ['order' => encrypt($order->id)]) }}">#{{ $order->id }}</a>
                                        @endif
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
                                        <select class="form-select form-select-sm fw-bold 
                                            bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'shipped' ? 'info' : ($order->status == 'delivered' ? 'success' : 'danger')) }}-subtle 
                                            text-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'shipped' ? 'info' : ($order->status == 'delivered' ? 'success' : 'danger')) }} 
                                            border border-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'shipped' ? 'info' : ($order->status == 'delivered' ? 'success' : 'danger')) }}-subtle 
                                            status-dropdown" 
                                            data-order-id="{{ $order->id }}">

                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
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

@section('customJS')
<script>
$('#orderSearchForm').on('submit', function(e) {
    e.preventDefault(e);
    let formData = $(this).serialize();

    $.ajax({
        url: "{{ route('orderList') }}",
        type: "GET",
        data: formData,
        beforeSend: function() {
            $('#orderTableBody').html(
                '<tr><td colspan ="8" class="text-center">Loading..</td></tr>');
        },
        success: function(res) {
            $('#orderTableBody').html(res.html);
        },
        error: function() {
            alert('error');
        }
    })
})

$(document).on('change', '.status-dropdown', function(){
    let orderId = $(this).data('order-id');
    let newStatus = $(this).val();

    $.ajax({
        url: '{{ route("updateOrderStatus") }}',
        method: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            order_id: orderId,
            status: newStatus,
        },
        success: function(response){
            toastr.success(response.message,'Success');
            location.reload();
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    })
})
</script>

@endsection