@extends('layouts.app')

@section('title')
  Roles
@endsection

@push('styles')
  {{-- Styles --}}
@endpush

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
                <li class="breadcrumb-item"><a class="breadcrumb-link">User Management</a></li>
                <li class="breadcrumb-item active">Roles</li>
              </ol>
            </nav>
            <h1 class="page-header-title mt-2">Roles</h1>
          </div>

          <div class="col-sm-auto mt-sm-0 mt-3">
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
              <button class="btn btn-primary w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#modalAddRole">
                <i class="bi-plus me-1"></i> Add Role
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Page Header -->
      <!-- Tab Content -->
      <div class="tab-content" id="rolesTabContent">
        <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
          <!-- Roles -->
          <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3">
            @foreach ($roles as $index => $role)
              <div class="col mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                  <div class="card-progress-wrap">
                    <div class="progress card-progress">
                      <div class="progress-bar {{ $role->is_active == 1 ? 'bg-success' : 'bg-danger' }}" style="width: 100%"></div>
                    </div>
                  </div>
                  <!-- Body -->
                  <div class="card-body pb-0">
                    <div class="row align-items-center mb-2">
                      <div class="col-9">
                        <h3 class="mb-1"><a class="text-dark btnViewRole" href="#">{{ $role->name }}</a></h3>
                      </div>

                      <div class="col-3 text-end">
                        <div class="dropdown">
                          <button class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="roleDropdown{{ $index + 1 }}"
                            data-bs-toggle="dropdown" type="button"><i class="bi-three-dots-vertical"></i>
                          </button>

                          <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                            <button class="dropdown-item btnViewRole" type="button">
                              <i class="bi-eye-fill dropdown-item-icon"></i> View Record
                            </button>
                            <button class="dropdown-item btnEditRole" type="button">
                              <i class="bi-pencil-fill dropdown-item-icon"></i> Edit Record
                            </button>
                            @if ($role->is_active)
                              <button class="dropdown-item btnStatusRole" data-status="0" type="button">
                                <i class="bi-x-circle-fill dropdown-item-icon text-danger fs-7"></i> Set to Inactive
                              </button>
                            @else
                              <button class="dropdown-item btnStatusRole" data-status="1" type="button">
                                <i class="bi-check-circle-fill dropdown-item-icon text-success"></i> Set to Active
                              </button>
                            @endif
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item text-danger btnDeleteRole" type="button">
                              <i class="bi-trash3-fill dropdown-item-icon text-danger"></i> Delete
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p>{{ $role->description }}</p>

                    @php
                      $permissionsToShow = $role->permissions->take(5);
                      $remainingPermissionsCount = $role->permissions->count() - 5;
                    @endphp

                    <ul class="list-pointer list-pointer-primary">
                      @foreach ($permissionsToShow as $permission)
                        <li class="list-pointer-item">{{ $permission->name }}</li>
                      @endforeach

                      @if ($remainingPermissionsCount > 0)
                        <li class="list-pointer-item">and {{ $remainingPermissionsCount }} more...</li>
                      @endif
                    </ul>
                  </div>
                  <!-- End Body -->

                  <!-- Footer -->
                  <div class="card-footer border-0 pt-0">
                    <div class="list-group list-group-flush list-group-no-gutters">
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col pt-1">
                            <span class="card-subtitle">Permissions:</span>
                          </div>

                          <div class="col-auto">
                            @if ($role->permissions->count() > 0)
                              <span class="badge bg-soft-dark text-dark p-2">
                                {{ $role->permissions->count() }} permissions assigned to this role
                              </span>
                            @else
                              <span class="badge bg-soft-dark text-dark p-2">No permissions assigned</span>
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col pt-1">
                            <span class="card-subtitle">Users:</span>
                          </div>
                          <div class="col-auto">
                            <div class="avatar-group avatar-group-xs avatar-circle">
                              @if ($role->users->isEmpty())
                                <span class="badge bg-soft-dark text-dark">No users assigned to this role</span>
                              @else
                                @php
                                  $maxDisplay = 5;
                                  $additionalUsers = $role->users->count() - $maxDisplay;
                                @endphp

                                @foreach ($role->users->take($maxDisplay) as $user)
                                  <span class="avatar" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="{{ $user->fname . ' ' . $user->lname }}">
                                    <img class="avatar-img" src="{{ Vite::asset('resources/img/uploads/user-images/' . $user->user_image) }}"
                                      alt="User Image">
                                  </span>
                                @endforeach

                                @if ($additionalUsers > 0)
                                  <span class="avatar avatar-light avatar-circle">
                                    <span class="avatar-initials">+{{ $additionalUsers }}</span>
                                  </span>
                                @endif
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Footer -->
                </div>
                <!-- End Card -->
              </div>
            @endforeach
          </div>
          <!-- End Roles -->
        </div>
      </div>
      <!-- End Tab Content -->
    </div>
    </div>
    </div>
    <!-- End Content -->
  </main>
@endsection

@section('sub-content')
  {{-- Sub Content --}}
@endsection

@push('scripts')
  {{-- Scripts --}}

  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/user-management/role-crud.js') }}"></script>

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
      }
    })()
  </script>
@endpush
