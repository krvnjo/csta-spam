@extends('layouts.app')

@section('title')
  Audit History
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <div class="content container-fluid">
      <!-- Audits Header -->
      <div class="page-header">
        <div class="row align-items-center">
          <div class="col-sm mb-2 mb-sm-0">
            <ol class="breadcrumb breadcrumb-no-gutter">
              <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item active">Audit History</li>
            </ol>
            <h1 class="page-header-title">Audit History</h1>
            <p class="page-header-text">Monitor and track system activity for accountability.</p>
          </div>
        </div>
      </div>
      <!-- End Audits Header -->

      <!-- Audits DataTable Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>
              <input class="form-control" id="auditsDatatableSearch" type="search" placeholder="Search">
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
                <button class="dropdown-item" id="auditExportCopy" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Copy Icon"> Copy
                </button>
                <button class="dropdown-item" id="auditExportPrint" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Print Icon"> Print
                </button>
                <div class="dropdown-divider"></div>
                <span class="dropdown-header">Download</span>
                <button class="dropdown-item" id="auditExportExcel" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Excel Icon"> Excel
                </button>
                <button class="dropdown-item" id="auditExportPdf" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="PDF Icon"> PDF
                </button>
              </div>
            </div>
            <!-- End Export Dropdown -->

            <!-- Filter Collapse Trigger -->
            <a class="btn btn-white btn-sm dropdown-toggle" data-bs-toggle="collapse" href="#auditFilterSearchCollapse">
              <i class="bi-funnel me-1"></i> Filters <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="auditsFilterCount"></span>
            </a>
            <!-- End Filter Collapse Trigger -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Filter Search Collapse -->
        <div class="collapse" id="auditFilterSearchCollapse">
          <div class="card-body">
            <div class="row">
              <!-- Event -->
              <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="mb-4">
                  <label class="form-label" for="teamsFilterLabel">Teams</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend input-group-text">
                      <i class="bi-people-fill"></i>
                    </div>
                    <input class="form-control" id="teamsFilterLabel" placeholder="Name, role, department">
                  </div>
                </div>
              </div>
              <!-- End Event -->

              <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="mb-4">
                  <label class="form-label" for="teamsFilterLabel">User</label>
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend input-group-text">
                      <i class="bi-people-fill"></i>
                    </div>
                    <input class="form-control" id="teamsFilterLabel" placeholder="Name, role, department">
                  </div>
                </div>
              </div>
              <!-- End Event -->
            </div>
          </div>
        </div>
        <!-- End Filter Search Collapse -->

        <!-- Body -->
        <div class="table-responsive datatable-custom">
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="auditsDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                 "targets": [0],
                 "orderable": false
               }],
              "order": [6, "desc"],
              "info": {
                "totalQty": "#auditsDatatableWithPagination"
              },
              "search": "#auditsDatatableSearch",
              "entries": "#auditsDatatableEntries",
              "pageLength": 10,
              "isResponsive": false,
              "isShowPaging": false,
              "pagination": "auditsDatatablePagination"
            }'>
            <thead class="thead-light">
              <tr>
                <th class="table-column-pe-0 w-auto">
                  <div class="form-check">
                    <input class="form-check-input" id="auditsDatatableCheckAll" type="checkbox">
                    <label class="form-check-label" for="auditsDatatableCheckAll"></label>
                  </div>
                </th>
                <th class="d-none w-auto">Audit Id</th>
                <th class="w-auto">Log Name</th>
                <th class="w-auto">Description</th>
                <th class="w-auto">Subject & Event</th>
                <th class="w-auto">Performed By</th>
                <th class="w-auto">Date Logged</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($audits as $index => $audit)
                <tr>
                  <td class="table-column-pe-0">
                    <div class="form-check">
                      <input class="form-check-input" id="auditCheck{{ $index + 1 }}" type="checkbox">
                      <label class="form-check-label" for="auditCheck{{ $index + 1 }}"></label>
                    </div>
                  </td>
                  <td class="d-none" data-audit-id="{{ Crypt::encryptString($audit->id) }}"></td>
                  <td><a class="d-block h5 mb-0 btnViewAudit">{{ $audit->log_name }}</a></td>
                  <td>{{ \Illuminate\Support\Str::limit($audit->description, 50, '...') }}</td>
                  <td>
                    <span class="d-block h5 mb-0">{{ $audit->subject->name }}</span>
                    <span class="d-block fs-5">{{ $audit->event }}</span>
                  </td>
                  <td>
                    <a class="d-flex align-items-center btnViewUser">
                      <div class="avatar avatar-circle">
                        <img class="avatar-img" src="{{ Vite::asset('resources/img/uploads/user-images/' . ($audit ? $audit->causer->user_image ?? 'system.jpg' : 'system.jpg')) }}"
                          alt="User Avatar">
                      </div>
                      <div class="ms-3">
                        <span class="d-block h5 text-inherit mb-0">{{ $audit?->causer ? $audit->causer->fname . ' ' . $audit->causer->lname : 'CSTA-SPAM System' }}</span>
                        <span class="d-block fs-5 text-body">{{ $audit?->causer ? $audit->causer->role->name : 'Super Admin' }}</span>
                      </div>
                    </a>
                  </td>
                  <td data-order="{{ $audit->created_at }}">
                    <span><i class="bi-calendar-event me-1"></i> Logged {{ $audit->created_at->diffForHumans() }}</span>
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
                  <select class="js-select form-select form-select-borderless" id="auditsDatatableEntries"
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
                <span id="auditsDatatableWithPagination"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>
            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <nav id="auditsDatatablePagination"></nav>
              </div>
            </div>
          </div>
        </div>
        <!-- End Footer -->
      </div>
      <!-- End Audits DataTable Card -->
    </div>
  </main>
@endsection

@section('sec-content')
  {{-- Secondary Content --}}
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/tom-select/dist/js/tom-select.complete.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/clipboard/dist/clipboard.min.js') }}"></script>
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
  <script src="{{ Vite::asset('resources/js/modules/other/audit-history.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    // Initialization of DataTable
    $(document).on("ready", function() {
      HSCore.components.HSDatatables.init($("#auditsDatatable"), {
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

      const auditsDatatable = HSCore.components.HSDatatables.getItem(0);

      const exportButtons = {
        "#auditExportCopy": ".buttons-copy",
        "#auditExportPrint": ".buttons-print",
        "#auditExportExcel": ".buttons-excel",
        "#auditExportPdf": ".buttons-pdf"
      };

      $.each(exportButtons, function(exportId, exportClass) {
        $(exportId).click(function() {
          auditsDatatable.button(exportClass).trigger();
        });
      });

      $(".js-datatable-filter").on("change", function() {
        filterDatatableAndCount(auditsDatatable, "#auditsFilterCount");
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


        // INITIALIZATION OF CLIPBOARD
        // =======================================================
        HSCore.components.HSClipboard.init('.js-clipboard')
      };
    })();
  </script>
@endpush
