@extends('admin.includes.app')
@section('content')

<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Manage CMS</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Pages</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="items" data-group="test">
            <div class="card">
                <div class="card-body">
                    <form action="javascript:void(0)" id="cmspageForm">
                        @if(isset($cmspage))
                        <input type="hidden" name="cmspage_id" id="cmspage_id" value="{{ isset($cmspage) ? $cmspage->id : '' }}">
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="page_title" class="form-label">Page Title</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Title" value="{{ isset($cmspage) ? $cmspage->title : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="url" class="form-label">Page URL</label>
                                    <input type="text" name="url" class="form-control" id="url" placeholder="URL" value="{{ isset($cmspage) ? $cmspage->url : '' }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="description"
                                        placeholder="Enter Description">{{ isset($cmspage) ? $cmspage->description : '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta title</label>
                                    <input type="text" name="meta_title" class="form-control" id="meta_title"
                                        placeholder="meta_title" value="{{ isset($cmspage) ? $cmspage->meta_title : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <input type="text" name="meta_description" class="form-control"
                                        id="meta_description" placeholder="meta_description" value="{{ isset($cmspage) ? $cmspage->meta_description : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control" id="meta_keywords"
                                        placeholder="meta_keywords" value="{{ isset($cmspage) ? $cmspage->meta_keywords : '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="inputEmail1" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" {{ isset($cmspage) && $cmspage->status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ isset($cmspage) && $cmspage->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-center">
                                <div class="repeater-remove-btn">
                                    <button type="submit"
                                        class="btn btn-danger btn-sm remove-btn px-3 py-2 submitButton">
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
    $('#cmspageForm').validate({
        rules: {
            title: {
                required: true
            },
            description: {
                required: true
            },
            url: {
                required: true
            },
        },
        messages: {
            title: {
                required: "Please enter title"
            },
            description: {
                required: "Please provide description"
            },
            url: {
                required: "Please provide url of CMS"
            },
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
            $("#submitButton").prop("disabled", true);
            var formData = new FormData(form);
            var cmsId = $("#cmspage_id").val(); // Get CMS ID if available (hidden input in form)
            var isEditMode = false;
            var url = cmsId ? '/storecms/' + cmsId : '/storecms';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

            });
            $.ajax({
                url: "{{ route('storecms') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == "success") {
                        toastr.success(response.message, 'Success', {
                            timeOut: 500
                        });
                        window.location.href = "{{ route('cmspage') }}";
                    } else {
                        toastr.error(response.message, 'Error', {
                            timeOut: 500
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }
    })
})
</script>

@endsection