@extends('layouts.app')

@section('title')
  Inventory Masterlist
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
                <li class="breadcrumb-item active" aria-current="page">Inventory Masterlist</li>
              </ol>
            </nav>
            <h1 class="page-header-title">Item Inventory Management</h1>
            <p class="page-header-text">Manage and organize inventory records.</p>
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
                <input class="form-control" id="inventoryDatatableSearch" type="search" aria-label="Search item" placeholder="Search item">
              </div>
              <!-- End Search -->
            </form>
          </div>

          <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
            <!-- Datatable Info -->
            <div id="inventoryDatatableCounterInfo" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="fs-5 me-3">
                  <span id="inventoryDatatableCounter">0</span>
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
              <button class="btn btn-white btn-md dropdown-toggle w-100" id="usersExportDropdown" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                <i class="bi-download me-2"></i> Export
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="usersExportDropdown">
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
              <button class="btn btn-white" data-bs-toggle="offcanvas" data-bs-target="#offcanvasStockFilter" type="button" aria-controls="offcanvasStockFilter">
                <i class="bi-filter me-1"></i> Filters
              </button>
            </div>
            <!-- End Dropdown -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom">
          <table class="table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table table table-hover w-100" id="inventoryOverviewDatatable"
                 data-hs-datatables-options='{
                   "columnDefs": [{
                      "targets": [0, 6],
                      "orderable": false
                    }],
                   "order": [],
                   "info": {
                     "totalQty": "#inventoryDatatableWithPaginationInfoTotalQty"
                   },
                   "search": "#inventoryDatatableSearch",
                   "entries": "#inventoryDatatableEntries",
                   "pageLength": 5,
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "inventoryDatatablePagination"
                 }'>
            <thead class="thead-light">
            <tr>
              <th class="d-none" id="PropertyId"></th>
              <th class="col-3">Item Name</th>
              <th class="col-3">Description</th>
              <th class="col-2">Category</th>
              <th class="col-2">Brand</th>
              <th class="col-2">Depreciation</th>
              <th class="col-2">Deprecation Rate</th>
              <th class="col-1 text-center">Inventory Quantity</th>
              <th class="col-3">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($propertyParents
                ->where('is_active', 1)
                ->sortByDesc('updated_at')
                ->map(function ($propertyParent) {
                    $propertyParent->children_count = $propertyParent->propertyChildren
                        ->whereNotNull('inventory_date')
                        ->where('is_active', 1)
                        ->count();
                    return $propertyParent;
                })
            as $propertyParent)
              <tr>
                <td class="d-none" data-property-id="{{ Crypt::encryptString($propertyParent->id) }}"></td>
                <td>
                  <a class="d-flex align-items-center" href="{{ route('prop-inv.show', $propertyParent->id) }}">
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
                <td>
                  <div class="chartjs-custom" style="height: 2rem; width: 7rem;">
                    <canvas class="js-chart"
                            data-hs-chartjs-options='{
                          "type": "line",
                          "data": {
                              "labels": {{ json_encode(range(0, $propertyParent->useful_life)) }},
                              "datasets": [{
                                  "data": {{ json_encode($propertyParent->depreciationValues) }},
                                  "backgroundColor": "transparent",
                                  "borderColor": "#377dff",
                                  "borderWidth": 2,
                                  "pointBackgroundColor": "transparent",
                                  "pointHoverBackgroundColor": "#377dff",
                                  "pointBorderColor": "transparent",
                                  "pointHoverBorderColor": "#377dff",
                                  "pointRadius": 2,
                                  "pointHoverRadius": 2,
                                  "tension": 0
                              }]
                          },
                          "options": {
                           "scales": {
                              "y": {
                                "display": false
                              },
                              "x": {
                                "grid": {
                                  "display": false,
                                  "drawBorder": false
                                },
                                "ticks": {
                                  "labelOffset": 40,
                                  "maxTicksLimit": 6,
                                  "padding": 20,
                                  "maxRotation": 0,
                                  "minRotation": 0,
                                  "fontSize": 12,
                                  "fontColor": "rgba(0, 0, 0, 0.4)"
                                }
                              }
                           },
                           "hover": {
                               "mode": "nearest",
                               "intersect": false
                           },
                           "plugins": {
                              "tooltip": {
                                "prefix": "₱",
                                "intersect": false
                              }
                           }
                         }
                      }'></canvas>
                  </div>
                </td>
                <td class="text-center">
                  @php
                    $isAppreciated = $propertyParent->depreciationRate >= 0;
                    $badgeClass = $isAppreciated ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger';
                    $iconClass = $isAppreciated ?  'bi-graph-up' : 'bi-graph-down';
                    $annualDepreciation = number_format($propertyParent->annualDepreciation, 2);
                    $formattedDepreciationRate = number_format($propertyParent->depreciationRate, 2);
                  @endphp
                  <span class="badge {{ $badgeClass }} p-1" data-bs-toggle="tooltip" title="₱{{ $annualDepreciation }} per year">
                        <i class="{{ $iconClass }}"></i> {{ abs($formattedDepreciationRate) }}%
                    </span>
                </td>
                <td style="text-align: center;">{{ $propertyParent->children_count }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a class="btn btn-white btn-sm" href="{{ route('prop-inv.child.index', $propertyParent) }}">
                      <i class="bi-eye me-1"></i> View All
                    </a>

                    <!-- Button Group -->
                    <div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="productsEditDropdown1"
                              data-bs-toggle="dropdown" aria-expanded="false"></button>

                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="productsEditDropdown1">
                        <button class="dropdown-item" type="button" id="btnEditPropParent" data-prop-parent-id="{{ $propertyParent->id }}">
                          <i class="bi-pencil-fill dropdown-item-icon"></i> Edit
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
                  <select class="js-select form-select form-select-borderless" id="inventoryDatatableEntries"
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
                <nav id="inventoryDatatablePagination" aria-label="Activity pagination"></nav>
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
  {{--  <x-modals.add-property :brands="$brands" :subcategories="$subcategories" :conditions="$conditions" :acquisitions="$acquisitions" /> --}}

  {{--  <x-modals.edit-property :brands="$brands" :subcategories="$subcategories" /> --}}

  <!-- Product Filter Modal -->
  <div class="offcanvas offcanvas-end" id="offcanvasStockFilter" aria-labelledby="offcanvasStockFilterLabel" tabindex="-1">
    <div class="offcanvas-header">
      <h4 class="mb-0" id="offcanvasEcommerceProductFilterLabel">Filters</h4>
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
  <script src="{{ Vite::asset('resources/vendor/chart.js/dist/chart.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->

  <script>
    $(document).on('ready', function() {
      // INITIALIZATION OF DATATABLES
      // =======================================================
      HSCore.components.HSDatatables.init($('#inventoryOverviewDatatable'), {
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
            checkAll: '#datatableCheckAll',
            counter: '#inventoryDatatableCounter',
            counterInfo: '#inventoryDatatableCounterInfo'
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

        // INITIALIZATION OF CHARTJS
        // =======================================================
        HSCore.components.HSChartJS.init('.js-chart')
      };
    })();
  </script>
@endpush
