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
            <button class="btn btn-primary w-100 w-sm-auto" id="btnAddNewRequestModal" data-bs-toggle="modal" data-bs-target="#modalAddNewRequest">
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
              <input class="form-control" id="newRequestsDatatableSearch" type="search" placeholder="Search">
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
            <a class="btn btn-white btn-sm dropdown-toggle" data-bs-toggle="collapse" href="#newRequestFilterSearchCollapse">
              <i class="bi-funnel me-1"></i> Filters <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="newRequestsFilterCount"></span>
            </a>
            <!-- End Filter Collapse Trigger -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Filter Search Collapse -->
        <div class="collapse" id="newRequestFilterSearchCollapse">
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
                      {{--                      @foreach ($priorities as $priority) --}}
                      {{--                        <option data-option-template='<span class="d-flex align-items-center"><span class="{{ $priority->color->class }}"></span>{{ $priority->name }}</span>' --}}
                      {{--                                value="{{ $priority->name }}"> --}}
                      {{--                        </option> --}}
                      {{--                      @endforeach --}}
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
                      {{--                      @foreach ($users as $user) --}}
                      {{--                        <option --}}
                      {{--                          data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="{{ asset('storage/img/user-images/' . $user->user_image) }}" alt="User Image" /><span class="text-truncate">{{ $user->name }}</span></span>' --}}
                      {{--                          value="{{ $user->name }}">{{ $user->name }}</option> --}}
                      {{--                      @endforeach --}}
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
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="newRequestsDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                 "targets": [9],
                 "orderable": false
               }],
              "order": [8, "desc"],
              "info": {
                "totalQty": "#newRequestsDatatableWithPagination"
              },
              "search": "#newRequestsDatatableSearch",
              "entries": "#newRequestsDatatableEntries",
              "pageLength": 10,
              "isResponsive": false,
              "isShowPaging": false,
              "pagination": "newRequestsDatatablePagination"
            }'>
            <thead class="thead-light">
              <tr>
                <th class="d-none"></th>
                <th>Borrow No.</th>
                <th>Requester</th>
                <th>Requested Items</th>
                <th>Quantity</th>
                <th>Remarks</th>
                <th>Status</th>
                <th>Borrow Date</th>
                <th>Date Created</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($borrowings as $borrowing)
                <tr>
                  <td class="d-none" data-borrow-id="{{ Crypt::encryptString($borrowing->id) }}"></td>
                  <td>{{ $borrowing->borrow_num }}</td>
                  <td>{{ $borrowing->requester->name }} | {{ $borrowing->requester->department->code }}</td>
                  <td>
                    @foreach ($borrowing->requestItems as $item)
                      <span style="color:gray"
                            @if (!empty($borrowing->remarks) && strlen($item->property->name) > 25) data-bs-toggle="tooltip"
                            data-bs-html="true"
                            data-bs-placement="top"
                            title="{{ $item->property->name }}" @endif>
                      {{ Str::limit(!empty($item->property->name) ? $item->property->name : 'No remarks provided', 30) }}
                    </span><br>
                    @endforeach
                  </td>
                  <td>
                    @foreach ($borrowing->requestItems as $item)
                      {{ $item->quantity }} - {{ $item->property->unit->name }}<br>
                    @endforeach
                  </td>
                  <td>
                    <span style="color:gray"
                      @if (!empty($borrowing->remarks) && strlen($borrowing->remarks) > 25) data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            data-bs-placement="top"
                                            title="{{ $borrowing->remarks }}" @endif>
                      {{ Str::limit(!empty($borrowing->remarks) ? $borrowing->remarks : 'No remarks provided', 30) }}
                    </span>
                  </td>
                  <td>
                    <span class="{{ $borrowing->progress->badge->class }}">
                      <span class="{{ $borrowing->progress->legend->class }}"></span>{{ $borrowing->progress->name }}
                    </span>
                  </td>
                  <td><i class="bi-calendar-event me-1"></i>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('F j, Y') }}</td>
                  <td><i class="bi-calendar-plus me-1"></i>Created {{ \Carbon\Carbon::parse($borrowing->created_at)->diffForHumans() }}</td>
                  <td>
                    <div class="btn-group position-static">
                      <button class="btn btn-white btn-sm" type="button"><i class="bi-eye"></i> View</button>

                      <div class="btn-group position-static">
                        <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" data-bs-toggle="dropdown" type="button"></button>
                        <div class="dropdown-menu dropdown-menu-end mt-1">
                          @if ($borrowing->prog_id == 1)
                            <button class="dropdown-item btnApproveRequest" data-borrow-num="{{ $borrowing->borrow_num }}" data-requester-name="{{ $borrowing->requester->name }}" type="button">
                              <i class="bi bi-check2-circle dropdown-item-icon text-success"></i> Approve
                            </button>
                            <button class="dropdown-item" type="button">
                              <i class="bi bi-x-circle dropdown-item-icon text-danger"></i> Reject
                            </button>
                          @endif
                          @if ($borrowing->prog_id == 2)
                            <button class="dropdown-item btnReleaseRequest" type="button">
                              <i class="bi bi-eject dropdown-item-icon text-warning"></i> Release
                            </button>
                          @endif
                          <button class="dropdown-item" type="button">
                            <i class="bi-pencil-fill dropdown-item-icon"></i> Edit Record
                          </button>
                          <div class="dropdown-divider"></div>
                          <button class="dropdown-item text-danger" type="button">
                            <i class="bi bi-trash3-fill dropdown-item-icon text-danger"></i> Delete
                          </button>
                        </div>
                      </div>
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
                  <select class="js-select form-select form-select-borderless" id="newRequestsDatatableEntries"
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
                <span id="newRequestsDatatableWithPagination"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>
            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <nav id="newRequestsDatatablePagination"></nav>
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
  <x-borrow-reservation.add-request :items="$items" :requesters="$requesters" />
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/js/modules/borrow-reservation/request.js') }}"></script>

  <script src="{{ Vite::asset('resources/vendor/tom-select/dist/js/tom-select.complete.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-add-field/dist/hs-add-field.min.js') }}"></script>
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
        filterDatatableAndCount(newRequestsDatatable, "#requestsFilterCount");
      });

      daterangepickerClear.on('cancel.daterangepicker', function() {
        $(this).val('');
        filterDatatableAndCount(newRequestsDatatable, "#requestsFilterCount");
      });

      HSCore.components.HSDatatables.init($("#newRequestsDatatable"), {
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

      const newRequestsDatatable = HSCore.components.HSDatatables.getItem(0);

      const exportButtons = {
        "#requestExportCopy": ".buttons-copy",
        "#requestExportPrint": ".buttons-print",
        "#requestExportExcel": ".buttons-excel",
        "#requestExportPdf": ".buttons-pdf"
      };

      $.each(exportButtons, function(exportId, exportClass) {
        $(exportId).click(function() {
          newRequestsDatatable.button(exportClass).trigger();
        });
      });

      $(".js-datatable-filter").on("change", function() {
        filterDatatableAndCount(newRequestsDatatable, "#newRequestsFilterCount");
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


        // INITIALIZATION OF ADD FIELD
        // =======================================================
        new HSAddField('.js-add-field', {
          addedField: field => {
            HSCore.components.HSTomSelect.init(field.querySelector('.js-select-dynamic'))
          }
        });

      };
    })();

    $(document).ready(function() {
      const itemSelects = $(".js-select-dynamic");

      itemSelects.on("change", function() {
        const selectedItems = [];

        itemSelects.each(function() {
          const value = $(this).val();
          if (value) {
            selectedItems.push(value);
          }
        });

        itemSelects.each(function() {
          const currentItemValue = $(this).val();
          $(this).find("option").each(function() {
            const optionValue = $(this).val();
            if (selectedItems.includes(optionValue) && optionValue !== currentItemValue) {
              $(this).attr("disabled", "disabled");
            } else {
              $(this).removeAttr("disabled");
            }
          });
        });
      });
    });
  </script>
@endpush
