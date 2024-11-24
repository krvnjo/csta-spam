@extends('layouts.app')

@section('title')
  System Settings
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <div class="content container-fluid">
      <!-- System Settings Header -->
      <div class="page-header">
        <div class="row align-items-center">
          <div class="col-sm mb-2 mb-sm-0">
            <ol class="breadcrumb breadcrumb-no-gutter">
              <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item active">System Settings</li>
            </ol>
            <h1 class="page-header-title">System Settings</h1>
            <p class="page-header-text">Configure and manage system settings to optimize functionality.</p>
          </div>
        </div>
      </div>
      <!-- End System Settings Header -->

      <div class="row">
        <!-- Settings Menu -->
        <div class="col-lg-3">
          <div class="navbar-expand-lg navbar-vertical mb-3 mb-lg-5">
            <div class="d-grid">
              <button class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse" data-bs-target="#navbarVerticalNavMenu" type="button">
                <span class="d-flex justify-content-between align-items-center">
                  <span class="text-dark">Menu</span>
                  <span class="navbar-toggler-default"><i class="bi-list"></i></span>
                  <span class="navbar-toggler-toggled"><i class="bi-x"></i></span>
                </span>
              </button>
            </div>

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
                  <a class="nav-link" href="#sessionTimeoutSection">
                    <i class="bi-clock nav-icon"></i> Session Timeout
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#passwordExpirationSection">
                    <i class="bi-key nav-icon"></i> Password Expiration
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#performanceCachingSection">
                    <i class="bi-bar-chart-line nav-icon"></i> Performance & Caching
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#databaseBackupSection">
                    <i class="bi-database nav-icon"></i> Database Backup
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- End Settings Menu -->

        <!-- Settings Content -->
        <div class="col-lg-9">
          <div class="d-grid gap-3 gap-lg-5">
            <!-- Session Timeout Card -->
            <div class="card" id="sessionTimeoutSection">
              <div class="card-header">
                <h4 class="card-title">Session Timeout</h4>
              </div>

              <div class="card-body">
                <p>Set the time a user’s session remains active before they're automatically logged out due to inactivity. <span class="fw-semibold">Default: 2 hours</span></p>
                <form id="frmSettingSession" method="POST" novalidate>
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="selSettingSession">Duration</label>
                    <div class="col-sm-9">
                      <div class="tom-select-custom">
                        <select class="js-select form-select" id="selSettingSession"
                          data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "placeholder": "Select session timeout duration"
                          }'>
                          <option value=""></option>
                          <option value="60" {{ $sessionDuration == 60 ? 'selected' : '' }}>1 hour duration per session</option>
                          <option value="120" {{ $sessionDuration == 120 ? 'selected' : '' }}>2 hour duration per session</option>
                          <option value="180" {{ $sessionDuration == 180 ? 'selected' : '' }}>3 hour duration per session</option>
                          <option value="240" {{ $sessionDuration == 240 ? 'selected' : '' }}>4 hour duration per session</option>
                          <option value="300" {{ $sessionDuration == 300 ? 'selected' : '' }}>5 hour duration per session</option>
                        </select>
                        <span class="invalid-feedback" id="valSettingSession"></span>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" id="btnSettingSaveSession" form="frmSettingSession" type="submit">
                      <span class="spinner-label">Save Changes</span>
                      <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <!-- End Session Timeout Card -->

            <!-- Password Expiration Card -->
            <div class="card" id="passwordExpirationSection">
              <div class="card-header">
                <h4 class="card-title">Password Expiration</h4>
              </div>

              <div class="card-body">
                <p>Users will be prompted to change their password after the specified period for security. <span class="fw-semibold">Default: 6-months</span></p>
                <form id="frmSettingExpiration" method="POST" novalidate>
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="selSettingExpiration">Expiration Period</label>
                    <div class="col-sm-9">
                      <div class="tom-select-custom">
                        <select class="js-select form-select" id="selSettingExpiration"
                          data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "placeholder": "Select expiration period"
                          }'>
                          <option value=""></option>
                          <option value="3" {{ $passwordExpiration == 3 ? 'selected' : '' }}>3-months time period</option>
                          <option value="6" {{ $passwordExpiration == 6 ? 'selected' : '' }}>6-months time period</option>
                          <option value="9" {{ $passwordExpiration == 9 ? 'selected' : '' }}>9-months time period</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" id="btnSettingSaveExpiration" form="frmSettingExpiration" type="submit">
                      <span class="spinner-label">Save Changes</span>
                      <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <!-- End Password Expiration Card -->

            <!-- Performance & Caching Card -->
            <div class="card" id="performanceCachingSection">
              <div class="card-header">
                <h4 class="card-title">Performance & Caching</h4>
              </div>

              <div class="card-body">
                <form id="frmSettingPerformance" method="POST" novalidate>
                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="selSettingClear">Clear Audit History Logs</label>
                    <div class="col-sm-9">
                      <div class="tom-select-custom">
                        <select class="js-select form-select" id="selSettingClear"
                          data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "placeholder": "Select old logs to clear"
                          }'>
                          <option value=""></option>
                          <option value="30" {{ $clearAuditLog == 30 ? 'selected' : '' }}>30 days old logs</option>
                          <option value="60" {{ $clearAuditLog == 60 ? 'selected' : '' }}>60 days old logs</option>
                          <option value="90" {{ $clearAuditLog == 90 ? 'selected' : '' }}>90 days old logs</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-4">
                    <label class="col-sm-3 col-form-label form-label" for="selSettingCaching">Caching Timeout</label>
                    <div class="col-sm-9">
                      <div class="tom-select-custom">
                        <select class="js-select form-select" id="selSettingExpiration"
                          data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "placeholder": "Select old logs to clear"
                          }'>
                          <option value=""></option>
                          <option value="60" {{ $cachingDuration == 60 ? 'selected' : '' }}>1 hour</option>
                          <option value="120" {{ $cachingDuration == 120 ? 'selected' : '' }}>2 hours</option>
                          <option value="180" {{ $cachingDuration == 180 ? 'selected' : '' }}>3 hours</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" id="btnSettingSavePerformance" form="frmSettingPerformance" type="submit">
                      <span class="spinner-label">Save Changes</span>
                      <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <!-- End Performance & Caching Card -->

            <!-- Database Backup -->
            <div class="card" id="databaseBackupSection">
              <div class="card-header">
                <h4 class="card-title">Database Backup</h4>
              </div>

              <div class="card-body">
                <p class="card-text">Manage and schedule automated database backups for data security.</p>
                <form>
                  <div class="list-group list-group-lg list-group-flush list-group-no-gutters">
                    <div class="list-group-item">
                      <div class="d-flex">
                        <div class="flex-shrink-0">
                          <i class="bi-database-fill list-group-icon"></i>
                        </div>

                        <div class="flex-grow-1">
                          <div class="row align-items-center">
                            <div class="col-sm mb-2 mb-sm-0">
                              <h4 class="mb-0">CSTA-SPAM Backup</h4>
                              <span class="fs-5 text-body">It will be downloaded as .sql file</span>
                            </div>
                            <div class="col-sm-auto">
                              <button class="btn btn-white" id="btnSettingSavePerformance" form="frmSettingPerformance" type="submit">
                                <span class="spinner-label">Download Backup</span>
                                <span class="spinner-border spinner-border-sm d-none"></span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- End Database Backup -->
          </div>

          <div id="stickyBlockEndPoint"></div>
        </div>
        <!-- End Settings Content -->
      </div>
    </div>
  </main>
@endsection

@section('sec-content')
  {{-- Secondary Content --}}
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/hs-sticky-block/dist/hs-sticky-block.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-scrollspy/dist/hs-scrollspy.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/tom-select/dist/js/tom-select.complete.min.js') }}"></script>

  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/other/system-settings.js') }}"></script>

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
        HSBsDropdown.init();


        // INITIALIZATION OF SELECT
        // =======================================================
        HSCore.components.HSTomSelect.init('.js-select')


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
      };
    })();
  </script>
@endpush
