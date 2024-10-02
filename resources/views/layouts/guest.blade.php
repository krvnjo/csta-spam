<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
  <body>
    <!-- JS Appearance -->
    <script src="{{ Vite::asset('resources/js/hs.theme-appearance.js') }}"></script>

    <!-- ========== Main Content ========== -->
    @yield('main-content')
    <!-- ========== End Main Content ========== -->

    <!-- ========== Secondary Content ========== -->
    @yield('sub-content')
    <!-- ========== End Secondary Content ========== -->

    <!-- JS Global Compulsory -->
    <script src="{{ Vite::asset('resources/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- JS Plugins -->
    @stack('scripts')
  </body>
</html>
