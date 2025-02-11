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
                    <form action="javascript:void(0)" id="categoryForm">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="thumbnail_image" class="form-label">Thumbnail Image</label>
                                    <input type="file" name="thumbnail_image" class="form-control" id="thumbnail_image">
                                    <p id="image-error" class="text-danger"></p>
                                    <div id="image-preview" style="margin-top: 10px; position: relative;">
                                        <img id="thumbnail-preview" src="" alt="Image Preview"
                                            style="max-width: 100%; display: none;" />
                                        <button id="remove-image" type="button"
                                            style="display: none; position: absolute; top: 0; right: 0; background: #ff0000; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">&times;</button>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="category" class="form-control" id="category"
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
                            <div class="col-md-1 d-flex align-items-center">
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
                            <th>Image</th>
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="tableBody">
                        @foreach ($categories as $key => $category)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><img src="{{url('storage/app/public/' . $category->thumbnail_image)}}"
                                    class="img-fluid thumbnail_image" alt="Category Thumbnail"></td>
                            <td>{{$category->category}}</td>
                            <td>{{$category->slug}}</td>
                            <td>{{$category->status}}</td>
                            <td>
                                <button class="btn p-0 editbtn" data-id="{{ $category->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <button class="btn p-0 deletebtn" data-id="{{ $category->id }}" data-type="category">
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                        <input type="hidden" id="modifydataid">
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="label-text">Modify Image</label>
                                    <input type="file" name="thumbnail_image" id="modifyimage" class="form-control">
                                    <img id="imageDisplay" src="" alt="Thumbnail Preview"
                                        style="display: none; width: 100px; height: auto; margin-top: 10px;" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="label-text">Modify Category</label>
                                    <input type="text" name="class" id="modifycategory" class="form-control">
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
    </div>
</main>
<!--end main wrapper-->

@endsection

@section('customJS')

<script>
$(document).ready(function() {
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
                url: '{{route("storeCategory")}}',
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
    $("#thumbnail_image").on("change", function(event) {
        var fileInput = event.target;
        var file = fileInput.files[0];
        var imageError = $("#image-error");
        var imagePreview = $("#thumbnail-preview");
        var removeImageBtn = $("#remove-image");

        imageError.text("");

        if (file) {
            if (file.size <= 3 * 1024 * 1024 && file.type.startsWith("image/")) {
                var reader = new FileReader();
                reader.onload = function(e) {
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
    $("#remove-image").on("click", function() {
        var fileInput = $("#thumbnail_image");
        var imagePreview = $("#thumbnail-preview");
        var removeImageBtn = $("#remove-image");

        fileInput.val("");
        imagePreview.hide();
        removeImageBtn.hide();
    });

    // 


    $(document).on('click', '.editbtn', function(e) {
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
            success: function(response) {
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
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });



    $('#modifycategory').on('input', function() {
        var categories = $(this).val();
        var slug = categories.toLowerCase().trim()
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

    $('#category').on('input', function() {
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'get',
            data: {
                category: element.val()
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