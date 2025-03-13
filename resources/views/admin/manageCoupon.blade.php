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

@section('customJS')

<!-- <script>
                $(document).ready(function () {
                    $("#categoryForm").validate({
                        rules: {
                            category: {
                                required: true,
                            }
                        },
                        messages: {
                            category: {
                                required: "This field is required"
                            }
                        },
                        errorElement: "p",
                        errorPlacement: function (error, element) {
                            if (element.prop("tagName").toLowerCase() === "select") {
                                error.insertAfter(element);
                            } else {
                                error.insertAfter(element);
                            }
                            error.addClass('text-danger');
                        },
                        submitHandler: function (form) {
                            $(".submitButton").prop("disabled", true);
                            var formData = new FormData(form);
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: '{{route("storeCategory")}}',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (response) {
                                    if (response.status == "success") {
                                        toastr.success(response.message, 'Success', {
                                            timeOut: 500
                                        });
                                        window.location.reload();
                                    } else {
                                        toastr.error(response.message, 'Error', {
                                            timeOut: 500
                                        });
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            })
                        }
                    });
                    $("#thumbnail_image").on("change", function (event) {
                        var fileInput = event.target;
                        var file = fileInput.files[0];
                        var imageError = $("#image-error");
                        var imagePreview = $("#thumbnail-preview");
                        var removeImageBtn = $("#remove-image");

                        imageError.text("");

                        if (file) {
                            if (file.size <= 3 * 1024 * 1024 && file.type.startsWith("image/")) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    imagePreview.attr("src", e.target.result).show();
                                    removeImageBtn.show();
                                }
                                reader.readAsDataURL(file);
                            } else {
                                imageError.text("Invalid image file. Make sure it's an image and under 3MB.");
                                imagePreview.hide();
                                removeImageBtn.hide();
                            }
                        } else {
                            imagePreview.hide();
                            removeImageBtn.hide();
                        }
                    });

                    // Handle remove image action
                    $("#remove-image").on("click", function () {
                        var fileInput = $("#thumbnail_image");
                        var imagePreview = $("#thumbnail-preview");
                        var removeImageBtn = $("#remove-image");

                        fileInput.val("");
                        imagePreview.hide();
                        removeImageBtn.hide();
                    });

                    // 


                    $(document).on('click', '.editbtn', function (e) {
                        e.preventDefault();
                        var dataid = $(this).data('id');

                        $.ajax({
                            url: '{{route("getCategory")}}',
                            type: 'POST',
                            data: {
                                dataid: dataid
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.status == "success") {
                                    $("#modifydataid").val(response.data.id);

                                    if (response.data.thumbnail_image) {
                                        var imageUrl = '{{ url("storage/app/public") }}/' + response.data
                                            .thumbnail_image;
                                        $("#imageDisplay").attr('src', imageUrl)
                                            .show();
                                    } else {
                                        $("#imageDisplay").hide();
                                    }

                                    $("#modifycategory").val(response.data.category);
                                    $("#modifyslug").val(response.data.slug);
                                    $("#modifystatus").val(response.data.status);

                                    // Show modal
                                    $("#modifymodal").modal('show');
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    });



                    $('#modifycategory').on('input', function () {
                        var categories = $(this).val();
                        var slug = categories.toLowerCase().trim()
                            .replace(/\s+/g, '-')
                            .replace(/[^\w\-]+/g, '')
                            .replace(/\-\-+/g, '-')
                            .replace(/^-+/, '')
                            .replace(/-+$/, '');
                        $('#modifyslug').val(slug);
                    });

                    $(document).on('click', '#closeidbtn', function (e) {
                        e.preventDefault();
                        $("#modifymodal").modal('hide');
                    });

                    $(document).on('click', '#confirmtomodify', function (e) {
                        e.preventDefault();
                        $("#confirmtomodify").prop("disabled", true);

                        var id = $("#modifydataid").val();
                        var thumbnailImage = $("#modifyimage")[0].files[0]; // Image file
                        var categories = $("#modifycategory").val();
                        var slug = $("#modifyslug").val();
                        var status = $("#modifystatus").val();

                        var formData = new FormData();
                        formData.append('id', id);
                        if (thumbnailImage) {
                            formData.append('thumbnail_image', thumbnailImage);
                        }
                        formData.append('category', categories);
                        formData.append('slug', slug);
                        formData.append('status', status);

                        $.ajax({
                            url: '{{route("modifyCategory")}}',
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                $("#confirmtomodify").prop("disabled", false);
                                if (response.status == "success") {
                                    toastr.success(response.message, 'Success', {
                                        timeOut: 1000
                                    });
                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 500);
                                } else if (response.status == "fail") {
                                    toastr.error(response.message, 'Failed', {
                                        timeOut: 500
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                                $("#confirmtomodify").prop("disabled", false);
                                toastr.error('An error occurred while processing your request.', 'Error', {
                                    timeOut: 500
                                });
                            }
                        });
                    });

                    $('#category').on('input', function () {
                        var element = $(this);
                        $("button[type=submit]").prop('disabled', true);
                        $.ajax({
                            url: '{{ route("getSlug") }}',
                            type: 'get',
                            data: {
                                category: element.val()
                            },
                            dataType: 'json',
                            success: function (response) {
                                $("button[type=submit]").prop('disabled', false);
                                if (response['status'] == true) {
                                    $('#slug').val(response.slug);
                                }
                            },
                            error: function (jqXHR, exception) {
                                console.log("Something went wrong");
                            }
                        })
                    });
                })
            </script> -->

@endsection