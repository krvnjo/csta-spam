@extends('layouts.app')

@section('title')
  Categories
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <div class="content container-fluid">
      <!-- Categories Header -->
      <div class="page-header">
        <div class="row align-items-center">
          <div class="col-sm mb-2 mb-sm-0">
            <ol class="breadcrumb breadcrumb-no-gutter">
              <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item"><a class="breadcrumb-link">File Maintenance</a></li>
              <li class="breadcrumb-item active">Categories</li>
            </ol>
            <h1 class="page-header-title">Categories</h1>
            <p class="page-header-text">Manage and organize category records.</p>
          </div>

          @can('create category maintenance')
            <div class="col-sm-auto mt-2 mt-sm-0">
              <button class="btn btn-primary w-100 w-sm-auto" id="btnAddCategoryModal" data-bs-toggle="modal" data-bs-target="#modalAddCategory">
                <i class="bi-plus-lg me-1"></i> Add Category
              </button>
            </div>
          @endcan
        </div>
      </div>
      <!-- End Categories Header -->

      <!-- Categories Details Card -->
      <div class="card mb-5">
        <div class="card-body">
          <div class="d-flex flex-column flex-sm-row align-items-sm-center text-sm-start text-center">
            <div class="flex-shrink-0"><span class="display-3 text-dark">{{ $totalCategories }}</span></div>
            <div class="flex-grow-1 ms-sm-3 my-1 mt-sm-0">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5">
                  <span class="d-block">Total Categories</span>
                  <span class="badge bg-soft-primary text-primary rounded-pill p-1">
                    <i class="bi-{{ $unusedCategories == 0 ? 'check-circle-fill' : 'trash-fill' }} me-1"></i>
                    {{ $unusedCategories == 0 ? 'Everything looks great!' : "$unusedCategories unused record(s) can be deleted." }}
                  </span>
                </div>

                <div class="col-lg-9 col-md-8 col-sm-7 mt-3 mt-sm-0">
                  <div class="d-flex justify-content-center justify-content-sm-start mb-2">
                    <div class="me-2"><span class="legend-indicator bg-success"></span>Active ({{ $activeCategories }})</div>
                    <div class="ms-2"><span class="legend-indicator bg-danger"></span>Inactive ({{ $inactiveCategories }})</div>
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
      <!-- End Categories Details Card -->

      <!-- Categories DataTable Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>
              <input class="form-control" id="categoriesDatatableSearch" type="search" placeholder="Search">
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
                <button class="dropdown-item" id="categoryExportCopy" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Copy Icon"> Copy
                </button>
                <button class="dropdown-item" id="categoryExportPrint" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Print Icon"> Print
                </button>
                <div class="dropdown-divider"></div>
                <span class="dropdown-header">Download</span>
                <button class="dropdown-item" id="categoryExportExcel" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Excel Icon"> Excel
                </button>
                <button class="dropdown-item" id="categoryExportPdf" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="PDF Icon"> PDF
                </button>
              </div>
            </div>
            <!-- End Export Dropdown -->

            <!-- Filter Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" data-bs-toggle="dropdown" data-bs-auto-close="outside" type="button">
                <i class="bi-filter me-2"></i> Filter <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="categoriesFilterCount"></span>
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end custom-dropdown">
                <div class="card">
                  <div class="card-header card-header-content-between">
                    <h5 class="card-header-title">Category Filters</h5>
                  </div>
                  <div class="card-body">
                    <!-- Status Filter -->
                    <div class="mb-2">
                      <small class="text-cap text-body">Status</small>
                      <div class="row">
                        <div class="col">
                          <div class="tom-select-custom">
                            <select class="js-select js-datatable-filter form-select" data-target-column-index="5"
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
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="categoriesDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                "targets": [0, 6],
                "orderable": false
              }],
              "order": [4, "desc"],
              "info": {
                "totalQty": "#categoriesDatatableWithPagination"
              },
              "search": "#categoriesDatatableSearch",
              "entries": "#categoriesDatatableEntries",
              "pageLength": 5,
              "isResponsive": false,
              "isShowPaging": false,
              "pagination": "categoriesDatatablePagination"
            }'>
            <thead class="thead-light">
              <tr>
                <th class="w-th" style="width: 8%">#</th>
                <th class="d-none"></th>
                <th>Category Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($categories as $category)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td class="d-none" data-category-id="{{ Crypt::encryptString($category->id) }}"></td>
                  <td><a class="h5 btnViewCategory">{{ $category->name }}</a></td>
                  <td data-order="{{ $category->created_at }}"><span><i class="bi-calendar-plus me-1"></i> {{ $category->created_at->format('F d, Y') }}</span></td>
                  <td data-order="{{ $category->updated_at }}"><span><i class="bi-calendar2-event me-1"></i> Updated {{ $category->updated_at->diffForHumans() }}</span></td>
                  <td>
                    <span class="badge bg-soft-{{ $category->is_active ? 'success' : 'danger' }} text-{{ $category->is_active ? 'success' : 'danger' }}">
                      <span class="legend-indicator bg-{{ $category->is_active ? 'success' : 'danger' }}"></span>{{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <div class="btn-group position-static">
                      <button class="btn btn-white btn-sm btnViewCategory" type="button"><i class="bi-eye"></i> View</button>

                      @canAny('update category maintenance, delete category maintenance')
                        <div class="btn-group position-static">
                          <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" data-bs-toggle="dropdown" type="button"></button>
                          <div class="dropdown-menu dropdown-menu-end mt-1">
                            @can('update category maintenance')
                              <button class="dropdown-item btnEditCategory" type="button">
                                <i class="bi-pencil-fill dropdown-item-icon"></i> Edit Record
                              </button>
                              <button class="dropdown-item btnSetCategory" data-status="{{ $category->is_active ? 0 : 1 }}" type="button">
                                <i class="bi {{ $category->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                                {{ $category->is_active ? 'Set to Inactive' : 'Set to Active' }}
                              </button>
                              @can('delete category maintenance')
                                <div class="dropdown-divider"></div>
                              @endcan
                            @endcan

                            @can('delete category maintenance')
                              <button class="dropdown-item text-danger btnDeleteCategory" type="button">
                                <i class="bi bi-trash3-fill dropdown-item-icon text-danger"></i> Delete
                              </button>
                            @endcan
                          </div>
                        </div>
                      @endcanAny
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
                  <select class="js-select form-select form-select-borderless" id="categoriesDatatableEntries"
                    data-hs-tom-select-options='{
                      "hideSearch": true,
                      "searchInDropdown": false
                    }'>
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="{{ $totalCategories }}">All</option>
                  </select>
                </div>
                <span class="text-secondary me-2">of</span>
                <span id="categoriesDatatableWithPagination"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>
            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <nav id="categoriesDatatablePagination"></nav>
              </div>
            </div>
          </div>
        </div>
        <!-- End Footer -->
      </div>
      <!-- End Categories DataTable Card -->
    </div>
  </main>
@endsection

@section('sec-content')
  <x-file-maintenance.add-category />
  <x-file-maintenance.view-category />
  <x-file-maintenance.edit-category />
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
  <script src="{{ Vite::asset('resources/js/modules/file-maintenance/category-crud.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    // Initialization of Datatable
    $(document).on("ready", function() {
      HSCore.components.HSDatatables.init($("#categoriesDatatable"), {
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

      const categoriesDatatable = HSCore.components.HSDatatables.getItem(0);

      const exportButtons = {
        "#categoryExportCopy": ".buttons-copy",
        "#categoryExportPrint": ".buttons-print",
        "#categoryExportExcel": ".buttons-excel",
        "#categoryExportPdf": ".buttons-pdf"
      };

      $.each(exportButtons, function(exportId, exportClass) {
        $(exportId).click(function() {
          categoriesDatatable.button(exportClass).trigger();
        });
      });

      $(".js-datatable-filter").on("change", function() {
        filterDatatableAndCount(categoriesDatatable, "#categoriesFilterCount");
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
