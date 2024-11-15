@extends('layouts.app')

@section('title')
  Ticket Request
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
  <link href="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <div class="content container-fluid">
      <!-- Ticket Requests Header -->
      <div class="page-header">
        <div class="row align-items-center">
          <div class="col-sm mb-2 mb-sm-0">
            <ol class="breadcrumb breadcrumb-no-gutter">
              <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item active">Repair & Maintenance</li>
            </ol>
            <h1 class="page-header-title">Ticket Requests</h1>
            <p class="page-header-text">Create and monitor repair and maintenance requests for approval.</p>
          </div>

          <div class="col-sm-auto mt-2 mt-sm-0">
            <button class="btn btn-primary w-100 w-sm-auto" id="btnAddRequestModal" data-bs-toggle="modal" data-bs-target="#modalAddRequest">
              <i class="bi-plus-lg me-1"></i> Create Ticket Request
            </button>
          </div>
        </div>
      </div>
      <!-- End Ticket Requests Header -->

      <!-- Requests DataTable Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>
              <input class="form-control" id="requestsDatatableSearch" type="search" placeholder="Search">
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
                <button class="dropdown-item" id="requestExportCopy" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Copy Icon"> Copy
                </button>
                <button class="dropdown-item" id="requestExportPrint" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Print Icon"> Print
                </button>
                <div class="dropdown-divider"></div>
                <span class="dropdown-header">Download</span>
                <button class="dropdown-item" id="requestExportExcel" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Excel Icon"> Excel
                </button>
                <button class="dropdown-item" id="requestExportPdf" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="PDF Icon"> PDF
                </button>
              </div>
            </div>
            <!-- End Export Dropdown -->

            <!-- Filter Collapse Trigger -->
            <a class="btn btn-white btn-sm dropdown-toggle" data-bs-toggle="collapse" href="#requestFilterSearchCollapse">
              <i class="bi-funnel me-1"></i> Filters <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="requestsFilterCount"></span>
            </a>
            <!-- End Filter Collapse Trigger -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Filter Search Collapse -->
        <div class="collapse" id="requestFilterSearchCollapse">
          <div class="card-body">
            <div class="row">
              <!-- Types -->
              <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="mb-3">
                  <label class="form-label" for="requestTypeFilter">Types</label>
                  <div class="tom-select-custom">
                    <select class="js-select js-datatable-filter form-select" id="requestTypeFilter" data-target-column-index="2"
                      data-hs-tom-select-options='{
                        "allowEmptyOption": true,
                        "hideSearch": true,
                        "placeholder": "All Types"
                      }'>
                      <option value="">All Types</option>
                      <option value="Repair">Repair</option>
                      <option value="Maintenance">Maintenance</option>
                    </select>
                  </div>
                </div>
              </div>
              <!-- End Types -->

              <!-- Priorities -->
              <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="mb-3">
                  <label class="form-label" for="requestPriorityFilter">Priorities</label>
                  <div class="tom-select-custom">
                    <select class="js-select js-datatable-filter form-select" id="requestPriorityFilter" data-target-column-index="5"
                      data-hs-tom-select-options='{
                        "singleMultiple": true,
                        "hideSearch": true,
                        "hideSelected": false,
                        "placeholder": "All Priorities"
                      }'
                      multiple>
                      @foreach ($priorities as $priority)
                        <option data-option-template='<span class="d-flex align-items-center"><span class="{{ $priority->color->class }}"></span>{{ $priority->name }}</span>'
                          value="{{ $priority->name }}">
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <!-- End Priorities -->

              <!-- Users -->
              <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="mb-3">
                  <label class="form-label" for="requestUserFilter">Users</label>
                  <div class="tom-select-custom">
                    <select class="js-select js-datatable-filter form-select" id="requestUserFilter" data-target-column-index="5"
                      data-hs-tom-select-options='{
                        "singleMultiple": true,
                        "hideSelected": false,
                        "placeholder": "All Users"
                      }'
                      autocomplete="off" multiple>
                      @foreach ($users as $user)
                        <option
                          data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="{{ asset('storage/img/user-images/' . $user->user_image) }}" alt="User Image" /><span class="text-truncate">{{ $user->name }}</span></span>'
                          value="{{ $user->name }}">{{ $user->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <!-- End Users -->

              <!-- Date Range -->
              <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="mb-3">
                  <label class="form-label" for="requestDateRangeFilter">Date Range</label>
                  <input class="js-daterangepicker-clear js-datatable-filter form-control daterangepicker-custom-input" data-target-column-index="6"
                    data-hs-daterangepicker-options='{
                      "autoUpdateInput": false,
                      "locale": {
                        "cancelLabel": "Clear"
                      }
                    }'
                    type="text" placeholder="Select date range">
                </div>
              </div>
              <!-- End Date Range -->
            </div>
          </div>
        </div>
        <!-- End Filter Search Collapse -->

        <!-- Body -->
        <div class="table-responsive datatable-custom">
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="requestsDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                 "targets": [3, 7],
                 "orderable": false
               }],
              "order": [6, "desc"],
              "info": {
                "totalQty": "#requestsDatatableWithPagination"
              },
              "search": "#requestsDatatableSearch",
              "entries": "#requestsDatatableEntries",
              "pageLength": 10,
              "isResponsive": false,
              "isShowPaging": false,
              "pagination": "requestsDatatablePagination"
            }'>
            <thead class="thead-light">
              <tr>
                <th class="w-th" style="width: 7%;">#</th>
                <th class="d-none"></th>
                <th>Ticket No.</th>
                <th>Name</th>
                <th>Type & Priority</th>
                <th>Total Cost</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
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
                  <select class="js-select form-select form-select-borderless" id="requestsDatatableEntries"
                    data-hs-tom-select-options='{
                      "hideSearch": true,
                      "searchInDropdown": false
                    }'>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                  </select>
                </div>
                <span class="text-secondary me-2">of</span>
                <span id="requestsDatatableWithPagination"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>
            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <nav id="requestsDatatablePagination"></nav>
              </div>
            </div>
          </div>
        </div>
        <!-- End Footer -->
      </div>
      <!-- End Requests DataTable Card -->
    </div>
  </main>
@endsection

@section('sec-content')
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/tom-select/dist/js/tom-select.complete.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/moment.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.js') }}"></script>
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
  <script src="{{ Vite::asset('resources/js/modules/repair-maintenance/request.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    // Initialization of DataTable
    $(document).on("ready", function() {
      HSCore.components.HSDaterangepicker.init('.js-daterangepicker-clear');

      const daterangepickerClear = $('.js-daterangepicker-clear');

      daterangepickerClear.on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        filterDatatableAndCount(requestsDatatable, "#requestsFilterCount");
      });

      daterangepickerClear.on('cancel.daterangepicker', function() {
        $(this).val('');
        filterDatatableAndCount(requestsDatatable, "#requestsFilterCount");
      });

      HSCore.components.HSDatatables.init($("#requestsDatatable"), {
        dom: "Bfrtip",
        buttons: [{
            extend: "copy",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(5)):not(:nth-child(7))'
            }
          },
          {
            extend: "print",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(5)):not(:nth-child(7))'
            }
          },
          {
            extend: "excel",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(5)):not(:nth-child(7))'
            }
          },
          {
            extend: "pdf",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(5)):not(:nth-child(7))'
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

      const requestsDatatable = HSCore.components.HSDatatables.getItem(0);

      const exportButtons = {
        "#requestExportCopy": ".buttons-copy",
        "#requestExportPrint": ".buttons-print",
        "#requestExportExcel": ".buttons-excel",
        "#requestExportPdf": ".buttons-pdf"
      };

      $.each(exportButtons, function(exportId, exportClass) {
        $(exportId).click(function() {
          requestsDatatable.button(exportClass).trigger();
        });
      });

      $(".js-datatable-filter").on("change", function() {
        filterDatatableAndCount(requestsDatatable, "#requestsFilterCount");
      });
    });

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
        HSBsDropdown.init();


        // INITIALIZATION OF SELECT
        // =======================================================
        HSCore.components.HSTomSelect.init(".js-select");
      };
    })();
  </script>
@endpush
