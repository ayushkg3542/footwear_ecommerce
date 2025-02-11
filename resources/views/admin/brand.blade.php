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
            <div class="breadcrumb-title pe-3">Brand</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Brand</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="items" data-group="test">
            <div class="card">
                <div class="card-body">
                    <form action="javascript:void(0)" id="brandForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="brand" class="form-label">Brand Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="brand" class="form-control" id="brand"
                                        placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control" id="slug" placeholder="Slug"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="inputEmail1" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" default selected>Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-center">
                                <div class="repeater-remove-btn">
                                    <button type="submit" class="btn btn-danger btn-sm remove-btn px-3 py-2">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Brand Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="tableBody">
                    @foreach ($brands as $key => $brand)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{$brand->brand}}</td>
                            <td>{{$brand->slug}}</td>
                            <td>{{$brand->status}}</td>
                            <td>
                                <button class="btn p-0 editbtn" data-id="{{ $brand->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn p-0 deletebtn" data-id="{{ $brand->id }}" data-type="brand">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="modifymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
                        <input type="hidden" id="modifydataid">
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="label-text">Modify Brand</label>
                                    <input type="text" name="class" id="modifybrand" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" name="slug" class="form-control" id="modifyslug"
                                        placeholder="Slug" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="label-text">Status</label>
                                    <select name="status" id="modifystatus" class="form-control">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeidbtn">Close</button>
                        <button type="button" class="btn btn-success" id="confirmtomodify">Modify</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmation</h5>
                        <input type="hidden" id="delete_id_modal">
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="deleteclosebtn">Close</button>
                        <button type="button" class="btn btn-danger" id="confirmtodelete">Delete</button>
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
$(document).ready(function() {
    $("#brandForm").validate({
        rules: {
            brand: {
                required: true,
            }
        },
        messages: {
            brand: {
                required: "This field is required"
            }
        },
        errorElement: "p",
        errorPlacement: function(error, element) {
            if (element.prop("tagName").toLowerCase() === "select") {
                error.insertAfter(element);
            } else {
                error.insertAfter(element);
            }
            error.addClass('text-danger');
        },
        submitHandler: function(form) {
            $(".submitButton").prop("disabled", true);
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{route("storeBrand")}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
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
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            })
        }
    });


    $(document).on('click', '.editbtn', function(e) {
        e.preventDefault();
        var dataid = $(this).data('id');

        $.ajax({
            url: '{{route("getBrand")}}',
            type: 'POST',
            data: {
                dataid: dataid
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == "success") {
                    $("#modifydataid").val(response.data.id);
                    $("#modifybrand").val(response.data.brand);
                    $("#modifyslug").val(response.data.slug);
                    $("#modifystatus").val(response.data.status);

                    // Show modal
                    $("#modifymodal").modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });



    $('#modifybrand').on('input', function() {
        var brand = $(this).val();
        var slug = brand.toLowerCase().trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
        $('#modifyslug').val(slug);
    });

    $(document).on('click', '#closeidbtn', function(e) {
        e.preventDefault();
        $("#modifymodal").modal('hide');
    });

    $(document).on('click', '#confirmtomodify', function(e) {
        e.preventDefault();
        $("#confirmtomodify").prop("disabled", true);

        var id = $("#modifydataid").val();
        var brand = $("#modifybrand").val();
        var slug = $("#modifyslug").val();
        var status = $("#modifystatus").val();

        var formData = new FormData(); 
        formData.append('id', id);
        formData.append('brand', brand);
        formData.append('slug', slug);
        formData.append('status', status);

        $.ajax({
            url: '{{route("modifyBrand")}}',
            type: "POST",
            data: formData,
            contentType: false, 
            processData: false, 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $("#confirmtomodify").prop("disabled", false);
                if (response.status == "success") {
                    toastr.success(response.message, 'Success', {
                        timeOut: 1000
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                } else if (response.status == "fail") {
                    toastr.error(response.message, 'Failed', {
                        timeOut: 500
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $("#confirmtomodify").prop("disabled", false);
                toastr.error('An error occurred while processing your request.', 'Error', {
                    timeOut: 500
                });
            }
        });
    });


    $('#brand').on('input', function() {
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("getBrandSlug") }}',
            type: 'get',
            data: {
                brand: element.val()
            },
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if (response['status'] == true) {
                    $('#slug').val(response.slug);
                }
            },
            error: function(jqXHR, exception) {
                console.log("Something went wrong");
            }
        })
    });
})
</script>

@endsection