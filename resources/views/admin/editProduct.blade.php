@extends('admin.includes.app')
@section('content')

<style>
.heroo {
    margin-top: 0px
}

#drop-area {
    width: 100%;
}

#img-view {
    border: 1px dashed black;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#img-view img {
    width: 80px
}

#imagePreview {
    display: flex;
    gap: 10px
}

.image-container {
    width: 120px;
    height: auto;
    position: relative;
}

.image-container .delete-icon {
    margin-right: 1rem;
    background-color: red;
    position: absolute;
    bottom: 0;
    padding: 3px;
    border-radius: 5px;
    color: #fff;
    right: 0;
}

.image-container .img-thumbnail {
    width: 100%;
}
</style>

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Products</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Products</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--  -->
        <!--end breadcrumb-->
        <form action="javascript: void(0)" id="productForm">
            <input type="hidden" id="product_id" name="product_id" value="{{ $productData->id ?? '' }}">
            <div id="deletedImagesContainer"></div>
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <h5 class="mb-3">Title <span class="text-danger">*</span></h5>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="write title here...."
                                    value="{{ old('title', $productData ? $productData->title : '') }}">
                            </div>
                            <div class="mb-4">
                                <h5 class="mb-3">Slug</h5>
                                <input type="text" class="form-control" name="slug" id="slug"
                                    value="{{ old('slug',$productData ? $productData->slug : '') }}" readonly>
                            </div>
                            <div class="mb-4">
                                <h5 class="mb-3">Short Description <span class="text-danger">*</span></h5>
                                <textarea class="form-control" cols="4" id="short_description" name="short_description"
                                    rows="6">{{ $productData->short_description }}</textarea>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3">Detail Description <span class="text-danger">*</span></h5>
                                <textarea class="form-control" id="detail_description" name="detail_description"
                                    cols="4" rows="6">{{ $productData->detail_description }}</textarea>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3">Shipping and Returns <span class="text-danger">*</span></h5>
                                <textarea class="form-control" id="shipping_returns" name="shipping_returns" cols="4"
                                    rows="6">{{ $productData->shipping_returns }}</textarea>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3">Display images</h5>
                                <div class="row">
                                    <div class="col-md-12 heroo">
                                        <label for="imageInput" id="drop-area">
                                            <input type="file" name="image[]" id="imageInput"
                                                class="form-control formControlCustom" hidden multiple>
                                            <div id="img-view">
                                                <img src="{{ url('public/admin/assets/images/arrow.png') }}" alt="">
                                                <p>Drag and Drop and Click Here</p>
                                            </div>
                                        </label>
                                        <p id="errorMessage" class="text-danger"></p>
                                        <div id="imagePreview" class="row mt-4">
                                            @foreach ($productData->images as $image)
                                            <div class="col-md-2 mb-3 position-relative existing-image"
                                                data-image="{{ $image->images }}">
                                                <img src="{{ url('public/product_images/' . $image->images) }}"
                                                    class="img-thumbnail" alt="Product Image"
                                                    style="width: 100%; height: auto;">
                                                <button type="button" class="btn btn-danger btn-sm delete-image"
                                                    style="position: absolute; top: 10px; right: 10px;"
                                                    data-image="{{ $image->images }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="mb-4">
                                <h5 class="mb-3">Price <span class="text-danger">*</span></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="new_price">New Price</label>
                                        <input type="text" name="new_price" class="form-control" id="new_price"
                                            value="{{ old('new_price', $productData ? $productData->new_price : '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="old_price">Old Price</label>
                                        <input type="text" name="old_price" class="form-control" id="old_price"
                                            value="{{ old('old_price', $productData ? $productData->old_price : '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3">Stock <span class="text-danger">*</span></h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input" type="radio" name="stock" value="in_stock"
                                                id="flexRadioSuccess"
                                                {{ old('stock', optional($productData)->stock) == 'in_stock' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexRadioSuccess">
                                                In Stock
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-danger">
                                            <input class="form-check-input" type="radio" name="stock"
                                                value="out_of_stock" id="flexRadioDanger"
                                                {{ old('stock', optional($productData)->stock) == 'out_of_stock' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexRadioDanger">
                                                Out of Stock
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <p id="stock-error" class="text-danger"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <button type="button" class="btn btn-outline-danger flex-fill"><i
                                        class="bi bi-x-circle me-2"></i>Discard</button>
                                <button type="button" class="btn btn-outline-success flex-fill"><i
                                        class="bi bi-cloud-download me-2"></i>Save Draft</button>
                                <button type="submit" class="btn btn-outline-primary flex-fill submitButton"><i
                                        class="bi bi-send me-2"></i>Publish</button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Organize</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="addcategory" class="form-label">Category<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="addcategory" name="category">
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if(isset($productData->category) &&
                                            $productData->category == $category->id) selected @endif>
                                            {{ $category->category }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="subcategory" class="form-label">Sub Category</label>
                                    <select class="form-select" id="subcategory" name="subcategory">
                                        <option value="">Select</option>
                                        @if ($productData && $productData->subcategory)
                                        @foreach ($subcategories as $subcategory)
                                        @if ($subcategory->category_id == $productData->category)
                                        {{-- category_id is in subcategories table --}}
                                        <option value="{{ $subcategory->id }}" @if($productData->subcategory ==
                                            $subcategory->id) selected @endif>
                                            {{ $subcategory->subcategory }}
                                        </option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <!--end row-->
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Inventory</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="Brand" class="form-label">Brand</label>
                                    <select name="brand" class="form-control" id="brand">
                                        <option value="">Select</option>
                                        @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @if($productData->brand == $brand->id) selected
                                            @endif>
                                            {{ $brand->brand }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="SKU" class="form-label">SKU (Stock Keeping Unit) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="SKU" name="sku" placeholder="SKU"
                                        value="{{ old('sku', $productData ? $productData->sku : '') }}">
                                </div>
                                <div class="col-12">
                                    <label for="barcode">Barcode <span class="text-danger">*</span></label>
                                    <input type="text" maxlength="13" name="barcode" id="barcode" class="form-control"
                                        placeholder="Barcode"
                                        value="{{ old('barcode', $productData ? $productData->barcode : '') }}">
                                </div>
                                <div class="col-12">
                                    <label for="Choose color" class="form-label">Choose Color</label>
                                    <div class="row">
                                        @php
                                        $selectedColors = isset($productData->colors) ? explode(',',
                                        $productData->colors) : [];
                                        @endphp

                                        @foreach ($colors as $color)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="colors[]"
                                                    value="{{ $color->id }}" id="color{{ $color->id }}"
                                                    @if(in_array($color->id, $selectedColors)) checked @endif>
                                                <label class="form-check-label" for="color{{ $color->id }}">
                                                    {{ $color->name }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>

                                <div class="col-12">
                                    <label for="Size" class="form-label">Size <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="size" id="Size" placeholder="Size"
                                        value="{{ old('size', $productData ? $productData->size : '') }}">
                                </div>
                                <div class="col-12">
                                    <label for="quantity" class="form-label">Quantity <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="quantity" id="quantity"
                                        placeholder="Ex: 1"
                                        value="{{ old('quantity', $productData ? $productData->quantity : '') }}">
                                </div>
                                <div class="col-12">
                                    <label for="quantity" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Active" @if($productData->status == 'Active') selected
                                            @endif>Active</option>
                                        <option value="Inactive" @if($productData->status == 'Inactive') selected
                                            @endif>Inactive</option>
                                    </select>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

@endsection


@section('customJS')
<script>
$(document).ready(function() {
    $('#short_description, #detail_description, #shipping_returns').summernote({
        callbacks: {
            onChange: function(contents, $editable) {
                $(this).val(contents);
                $(this).valid();
            }
        },
    });

    $('#title').on('input', function() {
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("getproductSlug") }}',
            type: 'get',
            data: {
                title: element.val()
            },
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if (response['status'] == true) {
                    $('#slug').val(response.slug);
                }
            },
            error: function(jqXHR, exception, error) {
                console.log("Something went wrong", jqXHR.responseText);
            }
        })
    });


    $('#addcategory').change(function() {
        var categoryId = $(this).val();

        if (categoryId) {
            $.ajax({
                url: '{{ route("getSubcategories") }}',
                type: 'GET',
                data: {
                    category_id: categoryId
                },
                success: function(response) {
                    $('#subcategory').empty();
                    $('#subcategory').append(
                        '<option value="">Select</option>');

                    $.each(response.subcategories, function(key, subcategory) {
                        $('#subcategory').append('<option value="' + subcategory
                            .id + '">' + subcategory.subcategory + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching subcategories:', xhr.responseText);
                }
            });
        } else {
            $('#subcategory').empty();
            $('#subcategory').append('<option value="0">Select</option>');
        }
    });

    $("#productForm").validate({
        rules: {
            title: {
                required: true
            },
            slug: {
                required: true
            },
            short_description: {
                required: true
            },
            detail_description: {
                required: true
            },
            shipping_returns: {
                required: true
            },
            new_price: {
                required: true
            },
            stock: {
                required: true
            },
            category: {
                required: true
            },
            sku: {
                required: true
            },
            barcode: {
                required: true
            },
            size: {
                required: true
            },
            quantity: {
                required: true
            }
        },
        messages: {
            title: {
                required: "Please enter product title"
            },
            slug: {
                required: "Please enter product slug"
            },
            short_description: {
                required: "Please enter product short description"
            },
            detail_description: {
                required: "Please enter product detail description"
            },
            shipping_returns: {
                required: "Please enter product shipping returns"
            },
            new_price: {
                required: "Please enter product price"
            },
            stock: {
                required: "Please select product stock"
            },
            category: {
                required: "Please enter product category"
            },
            sku: {
                required: "Please enter product sku"
            },
            barcode: {
                required: "Please enter product barcode"
            },
            size: {
                required: "Please enter product size"
            },
            quantity: {
                required: "Please enter product quantity"
            }
        },
        errorElement: "p",
        errorPlacement: function(error, element) {
            if (element.attr("name") === "stock") {
                error.insertAfter("#stock-error");
            } else if (element.hasClass("summernote")) {
                error.insertAfter($(element).next('.note-editor'));
            } else if (element.prop("tagName").toLowerCase() === "select") {
                error.insertAfter(element);
            } else {
                error.insertAfter(element);
            }
            error.addClass('text-danger');
        },
        submitHandler: function(form) {
            $(".submitButton").prop("disabled", true);
            var formData = new FormData(form);

            // Append images only if new images are selected
            if (selectedFiles.length > 0) {
                selectedFiles.forEach((file, index) => {
                    formData.append(`images[${index}]`, file);
                });
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route("modifyProduct", ["id" => $productData->id]) }}',

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
                        console.error('Full Error Response:', response);
                        toastr.error(response.message ??
                            'An unexpected error occurred.', 'Error', {
                                timeOut: 500
                            });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value, 'Validation Error');
                    });
                },
                complete: function() {
                    $(".submitButton").prop("disabled", false);
                }
            })
        }
    });

    let selectedFiles = [];

    $('#imageInput').on('change', function() {
        const files = Array.from(this.files);
        const imagePreview = $('#imagePreview');
        $('#errorMessage').text('');

        files.forEach((file) => {
            if (!file.type.startsWith('image/')) {
                $('#errorMessage').text('Only image files are allowed.');
                return;
            }

            if (selectedFiles.find(f => f.name === file.name)) {
                $('#errorMessage').text('This image is already selected.');
                return;
            }

            selectedFiles.push(file);

            const reader = new FileReader();
            reader.onload = function(e) {
                const index = selectedFiles.length - 1;
                const imageHtml = `
                <div class="col-md-2 mb-3 position-relative" data-index="${index}">
                    <img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: auto;">
                    <button type="button" class="btn btn-danger btn-sm delete-image" style="position: absolute; top: 10px; right: 10px;" data-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>`;
                imagePreview.append(imageHtml);
            };
            reader.readAsDataURL(file);
        });

        this.value = '';
    });

    $('#imagePreview').on('click', '.delete-image', function() {
        const index = $(this).data('index');
        selectedFiles.splice(index, 1);
        $(this).parent().remove();

        $('#imagePreview .col-md-2').each(function(i) {
            $(this).attr('data-index', i);
            $(this).find('.delete-image').attr('data-index', i);
        });
    });



    let deletedImages = []; // This will store images to be removed from DB

    $('#imagePreview').on('click', '.delete-image', function () {
        const isConfirmed = confirm("Are you sure you want to delete this image?");
        if (!isConfirmed) {
            return; // If user cancels, do nothing.
        }

        const imageName = $(this).data('image');

        // Only add to deletedImages if it's an existing image (from DB)
        if (imageName) {
            deletedImages.push(imageName);

            // Optional: Add this to a hidden input for form submission
            $('<input>').attr({
                type: 'hidden',
                name: 'deleted_images[]',
                value: imageName
            }).appendTo('#imagePreview');
        }

        $(this).parent().remove();
    });


});
</script>

@endsection

<!--  -->