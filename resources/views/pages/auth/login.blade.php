@extends('layouts.guest')

@section('title')
  Log In
@endsection

@push('styles')
  {{-- Styles --}}
@endpush

@section('main-content')
  <main class="main" id="content" role="main">
    <div class="position-fixed top-0 end-0 start-0 bg-img-start login-bg">
      <div class="shape shape-bottom zi-1">
        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1921 273">
          <polygon fill="#fff" points="0,273 1921,273 1921,0 " />
        </svg>
      </div>
    </div>

    <!-- Content -->
    <div class="container d-flex justify-content-center align-items-center" style="height: 90vh;">
      <div class="row justify-content-center w-100 mx-2" style="max-width: 30rem;">
        <!-- Logo -->
        <div class="d-flex justify-content-center mb-5">
          <img class="zi-2" src="{{ Vite::asset('resources/svg/logos-light/logo-login.svg') }}" alt="CSTA - SPAM Logo" style="width: 18rem;">
        </div>
        <!-- Logo -->

        <!-- Card -->
        <div class="card card-lg mb-5">
          <div class="card-body">
            <form id="frmLoginUser" novalidate>
              @csrf
              <div class="pb-5 text-center">
                <h1 class="display-5">Welcome!</h1>
                <p>Kindly log in with your username and password.</p>
              </div>

              <div class="mb-4">
                <label class="form-label" for="txtLoginUsername">Username</label>
                <input class="js-input-mask form-control" id="txtLoginUsername" name="user"
                  data-hs-mask-options='{
                    "mask": "00-00000"
                  }' type="text" tabindex="1"
                  placeholder="Enter your username">
                <span class="invalid-feedback" id="valLoginUsername"></span>
              </div>

              <div class="mb-6">
                <label class="form-label w-100" for="txtLoginPassword">
                  <span class="d-flex justify-content-between align-items-center">
                    <span>Password</span>
                    <a class="form-label-link mb-0" href="{{ route('auth.forgot') }}">Forgot Password?</a>
                  </span>
                </label>
                <div class="input-group">
                  <input class="js-toggle-password form-control form-control-lg" id="txtLoginPassword" name="pass"
                    data-hs-toggle-password-options='{
                      "target": "#togglePassTarget",
                      "defaultClass": "bi-eye-slash",
                      "showClass": "bi-eye",
                      "classChangeTarget": "#togglePassIcon"
                    }'
                    type="password" tabindex="2" placeholder="Enter your Password" />
                  <a class="input-group-text" id="togglePassTarget"><i class="bi-eye" id="togglePassIcon"></i></a>
                  <span class="invalid-feedback" id="valLoginPassword"></span>
                </div>
              </div>

              <div class="d-grid">
                <button class="btn btn-primary btn-lg" type="submit" tabindex="3">Log In</button>
              </div>
            </form>
          </div>
        </div>
        <!-- End Card -->

        <!-- Footer -->
        <div class="position-relative zi-1 text-center">
          <small class="text-cap text-body mb-4">@ CSTA - SPAM. 2024 | Developed by Achondo, Bunag, and Quimora</small>
        </div>
        <!-- End Footer -->
      </div>
    </div>
    <!-- End Content -->
  </main>
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/imask/dist/imask.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-toggle-password/dist/js/hs-toggle-password.js') }}"></script>

  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/auth/auth-user.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Init. -->
  <script>
    // Initialization of Other Plugins
    (function() {
      window.onload = function() {
        // INITIALIZATION OF INPUT MASK
        // =======================================================
        HSCore.components.HSMask.init('.js-input-mask');


        // INITIALIZATION OF TOGGLE PASSWORD
        // =======================================================
        new HSTogglePassword('.js-toggle-password')
      }
    })()
  </script>
@endpush
