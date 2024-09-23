<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="current-route" content="{{ Route::currentRouteName() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }} </title>

    <!-- Vite Asset Bundling -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Theme -->
    <link data-hs-appearance="default" href="{{ Vite::asset('resources/css/theme.min.css') }}" rel="stylesheet">
    <link data-hs-appearance="dark" href="{{ Vite::asset('resources/css/theme-dark.min.css') }}" rel="stylesheet">

    <!-- JS Window Config -->
    <script src="{{ Vite::asset('resources/js/hs-window-config') }}"></script>
  </head>
  <body>
    <!-- JS Appearance -->
    <script src="{{ Vite::asset('resources/js/hs.theme-appearance.js') }}"></script>

    <!-- ========== Main Content ========== -->
    @yield('main-content')
    <!-- ========== End Main Content ========== -->

    <!-- JS Global Compulsory -->
    <script src="{{ Vite::asset('resources/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/hs-toggle-password/dist/js/hs-toggle-password.js') }}"></script>

    <!-- JS Themes -->
    <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

    <!-- JS Plugins Init. -->
    <script>
      // Initialization of Other Plugins
      (function() {
        window.onload = function() {
          // INITIALIZATION OF TOGGLE PASSWORD
          // =======================================================
          new HSTogglePassword('.js-toggle-password')
        }
      })()
    </script>
  </body>
</html>
