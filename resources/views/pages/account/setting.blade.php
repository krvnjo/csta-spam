@extends('layouts.app')

@section('title')
  Account Settings
@endsection

@section('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endsection

@section('header')
  @include('layouts.header')
@endsection

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('main-content')
  <main class="main" id="content" role="main">
    <!-- Content -->
    <div class="content container-fluid">
      <!-- Page Header -->
      <div class="page-header">
        <div class="row align-items-end">
          <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-no-gutter">
                <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Account Settings</li>
              </ol>
            </nav>
            <h1 class="page-header-title mt-2">Settings</h1>
          </div>
        </div>
      </div>
      <!-- End Page Header -->

      <div class="row">
        <div class="col-lg-3">
          <!-- Navbar -->
          <div class="navbar-expand-lg navbar-vertical mb-3 mb-lg-5">
            <!-- Navbar Toggle -->
            <div class="d-grid">
              <button class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse" data-bs-target="#navbarVerticalNavMenu" type="button"
                aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu">
                <span class="d-flex justify-content-between align-items-center">
                  <span class="text-dark">Menu</span>

                  <span class="navbar-toggler-default">
                    <i class="bi-list"></i>
                  </span>

                  <span class="navbar-toggler-toggled">
                    <i class="bi-x"></i>
                  </span>
                </span>
              </button>
            </div>
            <!-- End Navbar Toggle -->

            <!-- Navbar Collapse -->
            <div class="collapse navbar-collapse" id="navbarVerticalNavMenu">
              <ul class="js-sticky-block js-scrollspy card card-navbar-nav nav nav-tabs nav-lg nav-vertical" id="navbarSettings"
                data-hs-sticky-block-options='{
                  "parentSelector": "#navbarVerticalNavMenu",
                  "targetSelector": "#header",
                  "breakpoint": "lg",
                  "startPoint": "#navbarVerticalNavMenu",
                  "endPoint": "#stickyBlockEndPoint",
                  "stickyOffsetTop": 20
                }'>
                <li class="nav-item">
                  <a class="nav-link active" href="#basicInformationSection">
                    <i class="bi-person nav-icon"></i> Basic information
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#changePasswordSection">
                    <i class="bi-key nav-icon"></i> Password
                  </a>
                </li>
              </ul>
            </div>
            <!-- End Navbar Collapse -->
          </div>
          <!-- End Navbar -->
        </div>

        <div class="col-lg-9">
          <div class="d-grid gap-3 gap-lg-5">
            <!-- Basic Information Card -->
            <div class="card" id="basicInformationSection">
              <!-- Profile Cover -->
              <div class="profile-cover" style="height: 8rem;">
                <div class="profile-cover-img-wrapper" style="height: 6.5rem;">
                  <img class="profile-cover-img" id="profileCoverImg" src="{{ Vite::asset('resources/img/1920x400/img1.jpg') }}" alt="Image Description"
                    style="height: 6.5rem;">
                  <div class="profile-cover-content profile-cover-uploader p-3">
                    <button class="js-file-attach-reset-img btn btn-sm btn-danger" id="btnRemoveUserImage" type="button">
                      <i class="bi-trash-fill"></i> Remove Avatar
                    </button>
                  </div>
                </div>
              </div>
              <!-- End Profile Cover -->

              <!-- Form -->
              <form id="frmAccountBasicInfo" method="post" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PATCH')
                <!-- User Image -->
                <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar mb-5" for="imgAddImage">
                  <img class="avatar-img" id="imgDisplayUserImage"
                    src="{{ Vite::asset('resources/img/uploads/user-images/' . Auth::user()->user_image) }}" alt="Image Description">
                  <input class="js-file-attach avatar-uploader-input" id="imgAddImage" name="image"
                    data-hs-file-attach-options='{
                       "textTarget": "#imgDisplayUserImage",
                       "mode": "image",
                       "targetAttr": "src",
                       "resetTarget": "#btnRemoveUserImage",
                       "resetImg": "{{ Vite::asset('resources/img/uploads/user-images/default.jpg') }}",
                       "allowTypes": [".png", ".jpeg", ".jpg"]
                    }'
                    type="file" accept=".jpg, .png, .jpeg">
                  <span class="avatar-uploader-trigger">
                    <i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i>
                  </span>
                </label>
                <!-- End User Image -->

                <!-- Body -->
                <div class="card-body">
                  <!-- Username -->
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="txtAccountUsername">Username</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="txtAccountUsername" type="text" value="{{ Auth::user()->user_name }}" readonly>
                    </div>
                  </div>
                  <!-- End Username -->

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

                  <!-- Role -->
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="txtAccountRole">Role</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="txtAccountRole" type="text" value="{{ Auth::user()->role->name }}" readonly>
                    </div>
                  </div>
                  <!-- End Role -->

                  <!-- Department -->
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="txtAccountDept">Department</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="txtAccountDept" type="text" value="{{ Auth::user()->department->name }}" readonly>
                    </div>
                  </div>
                  <!-- End Department -->

                  <!-- Email -->
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="txtAccountEmail">Email</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="txtAccountEmail" name="email" type="email" value="{{ Auth::user()->email }}"
                        placeholder="sample@site.com">
                      <span class="invalid-feedback" id="valAccountEmail"></span>
                    </div>
                  </div>
                  <!-- End Email -->

                  <!-- Phone -->
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="txtAccountPhone">Phone</label>
                    <div class="col-sm-9">
                      <input class="js-input-mask form-control" id="txtAccountPhone" name="phone"
                        data-hs-mask-options='{
                          "mask": "0900-000-0000"
                        }' type="text"
                        value="{{ Auth::user()->phone_num }}" placeholder="####-###-####">
                      <span class="invalid-feedback" id="valAccountPhone"></span>
                    </div>
                  </div>
                  <!-- End Phone -->

                  <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Save changes</button>
                  </div>
                </div>
                <!-- End Body -->
              </form>
              <!-- End Form -->
            </div>
            <!-- End Basic Information Card -->

            <!-- Change Password Card -->
            <div class="card" id="changePasswordSection">
              <div class="card-header">
                <h4 class="card-title">Change your password</h4>
              </div>

              <!-- Body -->
              <div class="card-body">
                <!-- Form -->
                <form id="frmAccountChangePass" method="post" novalidate>
                  @csrf
                  @method('PATCH')
                  <!-- Current Password -->
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="txtAccountCurrentPass">Current password</label>
                    <div class="col-sm-9">
                      <div class="input-group">
                        <input class="js-toggle-password form-control" id="txtAccountCurrentPass" name="current"
                          data-hs-toggle-password-options='{
                             "target": "#toggleCurrentPassTarget",
                             "defaultClass": "bi-eye-slash",
                             "showClass": "bi-eye",
                             "classChangeTarget": "#toggleCurrentPassIcon"
                           }'
                          type="password" placeholder="Enter your current password" />
                        <a class="input-group-text" id="toggleCurrentPassTarget"><i class="bi-eye" id="toggleCurrentPassIcon"></i></a>
                        <span class="invalid-feedback" id="valAccountCurrentPass"></span>
                      </div>
                    </div>
                  </div>
                  <!-- End Current Password -->

                  <!-- New Password -->
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="txtAccountNewPass">New password</label>
                    <div class="col-sm-9">
                      <div class="input-group">
                        <input class="js-toggle-password form-control" id="txtAccountNewPass" name="new"
                          data-hs-toggle-password-options='{
                             "target": [".toggleNewPassTarget", ".toggleConfirmPassTarget"],
                             "defaultClass": "bi-eye-slash",
                             "showClass": "bi-eye",
                             "classChangeTarget": "#toggleNewPassIcon"
                           }'
                          type="password" placeholder="Enter your new password" />
                        <a class="input-group-text toggleNewPassTarget"><i class="bi-eye" id="toggleNewPassIcon"></i></a>
                        <span class="invalid-feedback" id="valAccountNewPass"></span>
                      </div>
                    </div>
                  </div>
                  <!-- End New Password -->

                  <!-- Confirm Password -->
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="txtAccountConfirmPass">Confirm new password</label>
                    <div class="col-sm-9">
                      <div class="mb-4">
                        <div class="input-group">
                          <input class="js-toggle-password form-control" id="txtAccountConfirmPass" name="confirm"
                            data-hs-toggle-password-options='{
                              "target": [".toggleNewPassTarget", ".toggleConfirmPassTarget"],
                              "defaultClass": "bi-eye-slash",
                              "showClass": "bi-eye",
                              "classChangeTarget": "#toggleConfirmPassIcon"
                            }'
                            type="password" placeholder="Confirm your new password" />
                          <a class="input-group-text toggleConfirmPassTarget"><i class="bi-eye" id="toggleConfirmPassIcon"></i></a>
                          <span class="invalid-feedback" id="valAccountConfirmPass"></span>
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
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                  </div>
                </form>
                <!-- End Form -->
              </div>
              <!-- End Body -->
            </div>
            <!-- End Change Password Card -->
          </div>

          <!-- Sticky Block End Point -->
          <div id="stickyBlockEndPoint"></div>
        </div>
      </div>
    </div>
    <!-- End Content -->
  </main>
@endsection

@section('footer')
  @include('layouts.footer')
@endsection

@section('sub-content')
  {{-- Sub Content --}}
@endsection

@section('scripts')
  <!-- JS Other Plugins -->
  <script src="{{ Vite::asset('resources/vendor/hs-file-attach/dist/hs-file-attach.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-sticky-block/dist/hs-sticky-block.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-scrollspy/dist/hs-scrollspy.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/imask/dist/imask.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-toggle-password/dist/js/hs-toggle-password.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/tom-select/dist/js/tom-select.complete.min.js') }}"></script>

  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/account/settings.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Init. -->
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


        // INITIALIZATION OF SELECT
        // =======================================================
        HSCore.components.HSTomSelect.init('.js-select')


        // INITIALIZATION OF INPUT MASK
        // =======================================================
        HSCore.components.HSMask.init('.js-input-mask')


        // INITIALIZATION OF FILE ATTACHMENT
        // =======================================================
        new HSFileAttach('.js-file-attach')


        // INITIALIZATION OF TOGGLE PASSWORD
        // =======================================================
        new HSTogglePassword('.js-toggle-password');


        // INITIALIZATION OF STICKY BLOCKS
        // =======================================================
        new HSStickyBlock('.js-sticky-block', {
          targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ? '#header' : null
        })


        // SCROLLSPY
        // =======================================================
        new bootstrap.ScrollSpy(document.body, {
          target: '#navbarSettings',
          offset: 100
        })

        new HSScrollspy('#navbarVerticalNavMenu', {
          breakpoint: 'lg',
          scrollOffset: -20
        })
      }
    })()
  </script>
@endsection
