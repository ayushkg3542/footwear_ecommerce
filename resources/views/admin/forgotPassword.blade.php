<!doctype html>
<html lang="en" data-bs-theme="light">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | Bootstrap demo</title>
    <link rel="icon" href="{{url('public/admin/assets/images/favicon-32x32.png')}}" type="image/png">

    <!--plugins-->
    <link href="{{url('public/admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('public/admin/assets/plugins/metismenu/metisMenu.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/admin/assets/plugins/metismenu/mm-vertical.css')}}">
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
    <link href="{{url('public/admin/sass/responsive.css')}}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div class="section-authentication-cover">
        <div class="">
            <div class="row g-0">
                <div
                    class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end">
                    <img src="{{url('public/admin/assets/images/login.jpg')}}" class="img-fluid auth-img-cover-login"
                        style="height: 100%; object-fit: cover;" alt="">
                </div>

                <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                    <div class="card rounded-0 m-3 mb-0 border-0 shadow-none">
                        @include('admin.alert')
                        <div class="card-body p-sm-5">
                            <img src="{{url('public/admin/assets/images/logo1.png')}}" class="mb-4" width="145" alt="">
                            <h4 class="fw-bold">Forgot Password?</h4>
                            <p class="mb-0">Enter your registered email ID to reset the password</p>

                            <div class="form-body mt-4">
                                <form class="row g-3" action="{{route('processForgotPassword')}}" method="post">
                                    @csrf
                                    <div class="col-12">
                                        <label class="form-label">Email id</label>
                                        <input type="text" class="form-control" name="email" placeholder="example@user.com">
                                    </div>
                                    @error('email')
                                    <p class="invalidd-feedback text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="col-12">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Send</button>
                                            <a href="{{route('login')}}" class="btn btn-light">Back to Login</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!--end row-->
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bi-eye-slash-fill");
                $('#show_hide_password i').removeClass("bi-eye-fill");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                $('#show_hide_password i').addClass("bi-eye-fill");
            }
        });
    });
    </script>

</body>

</html>