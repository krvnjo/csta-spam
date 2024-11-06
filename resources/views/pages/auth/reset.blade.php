@extends('layouts.guest')

@section('title')
  Reset Password
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

    <!-- Reset Password Card -->
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
            <form id="frmResetPassword" method="POST" novalidate>
              @csrf
              <input name="token" type="hidden" value="{{ $token }}">

              <!-- Title -->
              <div class="pb-5 text-center">
                <h1 class="display-5">Reset your Password</h1>
                <p>Kindly enter your username and new password.</p>
              </div>
              <!-- End Title -->

              <!-- Username -->
              <div class="form-group mb-4">
                <label class="form-label" for="txtResetUser">Username</label>
                <input class="js-input-mask form-control" id="txtResetUser" name="user" data-hs-mask-options='{
                    "mask": "00-00000"
                  }' type="text"
                  placeholder="Enter your username">
                <span class="invalid-feedback" id="valResetUser"></span>
              </div>
              <!-- End Username -->

              <!-- Email Address -->
              <div class="form-group mb-4">
                <label class="form-label" for="txtResetEmail">Email Address</label>
                <input class="form-control" id="txtResetEmail" name="email" type="email" placeholder="Enter your email address">
                <span class="invalid-feedback" id="valResetEmail"></span>
              </div>
              <!-- End Email Address -->

              <!-- New Password -->
              <div class="form-group mb-4">
                <label class="form-label" for="txtResetPass">New Password</label>
                <div class="input-group">
                  <input class="js-toggle-password form-control" id="txtResetPass" name="pass"
                    data-hs-toggle-password-options='{
                      "target": [".toggle-pass-1", ".toggle-pass-2"],
                      "defaultClass": "bi-eye-slash",
                      "showClass": "bi-eye",
                      "classChangeTarget": "#togglePassIcon1"
                    }'
                    type="password" placeholder="Enter your new password" />
                  <a class="input-group-text toggle-pass-1"><i class="bi-eye" id="togglePassIcon1"></i></a>
                  <span class="invalid-feedback" id="valResetPass"></span>
                </div>
              </div>
              <!-- End New Password -->

              <!-- Confirm Password -->
              <div class="form-group mb-5">
                <label class="form-label" for="txtResetConfirm">Confirm Password</label>
                <div class="input-group">
                  <input class="js-toggle-password form-control" id="txtResetConfirm" name="confirm"
                    data-hs-toggle-password-options='{
                      "target": [".toggle-pass-1", ".toggle-pass-2"],
                      "defaultClass": "bi-eye-slash",
                      "showClass": "bi-eye",
                      "classChangeTarget": "#togglePassIcon2"
                    }'
                    type="password" placeholder="Confirm your password" />
                  <a class="input-group-text toggle-pass-2"><i class="bi-eye" id="togglePassIcon2"></i></a>
                  <span class="invalid-feedback" id="valResetConfirm"></span>
                </div>
              </div>
              <!-- End Confirm Password -->

              <!-- Reset Password Button -->
              <div class="d-grid">
                <button class="btn btn-primary btn-lg" id="btnResetPassword" type="submit">
                  <span class="spinner-label">Reset Password</span>
                  <span class="spinner-border spinner-border-sm d-none"></span>
                </button>
              </div>
              <!-- End Reset Password Button -->
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
