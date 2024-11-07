@extends('layouts.guest')

@section('title')
  Reset Password
@endsection

@push('styles')
  {{-- Styles --}}
@endpush

@section('main-content')
  <main class="main" id="content">
    <div class="position-fixed top-0 end-0 start-0 bg-img-start login-bg">
      <div class="shape shape-bottom zi-1">
        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1921 273">
          <polygon fill="#fff" points="0,273 1921,273 1921,0" />
        </svg>
      </div>
    </div>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
      <div class="row justify-content-center login-card w-100">
        <!-- CSTA - SPAM Logo -->
        <div class="d-flex justify-content-center mb-4">
          <img class="zi-2 login-logo" src="{{ Vite::asset('resources/svg/logos-light/logo-login.svg') }}" alt="CSTA - SPAM Logo">
        </div>
        <!-- End CSTA - SPAM Logo -->

        <!-- Reset Password Card -->
        <div class="card card-lg p-1">
          <div class="card-body card-login-padding">
            <form id="frmResetPassword" method="POST" novalidate>
              @csrf
              <input name="token" type="hidden" value="{{ $token }}">

              <!-- Title -->
              <div class="pb-4 text-center">
                <h1 class="display-5">Reset your Password</h1>
                <p>Please provide your username, email address, and your new password.</p>
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
                      "target": "#toggleResetPassTarget",
                      "defaultClass": "bi-eye-slash",
                      "showClass": "bi-eye",
                      "classChangeTarget": "#toggleResetPassIcon"
                    }'
                    type="password" placeholder="Enter your new password" />
                  <a class="input-group-text" id="toggleResetPassTarget"><i class="bi-eye" id="toggleResetPassIcon"></i></a>
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
                      "target": "#toggleResetConfirmTarget",
                      "defaultClass": "bi-eye-slash",
                      "showClass": "bi-eye",
                      "classChangeTarget": "#toggleResetConfirmIcon"
                    }'
                    type="password" placeholder="Confirm your new password" />
                  <a class="input-group-text" id="toggleResetConfirmTarget"><i class="bi-eye" id="toggleResetConfirmIcon"></i></a>
                  <span class="invalid-feedback" id="valResetConfirm"></span>
                </div>
              </div>
              <!-- End Confirm Password -->

              <!-- Reset Password Button -->
              <div class="d-grid">
                <button class="btn btn-primary btn-lg" id="btnResetPassword" form="frmResetPassword" type="submit">
                  <span class="spinner-label">Reset Password</span>
                  <span class="spinner-border spinner-border-sm d-none"></span>
                </button>
              </div>
              <!-- End Reset Password Button -->
            </form>
          </div>
        </div>
        <!-- End Reset Password Card -->

        <!-- Footer -->
        <div class="position-relative text-center my-4">
          <small class="text-cap text-body">&copy; CSTA - SPAM. 2024 | A capstone project developed by Achondo, Bunag, and Quimora</small>
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </main>
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/imask/dist/imask.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-toggle-password/dist/js/hs-toggle-password.js') }}"></script>

  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/auth/auth-user.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    $(document).ready(function() {
      // INITIALIZATION OF INPUT MASK
      // =======================================================
      HSCore.components.HSMask.init('.js-input-mask');

      // INITIALIZATION OF TOGGLE PASSWORD
      // =======================================================
      new HSTogglePassword('.js-toggle-password');
    });
  </script>
@endpush
