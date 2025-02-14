@extends('admin.includes.app')
@section('content')

<style>
    .btn-label-success{
        background-color: rgb(210, 255, 186);
    }
    .btn-label-danger{
        background-color: rgb(255, 186, 186);
    }
</style>

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">eCommerce</div>
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

        <!-- <div class="product-count d-flex align-items-center gap-3 gap-lg-4 mb-4 fw-medium flex-wrap font-text1">
            <a href="javascript:;"><span class="me-1">All</span><span class="text-secondary">(88754)</span></a>
            <a href="javascript:;"><span class="me-1">Published</span><span class="text-secondary">(56242)</span></a>
            <a href="javascript:;"><span class="me-1">Drafts</span><span class="text-secondary">(17)</span></a>
            <a href="javascript:;"><span class="me-1">On Discount</span><span class="text-secondary">(88754)</span></a>
        </div> -->

        <div class="row g-3">
            <div class="col-auto">
                <div class="position-relative">
                    <input class="form-control px-5" type="search" placeholder="Search Products">
                    <span
                        class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                </div>
            </div>
            <div class="col-auto flex-grow-1 overflow-auto">
                
              </div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <button class="btn btn-filter px-4"><i class="bi bi-box-arrow-right me-2"></i>Export</button>
                    <a href="{{route('addProducts') }}" class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>Add Product</a>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="card mt-4">
            <div class="card-body">
                <div class="product-table">
                    <div class="table-responsive white-space-nowrap">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <input class="form-check-input" type="checkbox">
                                    </th>
                                    <th>Product Name</th>
                                    <th>Slug</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key=>$product) 
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="product-box">
                                            <img src="{{ url('public/product_images/' . ($product->images->first()->images ?? 'default.png')) }}" width="70" class="rounded-3" alt="">
                                            </div>
                                            <div class="product-info">
                                            <a href="javascript:;" class="product-title">{{ $product->title }}</a>
                                            <p class="mb-0 product-category">SubCategory : {{  $product->subcategory_name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $product->slug }}</td>
                                    <td>&#8377;{{ $product->new_price ?? 'N/A' }}</td>
                                    <td>{{ $product->category_name ?? 'N/A' }}</td>
                                    <td class="text-primary">{{ $product->brand_name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($product->status === 'Active')
                                            <a href="javascript:void(0)" class="btn btn-label-success text-success">
                                                {{ $product->status }}
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" class="btn btn-label-danger text-danger">
                                                {{ $product->status }}
                                            </a>
                                        @endif
                                    </td>

                                    <td>{{ $product->created_at->format('M j, g:i A') }}</td>
                                    <td>
                                        <a class="btn text-success btn-label-success" href=""><i class="bi bi-pencil-square"></i></a>
                                        <a class="btn text-danger btn-label-danger" href=""><i class="bi bi-trash"></i></a>
                                    </td>
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