@extends('layouts.app')

@section('title')
  Ticket Requests
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
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
              <li class="breadcrumb-item"><a class="breadcrumb-link">Repair & Maintenance</a></li>
              <li class="breadcrumb-item active">Ticket Requests</li>
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

            <!-- Filter Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" data-bs-toggle="dropdown" data-bs-auto-close="outside" type="button">
                <i class="bi-filter me-2"></i> Filter <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="requestsFilterCount"></span>
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end custom-dropdown">
                <div class="card">
                  <div class="card-header card-header-content-between">
                    <h5 class="card-header-title">Ticket Request Filters</h5>
                  </div>
                  <div class="card-body">
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
                          @foreach ($progresses as $progress)
                            <option data-option-template='<span class="d-flex align-items-center"><span class="{{ $progress->legend->class }}"></span>{{ $progress->name }}</span>'
                              value="{{ $progress->name }}">
                            </option>
                          @endforeach
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
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="requestsDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                 "targets": [3, 4, 8],
                 "orderable": false
               }],
              "order": [6, "asc"],
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
                <th class="w-th" style="width: 5%;">#</th>
                <th class="d-none"></th>
                <th>Ticket No.</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Estimated Cost</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($tickets as $ticket)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td class="d-none" data-request-id="{{ Crypt::encryptString($ticket->id) }}"></td>
                  <td><a class="h5 btnViewRequest">{{ $ticket->ticket_num }}</a></td>
                  <td class="request-name">{{ $ticket->name }}</td>
                  <td>{{ Str::limit($ticket->description, 30, '...') }}</td>
                  <td class="text-end">
                    <strong>₱{{ number_format($ticket->cost, 2) }}</strong>
                  </td>
                  <td data-order="{{ $ticket->created_at }}">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $ticket->created_at->format('D, M d, Y | h:i A') }}">
                      <i class="bi-calendar-plus me-1"></i> {{ $ticket->created_at->format('F d, Y') }}
                    </span>
                  </td>
                  <td>
                    <span class="{{ $ticket->progress->badge->class }}">
                      <span class="{{ $ticket->progress->legend->class }}"></span>{{ $ticket->progress->name }}
                    </span>
                  </td>
                  <td>
                    <div class="btn-group position-static">
                      <button class="btn btn-white btn-sm btnViewRequest" type="button"><i class="bi-eye"></i> View</button>

                      @access('Repair & Maintenance', 'Read and Write, Full Access')
                        <div class="btn-group position-static">
                          <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" data-bs-toggle="dropdown" type="button"></button>
                          <div class="dropdown-menu dropdown-menu-end mt-1">
                            @if ($ticket->prog_id == 1)
                              <button class="dropdown-item btnSetStatus" data-status="2" type="button">
                                <i class="bi bi-check-circle-fill text-success dropdown-item-icon fs-7"></i> Approve Request
                              </button>
                              <div class="dropdown-divider"></div>
                              <button class="dropdown-item btnEditRequest" type="button">
                                <i class="bi-pencil-fill dropdown-item-icon"></i> Edit Request
                              </button>

                              @access('Repair & Maintenance', 'Full Access')
                                <button class="dropdown-item text-danger btnDeleteRequest" type="button">
                                  <i class="bi bi-trash3-fill dropdown-item-icon text-danger"></i> Delete
                                </button>
                              @endaccess
                            @else
                              <button class="dropdown-item btnSetStatus" data-status="4" type="button">
                                <i class="bi bi-play-circle-fill text-primary dropdown-item-icon fs-7"></i> Start Request
                              </button>
                              <button class="dropdown-item btnSetStatus" data-status="1" type="button">
                                <i class="bi bi-x-circle-fill text-danger dropdown-item-icon fs-7"></i> Cancel Request
                              </button>
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
  <x-repair-maintenance.add-request :items="$items" />
  <x-repair-maintenance.view-request />
  <x-repair-maintenance.edit-request :items="$items" />
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
  <script src="{{ Vite::asset('resources/js/modules/repair-maintenance/request.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    // Initialization of DataTable
    $(document).on("ready", function() {
      HSCore.components.HSDatatables.init($("#requestsDatatable"), {
        dom: "Bfrtip",
        buttons: [{
            extend: "copy",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(9))'
            }
          },
          {
            extend: "print",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(9))'
            }
          },
          {
            extend: "excel",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(9))'
            }
          },
          {
            extend: "pdf",
            className: "d-none",
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(9))'
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
