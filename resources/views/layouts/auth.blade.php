<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Sign In | Smart BM3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta
        content="Selamat datang di SmartBM3! Website ini merupakan produk dari SMK BM3 yang mencakup kebutuhan sistem pada sekolah"
        name="description" />
    <meta content="{{ env('APP_AUTHOR') }}" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ Storage::url('icon/favicon.png') }}">

    <!-- Layout config Js -->
    <script src="/vendor/manage/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/vendor/manage/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/vendor/manage/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/vendor/manage/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="/vendor/manage/assets/css/custom.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="/vendor/manage/index.html" class="d-inline-block auth-logo">
                                    <img src="/vendor/manage/assets/images/logo-light.png" alt=""
                                        height="20">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Managed by SMK BINA MANDIRI MULTIMEDIA</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                @yield('content')
            </div>
            <!-- end container -->

            <!-- footer -->
            <footer class="mt-3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <p class="mb-0 text-muted">
                                    &copy; {{ date('Y') }} SMK BINA MANDIRI MULTIMEDIA. Crafted with <i
                                        class="mdi mdi-heart text-danger"></i> by {{ env('APP_AUTHOR') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>
        <!-- end auth page content -->

    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="/vendor/manage/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/manage/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/vendor/manage/assets/js/plugins.js"></script>

    @include('component.alert')
</body>

</html>
