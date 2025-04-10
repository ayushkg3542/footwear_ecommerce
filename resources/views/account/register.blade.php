<!DOCTYPE html>
<html lang="zxx" class="no-js">


<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/fav.png">
    <meta name="author" content="CodePixar">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta charset="UTF-8">
    <title>Karma Shop - Login</title>

    <!--CSS ============================================= -->
    <link rel="stylesheet" href="{{url('public/front/css/linearicons.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{url('public/front/css/bootstrap.css')}}">
    <!-- <link rel="stylesheet" href="{{url('public/front/css/owl.carousel.css')}}"> -->
    <link rel="stylesheet" href="{{url('public/front/css/nice-select.css')}}">
    <!-- <link rel="stylesheet" href="{{url('public/front/css/nouislider.min.css')}}"> -->
    <link rel="stylesheet" href="{{url('public/front/css/main.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<style>
.login_box_img {
    height: 100% !important;
}

.login_box_img img {
    height: 100%;
}

.btn-filter img {
    width: 20px;
}

.separator {
    margin: 15px 0;
}

.separator .line {
    height: 1px;
    flex: 1;
    background-color: #dee2e6;
}

.google_link,
.facebook_link {
    padding: 8px 24px;
    width: 9rem;
    border-radius: 30px;
    border: 1px solid #dee2e6;
    box-shadow: 0px 0px 2px 0px;
}

.error {
    text-align: left !important;
    color: red;
}

#loader {
    position: absolute;
    z-index: 9999;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.7);
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

<body>

    <!-- Start Header Area -->
    @include('includes.header')
    <!-- End Header Area -->

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Login/Register</h1>
                    <nav class="d-flex align-items-center">
                        <a href="#">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Login/Register</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Login Box Area =================-->
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="{{ url('public/front/img/login.jpg') }}" alt="">
                        <div class="hover">
                            <h4>Already sign up to our website?</h4>
                            <p>There are advances being made in science and technology everyday, and a good example of
                                this is the</p>
                            <a class="primary-btn" href="{{ route('account.login') }}">Sign In</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner position-relative">
                        <h3>Login with Google</h3>
                        <a href="{{ route('google.login') }}" class="google_link"><img
                                src="{{ url('public/admin/assets/images/apps/05.png') }}" width="20"
                                alt="">&nbsp;&nbsp;Google</a>&nbsp;&nbsp;
                        <a href="{{ route('auth.facebook') }}" class="facebook_link"><img
                                src="{{ url('public/admin/assets/images/apps/17.png') }}" width="20"
                                alt="">&nbsp;&nbsp;Facebook</a>
                        <div class="separator section-padding d-flex justify-content-center align-items-center">
                            <div class="line" style="margin-right: 14px;"></div>
                            <p style="margin-bottom: 0px">OR</p>
                            <div class="line" style="margin-left: 14px;"></div>
                        </div>
                        <h3>Sign Up</h3>
                        <form class="row login_form" action="javascript:void(0)" method="post" id="signupForm"
                            novalidate="novalidate">
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Username"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone Number'">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="password" name="password"
                                    placeholder="Password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Password'">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="confirm_password" name="confirm_password"
                                    placeholder="Confirm Password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Confirm Password'">
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="creat_account">
                                    <input type="checkbox" id="f-option2" name="selector">
                                    <label for="f-option2">Keep me logged in</label>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="primary-btn">Sign Up</button>
                                <a href="#"></a>
                            </div>
                        </form>
                        <div id="loader" style="display:none;">
                            <div class="spinner-border text-warning" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->
    @include('includes.footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
    $(document).ready(function() {
        $("#signupForm").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    number: true,
                    maxlength: 10,
                    minlength:10,
                },
                password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                name: {
                    required: "Please enter your name"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                phone: {
                    required: "Please enter your phone number",
                    number: "Please enter a valid phone number",
                    maxlength: "Number cannot be more then 10 digit",
                    minlength: "Number must be 10 digit",
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 6 characters"
                },
                confirm_password: {
                    required: "Please enter your confirm password",
                    equalTo: "Passwords do not match"
                },
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                error.insertAfter(element);
                error.addClass("text-danger");
            },
            submitHandler: function(form) {
                $(".submitButton").prop("disabled", true);
                $("#loader").show();

                var formData = new FormData(form);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('account.processSignup')}}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#loader").hide();
                        $(".submitButton").prop("disabled", false);

                        if (response.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 3000,
                                showConfirmButton: true
                            }).then(() => {
                                window.location.href =
                                    "{{ route('account.login') }}";
                            });
                        } else {
                            toastr.error(response.message, 'Error', {
                                timeOut: 3000
                            });
                        }
                    },
                    error: function(xhr) {
                        $("#loader").hide(); // Hide loader
                        $(".submitButton").prop("disabled", false);
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
    </script>

</body>

</html>
<!--  -->