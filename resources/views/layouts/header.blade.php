<header class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-container navbar-bordered bg-white" id="header">
  <div class="navbar-nav-wrap">
    <!-- Logo -->
    <a class="navbar-brand" href="/" aria-label="CSTA - SPAM">
      <img class="navbar-brand-logo-mini d-block" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo-short.svg') }}"
        alt="CSTA - SPAM Logo" style="width: 2rem">
      <img class="navbar-brand-logo-mini d-block" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo-short.svg') }}"
        alt="CSTA - SPAM Logo" style="width: 2rem">
    </a>
    <!-- End Logo -->

    <div class="navbar-nav-wrap-content-start">
      <!-- Navbar Vertical Toggle -->
      <button class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler" type="button">
        <i class="bi-arrow-bar-left navbar-toggler-short-align" data-bs-placement="right"
          data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
          data-bs-toggle="tooltip" title="Collapse"></i>
        <i class="bi-arrow-bar-right navbar-toggler-full-align" data-bs-placement="right"
          data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
          data-bs-toggle="tooltip" title="Expand"></i>
      </button>
      <!-- End Navbar Vertical Toggle -->

      <!-- Search Form -->
      <div class="dropdown ms-2">
        <!-- Input Group -->
        <div class="d-none d-lg-block">
          <div class="input-group input-group-merge input-group-borderless input-group-hover-light navbar-input-group">
            <div class="input-group-prepend input-group-text">
              <i class="bi-search"></i>
            </div>

            <input class="js-form-search form-control"
              data-hs-form-search-options='{
                "clearIcon": "#clearSearchResultsIcon",
                "dropMenuElement": "#searchDropdownMenu",
                "dropMenuOffset": 20,
                "toggleIconOnFocus": true,
                "activeClass": "focus"
              }'
              type="search" aria-label="Search in front" placeholder="Search in CSTA - SPAM">
            <a class="input-group-append input-group-text" href="#">
              <i class="bi-x-lg" id="clearSearchResultsIcon" style="display: none;"></i>
            </a>
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
        <!-- End Input Group -->

        <!-- Card Search Content -->
        <div class="hs-form-search-menu-content dropdown-menu dropdown-menu-form-search navbar-dropdown-menu-borderless flex-grow-1"
          id="searchDropdownMenu">
          <div class="card">
            <!-- Body -->
            <div class="card-body-height" style="max-height: 250px; overflow-y: auto;">
              <div class="d-lg-none">
                <div class="input-group input-group-merge navbar-input-group mb-5">
                  <div class="input-group-prepend input-group-text">
                    <i class="bi-search"></i>
                  </div>

                  <input class="form-control" type="search" aria-label="Search in CSTA - SPAM" placeholder="Search in CSTA - SPAM">
                  <a class="input-group-append input-group-text" href="#">
                    <i class="bi-x-lg"></i>
                  </a>
                </div>
              </div>

              <span class="dropdown-header">Recent searches</span>

              <div class="dropdown-item bg-transparent text-wrap">
                <a class="btn btn-soft-dark btn-xs rounded-pill" href="#">
                  Property & Assets <i class="bi-search ms-1"></i>
                </a>
                <a class="btn btn-soft-dark btn-xs rounded-pill" href="#">
                  Notification Panel <i class="bi-search ms-1"></i>
                </a>
              </div>

              <div class="dropdown-divider"></div>

              <span class="dropdown-header">Suggested Searches</span>

              <a class="dropdown-item" href="/">
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

              <a class="dropdown-item" href="/">
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
            </div>
            <!-- End Body -->

            <!-- Footer -->
            <a class="card-footer text-center" href="/">
              See all results <i class="bi-chevron-right small"></i>
            </a>
            <!-- End Footer -->
          </div>
        </div>
        <!-- End Card Search Content -->

      </div>
      <!-- End Search Form -->
    </div>

    <div class="navbar-nav-wrap-content-end">
      <!-- Navbar -->
      <ul class="navbar-nav">
        <li class="nav-item d-sm-inline-block">
          <!-- Notification -->
          <div class="dropdown">
            <button class="btn btn-ghost-secondary btn-icon rounded-circle" id="navbarNotificationsDropdown" data-bs-toggle="dropdown"
              data-bs-auto-close="outside" data-bs-dropdown-animation type="button" aria-expanded="false">
              <i class="bi-bell"></i>
              <span class="btn-status btn-sm-status btn-status-danger"></span>
            </button>

            <div class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless"
              aria-labelledby="navbarNotificationsDropdown" style="width: 25rem;">
              <div class="card">
                <!-- Header -->
                <div class="card-header card-header-content-between">
                  <h4 class="card-title mb-0">Notifications</h4>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body-height">
                  <!-- Tab Content -->
                  <div class="tab-content" id="notificationTabContent">
                    <div class="tab-pane fade show active" id="notificationNavOne" role="tabpanel" aria-labelledby="notificationNavOne-tab">
                      <!-- List Group -->
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
                              <p class="text-body fs-5">Start using forms to capture the information of prospects visiting your Google website
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
                      <!-- End List Group -->
                    </div>
                  </div>
                  <!-- End Tab Content -->
                </div>
                <!-- End Body -->

                <!-- Card Footer -->
                <a class="card-footer text-center" href="#">
                  View all notifications <i class="bi-chevron-right"></i>
                </a>
                <!-- End Card Footer -->
              </div>
            </div>
          </div>
          <!-- End Notification -->
        </li>

        <li class="nav-item d-none d-sm-inline-block">
          <!-- Apps -->
          <div class="dropdown">
            <button class="btn btn-icon btn-ghost-secondary rounded-circle" id="navbarAppsDropdown" data-bs-toggle="dropdown"
              data-bs-dropdown-animation type="button" aria-expanded="false">
              <i class="bi-app-indicator"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless"
              aria-labelledby="navbarAppsDropdown" style="width: 25rem;">
              <div class="card">
                <!-- Header -->
                <div class="card-header">
                  <h4 class="card-title">Web apps &amp; services</h4>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body card-body-height">
                  <a class="dropdown-item" href="#">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <img class="avatar avatar-xs avatar-4x3" src="{{ Vite::asset('resources/svg/brands/atlassian-icon.svg') }}"
                          alt="Image Description">
                      </div>
                      <div class="flex-grow-1 text-truncate ms-3">
                        <h5 class="mb-0">Atlassian</h5>
                        <p class="card-text text-body">Security and control across Cloud</p>
                      </div>
                    </div>
                  </a>

                  <a class="dropdown-item" href="#">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <img class="avatar avatar-xs avatar-4x3" src="{{ Vite::asset('resources/svg/brands/slack-icon.svg') }}"
                          alt="Image Description">
                      </div>
                      <div class="flex-grow-1 text-truncate ms-3">
                        <h5 class="mb-0">Slack <span class="badge bg-primary rounded-pill text-uppercase ms-1">Try</span></h5>
                        <p class="card-text text-body">Email collaboration software</p>
                      </div>
                    </div>
                  </a>

                  <a class="dropdown-item" href="#">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <img class="avatar avatar-xs avatar-4x3" src="{{ Vite::asset('resources/svg/brands/google-webdev-icon.svg') }}"
                          alt="Image Description">
                      </div>
                      <div class="flex-grow-1 text-truncate ms-3">
                        <h5 class="mb-0">Google webdev</h5>
                        <p class="card-text text-body">Work involved in developing a website</p>
                      </div>
                    </div>
                  </a>

                  <a class="dropdown-item" href="#">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <img class="avatar avatar-xs avatar-4x3" src="{{ Vite::asset('resources/svg/brands/frontapp-icon.svg') }}"
                          alt="Image Description">
                      </div>
                      <div class="flex-grow-1 text-truncate ms-3">
                        <h5 class="mb-0">Frontapp</h5>
                        <p class="card-text text-body">The inbox for teams</p>
                      </div>
                    </div>
                  </a>

                  <a class="dropdown-item" href="#">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <img class="avatar avatar-xs avatar-4x3" src="{{ Vite::asset('resources/svg/illustrations/review-rating-shield.svg') }}"
                          alt="Image Description">
                      </div>
                      <div class="flex-grow-1 text-truncate ms-3">
                        <h5 class="mb-0">HS Support</h5>
                        <p class="card-text text-body">Customer service and support</p>
                      </div>
                    </div>
                  </a>

                  <a class="dropdown-item" href="#">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <div class="avatar avatar-sm avatar-soft-dark">
                          <span class="avatar-initials"><i class="bi-grid"></i></span>
                        </div>
                      </div>
                      <div class="flex-grow-1 text-truncate ms-3">
                        <h5 class="mb-0">More Front products</h5>
                        <p class="card-text text-body">Check out more HS products</p>
                      </div>
                    </div>
                  </a>
                </div>
                <!-- End Body -->

                <!-- Footer -->
                <a class="card-footer text-center" href="#">
                  View all apps <i class="bi-chevron-right"></i>
                </a>
                <!-- End Footer -->
              </div>
            </div>
          </div>
          <!-- End Apps -->
        </li>

        <li class="nav-item">
          <!-- Account -->
          <div class="dropdown">
            <a class="navbar-dropdown-account-wrapper" id="accountNavbarDropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside"
              data-bs-dropdown-animation href="#" aria-expanded="false">
              <div class="avatar avatar-sm avatar-circle">
                <img class="avatar-img" src="{{ Vite::asset('resources/img/uploads/user-avatar/default.jpg') }}" alt="User Image">
              </div>
            </a>

            <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account"
              aria-labelledby="accountNavbarDropdown" style="width: 16rem;">
              <div class="dropdown-item-text">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm avatar-circle">
                    <img class="avatar-img" src="{{ Vite::asset('resources/img/uploads/user-avatar/default.jpg') }}" alt="User Image">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h5 class="mb-0">Sample User</h5>
                    <p class="card-text text-body">sample@gmail.com</p>
                  </div>
                </div>
              </div>

              <div class="dropdown-divider"></div>

              <a class="dropdown-item" href="#">My Profile</a>
              <a class="dropdown-item" href="#">Account Settings</a>

              <!-- Dropdown -->
              <div class="dropdown">
                <a class="navbar-dropdown-submenu-item dropdown-item dropdown-toggle" id="selectThemeDropdown" data-bs-toggle="dropdown"
                  href="#" aria-expanded="false">System Appearance</a>

                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-sub-menu"
                  aria-labelledby="selectThemeDropdown">
                  <a class="dropdown-item" data-icon="bi-moon-stars" data-value="auto" href="#">
                    <i class="bi-moon-stars me-2"></i>
                    <span class="text-truncate" title="Auto (system default)">Auto (system default)</span>
                  </a>
                  <a class="dropdown-item" data-icon="bi-brightness-high" data-value="default" href="#">
                    <i class="bi-brightness-high me-2"></i>
                    <span class="text-truncate" title="Default (light mode)">Default (light mode)</span>
                  </a>
                  <a class="dropdown-item" data-icon="bi-moon" data-value="dark" href="#">
                    <i class="bi-moon me-2"></i>
                    <span class="text-truncate" title="Dark">Dark</span>
                  </a>
                </div>
              </div>
              <!-- End Dropdown -->

              <!-- Dropdown -->
              <div class="dropdown">
                <a class="navbar-dropdown-submenu-item dropdown-item dropdown-toggle" id="navSubmenuPagesAccountDropdown2"
                  data-bs-toggle="dropdown" href="javascript:" aria-expanded="false">Help & Support</a>

                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-sub-menu"
                  aria-labelledby="navSubmenuPagesAccountDropdown2">
                  <a class="dropdown-item" href="#">
                    <i class="bi-question-circle me-2"></i>
                    Need a Help?
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="bi-info-circle me-2"></i>
                    FAQ List
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="bi-flag me-2"></i>
                    Report a Problem
                  </a>
                </div>
              </div>
              <!-- End Dropdown -->

              <div class="dropdown-divider"></div>

              <a class="dropdown-item" href="#">Sign out</a>
            </div>
          </div>
          <!-- End Account -->
        </li>
      </ul>
      <!-- End Navbar -->
    </div>
  </div>
</header>
