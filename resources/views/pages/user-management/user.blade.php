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
            <h1 class="page-header-title">Users</h1>
            <p class="page-header-text">Administer and manage user accounts and data.</p>
          </div>

          @access('User Management', 'Read and Write, Full Access')
            <div class="col-sm-auto mt-2 mt-sm-0">
              <button class="btn btn-primary w-100 w-sm-auto" id="btnAddUserModal" data-bs-toggle="modal" data-bs-target="#modalAddUser">
                <i class="bi-plus-lg me-1"></i> Add User
              </button>
            </div>
          @endaccess
        </div>
      </div>
      <!-- End Users Header -->

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
                      <div class="tom-select-custom">
                        <select class="js-select js-datatable-filter form-select" data-target-column-index="3"
                          data-hs-tom-select-options='{
                            "hideSearch": true,
                            "hideSelected": false,
                            "placeholder": "All Roles",
                            "singleMultiple": true
                          }'
                          multiple>
                          @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <!-- End Roles Filter -->

                    <!-- Departments Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Departments</small>
                      <div class="tom-select-custom">
                        <select class="js-select js-datatable-filter form-select" data-target-column-index="3"
                          data-hs-tom-select-options='{
                            "hideSearch": true,
                            "hideSelected": false,
                            "placeholder": "All Departments",
                            "singleMultiple": true
                          }'
                          multiple>
                          @foreach ($departments as $department)
                            <option value="{{ $department->name }}">{{ $department->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <!-- End Departments Filter -->

                    <!-- Status Filter -->
                    <div class="mb-2">
                      <small class="text-cap text-body">Status</small>
                      <div class="tom-select-custom">
                        <select class="js-select js-datatable-filter form-select" data-target-column-index="7"
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
                "targets": [0, 4, 8],
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
                <th class="w-th" style="width: 5%;">#</th>
                <th class="d-none"></th>
                <th>Name</th>
                <th>Role & Department</th>
                <th>Contacts</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                @php
                  $userExportData = $users->map(function ($user) {
                      return [
                          'Username' => $user->user_name,
                          'First Name' => $user->fname,
                          'Middle Name' => $user->mname,
                          'Last Name' => $user->lname,
                          'Role' => $user->role->name,
                          'Department' => $user->department->name,
                          'Email' => $user->email,
                          'Phone' => $user->phone_num ?? 'N/A',
                          'Status' => $user->is_active ? 'Active' : 'Inactive',
                      ];
                  });
                @endphp
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td class="d-none" data-user-id="{{ Crypt::encryptString($user->id) }}"></td>
                  <td data-order="{{ $user->lname }}">
                    <a class="d-flex align-items-center btnViewUser">
                      <div class="avatar avatar-circle"><img class="avatar-img" src="{{ asset('storage/img/user-images/' . $user->user_image) }}" alt="User Image"></div>
                      <div class="ms-3">
                        <span class="d-block h5 text-inherit mb-0">{{ $user->name }}</span>
                        <span class="d-block fs-5 text-body user-name">{{ $user->user_name }}</span>
                      </div>
                    </a>
                  </td>
                  <td data-full-value="{{ implode(', ', [$user->role->name, $user->department->name]) }}">
                    <span class="d-block h5 mb-0">{{ $user->role->name }}</span>
                    <span class="d-block fs-5">{{ $user->department->name }}</span>
                  </td>
                  <td>
                    <span class="d-block h5 mb-0">{{ $user->email }}</span>
                    <span class="d-block fs-5">{{ $user->phone_num ?? 'N/A' }}</span>
                  </td>
                  <td data-order="{{ $user->created_at }}">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->created_at->format('D, M d, Y | g:i A') }}">
                      <i class="bi-calendar-plus me-1"></i>
                      {{ $user->created_at->format('F d, Y') }}
                    </span>
                  </td>
                  <td data-order="{{ $user->updated_at }}">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->updated_at->format('D, M d, Y | g:i A') }}">
                      <i class="bi-calendar2-event me-1"></i> Updated
                      {{ $user->updated_at->diffForHumans() }}
                    </span>
                  </td>
                  <td>
                    <span class="badge bg-soft-{{ $user->is_active ? 'success' : 'danger' }} text-{{ $user->is_active ? 'success' : 'danger' }}">
                      <span class="legend-indicator bg-{{ $user->is_active ? 'success' : 'danger' }}"></span>{{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <div class="btn-group position-static">
                      <button class="btn btn-white btn-sm btnViewUser" type="button"><i class="bi-eye"></i> View</button>

                      @access('User Management', 'Read and Write, Full Access')
                        <div class="btn-group position-static">
                          <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" data-bs-toggle="dropdown" type="button"></button>
                          <div class="dropdown-menu dropdown-menu-end mt-1">
                            <button class="dropdown-item btnEditUser" type="button">
                              <i class="bi-pencil-fill dropdown-item-icon"></i> Edit Record
                            </button>

                            @if (Auth::user()->id !== $user->id)
                              <button class="dropdown-item btnSetUser" data-status="{{ $user->is_active ? 0 : 1 }}" type="button">
                                <i class="bi {{ $user->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                                {{ $user->is_active ? 'Set to Inactive' : 'Set to Active' }}
                              </button>
                              @access('User Management', 'Full Access')
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-danger btnDeleteUser" type="button">
                                  <i class="bi bi-trash3-fill dropdown-item-icon text-danger"></i> Delete
                                </button>
                              @endaccess
                            @endif
                          </div>
                        </div>
                      @endaccess
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
  <x-user-management.add-user :roles="$roles" :departments="$departments" />
  <x-user-management.view-user />
  <x-user-management.edit-user :roles="$roles" :departments="$departments" />
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
  <script src="{{ Vite::asset('resources/js/modules/user-management/user.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    // Initialization of DataTable
    $(document).on("ready", function() {
      let userExportData = @json($userExportData);

      HSCore.components.HSDatatables.init($("#usersDatatable"), {
        dom: "Bfrtip",
        buttons: [{
            extend: "copy",
            className: "d-none",
            exportOptions: {
              columns: [2, 3, 4, 5, 7]
            }
          },
          {
            extend: "print",
            className: "d-none",
            exportOptions: {
              columns: [2, 3, 4, 5, 7]
            }
          },
          {
            extend: "excel",
            className: "d-none",
            filename: "User List - CSTA-SPAM",
            exportOptions: {
              columns: [2, 3, 4, 5, 7]
            },
            customize: function(xlsx) {
              const sheet = xlsx.xl.worksheets['sheet1.xml'];

              // Add column headers with "No." column added before "Username"
              const columnHeaders = `
            <row>
              <c t="inlineStr"><is><t>No.</t></is></c>
              <c t="inlineStr"><is><t>Username</t></is></c>
              <c t="inlineStr"><is><t>First Name</t></is></c>
              <c t="inlineStr"><is><t>Middle Name</t></is></c>
              <c t="inlineStr"><is><t>Last Name</t></is></c>
              <c t="inlineStr"><is><t>Role</t></is></c>
              <c t="inlineStr"><is><t>Department</t></is></c>
              <c t="inlineStr"><is><t>Email</t></is></c>
              <c t="inlineStr"><is><t>Phone</t></is></c>
              <c t="inlineStr"><is><t>Status</t></is></c>
            </row>
          `;

              // Add data rows dynamically, adding the row number for "No." column
              let rows = '';
              userExportData.forEach(function(user, index) {
                rows += `
              <row>
                <c t="inlineStr"><is><t>${index + 1}</t></is></c>
                <c t="inlineStr"><is><t>${user['Username']}</t></is></c>
                <c t="inlineStr"><is><t>${user['First Name']}</t></is></c>
                <c t="inlineStr"><is><t>${user['Middle Name']}</t></is></c>
                <c t="inlineStr"><is><t>${user['Last Name']}</t></is></c>
                <c t="inlineStr"><is><t>${user['Role']}</t></is></c>
                <c t="inlineStr"><is><t>${user['Department']}</t></is></c>
                <c t="inlineStr"><is><t>${user['Email']}</t></is></c>
                <c t="inlineStr"><is><t>${user['Phone']}</t></is></c>
                <c t="inlineStr"><is><t>${user['Status']}</t></is></c>
              </row>
            `;
              });

              // Inject into the sheet
              $(sheet).find("sheetData").html(columnHeaders + rows);

              // Adjust column widths (adjust as needed based on your data)
              const colWidths = [{
                  col: 1,
                  width: 5
                }, // No.
                {
                  col: 2,
                  width: 20
                }, // Username
                {
                  col: 3,
                  width: 20
                }, // First Name
                {
                  col: 4,
                  width: 20
                }, // Middle Name
                {
                  col: 5,
                  width: 20
                }, // Last Name
                {
                  col: 6,
                  width: 20
                }, // Role
                {
                  col: 7,
                  width: 25
                }, // Department
                {
                  col: 8,
                  width: 30
                }, // Email
                {
                  col: 9,
                  width: 20
                }, // Phone
                {
                  col: 10,
                  width: 20
                } // Status
              ];

              // Set column width
              colWidths.forEach(function(item) {
                $(sheet).find(`cols col:nth-child(${item.col})`).attr('width', item.width);
              });
            },
          },
          {
            extend: "pdf",
            className: "d-none",
            filename: "User List - CSTA-SPAM",
            exportOptions: {
              columns: [2, 3, 4, 5, 7]
            },
          },
          {
            extend: "pdf",
            className: "d-none",
            filename: "User List - CSTA-SPAM",
            exportOptions: {
              columns: [2, 3, 4, 5, 7]
            },
          },
        ],
        language: {
          zeroRecords: `<div class="text-center p-4">
            <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-error.svg') }}" alt="No records to display." style="width: 10rem;" data-hs-theme-appearance="default">
            <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations-light/oc-error.svg') }}" alt="No records to display." style="width: 10rem;" data-hs-theme-appearance="dark">
            <p class="mb-0">No records to display.</p>
          </div>`
        }
      });

      const usersDatatable = HSCore.components.HSDatatables.getItem(0);

      $("#userExportCopy, #userExportPrint, #userExportExcel, #userExportPdf").on("click", function() {
        const exportClass = `.buttons-${this.id.replace("userExport", "").toLowerCase()}`;
        usersDatatable.button(exportClass).trigger();
      });

      $(".js-datatable-filter").on("change", function() {
        filterDatatableAndCount(usersDatatable, "#usersFilterCount");
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
        new HSTogglePassword('.js-toggle-password')
      };
    })();
  </script>
@endpush
