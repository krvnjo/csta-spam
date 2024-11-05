@extends('layouts.app')

@section('title')
  Stock Masterlist
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
                <li class="breadcrumb-item active" aria-current="page">Stock Masterlist</li>
              </ol>
            </nav>
            <h1 class="page-header-title">Item Stock Management</h1>
            <p class="page-header-text">Manage and organize stock records.</p>
            <p class="page-header-text">
            <span class="legend-indicator bg-danger "></span>No stock
              <span class="ms-2"></span>
            <span class="legend-indicator bg-info"></span>Low stock
            </p>
          </div>
          <!-- End Col -->

          <div class="col-sm-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPropertyModal" type="button">
              <i class="bi bi-plus-lg me-1"></i> Add Item
            </button>
          </div>
          <!-- End Col -->
        </div>
        <!-- End Row -->
      </div>
      <!-- End Page Header -->

      {{--    <!-- Stats --> --}}
      {{--    <div class="row"> --}}
      {{--      <div class="col-sm-6 col-lg-3 mb-lg-5 mb-3"> --}}
      {{--        <!-- Card --> --}}
      {{--        <div class="card h-100"> --}}
      {{--          <div class="card-body"> --}}
      {{--            <h6 class="card-subtitle mb-2">Total Stocks</h6> --}}

      {{--            <div class="row align-items-center gx-2"> --}}
      {{--              <div class="col"> --}}
      {{--                <span class="js-counter display-4 text-dark">24</span> --}}
      {{--                <span class="text-body fs-5 ms-1">from 22</span> --}}
      {{--              </div> --}}
      {{--              <!-- End Col --> --}}

      {{--              <div class="col-auto"> --}}
      {{--                <span class="badge bg-soft-success text-success p-1"> --}}
      {{--                  <i class="bi-graph-up"></i> 5.0% --}}
      {{--                </span> --}}
      {{--              </div> --}}
      {{--              <!-- End Col --> --}}
      {{--            </div> --}}
      {{--            <!-- End Row --> --}}
      {{--          </div> --}}
      {{--        </div> --}}
      {{--        <!-- End Card --> --}}
      {{--      </div> --}}

      {{--      <div class="col-sm-6 col-lg-3 mb-lg-5 mb-3"> --}}
      {{--        <!-- Card --> --}}
      {{--        <div class="card h-100"> --}}
      {{--          <div class="card-body"> --}}
      {{--            <h6 class="card-subtitle mb-2">Total Inventory</h6> --}}

      {{--            <div class="row align-items-center gx-2"> --}}
      {{--              <div class="col"> --}}
      {{--                <span class="js-counter display-4 text-dark">12</span> --}}
      {{--                <span class="text-body fs-5 ms-1">from 11</span> --}}
      {{--              </div> --}}

      {{--              <div class="col-auto"> --}}
      {{--                <span class="badge bg-soft-success text-success p-1"> --}}
      {{--                  <i class="bi-graph-up"></i> 1.2% --}}
      {{--                </span> --}}
      {{--              </div> --}}
      {{--            </div> --}}
      {{--            <!-- End Row --> --}}
      {{--          </div> --}}
      {{--        </div> --}}
      {{--        <!-- End Card --> --}}
      {{--      </div> --}}

      {{--      <div class="col-sm-6 col-lg-3 mb-lg-5 mb-3"> --}}
      {{--        <!-- Card --> --}}
      {{--        <div class="card h-100"> --}}
      {{--          <div class="card-body"> --}}
      {{--            <h6 class="card-subtitle mb-2">New Stocks</h6> --}}

      {{--            <div class="row align-items-center gx-2"> --}}
      {{--              <div class="col"> --}}
      {{--                <span class="js-counter display-4 text-dark">56</span> --}}
      {{--                <span class="display-4 text-dark">%</span> --}}
      {{--                <span class="text-body fs-5 ms-1">from 48.7</span> --}}
      {{--              </div> --}}

      {{--              <div class="col-auto"> --}}
      {{--                <span class="badge bg-soft-danger text-danger p-1"> --}}
      {{--                  <i class="bi-graph-down"></i> 2.8% --}}
      {{--                </span> --}}
      {{--              </div> --}}
      {{--            </div> --}}
      {{--            <!-- End Row --> --}}
      {{--          </div> --}}
      {{--        </div> --}}
      {{--        <!-- End Card --> --}}
      {{--      </div> --}}

      {{--      <div class="col-sm-6 col-lg-3 mb-lg-5 mb-3"> --}}
      {{--        <!-- Card --> --}}
      {{--        <div class="card h-100"> --}}
      {{--          <div class="card-body"> --}}
      {{--            <h6 class="card-subtitle mb-2">In Maintenance</h6> --}}

      {{--            <div class="row align-items-center gx-2"> --}}
      {{--              <div class="col"> --}}
      {{--                <span class="js-counter display-4 text-dark">28.6</span> --}}
      {{--                <span class="display-4 text-dark">%</span> --}}
      {{--                <span class="text-body fs-5 ms-1">from 28.6%</span> --}}
      {{--              </div> --}}

      {{--              <div class="col-auto"> --}}
      {{--                <span class="badge bg-soft-secondary text-secondary p-1">0.0%</span> --}}
      {{--              </div> --}}
      {{--            </div> --}}
      {{--            <!-- End Row --> --}}
      {{--          </div> --}}
      {{--        </div> --}}
      {{--        <!-- End Card --> --}}
      {{--      </div> --}}
      {{--    </div> --}}
      {{--    <!-- End Stats --> --}}

      <!-- Card -->

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
                <input class="form-control" id="propertyDatatableSearch" type="search" aria-label="Search item" placeholder="Search item">
              </div>
              <!-- End Search -->
            </form>
          </div>

          <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
            <!-- Datatable Info -->
            <div id="propertyDatatableCounterInfo" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="fs-5 me-3">
                  <span id="propertyDatatableCounter">0</span>
                  Selected
                </span>
                <a class="btn btn-outline-danger btn-md" href="">
                  <i class="bi-trash"></i> Delete
                </a>
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
          <table class="table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table table table-hover w-100" id="propertyOverviewDatatable"
            data-hs-datatables-options='{
                   "columnDefs": [{
                      "targets": [0, 7],
                      "orderable": false
                    }],
                   "order": [],
                   "info": {
                     "totalQty": "#propertyDatatableWithPaginationInfoTotalQty"
                   },
                   "search": "#propertyDatatableSearch",
                   "entries": "#propertyDatatableEntries",
                   "pageLength": 5,
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "propertyDatatablePagination"
                 }'>
            <thead class="thead-light">
              <tr>
                <th class="d-none" id="PropertyId"></th>
                <th class="text-center" style="padding: 0; padding-left: 1rem;">
                  <span class="legend-indicator bg-danger"></span>
                  <span class="legend-indicator bg-info"></span>
                </th>
                <th class="col-3">Item Name</th>
                <th class="col-3">Description</th>
                <th class="col-2">Category</th>
                <th class="col-2">Brand</th>
                <th class="col-1 text-center">Total Quantity</th>
                <th class="col-3">Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($propertyParents->where('is_active', 1)->where('deleted_at', null)->sortByDesc('updated_at') as $propertyParent)
                <tr>
                  <td class="d-none" data-property-id="{{ Crypt::encryptString($propertyParent->id) }}"></td>
                  <td style="text-align: center; padding: 0;">
                    @if (!$propertyParent->propertyChildren->where('inventory_date', null)->count())
                      <span class="legend-indicator bg-danger" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="No Stock"></span>
                    @elseif ($propertyParent->propertyChildren->where('inventory_date', null)->count() <= 5)
                      <span class="legend-indicator bg-info" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="Low Stock"></span>
                    @endif
                  </td>
                  <td>
                    <a class="d-flex align-items-center btnViewProperty">
                      <div class="avatar avatar-lg">
                        @php
                          $imagePath = public_path('storage/img/prop-asset/' . $propertyParent->image);
                          $defaultImagePath = public_path('storage/img/prop-asset/default.jpg');
                          $imageUrl = file_exists($imagePath) ? asset('storage/img/prop-asset/' . $propertyParent->image) : asset('storage/img/prop-asset/default.jpg');
                        @endphp
                        <img class="avatar-img" src="{{ $imageUrl }}" alt="Image Description">
                      </div>
                      <div class="ms-3">
                        <span class="d-block h5 mb-0 text-inherit">{{ $propertyParent->name }}</span>
                      </div>
                    </a>
                  </td>
                  <td>
                    <span style="color:gray"
                      @if (!empty($propertyParent->description) && strlen($propertyParent->description) > 25) data-bs-toggle="tooltip"
                        data-bs-html="true"
                        data-bs-placement="bottom"
                        title="{{ $propertyParent->description }}" @endif>
                      {{ Str::limit(!empty($propertyParent->description) ? $propertyParent->description : 'No description provided', 30) }}
                    </span>
                  </td>
                  <td>
                    <span class="d-block fs-5">{{ $propertyParent->subcategory->name }}</span>
                  </td>
                  <td>{{ $propertyParent->brand->name }}</td>
                  <td style="text-align: center;">
                    {{ $propertyParent->quantity }}
                  </td>
                  <td>
                    <div class="btn-group position-static" role="group">
                      <a class="btn btn-white btn-sm" href="{{ route('prop-asset.child.index', $propertyParent) }}">
                        <i class="bi-eye me-1"></i> View All
                      </a>

                      <!-- Button Group -->
                      <div class="btn-group position-static">
                        <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="productsEditDropdown1" data-bs-toggle="dropdown" type="button"
                          aria-expanded="false"></button>

                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="productsEditDropdown1">
                          <button class="dropdown-item btnEditPropParent" type="button">
                            <i class="bi-pencil-fill dropdown-item-icon"></i> Edit Item
                          </button>
                          <button class="dropdown-item btnViewProperty" type="button">
                            <i class="bi bi-info-square-fill dropdown-item-icon"></i> View Details
                          </button>
                        </div>
                      </div>
                      <!-- End Button Group -->
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
                  <select class="js-select form-select form-select-borderless" id="propertyDatatableEntries"
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
                <span id="propertyDatatableWithPaginationInfoTotalQty"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <!-- Pagination -->
                <nav id="propertyDatatablePagination" aria-label="Activity pagination"></nav>
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
  <x-property-asset.add-property :brands="$brands" :subcategories="$subcategories" :conditions="$conditions" :acquisitions="$acquisitions" />

  <x-property-asset.edit-property :brands="$brands" :subcategories="$subcategories" />

  <x-property-asset.view-property />

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

  <!-- JS Modules -->
  <script src="{{ Vite::asset('resources/js/modules/properties-assets/property-stock-crud.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Init. -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    });

    (function() {
      // INITIALIZATION OF DROPZONE
      // =======================================================
      var addDropzone, editDropzone;

      HSCore.components.HSDropzone.init('.js-dropzone', {
        maxFiles: 1,
        maxFilesize: 1,
        acceptedFiles: ".jpeg,.jpg,.png",
        dictDefaultMessage: "Drag and drop your file here or click to upload",

        init: function() {
          var dropzoneInstance = this;

          if (this.element.id === 'addPropertyDropzone') {
            addDropzone = this;
          } else if (this.element.id === 'editPropertyDropzone') {
            editDropzone = this;
          }

          this.on("addedfile", function(file) {
            dropzoneInstance.element.querySelector(".dz-message").style.display = "none";
          });

          this.on("removedfile", function(file) {
            dropzoneInstance.element.querySelector(".dz-message").style.display = "block";
          });

          this.on("error", function(file, message) {
            if (file.size > 1048576) {
              Swal.fire({
                icon: 'error',
                title: 'File too large',
                text: 'File size exceeds the limit of 1MB. Please upload a smaller file.',
                confirmButtonText: 'OK',
                customClass: {
                  popup: 'bg-light rounded-3 shadow fs-4',
                  title: 'fs-1',
                  htmlContainer: 'text-muted text-center fs-4',
                  confirmButton: 'btn btn-sm btn-info',
                },
              });
              this.removeFile(file);
            }
          });
        }
      });
    })();
  </script>
  <script>
    $(document).on('ready', function() {
      // INITIALIZATION OF DATATABLES
      // =======================================================
      HSCore.components.HSDatatables.init($('#propertyOverviewDatatable'), {
        dom: 'Bfrtip',
        buttons: [{
            extend: 'copy',
            className: 'd-none',
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(8))'
            }
          },
          {
            extend: 'excel',
            className: 'd-none',
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(8))'
            }
          },
          {
            extend: 'pdf',
            className: 'd-none',
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(8))'
            }
          },
          {
            extend: 'print',
            className: 'd-none',
            title: '',
            message: '',
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(8))',
            },
            customize: function(win) {

              function formatDate(date) {
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return date.toLocaleDateString(undefined, options);
              }

              const currentDate = formatDate(new Date());

              $(win.document.body)
                .css('font-size', '10pt')
                .prepend(`
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                    <div style="display: flex; align-items: center;">
                      <img src="{{ Vite::asset('resources/svg/logos/logo.svg') }}" style="width: 14rem; margin-right: 7rem;" alt="CSTA - SPAM Logo" />
                    </div>
                    <div style="font-size: 10px;">${currentDate}</div> <!-- Add current date without right alignment -->
                  </div>
                  <h2 style="font-size: 12px; margin: 5px 0;">Colegio De Sta. Teresa De Avila - Stock Masterlist</h2> <!-- Custom print title -->
                `);
              $(win.document.body).find('table')
                .css({
                  'font-size': '8pt',
                  'width': '100%',
                  'border-collapse': 'collapse',
                });
              $(win.document.body).find('table th, table td')
                .css({
                  'padding': '4px',
                  'border': '1px solid #ccc',
                });
            }
          }
        ],
        select: {
          style: 'multi',
          selector: 'td:first-child input[type="checkbox"]',
          classMap: {
            checkAll: '#propertyDatatableCheckAll',
            counter: '#propertyDatatableCounter',
            counterInfo: '#propertyDatatableCounterInfo'
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
