<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>

    <!-- Vite Asset Bundling -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Plugins -->
    @yield('styles')

    <!-- CSS Theme -->
    <link data-hs-appearance="default" href="{{ Vite::asset('resources/css/theme.min.css') }}" rel="stylesheet">
    <link data-hs-appearance="dark" href="{{ Vite::asset('resources/css/theme-dark.min.css') }}" rel="stylesheet">

    <!-- JS Window Config and Appearance -->
    <script src="{{ Vite::asset('resources/js/hs-window-config') }}"></script>
  </head>
  <body class="has-navbar-vertical-aside navbar-vertical-aside-show-xl footer-offset">
    <!-- JS Appearance -->
    <script src="{{ Vite::asset('resources/js/hs.theme-appearance.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js') }}"></script>

    <!-- ========== Header ========== -->
    @yield('header')
    <!-- ========== End Header ========== -->

    <!-- ========== Sidebar ========== -->
    @yield('sidebar')
    <!-- ========== End Sidebar ========== -->

    <!-- ========== Main Content ========== -->
    @yield('main-content')
    <!-- ========== End Main Content ========== -->

    <!-- ========== Footer ========== -->
    @yield('footer')
    <!-- ========== End Footer ========== -->

    <!-- ========== Secondary Content ========== -->
    @yield('sub-content')
    <!-- ========== End Secondary Content ========== -->

    <!-- JS Global Compulsory -->
    <script src="{{ Vite::asset('resources/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/hs-form-search/dist/hs-form-search.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js') }}"></script>

    <!-- JS Plugins -->
    @yield('scripts')

    <!-- JS Style Switcher -->
    <script src="{{ Vite::asset('resources/js/hs-style-switcher.js') }}"></script>
  </body>
</html>
