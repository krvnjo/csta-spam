<header class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-container navbar-bordered bg-white" id="header">
  <div class="navbar-nav-wrap">
    <!-- Logo -->
    <a class="navbar-brand" data-route="dashboard.index" href="{{ route('dashboard.index') }}">
      <img class="navbar-brand-logo-mini d-block" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo-short.svg') }}"
        alt="CSTA - SPAM Logo">
      <img class="navbar-brand-logo-mini d-block" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo-short.svg') }}"
        alt="CSTA - SPAM Logo">
    </a>
    <!-- End Logo -->

    <div class="navbar-nav-wrap-content-start">
      <!-- Sidebar Toggle -->
      <button class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler" type="button">
        <i class="bi-arrow-bar-left navbar-toggler-short-align"
          data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'></i>
        <i class="bi-arrow-bar-right navbar-toggler-full-align"
          data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'></i>
      </button>
      <!-- End Sidebar Toggle -->

      <!-- Search Form -->
      <div class="dropdown ms-2">
        <!-- Search Input Group -->
        <div class="d-none d-lg-block">
          <div class="input-group input-group-merge input-group-borderless input-group-hover-light navbar-input-group">
            <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>

            <input class="js-form-search form-control"
              data-hs-form-search-options='{
                "clearIcon": "#clearSearchResultsIcon",
                "dropMenuElement": "#searchDropdownMenu",
                "dropMenuOffset": 20,
                "toggleIconOnFocus": true,
                "activeClass": "focus"
              }'
              type="search" placeholder="Search in CSTA - SPAM">
            <a class="input-group-append input-group-text"><i class="bi-x-lg" id="clearSearchResultsIcon" style="display: none;"></i></a>
          </div>
        </div>

        <button class="js-form-search js-form-search-mobile-toggle btn btn-ghost-secondary btn-icon rounded-circle d-lg-none"
          data-hs-form-search-options='{
            "clearIcon": "#clearSearchResultsIcon",
            "dropMenuElement": "#searchDropdownMenu",
            "dropMenuOffset": 20,
            "toggleIconOnFocus": true,
            "activeClass": "focus"
          }'
          type="button">
          <i class="bi-search"></i>
        </button>
        <!-- End Search Input Group -->

        <!-- Card Search Content -->
        <div class="hs-form-search-menu-content dropdown-menu dropdown-menu-form-search navbar-dropdown-menu-borderless flex-grow-1"
          id="searchDropdownMenu">
          <div class="card">
            <div class="card-body-height">
              <div class="d-lg-none">
                <div class="input-group input-group-merge navbar-input-group mb-5">
                  <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>
                  <input class="form-control" type="search" placeholder="Search in CSTA - SPAM">
                  <a class="input-group-append input-group-text"><i class="bi-x-lg"></i></a>
                </div>
              </div>

              <span class="dropdown-header">Recent searches</span>
              <a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <span class="icon icon-soft-dark icon-xs icon-circle">
                      <i class="bi-box"></i>
                    </span>
                  </div>
                  <div class="flex-grow-1 text-truncate ms-2">
                    <span>Property and Assets</span>
                  </div>
                </div>
              </a>

              <a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <span class="icon icon-soft-dark icon-xs icon-circle">
                      <i class="bi-bar-chart"></i>
                    </span>
                  </div>
                  <div class="flex-grow-1 text-truncate ms-2">
                    <span>Dashboard</span>
                  </div>
                </div>
              </a>

              <div class="dropdown-divider"></div>

              <span class="dropdown-header">Suggested</span>
              <a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <span class="icon icon-soft-dark icon-xs icon-circle">
                      <i class="bi-question-square"></i>
                    </span>
                  </div>
                  <div class="flex-grow-1 text-truncate ms-2">
                    <span>What is CSTA - SPAM?</span>
                  </div>
                </div>
              </a>

              <a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <span class="icon icon-soft-dark icon-xs icon-circle">
                      <i class="bi-paint-bucket"></i>
                    </span>
                  </div>
                  <div class="flex-grow-1 text-truncate ms-2">
                    <span>How to change theme color?</span>
                  </div>
                </div>
              </a>

              <a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <span class="icon icon-soft-dark icon-xs icon-circle">
                      <i class="bi-question-square"></i>
                    </span>
                  </div>
                  <div class="flex-grow-1 text-truncate ms-2">
                    <span>Frequently Asked Questions</span>
                  </div>
                </div>
              </a>
            </div>
            <a class="card-footer text-center" href="#">See all results <i class="bi-chevron-right small"></i></a>
          </div>
        </div>
        <!-- End Card Search Content -->
      </div>
      <!-- End Search Form -->
    </div>

    <div class="navbar-nav-wrap-content-end">
      <ul class="navbar-nav">
        <!-- Notification -->
        <li class="nav-item d-sm-inline-block">
          <div class="dropdown">
            <button class="btn btn-ghost-secondary btn-icon rounded-circle" id="navbarNotificationsDropdown" data-bs-toggle="dropdown"
              data-bs-auto-close="outside" data-bs-dropdown-animation type="button"><i class="bi-bell"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless" style="width: 25rem;">
              <div class="card">
                <!-- Header -->
                <div class="card-header card-header-content-between">
                  <h4 class="card-title mb-0">Notifications</h4>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body-height">
                  <div class="tab-content" id="notificationTabContent">
                    <div class="tab-pane fade show active" id="notificationNavOne">
                      <ul class="list-group list-group-flush navbar-card-list-group">
                        <!-- Item -->
                        <li class="list-group-item form-check-select">
                          <div class="row">
                            <div class="col-auto">
                              <div class="d-flex align-items-center">
                                <div class="form-check">
                                  <input class="form-check-input" id="notificationCheck1" type="checkbox" value="" checked>
                                  <label class="form-check-label" for="notificationCheck1"></label>
                                  <span class="form-check-stretched-bg"></span>
                                </div>
                                <img class="avatar avatar-sm avatar-circle" src="{{ Vite::asset('resources/img/160x160/img3.jpg') }}"
                                  alt="Image Description">
                              </div>
                            </div>
                            <!-- End Col -->

                            <div class="col ms-n2">
                              <h5 class="mb-1">Brian Warner</h5>
                              <p class="text-body fs-5">changed an issue from "In Progress" to <span class="badge bg-success">Review</span></p>
                            </div>
                            <!-- End Col -->

                            <small class="col-auto text-muted text-cap">2hr</small>
                            <!-- End Col -->
                          </div>
                          <!-- End Row -->

                          <a class="stretched-link" href="#"></a>
                        </li>
                        <!-- End Item -->

                        <!-- Item -->
                        <li class="list-group-item form-check-select">
                          <div class="row">
                            <div class="col-auto">
                              <div class="d-flex align-items-center">
                                <div class="form-check">
                                  <input class="form-check-input" id="notificationCheck3" type="checkbox" value="" checked>
                                  <label class="form-check-label" for="notificationCheck3"></label>
                                  <span class="form-check-stretched-bg"></span>
                                </div>
                                <div class="avatar avatar-sm avatar-circle">
                                  <img class="avatar-img" src="{{ Vite::asset('resources/img/160x160/img10.jpg') }}" alt="Image Description">
                                </div>
                              </div>
                            </div>
                            <!-- End Col -->

                            <div class="col ms-n2">
                              <h5 class="mb-1">Ruby Walter</h5>
                              <p class="text-body fs-5">joined the Slack group HS Team</p>
                            </div>
                            <!-- End Col -->

                            <small class="col-auto text-muted text-cap">3dy</small>
                            <!-- End Col -->
                          </div>
                          <!-- End Row -->

                          <a class="stretched-link" href="#"></a>
                        </li>
                        <!-- End Item -->

                        <!-- Item -->
                        <li class="list-group-item form-check-select">
                          <div class="row">
                            <div class="col-auto">
                              <div class="d-flex align-items-center">
                                <div class="form-check">
                                  <input class="form-check-input" id="notificationCheck4" type="checkbox" value="">
                                  <label class="form-check-label" for="notificationCheck4"></label>
                                  <span class="form-check-stretched-bg"></span>
                                </div>
                                <div class="avatar avatar-sm avatar-circle">
                                  <img class="avatar-img" src="{{ Vite::asset('resources/svg/brands/google-icon.svg') }}" alt="Image Description">
                                </div>
                              </div>
                            </div>
                            <!-- End Col -->

                            <div class="col ms-n2">
                              <h5 class="mb-1">from Google</h5>
                              <p class="text-body fs-5">Start using forms to capture the information of prospects
                                visiting your Google website
                              </p>
                            </div>
                            <!-- End Col -->

                            <small class="col-auto text-muted text-cap">17dy</small>
                            <!-- End Col -->
                          </div>
                          <!-- End Row -->

                          <a class="stretched-link" href="#"></a>
                        </li>
                        <!-- End Item -->
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- End Body -->

                <!-- Card Footer -->
                <a class="card-footer text-center" href="#">View all notifications <i class="bi-chevron-right"></i></a>
                <!-- End Card Footer -->
              </div>
            </div>
          </div>
        </li>
        <!-- End Notification -->

        <!-- Account -->
        <li class="nav-item">
          <div class="dropdown">
            <button class="btn navbar-dropdown-account-wrapper" id="accountNavbarDropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside"
              data-bs-dropdown-animation type="button">
              <div class="avatar avatar-sm avatar-circle">
                <img class="avatar-img" src="{{ asset('storage/img/user-images/' . Auth::user()->user_image) }}" alt="User Image">
                <span class="avatar-status avatar-sm-status avatar-status-success"></span>
              </div>
            </button>

            <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account"
              style="width: 16rem;">
              <!-- Profile Header -->
              <div class="dropdown-item-text">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm avatar-circle">
                    <img class="avatar-img" src="{{ asset('storage/img/user-images/' . Auth::user()->user_image) }}" alt="User Image">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h5 class="mb-0">{{ Auth::user()->fname . ' ' . Auth::user()->lname }}</h5>
                    <p class="card-text text-body">{{ Auth::user()->roles()->first()->name }}</p>
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
                <button class="navbar-dropdown-submenu-item dropdown-item dropdown-toggle" id="selectThemeDropdown" data-bs-toggle="dropdown"
                  type="button">System Appearance</button>

                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-sub-menu"
                  aria-labelledby="selectThemeDropdown">
                  <button class="dropdown-item" data-icon="bi-moon-stars" data-value="auto" type="button">
                    <i class="bi-moon-stars me-2"></i><span class="text-truncate" title="Auto (system default)">Auto (system default)</span>
                  </button>
                  <button class="dropdown-item" data-icon="bi-brightness-high" data-value="default" type="button">
                    <i class="bi-brightness-high me-2"></i><span class="text-truncate" title="Default (light mode)">Default (light mode)</span>
                  </button>
                  <button class="dropdown-item" data-icon="bi-moon" data-value="dark" type="button">
                    <i class="bi-moon me-2"></i><span class="text-truncate" title="Dark">Dark</span>
                  </button>
                </div>
              </div>
              <!-- End System Appearance -->

              <!-- Help & Support -->
              <div class="dropdown">
                <button class="navbar-dropdown-submenu-item dropdown-item dropdown-toggle" id="navSubmenuPagesAccountDropdown2"
                  data-bs-toggle="dropdown" type="button">Help & Support</button>

                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-sub-menu">
                  <a class="dropdown-item" href="#"><i class="bi-info-circle me-2"></i>FAQ List</a>
                  <a class="dropdown-item" href="#"><i class="bi-flag me-2"></i>Report a Problem</a>
                </div>
              </div>
              <!-- End Help & Support -->

              <div class="dropdown-divider"></div>

              <!-- Sign out -->
              <form method="post" action="{{ route('auth.logout') }}">
                @csrf
                <button class="dropdown-item" type="submit">Sign out</button>
              </form>
              <!-- End Sign out -->
            </div>
          </div>
        </li>
        <!-- End Account -->
      </ul>
    </div>
  </div>
</header>
