@extends('layouts.app')

@section('title')
  Profile & Account
@endsection

@push('styles')
  {{-- Styles --}}
@endpush

@section('main-content')
  <main class="main" id="content">
    <div class="content container-fluid">
      <div class="row justify-content-lg-center">
        <div class="col-lg-10">
          <!-- Profile Cover -->
          <div class="profile-cover cover-size">
            <div class="profile-cover-img-wrapper cover-resize">
              <img class="profile-cover-img cover-resize" src="{{ Vite::asset('resources/img/1920x400/img1.jpg') }}" alt="User Image">
              <div class="profile-cover-content profile-cover-uploader p-3">
                <button class="js-file-attach-reset-img profile-cover-uploader-label btn btn-sm btn-danger avatar-img-remove" id="btnRemoveAccountImage" type="button">
                  <i class="bi-trash-fill"></i>
                  <span class="d-none d-sm-inline-block ms-1">Remove Avatar</span>
                </button>
              </div>
            </div>
          </div>
          <!-- End Profile Cover -->

          <!-- Profile Header -->
          <div class="text-center mb-2">
            <!-- Form -->
            <form id="frmAccountImage" method="POST" enctype="multipart/form-data" novalidate>
              @csrf
              @method('PATCH')
              <input id="txtAccountId" name="id" type="hidden" value="{{ Crypt::encryptString(Auth::user()->id) }}">
              <input id="txtAccountUsername" name="user" type="hidden" value="{{ Auth::user()->user_name }}">

              <!-- User Image -->
              <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar" for="imgAccountImage">
                <img class="avatar-img" id="imgDisplayAccountImage" src="{{ asset('storage/img/user-images/' . Auth::user()->user_image) }}" alt="User Image">

                <input class="js-file-attach avatar-uploader-input" id="imgAccountImage" name="image"
                  data-hs-file-attach-options='{
                     "textTarget": "#imgDisplayAccountImage",
                     "mode": "image",
                     "targetAttr": "src",
                     "resetTarget": "#btnRemoveAccountImage",
                     "resetImg": "{{ asset('storage/img/user-images/default.jpg') }}",
                     "allowTypes": [".png", ".jpeg", ".jpg"]
                  }'
                  type="file" accept=".jpg, .png, .jpeg">

                <span class="avatar-uploader-trigger">
                  <i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i>
                </span>
              </label>
              <!-- End User Image -->
            </form>
            <!-- End Form -->

            <h1 class="page-header-title">{{ Auth::user()->fname . ' ' . Auth::user()->lname }}</h1>
            <ul class="list-inline list-px-2">
              <li class="list-inline-item">
                <i class="bi-briefcase me-1"></i>
                <span>{{ Auth::user()->role->name }}</span>
              </li>

              <li class="list-inline-item">
                <i class="bi-calendar-week me-1"></i>
                <span>Created {{ Auth::user()->created_at->format('F Y') }}</span>
              </li>
            </ul>
          </div>
          <!-- End Profile Header -->

          <div class="row pt-5">
            <div class="col-lg-4">
              <!-- Profile Card -->
              <div class="card mb-3 mb-lg-5">
                <div class="card-header card-header-content-between">
                  <h4 class="card-header-title">Profile</h4>
                </div>

                <div class="card-body">
                  <ul class="list-unstyled list-py-2 text-dark mb-0">
                    <li class="pb-0"><span class="card-subtitle">About</span></li>
                    <li><i class="bi-person-vcard dropdown-item-icon"></i> {{ Auth::user()->user_name }}</li>
                    <li><i class="bi-person dropdown-item-icon"></i> {{ Auth::user()->fname . ' ' . Auth::user()->lname }}</li>
                    <li><i class="bi-briefcase dropdown-item-icon"></i> {{ Auth::user()->role->name }}</li>
                    <li><i class="bi-building dropdown-item-icon"></i> {{ Auth::user()->department->name }}</li>

                    <li class="pt-4 pb-0"><span class="card-subtitle">Contacts</span></li>
                    <li><i class="bi-at dropdown-item-icon"></i> {{ Auth::user()->email }}</li>
                    <li><i class="bi-phone dropdown-item-icon"></i> {{ Auth::user()->phone_num }}</li>
                  </ul>
                </div>
              </div>
              <!-- End Profile Card -->
            </div>

            <div class="col-lg-8">
              <!-- Basic Information Card -->
              <div class="card mb-3 mb-lg-5">
                <div class="card-header card-header-content-between">
                  <h4 class="card-header-title">Basic Information</h4>
                </div>

                <div class="card-body">
                  <!-- Form -->
                  <form id="frmAccountBasicInfo" method="POST" novalidate>
                    <!-- Full Name -->
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label form-label" for="txtAccountFname">Full name</label>
                      <div class="col-sm-9">
                        <div class="input-group input-group-sm-vertical">
                          <input class="form-control" id="txtAccountFname" type="text" value="{{ Auth::user()->fname }}" readonly>
                          <input class="form-control" id="txtAccountMname" type="text" value="{{ Auth::user()->mname }}" readonly>
                          <input class="form-control" id="txtAccountLname" type="text" value="{{ Auth::user()->lname }}" readonly>
                        </div>
                      </div>
                    </div>
                    <!-- End Full Name -->

                    <!-- Email -->
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label form-label" for="txtAccountEmail">Email</label>
                      <div class="col-sm-9">
                        <input class="form-control" id="txtAccountEmail" name="email" type="email" value="{{ Auth::user()->email }}" placeholder="Enter your email address">
                        <span class="invalid-feedback" id="valAccountEmail"></span>
                      </div>
                    </div>
                    <!-- End Email -->

                    <!-- Phone -->
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label form-label" for="txtAccountPhone">Phone </label>
                      <div class="col-sm-9">
                        <input class="js-input-mask form-control" id="txtAccountPhone" name="phone"
                          data-hs-mask-options='{
                          "mask": "0900-000-0000"
                        }' type="text" value="{{ Auth::user()->phone_num }}"
                          placeholder="Enter your phone number">
                        <span class="invalid-feedback" id="valAccountPhone"></span>
                      </div>
                    </div>
                    <!-- End Phone -->

                    <div class="d-flex justify-content-end">
                      <button class="btn btn-primary" id="btnAccountSave" type="submit">
                        <span class="spinner-label">Save Changes</span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                      </button>
                    </div>
                  </form>
                  <!-- End Form -->
                </div>
              </div>
              <!-- End Basic Information Card -->

              <!-- Change Password Card -->
              <div class="card mb-3 mb-lg-5">
                <div class="card-header card-header-content-between">
                  <h4 class="card-header-title">Change your password</h4>
                </div>

                <div class="card-body">
                  <form id="frmAccountPass" method="POST" novalidate>
                    @csrf
                    @method('PATCH')
                    <input name="id" type="hidden" value="{{ Crypt::encryptString(Auth::user()->id) }}">

                    <!-- Current Password -->
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label form-label" for="txtAccountCurrent">Current Password</label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input class="js-toggle-password form-control" id="txtAccountCurrent" name="current"
                            data-hs-toggle-password-options='{
                             "target": "#toggleAccountCurrentTarget",
                             "defaultClass": "bi-eye-slash",
                             "showClass": "bi-eye",
                             "classChangeTarget": "#toggleAccountCurrentIcon"
                           }'
                            type="password" placeholder="Enter your current password" />
                          <a class="input-group-text" id="toggleAccountCurrentTarget"><i class="bi-eye" id="toggleAccountCurrentIcon"></i></a>
                          <span class="invalid-feedback" id="valAccountCurrent"></span>
                        </div>
                      </div>
                    </div>
                    <!-- End Current Password -->

                    <!-- New Password -->
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label form-label" for="txtAccountNew">New Password</label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input class="js-toggle-password form-control" id="txtAccountNew" name="new"
                            data-hs-toggle-password-options='{
                             "target": "#toggleAccountNewTarget",
                             "defaultClass": "bi-eye-slash",
                             "showClass": "bi-eye",
                             "classChangeTarget": "#toggleAccountNewIcon"
                           }'
                            type="password" placeholder="Enter your new password" />
                          <a class="input-group-text" id="toggleAccountNewTarget"><i class="bi-eye" id="toggleAccountNewIcon"></i></a>
                          <span class="invalid-feedback" id="valAccountNew"></span>
                        </div>
                      </div>
                    </div>
                    <!-- End New Password -->

                    <!-- Confirm Password -->
                    <div class="row mb-4">
                      <label class="col-sm-3 col-form-label form-label" for="txtAccountConfirm">Confirm New Password</label>
                      <div class="col-sm-9">
                        <div class="mb-4">
                          <div class="input-group">
                            <input class="js-toggle-password form-control" id="txtAccountConfirm" name="confirm"
                              data-hs-toggle-password-options='{
                              "target": "#toggleAccountConfirmTarget",
                              "defaultClass": "bi-eye-slash",
                              "showClass": "bi-eye",
                              "classChangeTarget": "#toggleAccountConfirmIcon"
                            }'
                              type="password" placeholder="Confirm your new password" />
                            <a class="input-group-text" id="toggleAccountConfirmTarget"><i class="bi-eye" id="toggleAccountConfirmIcon"></i></a>
                            <span class="invalid-feedback" id="valAccountConfirm"></span>
                          </div>
                        </div>

                        <h5>Password requirements:</h5>
                        <p class="fs-6 mb-2">Ensure that these requirements are met:</p>
                        <ul class="fs-6">
                          <li>Minimum 8 characters long - Maximum of 20 characters</li>
                          <li>At least one lowercase character</li>
                          <li>At least one uppercase character</li>
                          <li>At least one number and one symbol</li>
                        </ul>
                      </div>
                    </div>
                    <!-- End Confirm Password -->

                    <div class="d-flex justify-content-end">
                      <button class="btn btn-primary" id="btnAccountSavePass" form="frmAccountPass" type="submit">
                        <span class="spinner-label">Save Changes</span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- End Change Password Card -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection

@section('sec-content')
  {{-- Sub Content --}}
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/hs-file-attach/dist/hs-file-attach.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/imask/dist/imask.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-toggle-password/dist/js/hs-toggle-password.js') }}"></script>

  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/other/account.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    // Initialization of Other Plugins
    (function() {
      window.onload = function() {
        // INITIALIZATION OF NAVBAR VERTICAL ASIDE
        // =======================================================
        new HSSideNav('.js-navbar-vertical-aside').init();


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        new HSFormSearch('.js-form-search');


        // INITIALIZATION OF BOOTSTRAP DROPDOWN
        // =======================================================
        HSBsDropdown.init()


        // INITIALIZATION OF FILE ATTACHMENT
        // =======================================================
        new HSFileAttach(".js-file-attach");


        // INITIALIZATION OF INPUT MASK
        // =======================================================
        HSCore.components.HSMask.init(".js-input-mask");


        // INITIALIZATION OF TOGGLE PASSWORD
        // =======================================================
        new HSTogglePassword(".js-toggle-password");
      }
    })()
  </script>
@endpush
