@extends('layouts.app')

@section('title')
  Brands
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
                <li class="breadcrumb-item active" aria-current="page">Brands</li>
              </ol>
            </nav>

            <h1 class="page-header-title mt-2">Brands</h1>
          </div>
          <!-- End Col -->

          <div class="col-sm-auto mt-sm-0 mt-3">
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
              <button class="btn btn-primary w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                <i class="bi-plus me-1"></i> Add a Brand
              </button>
            </div>
          </div>
          <!-- End Col -->
        </div>
        <!-- End Row -->
      </div>
      <!-- End Page Header -->

      <!-- Card -->
      <div class="card mb-3 mb-lg-5">
        <!-- Body -->
        <div class="card-body">
          <div class="d-flex flex-column flex-md-row align-items-md-center text-md-start text-center">
            <div class="flex-shrink-0">
              <span class="display-3 text-dark">{{ $totalBrands }}</span>
            </div>

            <div class="flex-grow-1 ms-md-3 my-1 mt-md-0">
              <div class="row">
                <div class="col-12 col-md">
                  <span class="d-block">Total Brands</span>
                  <span class="badge bg-soft-primary text-primary rounded-pill p-1">
                    @if ($inactiveBrands == 0)
                      <i class="bi-hand-thumbs-up-fill"></i> All good!
                    @elseif($inactiveBrands == 1)
                      <i class="bi-arrow-clockwise"></i> 1 record can be restored
                    @else
                      <i class="bi-arrow-clockwise"></i> {{ $inactiveBrands }} records can be restored
                    @endif
                  </span>
                </div>
                <!-- End Col -->

                <div class="col-12 col-md-9 mt-3 mt-md-0">
                  <div class="d-flex justify-content-center justify-content-md-start mb-2">
                    <div class="me-3">
                      <span class="legend-indicator bg-success"></span>
                      Active ({{ $activeBrands }})
                    </div>

                    <div>
                      <span class="legend-indicator bg-danger"></span>
                      Inactive ({{ $inactiveBrands }})
                    </div>
                  </div>

                  <!-- Progress -->
                  <div class="progress rounded-pill">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuemax="100" aria-valuemin="0"
                      aria-valuenow="{{ $activePercentage }}" style="width: {{ $activePercentage }}%"></div>
                    <div class="progress-bar bg-danger" role="progressbar" aria-valuemax="100" aria-valuemin="0"
                      aria-valuenow="{{ $inactivePercentage }}" style="width: {{ $inactivePercentage }}%"></div>
                  </div>
                  <!-- End Progress -->
                </div>
                <!-- End Col -->
              </div>
              <!-- End Row -->
            </div>
          </div>
        </div>
        <!-- End Body -->
      </div>
      <!-- End Card -->

      <!-- Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text">
                <i class="bi-search"></i>
              </div>
              <input class="form-control" id="brandDatatableSearch" type="search" aria-label="Search" placeholder="Search">
            </div>
          </div>

          <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
            <!-- Datatable Info -->
            <div id="brandDatatableCounterInfo" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="fs-5 me-3">
                  <span id="brandDatatableCounter">0</span>
                  Selected
                </span>
                <a class="btn btn-outline-danger btn-sm" href="#">
                  <i class="bi-trash"></i> Delete
                </a>
              </div>
            </div>
            <!-- End Datatable Info -->

            <!-- Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" id="brandExportDropdown" data-bs-toggle="dropdown" type="button"
                aria-expanded="false">
                <i class="bi-download me-2"></i> Export
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="brandExportDropdown">
                <span class="dropdown-header">Options</span>
                <a class="dropdown-item" id="export-copy" href="#">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}"
                    alt="Image Description">
                  Copy
                </a>
                <a class="dropdown-item" id="export-print" href="#">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}"
                    alt="Image Description">
                  Print
                </a>
                <div class="dropdown-divider"></div>
                <span class="dropdown-header">Download options</span>
                <a class="dropdown-item" id="export-excel" href="#">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}"
                    alt="Image Description">
                  Excel
                </a>
                <a class="dropdown-item" id="export-csv" href="#">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/components/placeholder-csv-format.svg') }}"
                    alt="Image Description">
                  .CSV
                </a>
                <a class="dropdown-item" id="export-pdf" href="#">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}"
                    alt="Image Description">
                  PDF
                </a>
              </div>
            </div>
            <!-- End Dropdown -->

            <!-- Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm w-100" id="brandFilterDropdown" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                <i class="bi-filter me-1"></i> Filter <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="filterCountBadge"></span>
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered" aria-labelledby="brandFilterDropdown"
                style="min-width: 22rem;">
                <!-- Card -->
                <div class="card">
                  <div class="card-header card-header-content-between">
                    <h5 class="card-header-title">Brand Filters</h5>

                    <button class="btn btn-ghost-secondary btn-icon btn-sm ms-2" type="button">
                      <i class="bi-x-lg"></i>
                    </button>
                  </div>

                  <div class="card-body">
                    <div class="mb-4">
                      <small class="text-cap text-body">Status</small>

                      <div class="row">
                        <div class="col">
                          <!-- Select -->
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select form-select-sm" data-target-column-index="3"
                              data-hs-tom-select-options='{
                                "placeholder": "All Status",
                                "hideSearch": true,
                                "dropdownWidth": "100%"
                              }'>
                              <option value=""></option>
                              <option
                                data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-success"></span>Active</span>'
                                value="Active">
                                Active
                              </option>
                              <option
                                data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-danger"></span>Inactive</span>'
                                value="Inactive">
                                Inactive
                              </option>
                            </select>
                            <!-- End Select -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Card -->
              </div>
            </div>
            <!-- End Dropdown -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom">
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table"
            id="brandDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                 "targets": [0, 4],
                 "orderable": false
               }],
              "order": [1, "asc"],
              "info": {
                "totalQty": "#brandDatatableWithPagination"
              },
              "search": "#brandDatatableSearch",
              "entries": "#brandDatatableEntries",
              "pageLength": 5,
              "isResponsive": false,
              "isShowPaging": false,
              "pagination": "brandDatatablePagination"
            }'>
            <thead class="thead-light">
              <tr>
                <th class="table-column-pe-0">
                  <div class="form-check">
                    <input class="form-check-input" id="brandDatatableCheckAll" type="checkbox" value="">
                    <label class="form-check-label" for="brandDatatableCheckAll"></label>
                  </div>
                </th>
                <th style="width: 25%;">Brand Name</th>
                <th>Date Created</th>
                <th>Status</th>
                <th style="width: 15%;">Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($brands as $brand)
                <tr>
                  <td class="table-column-pe-0">
                    <div class="form-check">
                      <input class="form-check-input" id="brandCheck" type="checkbox" value="">
                      <label class="form-check-label" for="brandCheck"></label>
                    </div>
                  </td>
                  <td><span class="d-block h5 mb-0">{{ $brand->name }}</span></td>
                  <td><i class="bi-calendar-event me-1"></i> {{ $brand->created_at->format('M d, Y') }}</td>
                  <td>
                    @if ($brand->is_active)
                      <span class="legend-indicator bg-success"></span> Active
                    @else
                      <span class="legend-indicator bg-danger"></span> Inactive
                    @endif
                  </td>
                  <td>
                    <div class="dropdown position-static">
                      <button class="btn btn-white btn-sm" id="brandDropdownActions" data-bs-toggle="dropdown" type="button"
                        aria-expanded="false">
                        More <i class="bi-chevron-down ms-1"></i>
                      </button>

                      <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end" aria-labelledby="brandDropdownActions">
                        <button class="dropdown-item" type="button" href="#"><i class="bi-pencil-square me-2"></i> Edit Record</button>
                        @if ($brand->is_active)
                          <button class="dropdown-item" type="button" href="#"><i class="bi-x-circle me-2"></i> Set to Inactive</button>
                        @else
                          <button class="dropdown-item" type="button" href="#"><i class="bi-check-circle me-2"></i> Set to Active</button>
                        @endif
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item text-danger" type="button" href="#"><i class="bi-trash me-2"></i> Delete</button>
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
                  <select class="js-select form-select form-select-borderless" id="brandDatatableEntries"
                    data-hs-tom-select-options='{
                      "searchInDropdown": false,
                      "hideSearch": true
                    }'
                    autocomplete="off">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                  </select>
                </div>
                <!-- End Select -->

                <span class="text-secondary me-2">of</span>

                <!-- Pagination Quantity -->
                <span id="brandDatatableWithPagination"></span>
              </div>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <!-- Pagination -->
                <nav id="brandDatatablePagination" aria-label="Activity pagination"></nav>
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
  {{-- No Secondary Content --}}
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

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Init. -->
  <script>
    // Initialization of Datatables
    $(document).on('ready', function() {
      HSCore.components.HSDatatables.init($('#brandDatatable'), {
        dom: 'Bfrtip',
        buttons: [{
            extend: 'copy',
            className: 'd-none'
          },
          {
            extend: 'excel',
            className: 'd-none'
          },
          {
            extend: 'csv',
            className: 'd-none'
          },
          {
            extend: 'pdf',
            className: 'd-none'
          },
          {
            extend: 'print',
            className: 'd-none'
          },
        ],
        select: {
          style: 'multi',
          selector: 'td:first-child input[type="checkbox"]',
          classMap: {
            checkAll: '#brandDatatableCheckAll',
            counter: '#brandDatatableCounter',
            counterInfo: '#brandDatatableCounterInfo'
          }
        },
        language: {
          zeroRecords: `<div class="text-center p-4">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-error.svg') }}" alt="No Record to Show" style="width: 10rem;" data-hs-theme-appearance="default">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations-light/oc-error.svg') }}" alt="No Record to Show" style="width: 10rem;" data-hs-theme-appearance="dark">
            <p class="mb-0">No data to show</p>
            </div>`
        }
      });

      const datatable = HSCore.components.HSDatatables.getItem(0)

      $('#export-copy').click(function() {
        datatable.button('.buttons-copy').trigger()
      });

      $('#export-excel').click(function() {
        datatable.button('.buttons-excel').trigger()
      });

      $('#export-csv').click(function() {
        datatable.button('.buttons-csv').trigger()
      });

      $('#export-pdf').click(function() {
        datatable.button('.buttons-pdf').trigger()
      });

      $('#export-print').click(function() {
        datatable.button('.buttons-print').trigger()
      });

      $('.js-datatable-filter').on('change', function() {
        const $this = $(this),
          elVal = $this.val(),
          targetColumnIndex = $this.data("target-column-index");

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
          const cellContent = $(datatable.cell(dataIndex, targetColumnIndex).node()).text().trim();
          return elVal === '' || cellContent === elVal;
        });

        datatable.draw();
        $.fn.dataTable.ext.search.pop();

        // Update the filter count badge
        let selectedFilterCount = 0;

        // Loop through all filter selects
        $('.js-datatable-filter').each(function() {
          if ($(this).val() !== "") {
            selectedFilterCount++;
          }
        });

        const $badge = $('#filterCountBadge');
        if (selectedFilterCount > 0) {
          $badge.text(selectedFilterCount).show();
        } else {
          $badge.hide();
        }
      });
    });

    // Initialization of Other Plugins
    (function() {
      window.onload = function() {
        // INITIALIZATION OF NAVBAR VERTICAL ASIDE
        // =======================================================
        new HSSideNav('.js-navbar-vertical-aside').init()


        // INITIALIZATION OF NAV SCROLLER
        // =======================================================
        new HsNavScroller('.js-nav-scroller', {
          delay: 400
        })


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        new HSFormSearch('.js-form-search')


        // INITIALIZATION OF BOOTSTRAP DROPDOWN
        // =======================================================
        HSBsDropdown.init()


        // INITIALIZATION OF SELECT
        // =======================================================
        HSCore.components.HSTomSelect.init('.js-select')
      }
    })()
  </script>
@endsection
