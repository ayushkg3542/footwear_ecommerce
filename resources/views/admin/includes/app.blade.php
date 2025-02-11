<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Metoxi | Bootstrap 5 Admin Dashboard Template</title>
    <!--favicon-->
    <link rel="icon" href="{{url('public/admin/assets/images/favicon-32x32.png')}}" type="image/png">

    <!--plugins-->
    <link href="{{url('public/admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('public/admin/assets/plugins/metismenu/metisMenu.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/admin/assets/plugins/metismenu/mm-vertical.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/admin/assets/plugins/simplebar/css/simplebar.css')}}">
    <link href="{{url('public/admin/assets/plugins/fancy-file-uploader/fancy_fileupload.css')}}" rel="stylesheet">

    <!--bootstrap css-->
    <link href="{{url('public/admin/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--main css-->
    <link href="{{url('public/admin/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
    <link href="{{url('public/admin/sass/main.css')}}" rel="stylesheet">
    <link href="{{url('public/admin/sass/dark-theme.css')}}" rel="stylesheet">
    <link href="{{url('public/admin/sass/semi-dark.css')}}" rel="stylesheet">
    <link href="{{url('public/admin/sass/bordered-theme.css')}}" rel="stylesheet">
    <link href="{{url('public/admin/sass/responsive.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="{{url('public/admin/assets/summernote/summernote.min.css')}}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">



</head>

<body>

    @include('admin.includes.header')
    @include('admin.includes.sidebar')
    @yield('content')
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation</h5>
                    <input type="hidden" id="delete_id_modal">
                    <input type="hidden" id="delete_type_modal"> <!-- Add this input for type -->
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

    @include('admin.includes.footer')
    <script>
    $(document).on('click', '.deletebtn', function(e) {
        e.preventDefault();
        var deleteid = $(this).data('id');
        var type = $(this).data('type'); // Set type based on entity (category, subcategory, brand, etc.)

        $("#delete_id_modal").val(deleteid);
        $("#delete_type_modal").val(type); // Set type in modal
        $("#deleteModal").modal('show');
    });

    $(document).on('click', '#deleteclosebtn', function(e) {
        e.preventDefault();
        $("#deleteModal").modal('hide');
    });

    $(document).on('click', '#confirmtodelete', function(e) {
        e.preventDefault();
        var confirmid = $("#delete_id_modal").val();
        var type = $("#delete_type_modal").val(); // Retrieve type from hidden input

        $.ajax({
            url: '{{route("deleteEntity")}}',
            type: 'POST',
            data: {
                confirmid: confirmid,
                type: type
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === "success") {
                    $("#deleteModal").modal('hide');
                    toastr.success(response.message, 'Success', {
                        timeOut: 500
                    });
                    window.location.reload();
                } else if (response.status === "fail") {
                    $("#deleteModal").modal('hide');
                    toastr.error(response.message, 'Failed', {
                        timeOut: 500
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                toastr.error('An error occurred while processing your request.', 'Error', {
                    timeOut: 500
                });
            }
        });
    });
    </script>

    @yield('customJS')



</body>


</html>