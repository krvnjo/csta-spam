@extends('layouts.app')

@section('title')
  Users
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <div class="content container-fluid">
      <!-- Users Header -->
      <div class="page-header">
        <div class="row align-items-center">
          <div class="col-sm mb-2 mb-sm-0">
            <ol class="breadcrumb breadcrumb-no-gutter">
              <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item"><a class="breadcrumb-link">User Management</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
            <h1 class="page-header-title mt-2">Users</h1>
            <p class="page-header-text">Administer and manage user accounts and data.</p>
          </div>

          @can('create user management')
            <div class="col-sm-auto mt-sm-0 mt-3">
              <button class="btn btn-primary w-100 w-sm-auto" id="btnAddUserModal" data-bs-toggle="modal" data-bs-target="#modalAddUser">
                <i class="bi-plus-lg me-1"></i> Add User
              </button>
            </div>
          @endcan
        </div>
      </div>
      <!-- End Users Header -->

      <!-- Users Stats -->
      <div class="row">
        <!-- Total Users -->
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2">Total Users</h6>
              <div class="row align-items-center gx-2">
                <div class="col">
                  <span class="js-counter display-4 text-dark">{{ $totalUsers }}</span>
                  <span class="text-body fs-5 ms-1">from {{ $totalUsers }}</span>
                </div>
                <div class="col-auto">
                  <span class="icon icon-soft-secondary icon-sm icon-circle ms-3">
                    <i class="bi-people"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Total Users -->
      </div>
      <!-- End Users Stats -->

      <!-- Users DataTable Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>
              <input class="form-control" id="usersDatatableSearch" type="search" placeholder="Search">
            </div>
          </div>

          <div class="d-grid d-sm-flex justify-content-sm-center justify-content-md-end align-items-sm-center gap-2">
            @canAny('update user management, delete user management')
              <!-- DataTable Counter -->
              <div class="w-100 w-sm-auto" id="usersDatatableCounterInfo" style="display: none;">
                <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-2">
                  @can('update user management')
                    <button class="btn btn-sm btn-outline-secondary w-100 w-sm-auto" id="btnMultiSetUser" type="button">
                      <i class="bi-toggles me-1"></i> Set Status (<span class="fs-5"><span class="usersDatatableCounter"></span></span>)
                    </button>
                  @endcan

                  @can('delete user maintenance')
                    <button class="btn btn-sm btn-outline-danger w-100 w-sm-auto" id="btnMultiDeleteUser" type="button">
                      <i class="bi-trash3-fill"></i> Delete (<span class="fs-5"><span class="usersDatatableCounter"></span></span>)
                    </button>
                  @endcan
                </div>
              </div>
              <!-- End DataTable Counter -->
            @endcanAny

            <!-- Export Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" data-bs-toggle="dropdown" data-bs-auto-close="outside" type="button">
                <i class="bi-download me-2"></i> Export
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end w-100">
                <span class="dropdown-header">Options</span>
                <button class="dropdown-item" id="userExportCopy" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Copy Icon"> Copy
                </button>
                <button class="dropdown-item" id="userExportPrint" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Print Icon"> Print
                </button>
                <div class="dropdown-divider"></div>
                <span class="dropdown-header">Download</span>
                <button class="dropdown-item" id="userExportExcel" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Excel Icon"> Excel
                </button>
                <button class="dropdown-item" id="userExportPdf" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="PDF Icon"> PDF
                </button>
              </div>
            </div>
            <!-- End Export Dropdown -->

            <!-- Filter Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" data-bs-toggle="dropdown" data-bs-auto-close="outside" type="button">
                <i class="bi-filter me-2"></i> Filter <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="usersFilterCount"></span>
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end custom-dropdown">
                <div class="card">
                  <div class="card-header card-header-content-between">
                    <h5 class="card-header-title">User Filters</h5>
                  </div>
                  <div class="card-body">
                    <!-- Roles Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Roles</small>
                      <div class="row">
                        <div class="col">
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select" data-target-column-index="4"
                              data-hs-tom-select-options='{
                                "allowEmptyOption": true,
                                "hideSearch": true,
                                "placeholder": "All Roles"
                              }'>
                              <option value="">All Roles</option>
                              @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
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
                            <select class="js-select js-datatable-filter form-select" data-target-column-index="4"
                              data-hs-tom-select-options='{
                                "allowEmptyOption": true,
                                "hideSearch": true,
                                "placeholder": "All Departments"
                              }'>
                              <option value="">All Departments</option>
                              @foreach ($depts as $dept)
                                <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Departments Filter -->

                    <!-- Status Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Status</small>
                      <div class="row">
                        <div class="col">
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select" data-target-column-index="8"
                              data-hs-tom-select-options='{
                                "allowEmptyOption": true,
                                "hideSearch": true,
                                "placeholder": "All Status"
                              }'>
                              <option value="">All Status</option>
                              <option data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-success"></span>Active</span>' value="Active"></option>
                              <option data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-danger"></span>Inactive</span>' value="Inactive"></option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Status Filter -->
                  </div>
                </div>
              </div>
            </div>
            <!-- End Filter Dropdown -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="table-responsive datatable-custom">
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="usersDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                "targets": [0, 5, 9],
                "orderable": false
              }],
              "order": [7, "desc"],
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
                <th class="w-th">
                  @canAny('update user management, delete user management')
                    <input class="form-check-input" id="usersDatatableCheckAll" type="checkbox">
                  @else
                    #
                  @endcanAny
                </th>
                <th class="d-none"></th>
                <th>Name</th>
                <th>Username</th>
                <th>Role & Department</th>
                <th>Phone</th>
                <th>Date Created</th>
                <th>Last Updated</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($users as $index => $user)
                <tr>
                  <td>
                    @canAny('update user management, delete user management')
                      <input class="form-check-input" id="userCheck{{ $index + 1 }}" type="checkbox">
                    @else
                      {{ $index + 1 }}
                    @endcanAny
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
                  <td class="user-name">{{ $user->user_name }}</td>
                  <td data-full-value="{{ implode(', ', [$user->role->name, $user->department->name]) }}">
                    <span class="d-block h5 mb-0">{{ $user->role->name }}</span>
                    <span class="d-block fs-5">{{ $user->department->name }}</span>
                  </td>
                  <td>{{ $user->phone_num }}</td>
                  <td data-order="{{ $user->created_at }}"><span><i class="bi-calendar-plus me-1"></i> {{ $user->created_at->format('F d, Y') }}</span></td>
                  <td data-order="{{ $user->updated_at }}"><span><i class="bi-calendar2-event me-1"></i> Updated {{ $user->updated_at->diffForHumans() }}</span></td>
                  <td>
                    <span class="badge bg-soft-{{ $user->is_active ? 'success' : 'danger' }} text-{{ $user->is_active ? 'success' : 'danger' }}">
                      <span class="legend-indicator bg-{{ $user->is_active ? 'success' : 'danger' }}"></span>{{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <div class="btn-group position-static">
                      <button class="btn btn-white btn-sm btnViewUser" type="button"><i class="bi-eye"></i> View</button>
                      @canAny('update user management, delete user management')
                        <div class="btn-group position-static">
                          <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" data-bs-toggle="dropdown" type="button"></button>
                          <div class="dropdown-menu dropdown-menu-end mt-1">
                            @can('update user management')
                              <button class="dropdown-item btnEditUser" type="button">
                                <i class="bi-pencil-fill dropdown-item-icon"></i> Edit Record
                              </button>
                              <button class="dropdown-item btnSetUser" data-status="{{ $user->is_active ? 0 : 1 }}" type="button">
                                <i class="bi {{ $user->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                                {{ $user->is_active ? 'Set to Inactive' : 'Set to Active' }}
                              </button>
                              @can('delete user management')
                                <div class="dropdown-divider"></div>
                              @endcan
                            @endcan

                            @can('delete user management')
                              <button class="dropdown-item text-danger btnDeleteUser" type="button">
                                <i class="bi bi-trash3-fill dropdown-item-icon text-danger"></i> Delete
                              </button>
                            @endcan
                          </div>
                        </div>
                      @endcanAny
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- End Body -->

        <!-- Footer -->
        <div class="card-footer">
          <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
            <div class="col-sm mb-2 mb-sm-0">
              <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                <span class="me-2">Showing:</span>
                <div class="tom-select-custom tom-page-w">
                  <select class="js-select form-select form-select-borderless" id="usersDatatableEntries"
                    data-hs-tom-select-options='{
                      "hideSearch": true,
                      "searchInDropdown": false
                    }'>
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
      <!-- End Users DataTable Card -->
    </div>
  </main>
@endsection

@section('sec-content')
  <x-user-management.add-user :roles="$roles" :depts="$depts" />
  <x-user-management.view-user />
  <x-user-management.edit-user :roles="$roles" :depts="$depts" />
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/hs-counter/dist/hs-counter.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/appear/dist/appear.min.js') }}"></script>
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

  <!-- JS Plugins Initialization -->
  <script>
    // Initialization of Datatables
    $(document).on("ready", function() {
      HSCore.components.HSDatatables.init($("#usersDatatable"), {
        dom: "Bfrtip",
        buttons: [{
            extend: "copy",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(10))'
            }
          },
          {
            extend: "print",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(10))'
            }
          },
          {
            extend: "excel",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(10))'
            }
          },
          {
            extend: "pdf",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(10))'
            }
          }
        ],
        select: {
          style: "multi",
          selector: "td:first-child input[type=\"checkbox\"]",
          classMap: {
            checkAll: "#usersDatatableCheckAll",
            counter: ".usersDatatableCounter",
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

      $("#userExportCopy").click(function() {
        datatable.button(".buttons-copy").trigger();
      });

      $("#userExportPrint").click(function() {
        datatable.button(".buttons-print").trigger();
      });

      $("#userExportExcel").click(function() {
        datatable.button(".buttons-excel").trigger();
      });

      $("#userExportPdf").click(function() {
        datatable.button(".buttons-pdf").trigger();
      });

      $(".js-datatable-filter").on("change", function() {
        filterDatatableAndCount(datatable, "#usersFilterCount");
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


        // INITIALIZATION OF COUNTER
        // =======================================================
        new HSCounter('.js-counter')


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
        new HSTogglePassword('.js-toggle-password')
      };
    })();
  </script>
@endpush
