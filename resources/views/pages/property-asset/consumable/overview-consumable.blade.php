@extends('layouts.app')

@section('title')
  Consumable Masterlist
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
  <link href="{{ Vite::asset('resources/vendor/jsvectormap/dist/css/jsvectormap.min.css') }}" rel="stylesheet">
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content" role="main">
    <!-- Content -->
    <div class="content container-fluid">
      <!-- Page Header -->
      <div class="page-header">
        <div class="row align-items-end">
          <div class="col-sm mb-sm-0 mb-2">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-no-gutter">
                <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Consumable Masterlist</li>
              </ol>
            </nav>
            <h1 class="page-header-title">Item Consumable Management</h1>
            <p class="page-header-text">Manage and organize consumable items.</p>
            <p class="page-header-text">
              <span class="legend-indicator bg-danger "></span>No stock
              <span class="ms-2"></span>
              <span class="legend-indicator bg-info"></span>Low stock
            </p>
          </div>
          <!-- End Col -->

          <div class="col-sm-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addConsumableModal" type="button">
              <i class="bi bi-plus-lg me-1"></i> Add Item
            </button>
          </div>
          <!-- End Col -->
        </div>
        <!-- End Row -->
      </div>
      <!-- End Page Header -->

      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-md-0 mb-2">
            <form>
              <!-- Search -->
              <div class="input-group input-group-merge input-group-flush">
                <div class="input-group-prepend input-group-text">
                  <i class="bi-search"></i>
                </div>
                <input class="form-control" id="consumableDatatableSearch" type="search" aria-label="Search item" placeholder="Search item">
              </div>
              <!-- End Search -->
            </form>
          </div>

          <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
            <!-- Datatable Info -->
            <div id="consumableDatatableCounterInfo" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="fs-5 me-3">
                  <span id="consumableDatatableCounter">0</span>
                  Selected
                </span>
                <button class="btn btn-outline-danger btn-md" id="btnMultiDeleteConsumable" type="button">
                  <i class="bi-trash3-fill"></i> Delete
                </button>
              </div>
            </div>
            <!-- End Datatable Info -->

            <!-- Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-md dropdown-toggle w-100" id="propertyExportDropdown" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                <i class="bi-download me-2"></i> Export
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="propertyExportDropdown">
                <span class="dropdown-header">Options</span>
                <a class="dropdown-item" id="export-copy" href="">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Image Description">
                  Copy
                </a>
                <a class="dropdown-item" id="export-print" href="">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Image Description">
                  Print
                </a>
                <div class="dropdown-divider"></div>
                <span class="dropdown-header">Download options</span>
                <a class="dropdown-item" id="export-excel" href="">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Image Description">
                  Excel
                </a>
                <a class="dropdown-item" id="export-pdf" href="">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="Image Description">
                  PDF
                </a>
              </div>
            </div>
            <!-- End Dropdown -->

            <!-- Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPropertyFilter" type="button" aria-controls="offcanvasPropertyFilter">
                <i class="bi-filter me-1"></i> Filters
              </button>
            </div>
            <!-- End Dropdown -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom">
          <table class="table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table table table-hover w-100" id="consumableOverviewDatatable"
                 data-hs-datatables-options='{
                   "columnDefs": [{
                      "targets": [0, 9],
                      "orderable": false
                    }],
                   "order": [],
                   "info": {
                     "totalQty": "#consumableDatatableWithPaginationInfoTotalQty"
                   },
                   "search": "#consumableDatatableSearch",
                   "entries": "#consumableDatatableEntries",
                   "pageLength": 5,
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "consumableDatatablePagination"
                 }'>
            <thead class="thead-light">
            <tr>
              <th class="table-column-pe-0">
                <div class="form-check">
                  <input class="form-check-input" id="consumableDatatableCheckAll" type="checkbox" value="">
                  <label class="form-check-label" for="consumableDatatableCheckAll"></label>
                </div>
              </th>
              <th class="d-none" id="PropertyId"></th>
              <th class="text-center" style="padding: 0; padding-left: 1rem; width: 3rem;">
                <span class="legend-indicator bg-danger"></span>
                <span class="legend-indicator bg-info"></span>
              </th>
              <th class="col-3">Item Name</th>
              <th class="col-3">Description</th>
              <th class="col-2">Unit</th>
              <th class="col-1 text-center">Quantity</th>
              <th class="col-2">Last Updated</th>
              <th class="col-2 text-center">Status</th>
              <th class="col-3 text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($propertyConsumables->where('deleted_at', null)->sortByDesc('updated_at') as $propertyConsumable)
              <tr>
                <td class="table-column-pe-0">
                  <div class="form-check">
                    <input class="form-check-input child-checkbox" id="consumableDatatableCheck{{ $propertyConsumable->id }}" type="checkbox" value="{{ $propertyConsumable->id }}">
                    <label class="form-check-label" for="consumableDatatableCheck{{ $propertyConsumable->id }}"></label>
                  </div>
                </td>
                <td class="d-none" data-consumable-id="{{ Crypt::encryptString($propertyConsumable->id) }}"></td>
                <td style="text-align: center; padding: 0;">
                  @if ($propertyConsumable->quantity == 0)
                    <span class="legend-indicator bg-danger" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="No Stock"></span>
                  @elseif ($propertyConsumable->quantity <= 10)
                    <span class="legend-indicator bg-info" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="Low Stock"></span>
                  @endif
                </td>
                <td>{{ $propertyConsumable->name }}</td>
                <td>{{ $propertyConsumable->description }}</td>
                <td>{{ $propertyConsumable->unit->name }}</td>
                <td class="text-center">{{ $propertyConsumable->quantity }}</td>
                <td data-order="{{ $propertyConsumable->updated_at }}">
                  <span><i class="bi-calendar2-event me-1"></i> Updated {{ $propertyConsumable->updated_at->diffForHumans() }}</span>
                </td>
                <td>
                    <span class="badge bg-soft-{{ $propertyConsumable->is_active ? 'success' : 'danger' }} text-{{ $propertyConsumable->is_active ? 'success' : 'danger' }}">
                      <span class="legend-indicator bg-{{ $propertyConsumable->is_active ? 'success' : 'danger' }}"></span>{{ $propertyConsumable->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                  <div class="btn-group position-static">
                    <button class="btn btn-white btn-sm" type="button">
                      <i class="bi bi-check-circle-fill me-1"></i> Use
                    </button>
                    <div class="btn-group position-static">
                      <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="consumableEditDropdown" data-bs-toggle="dropdown" type="button"
                              aria-expanded="false"></button>

                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="consumableEditDropdown">
                        <button class="dropdown-item btnRestockConsumable"
                                data-restock-id="{{ $propertyConsumable->id }}"
                                data-consumable-name="{{ $propertyConsumable->name }}"
                                data-past-quantity="{{ $propertyConsumable->quantity }}"
                        type="button">
                        <i class="bi bi-plus-circle-fill dropdown-item-icon"></i> Restock
                        </button>

                        <button class="dropdown-item btnEditConsumable" type="button">
                          <i class="bi bi-pencil-fill dropdown-item-icon"></i> Edit
                        </button>
                        <button class="dropdown-item" type="button">
                          <i class="bi bi-info-square-fill dropdown-item-icon"></i> View Details
                        </button>
                        <button class="dropdown-item btnStatusConsumable" data-status="{{ $propertyConsumable->is_active ? 0 : 1 }}" type="button">
                          <i class="bi {{ $propertyConsumable->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                          {{ $propertyConsumable->is_active ? 'Set to Inactive' : 'Set to Active' }}
                        </button>
                        <button class="dropdown-item text-danger btnDeleteConsumable" data-consume-del-id="{{ $propertyConsumable->id }}" type="button">
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
        <!-- End Table -->

        <!-- Footer -->
        <div class="card-footer">
          <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
            <div class="col-sm mb-sm-0 mb-2">
              <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                <span class="me-2">Showing:</span>

                <!-- Select -->
                <div class="tom-select-custom" style="width: 80px;">
                  <select class="js-select form-select form-select-borderless" id="consumableDatatableEntries"
                          data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "hideSearch": true
                          }' autocomplete="off">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                  </select>
                </div>
                <!-- End Select -->

                <span class="text-secondary me-2">of</span>

                <!-- Pagination Quantity -->
                <span id="consumableDatatableWithPaginationInfoTotalQty"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <!-- Pagination -->
                <nav id="consumableDatatablePagination" aria-label="Activity pagination"></nav>
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

@section('sec-content')
  <x-property-asset.consumable.add-consumable  :units="$units" :propertyConsumables="$propertyConsumables"/>
  <x-property-asset.consumable.edit-consumable  :units="$units" :propertyConsumables="$propertyConsumables"/>
  <x-property-asset.consumable.restock-consumable />

  <!-- Product Filter Modal -->
  <div class="offcanvas offcanvas-end" id="offcanvasPropertyFilter" aria-labelledby="offcanvasPropertyFilterLabel" tabindex="-1">
    <div class="offcanvas-header">
      <h4 class="mb-0" id="offcanvasPropertyFilterLabel">Filters</h4>
      <button class="btn-close" data-bs-dismiss="offcanvas" type="button" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <span class="text-cap small">Product vendor</span>

      <div class="row">
        <div class="col-6">
          <div class="d-grid mb-2 gap-2">
            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio1" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio1">Google</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio2" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio2">Topman</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio3" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio3">RayBan</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio4" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio4">Mango</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio5" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio5">Calvin Klein</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio6" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio6">Givenchy</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio7" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio7">Asos</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio8" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio8">Apple</label>
            </div>
            <!-- End Form Check -->
          </div>
        </div>

        <div class="col-6">
          <div class="d-grid mb-2 gap-2">
            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio9" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio9">Times</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio10" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio10">Asos</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio11" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio11">Nike Jordan</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio12" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio12">VA RVCA</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio13" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio13">Levis</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio14" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio14">Beats</label>
            </div>
            <!-- End Form Check -->

            <!-- Form Check -->
            <div class="form-check">
              <input class="form-check-input" id="productVendorFilterRadio15" name="productAvailabilityFilterRadio" type="radio" value="">
              <label class="form-check-label" for="productVendorFilterRadio15">Clarks</label>
            </div>
            <!-- End Form Check -->
          </div>
        </div>
      </div>
      <!-- End Row -->

      <a class="link mt-2" href="">
        <i class="bi-x"></i> Clear
      </a>

      <hr>

      <span class="text-cap small">Availability</span>

      <div class="d-grid mb-2 gap-2">
        <!-- Form Check -->
        <div class="form-check">
          <input class="form-check-input" id="productAvailabilityFilterRadio1" name="productAvailabilityFilterRadio" type="radio" value="">
          <label class="form-check-label" for="productAvailabilityFilterRadio1">Available on Online Store</label>
        </div>
        <!-- End Form Check -->

        <!-- Form Check -->
        <div class="form-check">
          <input class="form-check-input" id="productAvailabilityFilterRadio2" name="productAvailabilityFilterRadio" type="radio" value="">
          <label class="form-check-label" for="productAvailabilityFilterRadio2">Unavailable on Online Store</label>
        </div>
        <!-- End Form Check -->
      </div>

      <a class="link mt-2" href="">
        <i class="bi-x"></i> Clear
      </a>

      <hr>

      <span class="text-cap small">Tagged with</span>

      <div class="mb-2">
        <input class="form-control" id="tagsLabel" name="tagsName" type="text" aria-label="Enter tags here" placeholder="Enter tags here">
      </div>

      <a class="link mt-2" href="">
        <i class="bi-x"></i> Clear
      </a>

      <hr>

      <span class="text-cap small">Product type</span>

      <div class="d-grid mb-2 gap-2">
        <!-- Form Check -->
        <div class="form-check">
          <input class="form-check-input" id="productTypeFilterRadio1" name="productTypeFilterRadio" type="radio" value="">
          <label class="form-check-label" for="productTypeFilterRadio1">Shoes</label>
        </div>
        <!-- End Form Check -->

        <!-- Form Check -->
        <div class="form-check">
          <input class="form-check-input" id="productTypeFilterRadio2" name="productTypeFilterRadio" type="radio" value="">
          <label class="form-check-label" for="productTypeFilterRadio2">Accessories</label>
        </div>
        <!-- End Form Check -->

        <!-- Form Check -->
        <div class="form-check">
          <input class="form-check-input" id="productTypeFilterRadio3" name="productTypeFilterRadio" type="radio" value="">
          <label class="form-check-label" for="productTypeFilterRadio3">Clothing</label>
        </div>
        <!-- End Form Check -->

        <!-- Form Check -->
        <div class="form-check">
          <input class="form-check-input" id="productTypeFilterRadio4" name="productTypeFilterRadio" type="radio" value="">
          <label class="form-check-label" for="productTypeFilterRadio4">Electronics</label>
        </div>
        <!-- End Form Check -->
      </div>

      <a class="link mt-2" href="">
        <i class="bi-x"></i> Clear
      </a>

      <hr>

      <span class="text-cap small">Collection</span>

      <!-- Input Group -->
      <div class="input-group input-group-merge mb-2">
        <div class="input-group-prepend input-group-text">
          <i class="bi-search"></i>
        </div>

        <input class="form-control" type="search" aria-label="Search for collections" placeholder="Search for collections">
      </div>
      <!-- End Input Group -->

      <!-- Form Check -->
      <div class="form-check mb-2">
        <input class="form-check-input" id="productCollectionFilterRadio1" type="radio" value="">
        <label class="form-check-label" for="productCollectionFilterRadio1">Home page</label>
      </div>
      <!-- End Form Check -->

      <a class="link mt-2" href="">
        <i class="bi-x"></i> Clear
      </a>
    </div>
    <!-- End Body -->

    <!-- Footer -->
    <div class="offcanvas-footer">
      <div class="row gx-2">
        <div class="col">
          <div class="d-grid">
            <button class="btn btn-white" type="button">Clear all filters</button>
          </div>
        </div>
        <!-- End Col -->

        <div class="col">
          <div class="d-grid">
            <button class="btn btn-primary" type="button">Save</button>
          </div>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
    </div>
    <!-- End Footer -->
  </div>
  <!-- End Product Filter Modal -->
@endsection

@push('scripts')
  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/properties-assets/property-consumable-crud.js') }}"></script>

  <!-- JS Other Plugins -->
  <script src="{{ Vite::asset('resources/vendor/hs-toggle-password/dist/js/hs-toggle-password.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-file-attach/dist/hs-file-attach.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-step-form/dist/hs-step-form.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-counter/dist/hs-counter.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/appear/dist/appear.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/imask/dist/imask.min.js') }}"></script>
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
  <script src="{{ Vite::asset('resources/vendor/dropzone/dist/min/dropzone.min.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Init. -->
  <script>
    $(document).on('ready', function() {
      // INITIALIZATION OF DATATABLES
      // =======================================================
      HSCore.components.HSDatatables.init($('#consumableOverviewDatatable'), {
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
            checkAll: '#consumableDatatableCheckAll',
            counter: '#consumableDatatableCounter',
            counterInfo: '#consumableDatatableCounterInfo'
          }
        },
        language: {
          zeroRecords: `<div class="text-center p-4">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations-light/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
            <p class="mb-0">No data to show</p>
            </div>`
        }
      })

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
        var $this = $(this),
          elVal = $this.val(),
          targetColumnIndex = $this.data('target-column-index');

        if (elVal === 'null') elVal = ''

        datatable.column(targetColumnIndex).search(elVal).draw();
      });
    });
  </script>

  <!-- JS Plugins Init. -->
  <script>
    // Initialization of Other Plugins
    (function() {
      window.onload = function() {
        // INITIALIZATION OF NAVBAR VERTICAL ASIDE
        // =======================================================
        new HSSideNav('.js-navbar-vertical-aside').init()


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        new HSFormSearch('.js-form-search')


        // INITIALIZATION OF BOOTSTRAP DROPDOWN
        // =======================================================
        HSBsDropdown.init()
      }
    })()
  </script>
@endpush
