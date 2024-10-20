@extends('layouts.app')

@section('title')
  Users
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <!-- Content -->
    <div class="content container-fluid">
      <!-- Page Header -->
      <div class="page-header">
        <div class="row align-items-end">
          <div class="col-sm mb-2 mb-sm-0">
            <nav>
              <ol class="breadcrumb breadcrumb-no-gutter">
                <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="breadcrumb-link">User Management</a></li>
                <li class="breadcrumb-item active">Users</li>
              </ol>
            </nav>
            <h1 class="page-header-title mt-2">Users</h1>
          </div>

          @can('create user management')
            <div class="col-sm-auto mt-sm-0 mt-3">
              <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                <button class="btn btn-primary w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#modalAddUser">
                  <i class="bi-plus me-1"></i> Add User
                </button>
              </div>
            </div>
          @endcan
        </div>
      </div>
      <!-- End Page Header -->

      <!-- Datatable Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <!-- Datatable Search -->
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>
              <input class="form-control" id="usersDatatableSearch" type="search" placeholder="Search">
            </div>
            <!-- End Datatable Search -->
          </div>

          <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
            @can('delete user management')
              <!-- Datatable Counter -->
              <div id="usersDatatableCounterInfo" style="display: none;">
                <div class="d-flex align-items-center">
                  <span class="fs-5 me-3"><span id="usersDatatableCounter"></span> Selected</span>
                  <button class="btn btn-outline-danger btn-sm" id="btnMultiDeleteUser" type="button"><i class="bi-trash3-fill"></i> Delete</button>
                </div>
              </div>
              <!-- End Datatable Counter -->
            @endcan

            <!-- Export Options Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" data-bs-toggle="dropdown" type="button">
                <i class="bi-download me-2"></i> Export
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end">
                <span class="dropdown-header">Options</span>
                <button class="dropdown-item" id="export-copy" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Copy Icon"> Copy
                </button>
                <button class="dropdown-item" id="export-print" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Print Icon"> Print
                </button>
                <div class="dropdown-divider"></div>
                <span class="dropdown-header">Download</span>
                <button class="dropdown-item" id="export-excel" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Excel Icon"> Excel
                </button>
                <button class="dropdown-item" id="export-pdf" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="PDF Icon"> PDF
                </button>
              </div>
            </div>
            <!-- End Export Options Dropdown -->

            <!-- Datatable Filter Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm w-100" data-bs-toggle="dropdown" type="button">
                <i class="bi-filter me-1"></i> Filter <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="userFilterCount"></span>
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered w-100" style="min-width: 22rem;">
                <div class="card">
                  <div class="card-header card-header-content-between">
                    <h5 class="card-header-title">User Filters</h5>
                    <button class="btn btn-ghost-secondary btn-icon btn-sm ms-2" type="button"><i class="bi-x-lg"></i></button>
                  </div>

                  <div class="card-body">
                    <!-- Roles Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Roles</small>
                      <div class="row">
                        <div class="col">
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select form-select-sm" data-target-column-index="4"
                              data-hs-tom-select-options='{
                                "allowEmptyOption": true,
                                "placeholder": "All Roles",
                                "hideSearch": true,
                                "dropdownWidth": "100%"
                              }'>
                              <option value="">All Roles</option>
                              @foreach ($roles as $name)
                                <option value="{{ $name }}">{{ $name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Roles Filter -->

                    <!-- Departments Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Departments</small>
                      <div class="row">
                        <div class="col">
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select form-select-sm" data-target-column-index="4"
                              data-hs-tom-select-options='{
                                "allowEmptyOption": true,
                                "placeholder": "All Departments",
                                "hideSearch": true,
                                "dropdownWidth": "100%"
                              }'>
                              <option value="">All Departments</option>
                              @foreach ($depts as $name)
                                <option value="{{ $name }}">{{ $name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Departments Filter -->

                    <!-- Active and Inactive Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Status</small>
                      <div class="row">
                        <div class="col">
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select form-select-sm" data-target-column-index="7"
                              data-hs-tom-select-options='{
                                "allowEmptyOption": true,
                                "placeholder": "All Status",
                                "hideSearch": true,
                                "dropdownWidth": "100%"
                              }'>
                              <option value="">All Status</option>
                              <option data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-success"></span>Active</span>' value="Active"></option>
                              <option data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-danger"></span>Inactive</span>' value="Inactive"></option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Active and Inactive Filter -->
                  </div>
                </div>
              </div>
            </div>
            <!-- End Datatable Filter Dropdown -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Users Datatable -->
        <div class="table-responsive datatable-custom">
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="usersDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                 "targets": [0, 5, 8],
                 "orderable": false
               }],
              "order": [6, "desc"],
              "info": {
                "totalQty": "#usersDatatableWithPagination"
              },
              "search": "#usersDatatableSearch",
              "entries": "#usersDatatableEntries",
              "pageLength": 5,
              "isResponsive": false,
              "isShowPaging": false,
              "pagination": "usersDatatablePagination"
            }'>
            <thead class="thead-light">
              <tr>
                <th>
                  @can('delete user management')
                    <div class="form-check">
                      <input class="form-check-input" id="usersDatatableCheckAll" type="checkbox">
                      <label class="form-check-label" for="usersDatatableCheckAll"></label>
                    </div>
                  @else
                    #
                  @endcan
                </th>
                <th class="d-none">User Id</th>
                <th>Name</th>
                <th>Username</th>
                <th>Role & Department</th>
                <th>Phone</th>
                <th>Date Updated</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($users as $index => $user)
                <tr>
                  <td>
                    @can('delete user management')
                      <div class="form-check">
                        <input class="form-check-input" id="userCheck{{ $index + 1 }}" type="checkbox">
                        <label class="form-check-label" for="userCheck{{ $index + 1 }}"></label>
                      </div>
                    @else
                      {{ $index + 1 }}
                    @endcan
                  </td>
                  <td class="d-none" data-user-id="{{ Crypt::encryptString($user->id) }}"></td>
                  <td>
                    <a class="d-flex align-items-center btnViewUser">
                      <div class="avatar avatar-circle"><img class="avatar-img" src="{{ asset('storage/img/user-images/' . $user->user_image) }}" alt="User Image"></div>
                      <div class="ms-3">
                        <span class="d-block h5 text-inherit mb-0">{{ $user->fname . ' ' . $user->lname }}</span>
                        <span class="d-block fs-5 text-body">{{ $user->email }}</span>
                      </div>
                    </a>
                  </td>
                  <td>{{ $user->user_name }}</td>
                  <td>
                    <span class="d-block h5 mb-0">{{ $user->role->name }}</span>
                    <span class="d-block fs-5">{{ $user->department->name }}</span>
                  </td>
                  <td>{{ $user->phone_num }}</td>
                  <td data-order="{{ $user->updated_at }}"><span><i class="bi-calendar-event me-1"></i> Updated {{ $user->updated_at->diffForHumans() }}</span></td>
                  <td>
                    <span class="badge bg-soft-{{ $user->is_active ? 'success' : 'danger' }} text-{{ $user->is_active ? 'success' : 'danger' }}">
                      <span class="legend-indicator bg-{{ $user->is_active ? 'success' : 'danger' }}"></span>{{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-white btn-sm btnViewUser" type="button"><i class="bi-eye"></i> View</button>

                      @can('update user management' || 'delete user management')
                        <div class="btn-group">
                          <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" data-bs-toggle="dropdown" type="button"></button>
                          <div class="dropdown-menu dropdown-menu-end mt-1">
                            @can('update user management')
                              <button class="dropdown-item btnEditUser" type="button"><i class="bi-pencil-fill dropdown-item-icon"></i> Edit Record</button>
                              <button class="dropdown-item btnStatusBrand" data-status="{{ $user->is_active ? 0 : 1 }}" type="button">
                                <i class="bi {{ $user->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                                {{ $user->is_active ? 'Set to Inactive' : 'Set to Active' }}
                              </button>
                              @can('delete user management')
                                <div class="dropdown-divider"></div>
                              @endcan
                            @endcan

                            @can('delete user management')
                              <button class="dropdown-item text-danger btnDeleteUser" type="button"><i class="bi-trash3-fill dropdown-item-icon text-danger"></i> Delete</button>
                            @endcan
                          </div>
                        </div>
                      @endcan
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- End User Table -->

        <!-- Footer -->
        <div class="card-footer">
          <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
            <div class="col-sm mb-2 mb-sm-0">
              <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                <span class="me-2">Showing:</span>
                <div class="tom-select-custom tom-page-w">
                  <select class="js-select form-select form-select-borderless" id="usersDatatableEntries"
                    data-hs-tom-select-options='{
                      "searchInDropdown": false,
                      "hideSearch": true
                    }' autocomplete="off">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="{{ $totalUsers }}">All</option>
                  </select>
                </div>
                <span class="text-secondary me-2">of</span>
                <span id="usersDatatableWithPagination"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>

            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <nav id="usersDatatablePagination"></nav>
              </div>
            </div>
          </div>
        </div>
        <!-- End Footer -->
      </div>
      <!-- End Datatable Card -->
    </div>
    <!-- End Content -->
  </main>
@endsection

@section('sec-content')
  <x-user-management.add-user :roles="$roles" :depts="$depts" />
  <x-user-management.view-user />
  <x-user-management.edit-user :roles="$roles" :depts="$depts" />
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/tom-select/dist/js/tom-select.complete.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-file-attach/dist/hs-file-attach.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/imask/dist/imask.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-toggle-password/dist/js/hs-toggle-password.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/datatables.net.extensions/select/select.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/jszip/dist/jszip.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/pdfmake/build/pdfmake.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/pdfmake/build/vfs_fonts.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/user-management/user-crud.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Init. -->
  <script>
    // Initialization of Datatables
    $(document).on("ready", function() {
      HSCore.components.HSDatatables.init($("#usersDatatable"), {
        dom: "Bfrtip",
        buttons: [{
            extend: "copy",
            className: "d-none"
          },
          {
            extend: "excel",
            className: "d-none"
          },
          {
            extend: "pdf",
            className: "d-none"
          },
          {
            extend: "print",
            className: "d-none"
          }
        ],
        select: {
          style: "multi",
          selector: "td:first-child input[type=\"checkbox\"]",
          classMap: {
            checkAll: "#usersDatatableCheckAll",
            counter: "#usersDatatableCounter",
            counterInfo: "#usersDatatableCounterInfo"
          }
        },
        language: {
          zeroRecords: `<div class="text-center p-4">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-error.svg') }}" alt="No records to display." style="width: 10rem;" data-hs-theme-appearance="default">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations-light/oc-error.svg') }}" alt="No records to display." style="width: 10rem;" data-hs-theme-appearance="dark">
            <p class="mb-0">No records to display.</p>
            </div>`
        }
      });

      const datatable = HSCore.components.HSDatatables.getItem(0);

      $("#export-copy").click(function() {
        datatable.button(".buttons-copy").trigger();
      });

      $("#export-excel").click(function() {
        datatable.button(".buttons-excel").trigger();
      });

      $("#export-pdf").click(function() {
        datatable.button(".buttons-pdf").trigger();
      });

      $("#export-print").click(function() {
        datatable.button(".buttons-print").trigger();
      });

      $(".js-datatable-filter").on("change", function() {
        let $this = $(this);
        let elVal = $this.val() === "null" ? "" : $this.val();
        let targetColumnIndex = $this.data("target-column-index");

        elVal = elVal.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");

        datatable.column(targetColumnIndex).search(elVal, true, false, false).draw();

        updateFilterCountBadge($("#userFilterCount"));
      });
    });

    // Initialization of Other Plugins
    (function() {
      window.onload = function() {
        // INITIALIZATION OF NAVBAR VERTICAL ASIDE
        // =======================================================
        new HSSideNav(".js-navbar-vertical-aside").init();


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        new HSFormSearch(".js-form-search");


        // INITIALIZATION OF BOOTSTRAP DROPDOWN
        // =======================================================
        HSBsDropdown.init();


        // INITIALIZATION OF SELECT
        // =======================================================
        HSCore.components.HSTomSelect.init(".js-select");


        // INITIALIZATION OF FILE ATTACHMENT
        // =======================================================
        new HSFileAttach('.js-file-attach');


        // INITIALIZATION OF INPUT MASK
        // =======================================================
        HSCore.components.HSMask.init('.js-input-mask');


        // INITIALIZATION OF TOGGLE PASSWORD
        // =======================================================
        new HSTogglePassword('.js-toggle-password');
      };
    })();
  </script>
@endpush
