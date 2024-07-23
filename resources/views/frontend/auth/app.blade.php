<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk | e-LAPKIN</title>
    @if (env('APP_ENV') == 'production')
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <link rel="shortcut icon" href="https://tekad.kemendesa.go.id/e-lapkin/images/logotekad.png" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ global_asset('vendors/') }}/fontawesome/css/all.min.css">
    <!-- Line Awesome -->
    <link rel="stylesheet" href="{{ global_asset('vendors/') }}/lineawesome/css/line-awesome.min.css">
    <!--  Bootstrap 5 -->
    <link rel="stylesheet" href="{{ global_asset('vendors/') }}/bootstrap/css/bootstrap.min.css">
    {{--  iziToast  --}}
    <!-- Swwet alert -->
    <link rel="stylesheet" href="{{ global_asset('vendors/') }}/sweet-alert/css/sweet-alert.min.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ global_asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ global_asset('backend/css/c-ui.css') }}">
    @yield('style')
</head>

<body class="default-theme" style="background: #4a6c33;">
    <!-- main content start -->
    <main class="auth-page">
        <section class="auth-container">
            <div
                class="form-wrapper pv-80 ph-100 bg-white d-flex justify-content-center align-items-center flex-column">
                <div class="form-container d-flex justify-content-center align-items-start flex-column">
                    <div class="form-logo mb-40">
                        @include('frontend.partials.dark_logo')
                    </div>
                    @yield('content')
                </div>
            </div>
        </section>
    </main>
    <!-- main content end -->
    <!-- vendors js  -->
    <script src="{{ global_asset('vendors/') }}/sweet-alert/js/sweetalert2@11.min.js"></script>
    @yield('script')
</body>
