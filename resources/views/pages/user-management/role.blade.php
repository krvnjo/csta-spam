@extends('layouts.app')

@section('title')
  Roles
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <div class="content container-fluid">
      <!-- Roles Header -->
      <div class="page-header">
        <div class="row align-items-center">
          <div class="col-sm mb-2 mb-sm-0">
            <ol class="breadcrumb breadcrumb-no-gutter">
              <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item"><a class="breadcrumb-link">User Management</a></li>
              <li class="breadcrumb-item active">Roles</li>
            </ol>
            <h1 class="page-header-title">Roles</h1>
            <p class="page-header-text">Manage and control user roles and permissions.</p>
          </div>

          @can('create role management')
            <div class="col-sm-auto mt-2 mt-sm-0">
              <button class="btn btn-primary w-100 w-sm-auto" id="btnAddRoleModal" data-bs-toggle="modal" data-bs-target="#modalAddRole">
                <i class="bi-plus-lg me-1"></i> Add Role
              </button>
            </div>
          @endcan
        </div>
      </div>
      <!-- End Roles Header -->

      <!-- Roles -->
      <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3">
        @foreach ($roles as $role)
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
                    <span class="d-none" data-role-id="{{ Crypt::encryptString($role->id) }}"></span>
                    <h3 class="mb-1"><a class="text-dark btnViewRole">{{ $role->name }}</a></h3>
                  </div>
                  @canAny('update role management, delete role management')
                    <div class="col-3 text-end">
                      <div class="dropdown">
                        <button class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="roleDropdown{{ $loop->iteration }}" data-bs-toggle="dropdown" type="button"><i
                            class="bi-three-dots-vertical"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                          <button class="dropdown-item btnViewRole" type="button">
                            <i class="bi-eye-fill dropdown-item-icon"></i> View Record
                          </button>
                          @can('update role management')
                            <button class="dropdown-item btnEditRole" type="button">
                              <i class="bi-pencil-fill dropdown-item-icon"></i> Edit Record
                            </button>
                          @endcan
                          @if (Auth::user()->role_id !== $role->id)
                            @can('update role management')
                              <button class="dropdown-item btnSetRole" data-status="{{ $role->is_active ? 0 : 1 }}" type="button">
                                <i class="bi {{ $role->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                                {{ $role->is_active ? 'Set to Inactive' : 'Set to Active' }}
                              </button>
                              @can('delete role management')
                                <div class="dropdown-divider"></div>
                              @endcan
                            @endcan

                            @can('delete role management')
                              <button class="dropdown-item text-danger btnDeleteRole" type="button">
                                <i class="bi-trash3-fill dropdown-item-icon text-danger"></i> Delete
                              </button>
                            @endcan
                          @endif
                        </div>
                      </div>
                    </div>
                  @endcanAny
                </div>
                <p>{{ $role->description }}</p>
                @php
                  $actionLabels = [
                      'view' => 'View',
                      'create' => 'Create',
                      'update' => 'Edit',
                      'delete' => 'Delete',
                  ];

                  $groupedPermissions = [];
                  foreach ($role->permissions as $permission) {
                      $parts = explode(' ', $permission->name, 2);
                      $action = $parts[0];
                      $baseName = $parts[1] ?? '';

                      $displayAction = $actionLabels[$action] ?? ucfirst($action);
                      $groupedPermissions[$baseName][] = $displayAction;
                  }

                  $groupedPermissions = array_slice($groupedPermissions, 0, 5, true);

                  $remainingPermissionsCount =
                      count(
                          $role->permissions->groupBy(function ($perm) {
                              return explode(' ', $perm->name, 2)[1] ?? '';
                          }),
                      ) - 5;
                @endphp

                <ul class="list-pointer list-pointer-primary">
                  @foreach ($groupedPermissions as $baseName => $actions)
                    @php
                      $formattedBaseName = ucwords(strtolower($baseName));
                      $uniqueActions = array_unique($actions);
                      $actionsText = implode(', ', array_slice($uniqueActions, 0, -1)) . (count($uniqueActions) > 1 ? ', and ' : '') . end($uniqueActions);
                    @endphp
                    <li class="list-pointer-item">{{ $formattedBaseName }}: {{ $actionsText }}</li>
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
                              <span class="avatar" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $user->fname . ' ' . $user->lname }}">
                                <img class="avatar-img" src="{{ asset('storage/img/user-images/' . $user->user_image) }}" alt="User Image">
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
  </main>
@endsection

@section('sec-content')
  <x-user-management.add-role :permissions="$permissions" />
  <x-user-management.view-role />
  <x-user-management.edit-role :permissions="$permissions" />
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/hs-count-characters/dist/js/hs-count-characters.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/tom-select/dist/js/tom-select.complete.min.js') }}"></script>

  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/user-management/role-crud.js') }}"></script>

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


        // INITIALIZATION OF COUNT CHARACTERS
        // =======================================================
        new HSCountCharacters('.js-count-characters')
      }
    })()
  </script>
@endpush
