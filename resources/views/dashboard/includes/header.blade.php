<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>mypos</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">
    <!-- product style -->
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    <!-- vue.js -->
    <script src="{{ asset('assets/js/vue.global.js') }}"></script>
</head>

<body class="hold-transition sidebar-mini">

    @include('sweetalert::alert')

    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">{{ __('site.dashboard') }}</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">{{ __('site.contact') }}</a>
                </li>

                <!-- Select Language Dropdown -->
                <li>
                    <div class="mt-2 ml-3" style="position: relative; display: inline-block;">
                        <i id="language-icon" class="fa fa-globe" style="font-size: 24px; cursor: pointer;"></i>
                        <ul id="language-dropdown"
                            style="display: none; position: absolute; background-color: white; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; list-style: none; padding: 0; margin: 0;">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li style="padding: 12px 16px;">
                                <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                    style="text-decoration: none; color: black; display: block;">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- end select language -->
                </li>
                <!-- End Select Language Dropdown -->

            </ul>
        </nav>
        <!-- /.navbar -->