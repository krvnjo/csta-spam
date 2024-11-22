<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>@yield('title') | {{ config('app.name') }} </title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Plugins -->
    @stack('styles')

    <!-- CSS Themes -->
    <link data-hs-appearance="default" href="{{ Vite::asset('resources/css/theme.min.css') }}" rel="stylesheet">
    <link data-hs-appearance="dark" href="{{ Vite::asset('resources/css/theme-dark.min.css') }}" rel="stylesheet">

    <!-- Vite Asset Bundling -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- JS Window Config -->
    <script src="{{ Vite::asset('resources/js/hs-window-config') }}"></script>
  </head>
  <body>
    <style>
      @media (min-width: 1400px) {
        .container-lg {
          max-width: 1140px;
        }
      }
    </style>
    <!-- JS Appearance -->
    <script src="{{ Vite::asset('resources/js/hs.theme-appearance.js') }}"></script>

    <!-- ========== Header ========== -->
    <header class="navbar navbar-expand-lg navbar-center navbar-light bg-white navbar-absolute-top navbar-show-hide" id="header"
      data-hs-header-options='{
        "fixMoment": 0,
        "fixEffect": "slide"
      }'>
      <div class="container-lg">
        <nav class="js-mega-menu navbar-nav-wrap d-flex justify-content-between align-items-center">
          <!-- Logo -->
          <a class="navbar-brand" data-route="dashboard.index" href="{{ route('dashboard.index') }}">
            <img class="navbar-brand-help d-none d-sm-inline-block" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo.svg') }}" alt="CSTA - SPAM Logo">
            <img class="navbar-brand-help d-none d-sm-inline-block" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo.svg') }}" alt="CSTA - SPAM Logo">
            <img class="navbar-brand-helps d-inline-block d-sm-none" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo-horizontal.svg') }}" alt="CSTA - SPAM Logo">
            <img class="navbar-brand-helps d-inline-block d-sm-none" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo-horizontal.svg') }}" alt="CSTA - SPAM Logo">
          </a>
          <!-- End Logo -->

          <!-- Secondary Content -->
          <div class="navbar-nav-wrap-secondary-content d-flex align-items-center ms-auto">
            <!-- Notification -->
            {{--            <div class="dropdown"> --}}
            {{--              <button class="btn btn-ghost-secondary btn-icon rounded-circle" id="navbarNotificationsDropdown" data-bs-toggle="dropdown" data-bs-dropdown-animation type="button"> --}}
            {{--                <i class="bi-bell"></i> --}}
            {{--                <span class="btn-status btn-sm-status btn-status-danger"></span> --}}
            {{--              </button> --}}

            {{--              <div class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless" style="width: 25rem;"> --}}
            {{--                <div class="card"> --}}
            {{--                  <!-- Header --> --}}
            {{--                  <div class="card-header card-header-content-between"> --}}
            {{--                    <h4 class="card-title mb-0">Notifications</h4> --}}
            {{--                  </div> --}}
            {{--                  <!-- End Header --> --}}

            {{--                  <!-- Body --> --}}
            {{--                  <div class="card-body-height"> --}}
            {{--                    <div class="tab-content" id="notificationTabContent"> --}}
            {{--                      <div class="tab-pane fade show active" id="notificationNavOne"> --}}
            {{--                        <ul class="list-group list-group-flush navbar-card-list-group"> --}}
            {{--                          <!-- Item --> --}}
            {{--                          <li class="list-group-item form-check-select"> --}}
            {{--                            <div class="row"> --}}
            {{--                              <div class="col-auto"> --}}
            {{--                                <div class="d-flex align-items-center"> --}}
            {{--                                  <div class="form-check"> --}}
            {{--                                    <input class="form-check-input" id="notificationCheck1" type="checkbox" value="" checked> --}}
            {{--                                    <label class="form-check-label" for="notificationCheck1"></label> --}}
            {{--                                    <span class="form-check-stretched-bg"></span> --}}
            {{--                                  </div> --}}
            {{--                                  <img class="avatar avatar-sm avatar-circle" src="{{ Vite::asset('resources/img/160x160/img3.jpg') }}" alt="Image Description"> --}}
            {{--                                </div> --}}
            {{--                              </div> --}}
            {{--                              <div class="col ms-n2"> --}}
            {{--                                <h5 class="mb-1">Brian Warner</h5> --}}
            {{--                                <p class="text-body fs-5">changed an issue from "In Progress" to <span class="badge bg-success">Review</span></p> --}}
            {{--                              </div> --}}
            {{--                              <small class="col-auto text-muted text-cap">2hr</small> --}}
            {{--                            </div> --}}
            {{--                            <a class="stretched-link" href="#"></a> --}}
            {{--                          </li> --}}
            {{--                          <!-- End Item --> --}}

            {{--                          <!-- Item --> --}}
            {{--                          <li class="list-group-item form-check-select"> --}}
            {{--                            <div class="row"> --}}
            {{--                              <div class="col-auto"> --}}
            {{--                                <div class="d-flex align-items-center"> --}}
            {{--                                  <div class="form-check"> --}}
            {{--                                    <input class="form-check-input" id="notificationCheck3" type="checkbox" value="" checked> --}}
            {{--                                    <label class="form-check-label" for="notificationCheck3"></label> --}}
            {{--                                    <span class="form-check-stretched-bg"></span> --}}
            {{--                                  </div> --}}
            {{--                                  <div class="avatar avatar-sm avatar-circle"> --}}
            {{--                                    <img class="avatar-img" src="{{ Vite::asset('resources/img/160x160/img10.jpg') }}" alt="Image Description"> --}}
            {{--                                  </div> --}}
            {{--                                </div> --}}
            {{--                              </div> --}}
            {{--                              <div class="col ms-n2"> --}}
            {{--                                <h5 class="mb-1">Ruby Walter</h5> --}}
            {{--                                <p class="text-body fs-5">joined the Slack group HS Team</p> --}}
            {{--                              </div> --}}
            {{--                              <small class="col-auto text-muted text-cap">3dy</small> --}}
            {{--                            </div> --}}
            {{--                            <a class="stretched-link" href="#"></a> --}}
            {{--                          </li> --}}
            {{--                          <!-- End Item --> --}}

            {{--                          <!-- Item --> --}}
            {{--                          <li class="list-group-item form-check-select"> --}}
            {{--                            <div class="row"> --}}
            {{--                              <div class="col-auto"> --}}
            {{--                                <div class="d-flex align-items-center"> --}}
            {{--                                  <div class="form-check"> --}}
            {{--                                    <input class="form-check-input" id="notificationCheck4" type="checkbox" value=""> --}}
            {{--                                    <label class="form-check-label" for="notificationCheck4"></label> --}}
            {{--                                    <span class="form-check-stretched-bg"></span> --}}
            {{--                                  </div> --}}
            {{--                                  <div class="avatar avatar-sm avatar-circle"> --}}
            {{--                                    <img class="avatar-img" src="{{ Vite::asset('resources/svg/brands/google-icon.svg') }}" alt="Image Description"> --}}
            {{--                                  </div> --}}
            {{--                                </div> --}}
            {{--                              </div> --}}
            {{--                              <div class="col ms-n2"> --}}
            {{--                                <h5 class="mb-1">from Google</h5> --}}
            {{--                                <p class="text-body fs-5">Start using forms to capture the information of prospects visiting your Google website</p> --}}
            {{--                              </div> --}}
            {{--                              <small class="col-auto text-muted text-cap">17dy</small> --}}
            {{--                            </div> --}}
            {{--                            <a class="stretched-link" href="#"></a> --}}
            {{--                          </li> --}}
            {{--                          <!-- End Item --> --}}
            {{--                        </ul> --}}
            {{--                      </div> --}}
            {{--                    </div> --}}
            {{--                  </div> --}}
            {{--                  <!-- End Body --> --}}

            {{--                  <!-- Card Footer --> --}}
            {{--                  <a class="card-footer text-center" href="#">View all notifications <i class="bi-chevron-right"></i></a> --}}
            {{--                  <!-- End Card Footer --> --}}
            {{--                </div> --}}
            {{--              </div> --}}
            {{--            </div> --}}
            <!-- End Notification -->

            <!-- Account -->
            <div class="dropdown">
              <button class="btn navbar-dropdown-account-wrapper" id="accountNavbarDropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" data-bs-dropdown-animation type="button">
                <div class="avatar avatar-sm avatar-circle">
                  <img class="avatar-img" src="{{ asset('storage/img/user-images/' . Auth::user()->user_image) }}" alt="User Image">
                  <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                </div>
              </button>

              <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account" style="width: 16rem;">
                <!-- Profile Header -->
                <div class="dropdown-item-text">
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm avatar-circle">
                      <img class="avatar-img" src="{{ asset('storage/img/user-images/' . Auth::user()->user_image) }}" alt="User Image">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <h5 class="mb-0">{{ Auth::user()->fname . ' ' . Auth::user()->lname }}</h5>
                      <p class="card-text text-body">{{ Auth::user()->role->name }}</p>
                    </div>
                  </div>
                </div>
                <!-- End Profile Header -->

                <div class="dropdown-divider"></div>

                <!-- Account Settings -->
                <a class="dropdown-item" href="{{ route('account.index', ['username' => Auth::user()->user_name]) }}">Profile & Account</a>
                <!-- End Account Settings -->

                <!-- System Appearance -->
                <div class="dropdown">
                  <button class="navbar-dropdown-submenu-item dropdown-item dropdown-toggle" id="selectThemeDropdown" data-bs-toggle="dropdown" data-bs-dropdown-animation type="button">
                    System Appearance
                  </button>
                  <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-sub-menu theme-dropdown">
                    <button class="dropdown-item" data-icon="bi-moon-stars" data-value="auto" type="button">
                      <i class="bi-moon-stars me-2"></i><span class="text-truncate">Auto (system default)</span>
                    </button>
                    <button class="dropdown-item" data-icon="bi-brightness-high" data-value="default" type="button">
                      <i class="bi-brightness-high me-2"></i><span class="text-truncate">Default (light mode)</span>
                    </button>
                    <button class="dropdown-item" data-icon="bi-moon" data-value="dark" type="button">
                      <i class="bi-moon me-2"></i><span class="text-truncate">Dark</span>
                    </button>
                  </div>
                </div>
                <!-- End System Appearance -->

                <!-- Help Resources -->
                <div class="dropdown">
                  <button class="navbar-dropdown-submenu-item dropdown-item dropdown-toggle" id="navSubmenuPagesAccountDropdown2" data-bs-toggle="dropdown" data-bs-dropdown-animation
                    type="button">Help Resources</button>
                  <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-sub-menu">
                    <a class="dropdown-item" href="{{ route('help.about') }}"><i class="bi-question-circle me-2"></i>About Us</a>
                    <a class="dropdown-item" href="{{ route('help.guide') }}"><i class="bi-journal-text me-2"></i>User Guide</a>
                  </div>
                </div>
                <!-- End Help Resources -->

                <div class="dropdown-divider"></div>

                <!-- Log Out -->
                <form id="frmLogoutUser" method="post" action="{{ route('auth.logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">Log Out</button>
                </form>
                <!-- End Log Out -->
              </div>
            </div>
          </div>
          <!-- End Secondary Content -->
        </nav>
      </div>
    </header>
    <!-- ========== End Header ========== -->

    <!-- ========== Main Content ========== -->
    @yield('main-content')
    <!-- ========== End Main Content ========== -->

    <!-- ========== Footer ========== -->
    <footer class="container-lg text-center pb-8">
      <ul class="list-inline mb-3">
        <li class="list-inline-item">
          <a class="btn btn-soft-secondary btn-sm btn-icon rounded-circle" href="https://www.facebook.com/csta2007">
            <i class="bi-facebook"></i>
          </a>
        </li>

        <li class="list-inline-item">
          <a class="btn btn-soft-secondary btn-sm btn-icon rounded-circle" href="https://www.instagram.com/csta2007/">
            <i class="bi-instagram"></i>
          </a>
        </li>

        <li class="list-inline-item">
          <a class="btn btn-soft-secondary btn-sm btn-icon rounded-circle" href="mailto:officialregistrarcsta@gmail.com">
            <i class="bi-envelope"></i>
          </a>
        </li>
      </ul>
      <p class="mb-0">&copy; CSTA - SPAM 2024. All rights reserved.</p>
    </footer>
    <!-- ========== End Footer ========== -->

    <!-- ========== Secondary Content ========== -->
    @yield('sec-content')
    <!-- ========== End Secondary Content ========== -->

    <!-- JS Global Compulsory -->
    <script src="{{ Vite::asset('resources/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- JS Plugins -->
    @stack('scripts')

    <!-- JS Style Switcher -->
    <script src="{{ Vite::asset('resources/js/hs-style-switcher.js') }}"></script>
  </body>
</html>
