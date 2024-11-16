@extends('layouts.app')

@section('title')
   New Requests
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
  <link href="{{ Vite::asset('resources/vendor/jsvectormap/dist/css/jsvectormap.min.css') }}" rel="stylesheet">
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
              <li class="breadcrumb-item active">Borrow & Reservation</li>
            </ol>
            <h1 class="page-header-title">New Request</h1>
            <p class="page-header-text">Create and monitor borrow and reservation requests for approval.</p>
          </div>

          <div class="col-sm-auto mt-2 mt-sm-0">
            <button class="btn btn-primary w-100 w-sm-auto" id="btnAddRequestModal" data-bs-toggle="modal" data-bs-target="#modalAddRequest">
              <i class="bi-plus-lg me-1"></i> Create Request
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
              <!-- Priorities -->
              <div class="col-sm-12 col-md-4">
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
              <div class="col-sm-12 col-md-4">
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
              <div class="col-sm-12 col-md-4">
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
                 "targets": [3, 6, 9],
                 "orderable": false
               }],
              "order": [7, "desc"],
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
              <th>Description</th>
              <th>Estimated Cost</th>
              <th>Priority</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($tickets as $ticket)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="d-none" data-brand-id="{{ Crypt::encryptString($ticket->id) }}"></td>
                <td><a class="h5 btnViewRequest">{{ $ticket->name }}</a></td>
                <td>
                  {{ Str::limit($ticket->description, 50, '...') }}
                </td>
                <td class="text-end">
                  @php
                    $purchasePrice = number_format($ticket->total_cost, 2);
                  @endphp
                  <strong>₱{{ $purchasePrice }}</strong>
                </td>
                <td data-order="{{ $ticket->priority->name }}">
                  <span class="{{ $ticket->priority->color->class }}"></span>{{ $ticket->priority->name }}
                </td>
                <td>
                    <span class="{{ $ticket->progress->badge->class }}">
                      <span class="{{ $ticket->progress->legend->class }}"></span>{{ $ticket->progress->name }}
                    </span>
                </td>
                <td data-order="{{ $ticket->created_at }}">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $ticket->created_at->format('D, M d, Y | h:i A') }}">
                      <i class="bi-calendar-plus me-1"></i> {{ $ticket->created_at->format('F d, Y') }}
                    </span>
                </td>
                <td data-order="{{ $ticket->updated_at }}">
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $ticket->updated_at->format('D, M d, Y | h:i A') }}">
                      <i class="bi-calendar2-event me-1"></i> Updated {{ $ticket->updated_at->diffForHumans() }}
                    </span>
                </td>
                <td>
                  <div class="btn-group position-static">
                    <button class="btn btn-white btn-sm btnViewRequest" type="button"><i class="bi-eye"></i> View</button>

                    @access('File Maintenance', 'Read and Write, Full Access')
                    <div class="btn-group position-static">
                      <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" data-bs-toggle="dropdown" type="button"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1">
                        <button class="dropdown-item btnEditRequest" type="button">
                          <i class="bi-pencil-fill dropdown-item-icon"></i> Edit Record
                        </button>

                        @access('File Maintenance', 'Full Access')
                        <button class="dropdown-item text-danger btnDeleteRequest" type="button">
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
  {{-- Secondary Content --}}
@endsection

@push('scripts')
  {{-- Scripts --}}

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
        HSBsDropdown.init();
      };
    })();
  </script>
@endpush
