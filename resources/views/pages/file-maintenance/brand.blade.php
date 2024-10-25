@extends('layouts.app')

@section('title')
  Brands
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <!-- Content -->
    <div class="content container-fluid">
      <!-- Page Header -->
      <div class="page-header">
        <div class="row align-items-end">
          <div class="col-sm mb-2 mb-sm-0">
            <nav>
              <ol class="breadcrumb breadcrumb-no-gutter">
                <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="breadcrumb-link">File Maintenance</a></li>
                <li class="breadcrumb-item active">Brands</li>
              </ol>
            </nav>
            <h1 class="page-header-title mt-2">Brands</h1>
          </div>

          @can('create brand maintenance')
            <div class="col-sm-auto mt-sm-0 mt-3">
              <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                <button class="btn btn-primary w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#modalAddBrand">
                  <i class="bi-plus me-1"></i> Add Brand
                </button>
              </div>
            </div>
          @endcan
        </div>
      </div>
      <!-- End Page Header -->

      <!-- Active and Inactive Brands Card -->
      <div class="card mb-3 mb-lg-5">
        <div class="card-body">
          <div class="d-flex flex-column flex-md-row align-items-md-center text-md-start text-center">
            <div class="flex-shrink-0"><span class="display-3 text-dark">{{ $totalBrands }}</span></div>
            <div class="flex-grow-1 ms-md-3 my-1 mt-md-0">
              <div class="row">
                <div class="col-12 col-md">
                  <span class="d-block">Total Brands</span>
                  <span class="badge bg-soft-primary text-primary rounded-pill p-1">
                    @if ($deletedBrands == 0)
                      <i class="bi-hand-thumbs-up-fill"></i> Everything looks great!
                    @else
                      <i class="bi-arrow-counterclockwise"></i> {{ $deletedBrands }} record(s) can be restored from bin.
                    @endif
                  </span>
                </div>

                <div class="col-12 col-md-9 mt-3 mt-md-0">
                  <div class="d-flex justify-content-center justify-content-md-start mb-2">
                    <div class="me-3"><span class="legend-indicator bg-success"></span>Active ({{ $activeBrands }})</div>
                    <div><span class="legend-indicator bg-danger"></span>Inactive ({{ $inactiveBrands }})</div>
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
      <!-- End Active and Inactive Brands Card -->

      <!-- Datatable Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <!-- Datatable Search -->
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>
              <input class="form-control" id="brandsDatatableSearch" type="search" placeholder="Search">
            </div>
            <!-- End Datatable Search -->
          </div>

          <div class="d-grid d-md-flex justify-content-md-end align-items-sm-center gap-2">
            @can('delete brand maintenance')
              <!-- Datatable Counter -->
              <div id="brandsDatatableCounterInfo" style="display: none;">
                <div class="d-flex align-items-center justify-content-center">
                  <span class="fs-5 me-3"><span id="brandsDatatableCounter"></span> Selected</span>
                  <button class="btn btn-sm btn-outline-danger" id="btnMultiDeleteBrand" type="button"><i class="bi-trash3-fill"></i> Delete</button>
                </div>
              </div>
              <!-- End Datatable Counter -->
            @endcan

            <!-- Export Options Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" data-bs-toggle="dropdown" type="button"><i class="bi-download me-2"></i> Export</button>
              <div class="dropdown-menu dropdown-menu-sm-end w-100">
                <span class="dropdown-header">Options</span>
                <button class="dropdown-item" id="export-copy" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Copy Icon"> Copy
                </button>
                <button class="dropdown-item" id="export-print" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Print Icon"> Print
                </button>

                <div class="dropdown-divider"></div>

                <span class="dropdown-header">Download</span>
                <button class="dropdown-item" id="export-excel" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Excel Icon"> Excel
                </button>
                <button class="dropdown-item" id="export-pdf" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="PDF Icon"> PDF
                </button>
              </div>
            </div>
            <!-- End Export Options Dropdown -->

            <!-- Datatable Filter Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm w-100" data-bs-toggle="dropdown" data-bs-auto-close="outside" type="button">
                <i class="bi-filter me-1"></i> Filter <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="brandFilterCount"></span>
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered w-100" id="filterDropdown" style="min-width: 22rem;">
                <div class="card">
                  <div class="card-header card-header-content-between">
                    <h5 class="card-header-title">Brand Filters</h5>
                  </div>
                  <div class="card-body">
                    <!-- Subcategories Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Subcategories</small>
                      <div class="row">
                        <div class="col">
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select" data-target-column-index="3"
                              data-hs-tom-select-options='{
                                "dropdownWidth": "100%",
                                "hideSelected": false,
                                "placeholder": "All Subcategories",
                                "singleMultiple": true
                              }'
                              autocomplete="off" multiple>
                              @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->name }}">{{ $subcategory->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Subcategories Filter -->

                    <!-- Active and Inactive Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Status</small>
                      <div class="row">
                        <div class="col">
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select" data-target-column-index="5"
                              data-hs-tom-select-options='{
                                "allowEmptyOption": true,
                                "dropdownWidth": "100%",
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
                    <!-- End Active and Inactive Filter -->
                  </div>
                </div>
              </div>
            </div>
            <!-- End Datatable Filter Dropdown -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Brands Datatable -->
        <div class="table-responsive datatable-custom">
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="brandsDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                "targets": [0, 6],
                "orderable": false
              }],
              "order": [4, "desc"],
              "info": {
                "totalQty": "#brandsDatatableWithPagination"
              },
              "search": "#brandsDatatableSearch",
              "entries": "#brandsDatatableEntries",
              "pageLength": 5,
              "isResponsive": false,
              "isShowPaging": false,
              "pagination": "brandsDatatablePagination"
            }'>
            <thead class="thead-light">
              <tr>
                <th class="w-th">
                  @can('delete brand maintenance')
                    <input class="form-check-input" id="brandsDatatableCheckAll" type="checkbox">
                  @else
                    #
                  @endcan
                </th>
                <th class="d-none">Brand Id</th>
                <th>Brand Name</th>
                <th>Brand Subcategories</th>
                <th>Date Updated</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($brands as $index => $brand)
                <tr>
                  <td>
                    @can('delete brand maintenance')
                      <input class="form-check-input" id="brandCheck{{ $index + 1 }}" type="checkbox">
                    @else
                      {{ $index + 1 }}
                    @endcan
                  </td>
                  <td class="d-none" data-brand-id="{{ Crypt::encryptString($brand->id) }}"></td>
                  <td><span class="text-inherit h5 mb-0">{{ $brand->name }}</span></td>
                  <td>
                    @php
                      $subcategoryNames = $brand->subcategories->sortBy('name')->pluck('name')->implode(', ');
                      $truncatedSubcategories = Str::limit($subcategoryNames, 50, '...');
                    @endphp
                    {{ $subcategoryNames ? $truncatedSubcategories : 'No subcategories available.' }}
                  </td>
                  <td data-order="{{ $brand->updated_at }}"><span><i class="bi-calendar2-event me-1"></i> Updated {{ $brand->updated_at->diffForHumans() }}</span></td>
                  <td>
                    <span class="badge bg-soft-{{ $brand->is_active ? 'success' : 'danger' }} text-{{ $brand->is_active ? 'success' : 'danger' }}">
                      <span class="legend-indicator bg-{{ $brand->is_active ? 'success' : 'danger' }}"></span>{{ $brand->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-white btn-sm btnViewBrand" type="button"><i class="bi-eye"></i> View</button>
                      @can('update brand maintenance' || 'delete brand maintenance')
                        <div class="btn-group">
                          <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" data-bs-toggle="dropdown" type="button"></button>
                          <div class="dropdown-menu dropdown-menu-end mt-1">
                            @can('update brand maintenance')
                              <button class="dropdown-item btnEditBrand" type="button"><i class="bi-pencil-fill dropdown-item-icon"></i> Edit Record</button>
                              <button class="dropdown-item btnStatusBrand" data-status="{{ $brand->is_active ? 0 : 1 }}" type="button">
                                <i class="bi {{ $brand->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                                {{ $brand->is_active ? 'Set to Inactive' : 'Set to Active' }}
                              </button>
                              @can('delete brand maintenance')
                                <div class="dropdown-divider"></div>
                              @endcan
                            @endcan

                            @can('delete brand maintenance')
                              <button class="dropdown-item text-danger btnDeleteBrand" type="button"><i class="bi bi-trash3-fill dropdown-item-icon text-danger"></i> Delete</button>
                            @endcan
                          </div>
                        </div>
                      @endcan
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- End Brand Datatable -->

        <!-- Footer -->
        <div class="card-footer">
          <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
            <div class="col-sm mb-2 mb-sm-0">
              <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                <span class="me-2">Showing:</span>
                <div class="tom-select-custom tom-page-w">
                  <select class="js-select form-select form-select-borderless" id="brandsDatatableEntries"
                    data-hs-tom-select-options='{
                      "hideSearch": true,
                      "searchInDropdown": false
                    }' autocomplete="off">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="{{ $totalBrands }}">All</option>
                  </select>
                </div>
                <span class="text-secondary me-2">of</span>
                <span id="brandsDatatableWithPagination"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>

            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <nav id="brandsDatatablePagination"></nav>
              </div>
            </div>
          </div>
        </div>
        <!-- End Footer -->
      </div>
      <!-- End Datatable Card -->
    </div>
    <!-- End Content -->
  </main>
@endsection

@section('sec-content')
  <x-file-maintenance.add-brand :subcategories="$subcategories" />
  <x-file-maintenance.view-brand />
  <x-file-maintenance.edit-brand :subcategories="$subcategories" />
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
  <script src="{{ Vite::asset('resources/js/modules/file-maintenance/brand-crud.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Init. -->
  <script>
    // Initialization of Datatables
    $(document).on("ready", function() {
      HSCore.components.HSDatatables.init($("#brandsDatatable"), {
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
            checkAll: "#brandsDatatableCheckAll",
            counter: "#brandsDatatableCounter",
            counterInfo: "#brandsDatatableCounterInfo"
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
        let elVal = $this.val();
        let targetColumnIndex = $this.data("target-column-index");

        if (Array.isArray(elVal)) {
          elVal = elVal.map(val => val.replace(/[.*+?^${}()|[\]\\]/g, "\\$&")).join("|");
        } else {
          elVal = elVal === "null" ? "" : elVal.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
        }
        datatable.column(targetColumnIndex).search(elVal, true, false, false).draw();

        updateFilterCountBadge($("#brandFilterCount"));
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
      };
    })();
  </script>
@endpush
