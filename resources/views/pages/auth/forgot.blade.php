@extends('layouts.guest')

@section('title')
  Forgot Password
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

        <!-- Forgot Password Card -->
        <div class="card card-lg p-1">
          <div class="card-body card-login-padding" id="cardForgotPassword">
            <form id="frmForgotPassword" method="POST" novalidate>
              @csrf
              <!-- Title -->
              <div class="pb-4 text-center">
                <h1 class="display-5">Request Password Reset</h1>
                <p>Enter the email address associated with your account and we'll send you a link to reset your password.</p>
              </div>
              <!-- End Title -->

              <!-- Email Address -->
              <div class="form-group mb-5">
                <label class="form-label" for="txtForgotEmail">Email Address</label>
                <input class="form-control" id="txtForgotEmail" name="email" type="email" placeholder="Enter your email address">
                <span class="invalid-feedback" id="valForgotEmail"></span>
              </div>
              <!-- End Email Address -->

              <!-- Forgot Password and Back to Login Button -->
              <div class="d-grid gap-2">
                <button class="btn btn-primary btn-lg" id="btnForgotPassword" form="frmForgotPassword" type="submit">
                  <span class="spinner-label">Send Request</span>
                  <span class="spinner-border spinner-border-sm d-none"></span>
                </button>
                <div class="text-center">
                  <a class="btn btn-link" href="{{ route('auth.login') }}"><i class="bi-chevron-left"></i> Back to log in</a>
                </div>
              </div>
              <!-- End Forgot Password and Back to Login Button -->
            </form>
          </div>
        </div>
        <!-- End Forgot Password Card -->

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
  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/auth/auth-user.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>
@endpush
