<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
    <script src="{{ Vite::asset('resources/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js') }}"></script>

    <!-- ========== Main Content ========== -->
    <main class="main" id="content">
      <!-- Content -->
      <div class="container">
        <a class="position-absolute top-0 start-0 end-0 py-4" data-route="dashboard.index" href="{{ route('dashboard.index') }}">
          <img class="avatar avatar-xl avatar-4x3 avatar-centered" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo.svg') }}" alt="Logo" style="width: 18rem">
          <img class="avatar avatar-xl avatar-4x3 avatar-centered" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo.svg') }}" alt="Logo" style="width: 18rem">
        </a>

        <div class="footer-height-offset d-flex justify-content-center align-items-center flex-column">
          <div class="row justify-content-center align-items-sm-center w-100">
            <div class="col-9 col-sm-6 col-lg-4">
              <div class="text-center text-sm-end me-sm-4 mb-5 mb-sm-0">
                <img class="img-fluid" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/illustrations/oc-thinking.svg') }}" alt="Image">
                <img class="img-fluid" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/illustrations-light/oc-thinking.svg') }}" alt="Image">
              </div>
            </div>
            <div class="col-sm-6 col-lg-4 text-center text-sm-start">
              <h1 class="display-1 mb-0">@yield('code')</h1>
              <p class="lead">@yield('message')</p>
              <a class="btn btn-white" href="javascript:window.history.back();"><i class="bi-arrow-left"></i> Back to Previous Page</a>
              <a class="btn btn-primary" href="{{ route('dashboard.index') }}"><i class="bi-house"></i> Back to Home</a>
            </div>
          </div>
        </div>
      </div>
      <!-- End Content -->

      <!-- Footer -->
      <div class="footer text-center">
        <ul class="list-inline list-separator">
          <li class="list-inline-item"><a class="list-separator-link" href="#">About Us</a></li>
          <li class="list-inline-item"><a class="list-separator-link" href="#">User Guide</a></li>
        </ul>
      </div>
      <!-- End Footer -->
    </main>
    <!-- ========== End Main Content ========== -->

    <!-- JS Global Compulsory -->
    <script src="{{ Vite::asset('resources/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- JS Themes -->
    <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

    <!-- JS Style Switcher -->
    <script src="{{ Vite::asset('resources/js/hs-style-switcher.js') }}"></script>
  </body>
</html>
