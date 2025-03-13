@extends('admin.includes.app')
@section('content')

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
                        <li class="breadcrumb-item active" aria-current="page">Add Coupon</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="items" data-group="test">
            <div class="card">
                <div class="card-body">
                    <form action="javascript:void(0)" method="post" id="discountForm">
                        @if(isset($coupon))
                        <input type="hidden" name="discount_id" value="{{ $coupon->id }}">
                        @endif
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Select Product<span
                                            class="text-danger">*</span></label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option default selected>Select</option>
                                        @foreach ($products as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($coupon) && $coupon->product_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" value="{{ isset($coupon) ? $coupon->start_date : '' }}"
                                        name="start_date" class="form-control" id="start_date">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" value="{{ isset($coupon) ? $coupon->end_date : '' }}"
                                        name="end_date" class="form-control" id="end_date">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="discount_percentage" class="form-label">Discount Percentage</label>
                                    <input type="number" min="0" max="100" value="{{ isset($coupon) ? $coupon->discount_percentage : '' }}"
                                        name="discount_percentage" class="form-control" id="discount_percentage">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="upto_amount" class="form-label">Upto Amount</label>
                                    <input type="text" value="{{ isset($coupon) ? $coupon->upto_amount : '' }}"
                                        name="upto_amount" class="form-control" id="upto_amount">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="max_amount" class="form-label">Maximum Amount</label>
                                    <input type="text" value="{{ isset($coupon) ? $coupon->max_amount : '' }}"
                                        name="max_amount" class="form-control" id="max_amount">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active"
                                            {{ isset($coupon) && $coupon->status == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Inactive"
                                            {{ isset($coupon) && $coupon->status == 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-center">
                                <div class="repeater-remove-btn">
                                    <button type="submit" class="btn btn-danger btn-sm remove-btn px-3 py-2 discountsubmitbtn">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@section('customJS')
<script>
$(document).ready(function() {
    $("#discountForm").validate({
        rules: {
            product_id: {
                required: true,
            },
            discount_percentage: {
                required: true,
            },
            upto_amount: {
                required: true,
            },
            start_date: {
                required: true,
            },
            end_date: {
                required: true,
            },
            max_amount: {
                required: true,
            }
        },
        messages: {
            product_id: {
                required: "Please select a product",
            },
            discount_percentage: {
                required: "Please enter discount percentage",
            },
            upto_amount: {
                required: "Please enter amount",
            },
            start_date: {
                required: "Please select start date",
            },
            end_date: {
                required: "Please select end date",
            },
            max_amount: {
                required: "Required",
            }
        },
        errorElement: "p",
        errorPlacement: function(error, element) {
            if (element.prop("tagName").toLowerCase() === "select") {
                error.insertAfter(element);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            $("#discountsubmitbtn").prop("disabled", true);
            var formData = new FormData(form);
            var isEditMode = false; // Set to true if editing an existing discount
            var url = isEditMode ? '/updateDiscount' : '/storeCoupon';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route("storeCoupon")}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == "success") {
                        toastr.success(response.message, 'Success', {
                            timeOut: 500
                        });
                        window.location.href = "{{ route('couponList') }}";

                    } else if (response.data.status == "fail") {
                        $("#discountsubmitbtn").prop("disabled", false);
                        if (response.data.errortype == "discounterror") {
                            $("#discount_percentage").val('');
                            $("#errorpercentagemessage").show();
                        } else {
                            toastr.error(response.message, 'Error', {
                                timeOut: 500
                            });
                        }

                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }
    });
    $(".submitButton").click(function() {
        $("#discountForm").submit();
    });

    $('.reset').on('click', function() {
        location.reload();
    });
});
</script>
@endsection