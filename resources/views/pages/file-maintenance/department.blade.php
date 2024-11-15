@extends('layouts.app')

@section('title')
  Departments
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <div class="content container-fluid">
      <!-- Departments Header -->
      <div class="page-header">
        <div class="row align-items-center">
          <div class="col-sm mb-2 mb-sm-0">
            <ol class="breadcrumb breadcrumb-no-gutter">
              <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item"><a class="breadcrumb-link">File Maintenance</a></li>
              <li class="breadcrumb-item active">Departments</li>
            </ol>
            <h1 class="page-header-title">Departments</h1>
            <p class="page-header-text">Manage and organize department records.</p>
          </div>

          @access('File Maintenance', 'Read and Write, Full Access')
            <div class="col-sm-auto mt-2 mt-sm-0">
              <button class="btn btn-primary w-100 w-sm-auto" id="btnAddDepartmentModal" data-bs-toggle="modal" data-bs-target="#modalAddDepartment">
                <i class="bi-plus-lg me-1"></i> Add Department
              </button>
            </div>
          @endaccess
        </div>
      </div>
      <!-- End Departments Header -->

      <!-- Departments Details Card -->
      <div class="card mb-5">
        <div class="card-body">
          <div class="d-flex flex-column flex-sm-row align-items-sm-center text-sm-start text-center">
            <div class="flex-shrink-0"><span class="display-3 text-dark">{{ $totalDepartments }}</span></div>
            <div class="flex-grow-1 ms-sm-3 my-1 mt-sm-0">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5">
                  <span class="d-block">Total Departments</span>
                  <span class="badge bg-soft-primary text-primary rounded-pill p-1">
                    <i class="bi-{{ $unusedDepartments == 0 ? 'check-circle-fill' : 'trash-fill' }} me-1"></i>
                    {{ $unusedDepartments == 0 ? 'Everything looks great!' : "$unusedDepartments unused record(s) can be deleted." }}
                  </span>
                </div>

                <div class="col-lg-9 col-md-8 col-sm-7 mt-3 mt-sm-0">
                  <div class="d-flex justify-content-center justify-content-sm-start mb-2">
                    <div class="me-2"><span class="legend-indicator bg-success"></span>Active ({{ $activeDepartments }})</div>
                    <div class="ms-2"><span class="legend-indicator bg-danger"></span>Inactive ({{ $inactiveDepartments }})</div>
                  </div>
                  <div class="progress rounded-pill">
                    <div class="progress-bar bg-success" style="width: {{ $activePercentage }}%"></div>
                    <div class="progress-bar bg-danger" style="width: {{ $inactivePercentage }}%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Departments Details Card -->

      <!-- Departments DataTable Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>
              <input class="form-control" id="departmentsDatatableSearch" type="search" placeholder="Search">
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
                <button class="dropdown-item" id="departmentExportCopy" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Copy Icon"> Copy
                </button>
                <button class="dropdown-item" id="departmentExportPrint" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Print Icon"> Print
                </button>
                <div class="dropdown-divider"></div>
                <span class="dropdown-header">Download</span>
                <button class="dropdown-item" id="departmentExportExcel" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Excel Icon"> Excel
                </button>
                <button class="dropdown-item" id="departmentExportPdf" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="PDF Icon"> PDF
                </button>
              </div>
            </div>
            <!-- End Export Dropdown -->

            <!-- Filter Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" data-bs-toggle="dropdown" data-bs-auto-close="outside" type="button">
                <i class="bi-filter me-2"></i> Filter <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="departmentsFilterCount"></span>
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end custom-dropdown">
                <div class="card">
                  <div class="card-header card-header-content-between">
                    <h5 class="card-header-title">Department Filters</h5>
                  </div>
                  <div class="card-body">
                    <!-- Status Filter -->
                    <div class="mb-2">
                      <small class="text-cap text-body">Status</small>
                      <div class="row">
                        <div class="col">
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select" data-target-column-index="6"
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
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="departmentsDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                "targets": [0, 7],
                "orderable": false
              }],
              "order": [5, "desc"],
              "info": {
                "totalQty": "#departmentsDatatableWithPagination"
              },
              "search": "#departmentsDatatableSearch",
              "entries": "#departmentsDatatableEntries",
              "pageLength": 5,
              "isResponsive": false,
              "isShowPaging": false,
              "pagination": "departmentsDatatablePagination"
            }'>
            <thead class="thead-light">
              <tr>
                <th class="w-th" style="width: 8%">#</th>
                <th class="d-none"></th>
                <th>Department Name</th>
                <th>Department Code</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($departments as $department)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td class="d-none" data-department-id="{{ Crypt::encryptString($department->id) }}"></td>
                  <td><a class="h5 btnViewDepartment">{{ $department->name }}</a></td>
                  <td>{{ $department->code }}</td>
                  <td data-order="{{ $department->created_at }}">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $department->created_at->format('D, M d, Y | h:i A') }}">
                      <i class="bi-calendar-plus me-1"></i> {{ $department->created_at->format('F d, Y') }}
                    </span>
                  </td>
                  <td data-order="{{ $department->updated_at }}">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $department->updated_at->format('D, M d, Y | h:i A') }}">
                      <i class="bi-calendar2-event me-1"></i> Updated {{ $department->updated_at->diffForHumans() }}
                    </span>
                  </td>
                  <td>
                    <span class="badge bg-soft-{{ $department->is_active ? 'success' : 'danger' }} text-{{ $department->is_active ? 'success' : 'danger' }}">
                      <span class="legend-indicator bg-{{ $department->is_active ? 'success' : 'danger' }}"></span>{{ $department->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <div class="btn-group position-static">
                      <button class="btn btn-white btn-sm btnViewDepartment" type="button"><i class="bi-eye"></i> View</button>

                      @access('File Maintenance', 'Read and Write, Full Access')
                        <div class="btn-group position-static">
                          <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" data-bs-toggle="dropdown" type="button"></button>
                          <div class="dropdown-menu dropdown-menu-end mt-1">
                            <button class="dropdown-item btnEditDepartment" type="button">
                              <i class="bi-pencil-fill dropdown-item-icon"></i> Edit Record
                            </button>
                            <button class="dropdown-item btnSetDepartment" data-status="{{ $department->is_active ? 0 : 1 }}" type="button">
                              <i class="bi {{ $department->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                              {{ $department->is_active ? 'Set to Inactive' : 'Set to Active' }}
                            </button>

                            @access('File Maintenance', 'Full Access')
                              <div class="dropdown-divider"></div>
                              <button class="dropdown-item text-danger btnDeleteDepartment" type="button">
                                <i class="bi bi-trash3-fill dropdown-item-icon text-danger"></i> Delete
                              </button>
                            @endaccess
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
                  <select class="js-select form-select form-select-borderless" id="departmentsDatatableEntries"
                    data-hs-tom-select-options='{
                      "hideSearch": true,
                      "searchInDropdown": false
                    }'>
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="{{ $totalDepartments }}">All</option>
                  </select>
                </div>
                <span class="text-secondary me-2">of</span>
                <span id="departmentsDatatableWithPagination"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>
            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <nav id="departmentsDatatablePagination"></nav>
              </div>
            </div>
          </div>
        </div>
        <!-- End Footer -->
      </div>
      <!-- End Departments DataTable Card -->
    </div>
  </main>
@endsection

@section('sec-content')
  <x-file-maintenance.add-department />
  <x-file-maintenance.view-department />
  <x-file-maintenance.edit-department />
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/tom-select/dist/js/tom-select.complete.min.js') }}"></script>
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
  <script src="{{ Vite::asset('resources/js/modules/file-maintenance/department-crud.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    // Initialization of Datatable
    $(document).on("ready", function() {
      HSCore.components.HSDatatables.init($("#departmentsDatatable"), {
        dom: "Bfrtip",
        buttons: [{
            extend: "copy",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(6)):not(:nth-child(8))'
            }
          },
          {
            extend: "print",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(6)):not(:nth-child(8))'
            }
          },
          {
            extend: "excel",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(6)):not(:nth-child(8))'
            }
          },
          {
            extend: "pdf",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(6)):not(:nth-child(8))'
            }
          }
        ],
        language: {
          zeroRecords: `<div class="text-center p-4">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-error.svg') }}" alt="No records to display." style="width: 10rem;" data-hs-theme-appearance="default">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations-light/oc-error.svg') }}" alt="No records to display." style="width: 10rem;" data-hs-theme-appearance="dark">
            <p class="mb-0">No records to display.</p>
          </div>`
        }
      });

      const departmentsDatatable = HSCore.components.HSDatatables.getItem(0);

      const exportButtons = {
        "#departmentExportCopy": ".buttons-copy",
        "#departmentExportPrint": ".buttons-print",
        "#departmentExportExcel": ".buttons-excel",
        "#departmentExportPdf": ".buttons-pdf"
      };

      $.each(exportButtons, function(exportId, exportClass) {
        $(exportId).click(function() {
          departmentsDatatable.button(exportClass).trigger();
        });
      });

      $(".js-datatable-filter").on("change", function() {
        filterDatatableAndCount(departmentsDatatable, "#departmentsFilterCount");
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
        HSBsDropdown.init()


        // INITIALIZATION OF SELECT
        // =======================================================
        HSCore.components.HSTomSelect.init(".js-select");
      };
    })();
  </script>
@endpush
