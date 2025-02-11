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
            <div class="breadcrumb-title pe-3">Color</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Color</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="items" data-group="test">
            <div class="card">
                <div class="card-body">
                    <form action="javascript:void(0)" id="colorForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="color" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Color Code<span
                                            class="text-danger">*</span></label>
                                    <input type="color" name="code" class="form-control" id="color_code">
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
                                    <button type="submit" class="btn btn-danger btn-sm remove-btn px-3 py-2 submitButton">
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
                            <th>Name</th>
                            <th>Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="tableBody">
                        @foreach ($colors as $key => $color)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{$color->name}}</td>
                                <td>{{$color->code}}</td>
                                <td>{{$color->status}}</td>
                                <td>
                                    <button class="btn p-0 editbtn" data-id="{{ $color->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn p-0 deletebtn" data-id="{{ $color->id }}" data-type="color">
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Color</h5>
                        <input type="hidden" id="modifydataid">
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="label-text">Modify Color</label>
                                    <input type="text" name="name" id="modifyname" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code" class="form-label">Modify Code</label>
                                    <input type="color" name="code" class="form-control" id="modifycode">
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
    $(document).ready(function () {
        $("#colorForm").validate({
            rules: {
                name: {
                    required: true,
                },
                code: {
                    required: true,
                }

            },
            messages: {
                name: {
                    required: "This field is required"
                },
                code: {
                    required: "This field is required",
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
                    url: '{{route("storeColor")}}',
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


        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();
            var dataid = $(this).data('id');

            $.ajax({
                url: '{{route("getColor")}}',
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
                        $("#modifyname").val(response.data.name);
                        $("#modifycode").val(response.data.code);
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

        $(document).on('click', '#closeidbtn', function (e) {
            e.preventDefault();
            $("#modifymodal").modal('hide');
        });

        $(document).on('click', '#confirmtomodify', function (e) {
            e.preventDefault();
            $("#confirmtomodify").prop("disabled", true);

            var id = $("#modifydataid").val();
            var name = $("#modifyname").val();
            var code = $("#modifycode").val();
            var status = $("#modifystatus").val();

            var formData = new FormData();
            formData.append('id', id);
            formData.append('name', name);
            formData.append('code', code);
            formData.append('status', status);

            $.ajax({
                url: '{{route("modifyColor")}}',
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
    })
</script>

@endsection