@extends('layouts.guest')

@section('title')
  Change Expired Password
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

        <!-- Change Password Card -->
        <div class="card card-lg p-1">
          <div class="card-body card-login-padding">
            <form id="frmChangePassword" method="POST" novalidate>
              @csrf
              <input name="token" type="hidden" value="{{ $token }}">

              <!-- Title -->
              <div class="pb-4 text-center">
                <h1 class="display-5">Change Expired Password</h1>
                <p>Your password has expired. Please create a new one to continue accessing your account.</p>
              </div>
              <!-- End Title -->

              <!-- Username -->
              <div class="form-group mb-4">
                <label class="form-label" for="txtChangeUser">Username</label>
                <input class="js-input-mask form-control" id="txtChangeUser" name="user" data-hs-mask-options='{
                    "mask": "00-00000"
                  }' type="text"
                  placeholder="Enter your username">
                <span class="invalid-feedback" id="valChangeUser"></span>
              </div>
              <!-- End Username -->

              <!-- Current Password -->
              <div class="form-group mb-4">
                <label class="form-label" for="txtChangeCurrent">Current Password</label>
                <div class="input-group">
                  <input class="js-toggle-password form-control" id="txtChangeCurrent" name="current"
                    data-hs-toggle-password-options='{
                      "target": "#toggleChangeCurrentTarget",
                      "defaultClass": "bi-eye-slash",
                      "showClass": "bi-eye",
                      "classChangeTarget": "#toggleChangeCurrentIcon"
                    }'
                    type="password" placeholder="Enter your current password" />
                  <a class="input-group-text" id="toggleChangeCurrentTarget"><i class="bi-eye" id="toggleChangeCurrentIcon"></i></a>
                  <span class="invalid-feedback" id="valChangeCurrent"></span>
                </div>
              </div>
              <!-- End Current Password -->

              <!-- New Password -->
              <div class="form-group mb-4">
                <label class="form-label" for="txtChangeNew">New Password</label>
                <div class="input-group">
                  <input class="js-toggle-password form-control" id="txtChangeNew" name="new"
                    data-hs-toggle-password-options='{
                      "target": "#toggleChangeNewTarget",
                      "defaultClass": "bi-eye-slash",
                      "showClass": "bi-eye",
                      "classChangeTarget": "#toggleChangeNewIcon"
                    }'
                    type="password" placeholder="Enter your new password" />
                  <a class="input-group-text" id="toggleChangeNewTarget"><i class="bi-eye" id="toggleChangeNewIcon"></i></a>
                  <span class="invalid-feedback" id="valChangeNew"></span>
                </div>
              </div>
              <!-- End New Password -->

              <!-- Confirm Password -->
              <div class="form-group mb-5">
                <label class="form-label" for="txtChangeConfirm">Confirm Password</label>
                <div class="input-group">
                  <input class="js-toggle-password form-control" id="txtChangeConfirm" name="confirm"
                    data-hs-toggle-password-options='{
                      "target": "#toggleChangeConfirmTarget",
                      "defaultClass": "bi-eye-slash",
                      "showClass": "bi-eye",
                      "classChangeTarget": "#toggleChangeConfirmIcon"
                    }'
                    type="password" placeholder="Confirm your new password" />
                  <a class="input-group-text" id="toggleChangeConfirmTarget"><i class="bi-eye" id="toggleChangeConfirmIcon"></i></a>
                  <span class="invalid-feedback" id="valChangeConfirm"></span>
                </div>
              </div>
              <!-- End Confirm Password -->

              <!-- Change Password Button -->
              <div class="d-grid">
                <button class="btn btn-primary btn-lg" id="btnChangePassword" form="frmChangePassword" type="submit">
                  <span class="spinner-label">Change Password</span>
                  <span class="spinner-border spinner-border-sm d-none"></span>
                </button>
              </div>
              <!-- End Change Password Button -->
            </form>
          </div>
        </div>
        <!-- End Change Password Card -->

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
