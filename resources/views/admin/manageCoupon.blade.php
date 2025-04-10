@extends('admin.includes.app')
@section('content')

<style>
.thumbnail_image {
    max-width: 100px;
    height: auto;
}
</style>

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Coupon</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Coupon List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Sr.No.</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Discount %</th>
                            <th scope="col">Discount Upto</th>
                            <th scope="col">Max Amount</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="tableBody">
                        @foreach($coupon as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->product->title }}</td>
                            <td>{{ $item->discount_percentage }}%</td>
                            <td>{{ $item->upto_amount }}</td>
                            <td>{{ $item->max_amount }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <a href="{{ route('manageCoupon', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</main>
<!--end main wrapper-->

@endsection
