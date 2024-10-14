@extends('layouts.guest')

@section('title')
  Request Password Reset
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
            <form id="frmForgotUser" novalidate>
              @csrf
              <div class="pb-5 text-center">
                <h1 class="display-5">Request Password Reset</h1>
                <p>Enter your email address associated with your account and we'll send you instructions to reset your password.</p>
              </div>

              <div class="mb-4">
                <label class="form-label" for="txtForgotEmail">Email Address</label>
                <input class="form-control" id="txtForgotEmail" name="email" placeholder="Enter your email address">
                <span class="invalid-feedback" id="valForgotEmail"></span>
              </div>

              <div class="d-grid gap-2">
                <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                <div class="text-center">
                  <a class="btn btn-link" href="{{ route('auth.login') }}">
                    <i class="bi-chevron-left"></i> Back to log in
                  </a>
                </div>
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
      }
    })()
  </script>
@endpush
