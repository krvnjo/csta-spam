@extends('layouts.app')

@section('title')
  Acquisitions
@endsection

@section('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endsection

@section('header')
  @include('layouts.header')
@endsection

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('main-content')
  <main class="main" id="content" role="main">
    <!-- Content -->
    <div class="content container-fluid">
      <!-- Page Header -->
      <div class="page-header">
        <div class="row align-items-end">
          <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-no-gutter">
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a class="breadcrumb-link">File Maintenance</a></li>
                <li class="breadcrumb-item active" aria-current="page">Acquisitions</li>
              </ol>
            </nav>
            <h1 class="page-header-title mt-2">Acquisitions</h1>
          </div>

          <div class="col-sm-auto mt-sm-0 mt-3">
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
              <button class="btn btn-primary w-100 w-sm-auto" data-bs-toggle="modal"
                data-bs-target="#addAcquisitionModal">
                <i class="bi-plus me-1"></i> Add a Acquisition
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Page Header -->

      <!-- Active and Inactive Acquisitions Card -->
      <div class="card mb-3 mb-lg-5">
        <div class="card-body">
          <div class="d-flex flex-column flex-md-row align-items-md-center text-md-start text-center">
            <div class="flex-shrink-0">
              <span class="display-3 text-dark">{{ $totalAcquisitions }}</span>
            </div>

            <div class="flex-grow-1 ms-md-3 my-1 mt-md-0">
              <div class="row">
                <div class="col-12 col-md">
                  <span class="d-block">Total Acquisitions</span>
                  <span class="badge bg-soft-primary text-primary rounded-pill p-1">
                    @if ($deletedAcquisitions == 0)
                      <i class="bi-hand-thumbs-up-fill"></i> All good!
                    @else
                      <i class="bi-arrow-clockwise"></i> {{ $deletedAcquisitions }} record/s can be restored from bin
                    @endif
                  </span>
                </div>

                <div class="col-12 col-md-9 mt-3 mt-md-0">
                  <div class="d-flex justify-content-center justify-content-md-start mb-2">
                    <div class="me-3">
                      <span class="legend-indicator bg-success"></span>
                      Active ({{ $activeAcquisitions }})
                    </div>
                    <div>
                      <span class="legend-indicator bg-danger"></span>
                      Inactive ({{ $inactiveAcquisitions }})
                    </div>
                  </div>

                  <div class="progress rounded-pill">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuemax="100" aria-valuemin="0"
                      aria-valuenow="{{ $activePercentage }}" style="width: {{ $activePercentage }}%"></div>
                    <div class="progress-bar bg-danger" role="progressbar" aria-valuemax="100" aria-valuemin="0"
                      aria-valuenow="{{ $inactivePercentage }}" style="width: {{ $inactivePercentage }}%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Active and Inactive Acquisitions Card -->

      <!-- Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text">
                <i class="bi-search"></i>
              </div>
              <input class="form-control" id="acquisitionDatatableSearch" type="search" aria-label="Search"
                placeholder="Search">
            </div>
          </div>

          <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
            <!-- Datatable Counter -->
            <div id="acquisitionDatatableCounterInfo" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="fs-5 me-3">
                  <span id="acquisitionDatatableCounter"></span> Selected
                </span>
                <button class="btn btn-outline-danger btn-sm" id="btnMultiDeleteAcquisition" type="button">
                  <i class="bi-trash"></i> Delete
                </button>
              </div>
            </div>
            <!-- End Datatable Counter -->

            <!-- Export Options Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" id="acquisitionExportDropdown"
                data-bs-toggle="dropdown" type="button" aria-expanded="false"><i class="bi-download me-2"></i> Export
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="acquisitionExportDropdown">
                <span class="dropdown-header">Options</span>
                <button class="dropdown-item" id="export-copy" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2"
                    src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Copy Icon"> Copy
                </button>
                <button class="dropdown-item" id="export-print" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2"
                    src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Print Icon"> Print
                </button>

                <div class="dropdown-divider"></div>

                <span class="dropdown-header">Download options</span>
                <button class="dropdown-item" id="export-excel" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2"
                    src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Excel Icon"> Excel
                </button>
                <button class="dropdown-item" id="export-pdf" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2"
                    src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="PDF Icon"> PDF
                </button>
              </div>
            </div>
            <!-- End Export Options Dropdown -->

            <!-- Datatable Filter Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm w-100" id="acquisitionFilterDropdown" data-bs-toggle="dropdown"
                type="button" aria-expanded="false">
                <i class="bi-filter me-1"></i> Filter <span class="badge bg-soft-dark text-dark rounded-circle ms-1"
                  id="acquisitionFilterCount"></span>
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered"
                aria-labelledby="acquisitionFilterDropdown" style="min-width: 22rem;">
                <div class="card">
                  <div class="card-header card-header-content-between">
                    <h5 class="card-header-title">Acquisition Filters</h5>

                    <button class="btn btn-ghost-secondary btn-icon btn-sm ms-2" type="button">
                      <i class="bi-x-lg"></i>
                    </button>
                  </div>

                  <div class="card-body">
                    <div class="mb-4">
                      <small class="text-cap text-body">Status</small>

                      <div class="row">
                        <div class="col">
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select form-select-sm"
                              data-target-column-index="4"
                              data-hs-tom-select-options='{
                                "placeholder": "All Status",
                                "hideSearch": true,
                                "dropdownWidth": "100%"
                              }'>
                              <option value=""></option>
                              <option
                                data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-success"></span>Active</span>'
                                value="Active">
                              </option>
                              <option
                                data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-danger"></span>Inactive</span>'
                                value="Inactive">
                              </option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Datatable Filter Dropdown -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom">
          <table
            class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100"
            id="acquisitionDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                 "targets": [0, 5],
                 "orderable": false
               }],
              "order": [3, "desc"],
              "info": {
                "totalQty": "#acquisitionDatatableWithPagination"
              },
              "search": "#acquisitionDatatableSearch",
              "entries": "#acquisitionDatatableEntries",
              "pageLength": 5,
              "isResponsive": false,
              "isShowPaging": false,
              "pagination": "acquisitionDatatablePagination"
            }'>
            <thead class="thead-light">
              <tr>
                <th class="table-column-pe-0">
                  <div class="form-check">
                    <input class="form-check-input" id="acquisitionDatatableCheckAll" type="checkbox" value="">
                    <label class="form-check-label" for="acquisitionDatatableCheckAll"></label>
                  </div>
                </th>
                <th class="d-none">Acquisition Id</th>
                <th style="width: 25%;">Acquisition Name</th>
                <th>Date Created</th>
                <th style="width: 20%;">Status</th>
                <th style="width: 15%;">Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($acquisitions as $index => $acquisition)
                <tr>
                  <td class="table-column-pe-0">
                    <div class="form-check">
                      <input class="form-check-input" id="acquisitionCheck{{ $index + 1 }}" type="checkbox">
                      <label class="form-check-label" for="acquisitionCheck{{ $index + 1 }}"></label>
                    </div>
                  </td>
                  <td class="d-none" data-acquisition-id="{{ Crypt::encryptString($acquisition->id) }}"></td>
                  <td><span class="d-block h5 mb-0">{{ $acquisition->name }}</span></td>
                  <td>
                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Modified on: {{ $acquisition->updated_at->format('M d, Y') }}">
                      <i class="bi-calendar-event me-1"></i>
                      {{ $acquisition->created_at->format('M d, Y H:i:s') }}
                    </span>
                  <td>
                    @if ($acquisition->is_active)
                      <span class="badge bg-soft-success text-success">
                        <span class="legend-indicator bg-success"></span>Active
                      </span>
                    @else
                      <span class="badge bg-soft-danger text-danger">
                        <span class="legend-indicator bg-danger"></span>Inactive
                      </span>
                    @endif
                  </td>
                  <td>
                    <div class="dropdown position-static">
                      <button class="btn btn-white btn-sm" id="acquisitionDropdownActions" data-bs-toggle="dropdown"
                        type="button" aria-expanded="false"> More <i class="bi-chevron-down ms-1"></i>
                      </button>

                      <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                        <button class="dropdown-item" id="btnEditAcquisition" type="button">
                          <i class="bi-pencil-square me-2"></i> Edit Record
                        </button>
                        @if ($acquisition->is_active)
                          <button class="dropdown-item btnStatusAcquisition" data-status="0" type="button">
                            <i class="bi-x-lg me-2"></i> Set to Inactive
                          </button>
                        @else
                          <button class="dropdown-item btnStatusAcquisition" data-status="1" type="button">
                            <i class="bi-check-lg me-2"></i> Set to Active
                          </button>
                        @endif
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item text-danger" id="btnDeleteAcquisition" type="button">
                          <i class="bi-trash me-2"></i> Delete
                        </button>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="card-footer">
          <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
            <div class="col-sm mb-2 mb-sm-0">
              <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                <span class="me-2">Showing:</span>

                <!-- Select -->
                <div class="tom-select-custom tom-page-w">
                  <select class="js-select form-select form-select-borderless" id="acquisitionDatatableEntries"
                    data-hs-tom-select-options='{
                      "searchInDropdown": false,
                      "hideSearch": true
                    }'
                    autocomplete="off">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="{{ $totalAcquisitions }}">All</option>
                  </select>
                </div>
                <!-- End Select -->

                <span class="text-secondary me-2">of</span>

                <!-- Pagination Quantity -->
                <span id="acquisitionDatatableWithPagination"></span>
              </div>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <!-- Pagination -->
                <nav id="acquisitionDatatablePagination" aria-label="Activity pagination"></nav>
              </div>
            </div>
            <!-- End Col -->
          </div>
          <!-- End Row -->
        </div>
        <!-- End Footer -->
      </div>
      <!-- End Card -->
    </div>
    <!-- End Content -->
  </main>
@endsection

@section('footer')
  @include('layouts.footer')
@endsection

@section('sub-content')
  <x-file-maintenance.add-acquisition />
  <x-file-maintenance.edit-acquisition />
@endsection

@section('scripts')
  <!-- JS Other Plugins -->
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
  <script src="{{ Vite::asset('resources/js/modules/file-maintenance/acquisition-crud.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Init. -->
  <script>
    // Initialization of Datatables
    $(document).on("ready", function() {
      HSCore.components.HSDatatables.init($("#acquisitionDatatable"), {
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
            checkAll: "#acquisitionDatatableCheckAll",
            counter: "#acquisitionDatatableCounter",
            counterInfo: "#acquisitionDatatableCounterInfo"
          }
        },
        language: {
          zeroRecords: `<div class="text-center p-4">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-error.svg') }}" alt="No Record to Show" style="width: 10rem;" data-hs-theme-appearance="default">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations-light/oc-error.svg') }}" alt="No Record to Show" style="width: 10rem;" data-hs-theme-appearance="dark">
            <p class="mb-0">The acquisitions table is empty. No records to show</p>
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

        updateFilterCountBadge($("#acquisitionFilterCount"));
      });
    });

    // Initialization of Other Plugins
    (function() {
      window.onload = function() {
        // INITIALIZATION OF NAVBAR VERTICAL ASIDE
        // =======================================================
        new HSSideNav(".js-navbar-vertical-aside").init();


        // INITIALIZATION OF NAV SCROLLER
        // =======================================================
        new HsNavScroller(".js-nav-scroller", {
          delay: 400
        });


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        new HSFormSearch(".js-form-search");


        // INITIALIZATION OF BOOTSTRAP DROPDOWN
        // =======================================================
        HSBsDropdown.init();


        // INITIALIZATION OF SELECT
        // =======================================================
        HSCore.components.HSTomSelect.init(".js-select");
      };
    })();
  </script>
@endsection
