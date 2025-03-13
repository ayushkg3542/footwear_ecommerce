@extends('admin.includes.app')
@section('content')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Category</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Category</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="items" data-group="test">
            <div class="card">
                <div class="card-body">
                    <form action="javascript:void(0)" id="subcategoryForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Category</label>
                                    <select name="category_id" class="form-control" id="category">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Sub-Category</label>
                                    <input type="text" class="form-control" name="subcategory" id="subcategory">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
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
                            <th>Category</th>
                            <th>Sub-Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="tableBody">
                        @if($subcategories->count() > 0)
                        @foreach ($subcategories as $key => $subcategory)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $subcategory->category->category }}</td>
                            <td>{{$subcategory->subcategory}}</td>
                            <td>{{$subcategory->status}}</td>
                            <td>
                                <button class="btn p-0 editbtn" data-id="{{ $subcategory->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <button class="btn p-0 deletebtn" data-id="{{ $subcategory->id }}" data-type="subcategory">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="text-center" colspan="12">No data found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="modifymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Sub-Category</h5>
                        <input type="hidden" id="modifydataid">
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="label-text">Category</label>
                                    <input type="text" name="class" id="modifycategory" class="form-control">
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
        
    </div>
</main>
<!--end main wrapper-->

@endsection

@section('customJS')

<script>
$(document).ready(function() {
    $("#subcategoryForm").validate({
        rules: {
            category_id: {
                required: true,
            },
            subcategory: {
                required: true,
            }
        },
        messages: {
            category_id: {
                required: "This field is required"
            },
            subcategory:{
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
                url: '{{route("storesubCategory")}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == "success") {
                        toastr.success(response.message, 'Success', {
                            timeOut: 1500
                        });
                        window.location.reload();
                    } else {
                        toastr.error(response.message, 'Error', {
                            timeOut: 1500
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            })
        }
    })

    $(document).on('click', '.editbtn', function(e) {
        e.preventDefault();
        var dataid = $(this).data('id');

        $.ajax({
            url: '{{route("getsubCategory")}}',
            type: 'POST',
            data: {
                dataid: dataid
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == "success") {
                    // console.log(response);
                    $("#modifydataid").val(response.data.id);
                    $("#modifycategory").val(response.data.category);
                    $("#modifystatus").val(response.data.status);
                    $("#modifymodal").modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    $(document).on('click', '#closeidbtn', function(e) {
        e.preventDefault();
        $("#modifymodal").modal('hide');
    });

    $(document).on('click', '#confirmtomodify', function(e) {
        e.preventDefault();
        $("#confirmtomodify").prop("disabled", true);
        var id = $("#modifydataid").val();
        var categories = $("#modifycategory").val();
        var status = $("#modifystatus").val();

        $.ajax({
            url: '{{route("modifysubCategory")}}',
            type: "POST",
            data: {
                id: id,
                category: categories,
                status: status
            },
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
        })
    });
})
</script>

@endsection