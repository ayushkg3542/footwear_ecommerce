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
    <!--bootstrap css-->
    <link href="{{url('public/admin/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="{{url('public/admin/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
    <link href="{{url('public/admin/sass/main.css')}}" rel="stylesheet">
    <link href="{{url('public/admin/sass/dark-theme.css')}}" rel="stylesheet">
    <link href="{{url('public/admin/sass/semi-dark.css')}}" rel="stylesheet">
    <link href="{{url('public/admin/sass/bordered-theme.css')}}" rel="stylesheet">
    <link href="{{url('public/admin/sass/responsive.css')}}" rel="stylesheet">

</head>

<body>

@include('admin.includes.header')
@include('admin.includes.sidebar')
@yield('content')
@include('admin.includes.footer')

@yield('customJS')


</body>


</html>