<aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered bg-white">
  <div class="navbar-vertical-container">
    <div class="navbar-vertical-footer-offset">
      <!-- Logo -->
      <a class="navbar-brand" data-route="dashboard.index" href="{{ route('dashboard.index') }}" aria-label="CSTA - SPAM Logo">
        <img class="navbar-brand-logo" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo.svg') }}" alt="CSTA - SPAM Logo">
        <img class="navbar-brand-logo" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo.svg') }}"
          alt="CSTA - SPAM Logo">
        <img class="navbar-brand-logo-mini" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/logos/logo-short.svg') }}"
          alt="CSTA - SPAM Logo">
        <img class="navbar-brand-logo-mini" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/logos-light/logo-short.svg') }}"
          alt="CSTA - SPAM Logo">
      </a>
      <!-- End Logo -->

      <!-- Sidebar Toggle -->
      <button class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler" type="button">
        <i class="bi-arrow-bar-left navbar-toggler-short-align"
          data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'></i>
        <i class="bi-arrow-bar-right navbar-toggler-full-align"
          data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'></i>
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

          <div id="navbarVerticalMenuPagesMenu">
            <!-- Property and Assets -->
            <div class="nav-item">
              <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesPropertyAssets">
                <i class="bi-box-seam nav-icon"></i>
                <span class="nav-link-title">P&A Management</span>
              </a>

              <div class="nav-collapse collapse" id="navbarVerticalMenuPagesPropertyAssets" data-bs-parent="#navbarVerticalMenuPagesMenu">
                <a class="nav-link" href="/properties-assets/stocks">Stock Masterlist</a>
                <a class="nav-link" href="/properties-inventory/overview">Inventory Masterlist</a>
              </div>
            </div>
            <!-- End Property and Assets -->

            <!-- Borrowing and Reservation -->
            <div class="nav-item">
              <a class="nav-link" data-placement="left" href="#">
                <i class="bi-calendar2-week nav-icon"></i>
                <span class="nav-link-title">Borrow & Reservation</span>
              </a>
            </div>
            <!-- End Borrowing and Reservation -->

            <!-- Item Maintenance -->
            <div class="nav-item">
              <a class="nav-link" data-placement="left" href="#">
                <i class="bi-tools nav-icon"></i>
                <span class="nav-link-title">Item Maintenance</span>
              </a>
            </div>
            <!-- End Item Maintenance -->

            <!-- Reports & Analytics -->
            <div class="nav-item">
              <a class="nav-link" data-placement="left" href="#">
                <i class="bi-clipboard-data nav-icon"></i>
                <span class="nav-link-title">Reports & Analytics</span>
              </a>
            </div>
            <!-- End Reports & Analytics -->
          </div>
          <!-- End Main Menu -->

          <!-- Others -->
          <span class="dropdown-header mt-4">Others</span>
          <small class="bi-three-dots nav-subtitle-replacer"></small>

          <!-- User Management -->
          <div class="nav-item">
            <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuUserManagement">
              <i class="bi-people nav-icon"></i>
              <span class="nav-link-title">User Management</span>
            </a>

            <div class="nav-collapse collapse" id="navbarVerticalMenuUserManagement" data-bs-parent="#navbarVerticalMenu">
              <a class="nav-link" data-route="user.index" href="{{ route('user.index') }}">Users</a>
              <a class="nav-link" data-route="role.index" href="{{ route('role.index') }}">Roles</a>
            </div>
          </div>
          <!-- End User Management -->

          <!-- File Maintenance -->
          <div class="nav-item">
            <div class="nav-item">
              <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuFileMaintenance">
                <i class="bi-folder2-open nav-icon"></i>
                <span class="nav-link-title">File Maintenance</span>
              </a>

              <div class="nav-collapse collapse" id="navbarVerticalMenuFileMaintenance" data-bs-parent="#navbarVerticalMenu">
                <a class="nav-link" data-route="brand.index" href="{{ route('brand.index') }}">Brands</a>
                <a class="nav-link" data-route="category.index" href="{{ route('category.index') }}">Categories</a>
                <a class="nav-link" data-route="condition.index" href="{{ route('condition.index') }}">Conditions</a>
                <a class="nav-link" data-route="department.index" href="{{ route('department.index') }}">Departments</a>
                <a class="nav-link" data-route="designation.index" href="{{ route('designation.index') }}">Designations</a>
                <a class="nav-link" data-route="status.index" href="{{ route('status.index') }}">Statuses</a>
                <a class="nav-link" data-route="subcategory.index" href="{{ route('subcategory.index') }}">Subcategories</a>
              </div>
            </div>
          </div>
          <!-- End File Maintenance -->

          <!-- Activity History -->
          <div class="nav-item">
            <a class="nav-link" data-placement="left" href="#">
              <i class="bi-clock-history nav-icon"></i>
              <span class="nav-link-title">Activity History</span>
            </a>
          </div>
          <!-- End Activity History -->

          <!-- System Settings -->
          <div class="nav-item">
            <a class="nav-link" data-placement="left" href="#">
              <i class="bi-gear nav-icon"></i>
              <span class="nav-link-title">System Settings</span>
            </a>
          </div>
          <!-- End System Settings -->
          <!-- End Others -->
        </div>
      </div>
      <!-- End Sidebar -->

      <!-- Footer -->
      <div class="navbar-vertical-footer d-flex justify-content-center py-3">
        <div class="nav-item">
          <a class="nav-link" data-placement="left" href="#">
            <i class="bi-trash nav-icon"></i>
            <span class="nav-link-title">Recycle Bin</span>
          </a>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</aside>
