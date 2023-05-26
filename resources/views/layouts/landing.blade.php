<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>PPDB | SMK BINA MANDIRI MULTIMEDIA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="SMK BINA MANDIRI MULTIMEDIA" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ Storage::url('icon/favicon.png') }}">

    <!--Swiper slider css-->
    <link href="/vendor/manage/assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="/vendor/manage/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/vendor/manage/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/vendor/manage/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/vendor/manage/assets/css/landing.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="/vendor/manage/assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">

    <!-- Begin page -->
    <div class="layout-wrapper landing">
        @yield('content')
    </div>
    <!-- end layout wrapper -->


    <!-- JAVASCRIPT -->
    <script src="/vendor/manage/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/manage/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/vendor/manage/assets/libs/node-waves/waves.min.js"></script>
    <script src="/vendor/manage/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/vendor/manage/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/vendor/manage/assets/js/plugins.js"></script>

    <!--Swiper slider js-->
    <script src="/vendor/manage/assets/libs/swiper/swiper-bundle.min.js"></script>

    <script src="/vendor/manage/assets/js/pages/landing.init.js"></script>
</body>

</html>
