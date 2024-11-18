<header class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-container navbar-bordered bg-white" id="header">
  <div class="navbar-nav-wrap">
    <!-- Logo -->
    <a class="navbar-brand" data-route="dashboard.index" href="{{ route('dashboard.index') }}">
      <img class="navbar-brand-logo d-none d-sm-inline-block" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo.svg') }}" alt="CSTA - SPAM Logo">
      <img class="navbar-brand-logo d-none d-sm-inline-block" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo.svg') }}" alt="CSTA - SPAM Logo">
      <img class="navbar-brand-logo-mini d-inline-block d-sm-none" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo-short.svg') }}" alt="CSTA - SPAM Logo">
      <img class="navbar-brand-logo-mini d-inline-block d-sm-none" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo-short.svg') }}" alt="CSTA - SPAM Logo">
    </a>
    <!-- End Logo -->

    <div class="navbar-nav-wrap-content-start">
      <!-- Sidebar Toggle -->
      <button class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler" type="button">
        <i class="bi-arrow-bar-left navbar-toggler-short-align"></i>
        <i class="bi-arrow-bar-right navbar-toggler-full-align"></i>
      </button>
      <!-- End Sidebar Toggle -->

      <!-- Search Input Group -->
      <div class="d-none d-md-block">
        <form class="position-relative" id="docsSearch"
          data-hs-list-options='{
              "searchMenu": true,
              "keyboard": true,
              "item": "searchTemplate",
              "valueNames": ["component", "category", {"name": "link", "attr": "href"}],
              "empty": "#searchNoResults"
            }'>
          <!-- Input Group -->
          <div class="input-group input-group-merge navbar-input-group">
            <div class="input-group-prepend input-group-text">
              <i class="bi-search"></i>
            </div>
            <input class="search form-control form-control-sm" type="search" placeholder="Search in CSTA-SPAM">
            <a class="input-group-append input-group-text" href="javascript:"><i class="bi-x" id="clearSearchResultsIcon" style="display: none;"></i></a>
          </div>
          <!-- End Input Group -->

          <!-- List -->
          <div class="list dropdown-menu navbar-dropdown-menu-borderless w-100 overflow-auto" style="max-height: 16rem;"></div>
          <!-- End List -->

          <!-- Empty -->
          <div id="searchNoResults" style="display: none;">
            <div class="text-center p-4">
              <img class="mb-3" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/illustrations/oc-error.svg') }}" alt="Image Description" style="width: 7rem;">
              <img class="mb-3" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/illustrations-light/oc-error.svg') }}" alt="Image Description" style="width: 7rem;">
              <p class="mb-0">No Results</p>
            </div>
          </div>
          <!-- End Empty -->
        </form>

        <div class="d-none">
          <div class="dropdown-item" id="searchTemplate">
            <a class="d-block link" href="#">
              <span class="category d-block fw-normal text-muted mb-1"></span>
              <span class="component text-dark"></span>
            </a>
          </div>
        </div>
      </div>
      <!-- End Search Input Group -->
    </div>

    <div class="navbar-nav-wrap-content-end">
      <ul class="navbar-nav">
        {{--        <!-- Notification --> --}}
        {{--        <li class="nav-item d-sm-inline-block"> --}}
        {{--          <div class="dropdown"> --}}
        {{--            <button class="btn btn-ghost-secondary btn-icon rounded-circle" id="navbarNotificationsDropdown" data-bs-toggle="dropdown" data-bs-dropdown-animation type="button"> --}}
        {{--              <i class="bi-bell"></i> --}}
        {{--              <span class="btn-status btn-sm-status btn-status-danger"></span> --}}
        {{--            </button> --}}

        {{--            <div class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless" style="width: 25rem;"> --}}
        {{--              <div class="card"> --}}
        {{--                <!-- Header --> --}}
        {{--                <div class="card-header card-header-content-between"> --}}
        {{--                  <h4 class="card-title mb-0">Notifications</h4> --}}
        {{--                </div> --}}
        {{--                <!-- End Header --> --}}

        {{--                <!-- Body --> --}}
        {{--                <div class="card-body-height"> --}}
        {{--                  <div class="tab-content" id="notificationTabContent"> --}}
        {{--                    <div class="tab-pane fade show active" id="notificationNavOne"> --}}
        {{--                      <ul class="list-group list-group-flush navbar-card-list-group"> --}}
        {{--                        <!-- Item --> --}}
        {{--                        <li class="list-group-item form-check-select"> --}}
        {{--                          <div class="row"> --}}
        {{--                            <div class="col-auto"> --}}
        {{--                              <div class="d-flex align-items-center"> --}}
        {{--                                <div class="form-check"> --}}
        {{--                                  <input class="form-check-input" id="notificationCheck1" type="checkbox" value="" checked> --}}
        {{--                                  <label class="form-check-label" for="notificationCheck1"></label> --}}
        {{--                                  <span class="form-check-stretched-bg"></span> --}}
        {{--                                </div> --}}
        {{--                                <img class="avatar avatar-sm avatar-circle" src="{{ Vite::asset('resources/img/160x160/img3.jpg') }}" alt="Image Description"> --}}
        {{--                              </div> --}}
        {{--                            </div> --}}
        {{--                            <div class="col ms-n2"> --}}
        {{--                              <h5 class="mb-1">Brian Warner</h5> --}}
        {{--                              <p class="text-body fs-5">changed an issue from "In Progress" to <span class="badge bg-success">Review</span></p> --}}
        {{--                            </div> --}}
        {{--                            <small class="col-auto text-muted text-cap">2hr</small> --}}
        {{--                          </div> --}}
        {{--                          <a class="stretched-link" href="#"></a> --}}
        {{--                        </li> --}}
        {{--                        <!-- End Item --> --}}

        {{--                        <!-- Item --> --}}
        {{--                        <li class="list-group-item form-check-select"> --}}
        {{--                          <div class="row"> --}}
        {{--                            <div class="col-auto"> --}}
        {{--                              <div class="d-flex align-items-center"> --}}
        {{--                                <div class="form-check"> --}}
        {{--                                  <input class="form-check-input" id="notificationCheck3" type="checkbox" value="" checked> --}}
        {{--                                  <label class="form-check-label" for="notificationCheck3"></label> --}}
        {{--                                  <span class="form-check-stretched-bg"></span> --}}
        {{--                                </div> --}}
        {{--                                <div class="avatar avatar-sm avatar-circle"> --}}
        {{--                                  <img class="avatar-img" src="{{ Vite::asset('resources/img/160x160/img10.jpg') }}" alt="Image Description"> --}}
        {{--                                </div> --}}
        {{--                              </div> --}}
        {{--                            </div> --}}
        {{--                            <div class="col ms-n2"> --}}
        {{--                              <h5 class="mb-1">Ruby Walter</h5> --}}
        {{--                              <p class="text-body fs-5">joined the Slack group HS Team</p> --}}
        {{--                            </div> --}}
        {{--                            <small class="col-auto text-muted text-cap">3dy</small> --}}
        {{--                          </div> --}}
        {{--                          <a class="stretched-link" href="#"></a> --}}
        {{--                        </li> --}}
        {{--                        <!-- End Item --> --}}

        {{--                        <!-- Item --> --}}
        {{--                        <li class="list-group-item form-check-select"> --}}
        {{--                          <div class="row"> --}}
        {{--                            <div class="col-auto"> --}}
        {{--                              <div class="d-flex align-items-center"> --}}
        {{--                                <div class="form-check"> --}}
        {{--                                  <input class="form-check-input" id="notificationCheck4" type="checkbox" value=""> --}}
        {{--                                  <label class="form-check-label" for="notificationCheck4"></label> --}}
        {{--                                  <span class="form-check-stretched-bg"></span> --}}
        {{--                                </div> --}}
        {{--                                <div class="avatar avatar-sm avatar-circle"> --}}
        {{--                                  <img class="avatar-img" src="{{ Vite::asset('resources/svg/brands/google-icon.svg') }}" alt="Image Description"> --}}
        {{--                                </div> --}}
        {{--                              </div> --}}
        {{--                            </div> --}}
        {{--                            <div class="col ms-n2"> --}}
        {{--                              <h5 class="mb-1">from Google</h5> --}}
        {{--                              <p class="text-body fs-5">Start using forms to capture the information of prospects visiting your Google website</p> --}}
        {{--                            </div> --}}
        {{--                            <small class="col-auto text-muted text-cap">17dy</small> --}}
        {{--                          </div> --}}
        {{--                          <a class="stretched-link" href="#"></a> --}}
        {{--                        </li> --}}
        {{--                        <!-- End Item --> --}}
        {{--                      </ul> --}}
        {{--                    </div> --}}
        {{--                  </div> --}}
        {{--                </div> --}}
        {{--                <!-- End Body --> --}}

        {{--                <!-- Card Footer --> --}}
        {{--                <a class="card-footer text-center" href="#">View all notifications <i class="bi-chevron-right"></i></a> --}}
        {{--                <!-- End Card Footer --> --}}
        {{--              </div> --}}
        {{--            </div> --}}
        {{--          </div> --}}
        {{--        </li> --}}
        {{--        <!-- End Notification --> --}}

        <!-- Account -->
        <li class="nav-item">
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

              {{--              <!-- Help Resources --> --}}
              {{--              <div class="dropdown"> --}}
              {{--                <button class="navbar-dropdown-submenu-item dropdown-item dropdown-toggle" id="helpResourcesDropdown" data-bs-toggle="dropdown" data-bs-dropdown-animation type="button"> --}}
              {{--                  Help Resources --}}
              {{--                </button> --}}
              {{--                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-sub-menu"> --}}
              {{--                  <a class="dropdown-item" href="{{ route('help.about') }}"><i class="bi-question-circle me-2"></i>About Us</a> --}}
              {{--                  <a class="dropdown-item" href="{{ route('help.guide') }}"><i class="bi-journal-text me-2"></i>User Guide</a> --}}
              {{--                </div> --}}
              {{--              </div> --}}
              {{--              <!-- End Help Resources --> --}}

              <div class="dropdown-divider"></div>

              <!-- Log Out -->
              <form id="frmLogoutUser" method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button class="dropdown-item" form="frmLogoutUser" type="submit">Log Out</button>
              </form>
              <!-- End Log Out -->
            </div>
          </div>
        </li>
        <!-- End Account -->
      </ul>
    </div>
  </div>
</header>
