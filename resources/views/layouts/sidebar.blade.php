<aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered bg-white">
  <div class="navbar-vertical-container">
    <div class="navbar-vertical-footer-offset">
      <!-- Logo -->
      <a class="navbar-brand" data-route="dashboard.index" href="{{ route('dashboard.index') }}">
        <img class="navbar-brand-logo" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo.svg') }}" alt="CSTA - SPAM Logo">
        <img class="navbar-brand-logo" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo.svg') }}" alt="CSTA - SPAM Logo">
        <img class="navbar-brand-logo-mini" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo-short.svg') }}" alt="CSTA - SPAM Logo">
        <img class="navbar-brand-logo-mini" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo-short.svg') }}" alt="CSTA - SPAM Logo">
      </a>
      <!-- End Logo -->

      <!-- Sidebar Toggle -->
      <button class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler" type="button">
        <i class="bi-arrow-bar-left navbar-toggler-short-align"></i>
        <i class="bi-arrow-bar-right navbar-toggler-full-align"></i>
      </button>
      <!-- End Sidebar Toggle -->

      <!-- Sidebar -->
      <div class="navbar-vertical-content">
        <div class="nav nav-pills nav-vertical card-navbar-nav" id="navbarVerticalMenu">
          <!-- Dashboard -->
          <div class="nav-item">
            <a class="nav-link" data-placement="left" data-route="dashboard.index" href="{{ route('dashboard.index') }}">
              <i class="bi-house-door nav-icon"></i>
              <span class="nav-link-title">Dashboard</span>
            </a>
          </div>
          <!-- End Dashboard -->

          <!-- Main Menu -->
          <span class="dropdown-header mt-4">Main Menu</span>
          <small class="bi-three-dots nav-subtitle-replacer"></small>

          <div id="navbarVerticalMenuMainMenu">
            @access('Item Management', 'View Only, Read and Write, Full Access')
              <!-- Item Management -->
              <div class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesItemManagement">
                  <i class="bi-box-seam nav-icon"></i>
                  <span class="nav-link-title">Item Management</span>
                </a>

                <div class="nav-collapse collapse" id="navbarVerticalMenuPagesItemManagement" data-bs-parent="#navbarVerticalMenuMainMenu">
                  <a class="nav-link" data-route="prop-overview.index" href="{{ route('prop-overview.index') }}">Overview</a>
                  <a class="nav-link" data-route="prop-asset.index" href="{{ route('prop-asset.index') }}">Item Masterlist</a>
                </div>
              </div>
              <!-- End Item Management -->
            @endaccess

            @access('Borrow & Reservation', 'View Only, Read and Write, Full Access')
              <!-- Borrow & Reservation -->
              <div class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesBorrowReservation">
                  <i class="bi-calendar2-week nav-icon"></i>
                  <span class="nav-link-title">Borrow & Reservation</span>
                </a>

                <div class="nav-collapse collapse" id="navbarVerticalMenuPagesBorrowReservation" data-bs-parent="#navbarVerticalMenuMainMenu">
                  <a class="nav-link" data-route="" href="">Overview</a>
                </div>
              </div>
              <!-- End Borrow & Reservation -->
            @endaccess

            @access('Repair & Maintenance', 'View Only, Read and Write, Full Access')
              <!-- Repair & Maintenance -->
              <div class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesRepairMaintenance">
                  <i class="bi-tools nav-icon"></i>
                  <span class="nav-link-title">Repair & Maintenance</span>
                </a>

                <div class="nav-collapse collapse" id="navbarVerticalMenuPagesRepairMaintenance" data-bs-parent="#navbarVerticalMenuMainMenu">
                  <a class="nav-link" data-route="request.index" href="{{ route('request.index') }}">Ticket Requests</a>
                  <a class="nav-link" data-route="ongoing.index" href="{{ route('ongoing.index') }}">Ongoing Maintenance</a>
                  <a class="nav-link" data-route="history.index" href="{{ route('history.index') }}">Maintenance Logs</a>
                </div>
              </div>
              <!-- End Repair & Maintenance -->
            @endaccess

            {{--            @access('Analytics Reports', 'View Only, Read and Write, Full Access') --}}
            {{--              <!-- Analytics Reports --> --}}
            {{--              <div class="nav-item"> --}}
            {{--                <a class="nav-link" data-placement="left" href="#"> --}}
            {{--                  <i class="bi-clipboard-data nav-icon"></i> --}}
            {{--                  <span class="nav-link-title">Analytics Reports</span> --}}
            {{--                </a> --}}
            {{--              </div> --}}
            {{--              <!-- End Analytics Reports --> --}}
            {{--            @endaccess --}}
          </div>
          <!-- End Main Menu -->

          <!-- Others -->
          <span class="dropdown-header mt-4">Others</span>
          <small class="bi-three-dots nav-subtitle-replacer"></small>

          <div id="navbarVerticalMenuOthersMenu">
            @access('User Management', 'View Only, Read and Write, Full Access')
              <!-- User Management -->
              <div class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuUserManagement">
                  <i class="bi-people nav-icon"></i>
                  <span class="nav-link-title">User Management</span>
                </a>

                <div class="nav-collapse collapse" id="navbarVerticalMenuUserManagement" data-bs-parent="#navbarVerticalMenuOthersMenu">
                  <a class="nav-link" data-route="user.index" href="{{ route('user.index') }}">Users</a>
                  <a class="nav-link" data-route="role.index" href="{{ route('role.index') }}">Roles</a>
                </div>
              </div>
              <!-- End User Management -->
            @endaccess

            <!-- File Maintenance -->
            @access('File Maintenance', 'View Only, Read and Write, Full Access')
              <div class="nav-item">
                <div class="nav-item">
                  <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuFileMaintenance">
                    <i class="bi-folder2-open nav-icon"></i>
                    <span class="nav-link-title">File Maintenance</span>
                  </a>

                  <div class="nav-collapse collapse" id="navbarVerticalMenuFileMaintenance" data-bs-parent="#navbarVerticalMenuOthersMenu">
                    <a class="nav-link" data-route="brand.index" href="{{ route('brand.index') }}">Brands</a>
                    <a class="nav-link" data-route="category.index" href="{{ route('category.index') }}">Categories</a>
                    <a class="nav-link" data-route="department.index" href="{{ route('department.index') }}">Departments</a>
                    <a class="nav-link" data-route="designation.index" href="{{ route('designation.index') }}">Designations</a>
                    <a class="nav-link" data-route="requester.index" href="{{ route('requester.index') }}">Requesters</a>
                  </div>
                </div>
              </div>
            @endaccess
            <!-- End File Maintenance -->

            @access('Audit History', 'View Only, Read and Write, Full Access')
              <!-- Audit History -->
              <div class="nav-item">
                <a class="nav-link" data-placement="left" data-route="audit.index" href="{{ route('audit.index') }}">
                  <i class="bi-clock-history nav-icon"></i>
                  <span class="nav-link-title">Audit History</span>
                </a>
              </div>
              <!-- End Audit History -->
            @endaccess
          </div>
          <!-- End Others -->
        </div>
      </div>
      <!-- End Sidebar -->

      <!-- Footer -->
      <div class="navbar-vertical-footer">
        <ul class="navbar-vertical-footer-list">
          <!-- System Appearance -->
          <li class="navbar-vertical-footer-list-item">
            <div class="dropdown dropup">
              <button class="btn btn-ghost-secondary btn-icon rounded-circle" id="themeDropdown" data-bs-toggle="dropdown" data-bs-dropdown-animation type="button"></button>
              <div class="dropdown-menu navbar-dropdown-menu navbar-dropdown-menu-borderless  theme-dropdown">
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
          </li>
          <!-- End System Appearance -->

          <!-- Help Resources -->
          <li class="navbar-vertical-footer-list-item">
            <div class="dropdown dropup">
              <button class="btn btn-ghost-secondary btn-icon rounded-circle" id="helpResourcesDropdown" data-bs-toggle="dropdown" data-bs-dropdown-animation type="button">
                <i class="bi-info-circle"></i>
              </button>
              <div class="dropdown-menu navbar-dropdown-menu-borderless">
                <a class="dropdown-item" href="{{ route('help.about') }}"><i class="bi-question-circle me-2"></i>About Us</a>
                <a class="dropdown-item" href="{{ route('help.guide') }}"><i class="bi-journal-text me-2"></i>User Guide</a>
              </div>
            </div>
          </li>
          <!-- End Help Resources -->
        </ul>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</aside>
