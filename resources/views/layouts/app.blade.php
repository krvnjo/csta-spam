<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="current-route" content="{{ Route::currentRouteName() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title') | {{ config('app.name') }} </title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Plugins -->
    @stack('styles')

    <!-- CSS Themes -->
    <link data-hs-appearance="default" href="{{ Vite::asset('resources/css/theme.min.css') }}" rel="stylesheet">
    <link data-hs-appearance="dark" href="{{ Vite::asset('resources/css/theme-dark.min.css') }}" rel="stylesheet">

    <!-- Vite Asset Bundling -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- JS Window Config -->
    <script src="{{ Vite::asset('resources/js/hs-window-config') }}"></script>
  </head>
  <body class="has-navbar-vertical-aside navbar-vertical-aside-show-xl footer-offset">
    <!-- JS Appearance -->
    <script src="{{ Vite::asset('resources/js/hs.theme-appearance.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js') }}"></script>

    <!-- ========== Header ========== -->
    @include('layouts.header')
    <!-- ========== End Header ========== -->

    <!-- ========== Sidebar ========== -->
    @include('layouts.sidebar')
    <!-- ========== End Sidebar ========== -->

    <!-- ========== Main Content ========== -->
    @yield('main-content')
    <!-- ========== End Main Content ========== -->

    <!-- ========== Footer ========== -->
    @include('layouts.footer')
    <!-- ========== End Footer ========== -->

    <!-- ========== Secondary Content ========== -->
    @yield('sec-content')
    <!-- ========== End Secondary Content ========== -->

    <!-- JS Global Compulsory -->
    <script src="{{ Vite::asset('resources/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/hs-form-search/dist/hs-form-search.min.js') }}"></script>

    <!-- JS Plugins -->
    @stack('scripts')

    <!-- JS Style Switcher -->
    <script src="{{ Vite::asset('resources/js/hs-style-switcher.js') }}"></script>
  </body>
</html>
