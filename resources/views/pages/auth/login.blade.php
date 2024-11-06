@extends('layouts.guest')

@section('title')
  Log In
@endsection

@push('styles')
  {{-- Styles --}}
@endpush

@section('main-content')
  <main class="main" id="content">
    <!-- Shape -->
    <div class="position-fixed top-0 end-0 start-0 bg-img-start login-bg">
      <div class="shape shape-bottom zi-1">
        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1921 273">
          <polygon fill="#fff" points="0,273 1921,273 1921,0" />
        </svg>
      </div>
    </div>
    <!-- End Shape -->

    <!-- Login Card -->
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
      <div class="row justify-content-center w-100" style="max-width: 30rem;">
        <!-- Logo -->
        <div class="d-flex justify-content-center mb-4">
          <img class="zi-2" src="{{ Vite::asset('resources/svg/logos-light/logo-login.svg') }}" alt="CSTA - SPAM Logo" style="width: 18rem;">
        </div>
        <!-- End Logo -->

        <!-- Card -->
        <div class="card card-lg p-1">
          <div class="card-body card-login-padding">
            <form id="frmLoginUser" method="POST" novalidate>
              @csrf
              <!-- Title -->
              <div class="pb-5 text-center">
                <h1 class="display-5">Welcome!</h1>
                <p>Kindly log in with your username and password.</p>
              </div>
              <!-- End Title -->

              <!-- Username -->
              <div class="form-group mb-4">
                <label class="form-label" for="txtLoginUser">Username</label>
                <input class="js-input-mask form-control" id="txtLoginUser" name="user" data-hs-mask-options='{
                    "mask": "00-00000"
                  }' type="text"
                  placeholder="Enter your username">
                <span class="invalid-feedback" id="valLoginUser"></span>
              </div>
              <!-- End Username -->

              <!-- Password -->
              <div class="form-group mb-5">
                <label class="form-label" for="txtLoginPass">Password</label>
                <div class="input-group">
                  <input class="js-toggle-password form-control" id="txtLoginPass" name="pass"
                    data-hs-toggle-password-options='{
                      "target": "#togglePassTarget",
                      "defaultClass": "bi-eye-slash",
                      "showClass": "bi-eye",
                      "classChangeTarget": "#togglePassIcon"
                    }'
                    type="password" placeholder="Enter your password" />
                  <a class="input-group-text" id="togglePassTarget"><i class="bi-eye" id="togglePassIcon"></i></a>
                  <span class="invalid-feedback" id="valLoginPass"></span>
                </div>
              </div>
              <!-- End Password -->

              <!-- Login and Forgot Password Button -->
              <div class="d-grid gap-2">
                <button class="btn btn-primary btn-lg" id="btnLoginUser" type="submit">
                  <span class="spinner-label">Log In</span>
                  <span class="spinner-border spinner-border-sm d-none"></span>
                </button>
                <div class="text-center">
                  <a class="btn btn-link" href="{{ route('password.request') }}">Forgot your password?</a>
                </div>
              </div>
              <!-- End Login and Forgot Password Button -->
            </form>
          </div>
        </div>
        <!-- End Card -->

        <!-- Footer -->
        <div class="position-relative text-center mt-4">
          <small class="text-cap text-body mb-4">&copy; CSTA - SPAM. 2024 | A capstone project developed by Achondo, Bunag, and Quimora</small>
        </div>
        <!-- End Footer -->
      </div>
    </div>
    <!-- End Login Card -->
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
