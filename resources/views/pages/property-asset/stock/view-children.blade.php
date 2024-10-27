@extends('layouts.app')

@section('title')
  P & A Masterlist | CSTA - SPAM
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
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('prop-asset.index') }}">Property & Assets</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $propertyParents->name }}</li>
              </ol>
            </nav>
            <div class="row">
              <div class="col-auto">
                <div class="avatar avatar-xl">
                  @php
                    $imagePath = public_path('storage/img/prop-asset/' . $propertyParents->image);
                    $defaultImagePath = public_path('storage/img/prop-asset/default.jpg');
                    $imageUrl = file_exists($imagePath) ? asset('storage/img/prop-asset/' . $propertyParents->image) : asset('storage/img-uploads/prop-asset/default.jpg');
                  @endphp
                  <img class="avatar-img" src="{{ $imageUrl }}" alt="Image Description">
                </div>
              </div>
              <div class="col">
                <h1 class="page-header-title position-relative">
                  {{ $propertyParents->name }}
                  <span class="d-none">{{ $propertyParents->id }}</span>
                </h1>
                <h3>
                  <span class="badge bg-primary">{{ $propertyParents->brand->name }}</span>
                  <span class="badge bg-secondary">{{ $propertyParents->subcategory->name }}</span>
                </h3>
                <p>{{ $propertyParents->description }}</p>
              </div>
            </div>

          </div>
          <!-- End Col -->

          <div class="col-sm-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPropertyChild" type="button">
              <i class="bi bi-plus-lg me-1"></i> Add Variant
            </button>
          </div>
          <!-- End Col -->
        </div>
        <!-- End Row -->
      </div>
      <!-- End Page Header -->

      <!-- Stats -->
      <div class="row">
        <div class="col-sm-6 col-lg-3 mb-lg-5 mb-3">
          <!-- Card -->
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2">Total Quantity</h6>

              <div class="row align-items-center gx-2">
                <div class="col">
                  <span class="js-counter display-4 text-dark">{{ $propertyParents->quantity }}</span>
                  {{--                <span class="text-body fs-5 ms-1">from 22</span> --}}
                </div>
                <!-- End Col -->
              </div>
              <!-- End Row -->
            </div>
          </div>
          <!-- End Card -->
        </div>

        <div class="col-sm-6 col-lg-3 mb-lg-5 mb-3">
          <!-- Card -->
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2">In Stock</h6>

              <div class="row align-items-center gx-2">
                <div class="col">
                  <span class="js-counter display-4 text-dark">{{ $propertyActiveStock }}</span>
                  {{--                <span class="text-body fs-5 ms-1">from 11</span> --}}
                </div>
              </div>
              <!-- End Row -->
            </div>
          </div>
          <!-- End Card -->
        </div>

        <div class="col-sm-6 col-lg-3 mb-lg-5 mb-3">
          <!-- Card -->
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2">In Inventory</h6>

              <div class="row align-items-center gx-2">
                <div class="col">
                  <span class="js-counter display-4 text-dark">{{ $propertyInInventory }}</span>
                  {{--                <span class="text-body fs-5 ms-1">from 48.7</span> --}}
                </div>
              </div>
              <!-- End Row -->
            </div>
          </div>
          <!-- End Card -->
        </div>

        <div class="col-sm-6 col-lg-3 mb-lg-5 mb-3">
          <!-- Card -->
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2">Active / Inactive (Stock)</h6>
              <span class="js-counter display-4">
                <span class="text-success">{{ $propertyActiveStock }}</span> /
                <span class="text-danger">{{ $propertyInactiveStock }}</span>
              </span>
              <div class="row align-items-center gx-2">
                <div class="col">
                </div>

              </div>
              <!-- End Row -->
            </div>
          </div>
          <!-- End Card -->
        </div>
      </div>
      <!-- End Stats -->

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
                <input class="form-control" id="propertyStockDatatableSearch" type="search" aria-label="Search item" placeholder="Search item">
              </div>
              <!-- End Search -->
            </form>
          </div>

          <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
            <!-- Datatable Info -->
            <div id="propertyStockDatatableCounterInfo" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="fs-5 me-3">
                  <span id="datatableCounter">0</span>
                  Selected
                </span>
                <button class="btn btn-outline-info btn-md" id="btnMoveToInventory" type="button">
                  <i class="bi bi-arrow-left-right"></i> Move to Inventory
                </button>
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
                <a class="dropdown-item" id="export-csv" href="">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/components/placeholder-csv-format.svg') }}" alt="Image Description">
                  .CSV
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
              <button class="btn btn-white" data-bs-toggle="offcanvas" data-bs-target="#propertyStockFilter" type="button" aria-controls="propertyStockFilter">
                <i class="bi-filter me-1"></i> Filters
              </button>
            </div>
            <!-- End Dropdown -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom position-relative">
          <table class="table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table table table-hover w-100" id="propertyChildDatatable"
            data-hs-datatables-options='{
                   "columnDefs": [{
                      "targets": [0, 10],
                      "orderable": false
                    }],
                   "order": [],
                   "info": {
                     "totalQty": "#propertyStockDatatableWithPaginationInfoTotalQty"
                   },
                   "search": "#propertyStockDatatableSearch",
                   "entries": "#propertyStockDatatableEntries",
                   "pageLength": 10,
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "propertyStockDatatablePagination"
                 }'>
            <thead class="thead-light">
              <tr>
                <th class="table-column-pe-0">
                  <div class="form-check">
                    <input class="form-check-input" id="propertyStockDatatableCheckAll" type="checkbox" value="">
                    <label class="form-check-label" for="propertyStockDatatableCheckAll"></label>
                  </div>
                </th>
                <th class="d-none w-auto">Child Id</th>
                <th class="table-column-ps-0">Item Code</th>
                <th>Serial #</th>
                <th>Acquired Type</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Condition</th>
                <th>Status</th>
                <th>Date Added</th>
                <th>Active</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($propertyChildren->where('inventory_date', null)->sortByDesc('updated_at') as $propertyChild)
                <tr>
                  <td class="table-column-pe-0">
                    <div class="form-check">
                      <input class="form-check-input child-checkbox" id="propertyStockDatatableCheck{{ $propertyChild->id }}" type="checkbox" value="{{ $propertyChild->id }}">
                      <label class="form-check-label" for="propertyStockDatatableCheck{{ $propertyChild->id }}"></label>
                    </div>
                  </td>
                  <td class="d-none" data-child-id="{{ Crypt::encryptString($propertyChild->id) }}"></td>
                  <td>
                    @if ($propertyChild->created_at == $propertyChild->updated_at)
                      <span class="badge bg-success">New</span>
                      {{ $propertyChild->prop_code }}
                    @elseif ($propertyChild->created_at->diffInDays(Carbon::now()) >= 7)
                      {{ $propertyChild->prop_code }}
                    @else
                      {{ $propertyChild->prop_code }}
                    @endif
                  </td>
                  <td>{{ $propertyChild->serial_num ?? '-' }}</td>
                  <td>{{ $propertyChild->acquisition->name }}</td>
                  <td>{{ $propertyChild->designation->name }}</td>
                  <td>{{ $propertyChild->department->dept_code }}</td>
                  <td>{{ $propertyChild->condition->name }}</td>
                  <td><span class="{{ $propertyChild->status->color->class }} fs-6">{{ $propertyChild->status->name }}</span></td>
                  <td data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
                    title="Date Acquired: {{ \Carbon\Carbon::parse($propertyChild->acq_date)->format('F j, Y') }}, Warranty Date: {{ $propertyChild->warranty_date ? \Carbon\Carbon::parse($propertyChild->warranty_date)->format('F j, Y') : '-' }}">
                    {{ \Carbon\Carbon::parse($propertyChild->stock_date)->format('F j, Y') }}</td>
                  <td @if ($propertyChild->remarks) data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="Remarks: {{ $propertyChild->remarks }}" @endif>
                    @if ($propertyChild->is_active)
                      <span class="legend-indicator bg-success"></span>Active
                    @else
                      <span class="legend-indicator bg-danger"></span>Deleted
                    @endif
                  </td>
                  <td>
                    <div class="btn-group" role="group">
                      <button class="btn btn-white btn-sm btnEditPropChild" type="button">
                        <i class="bi-pencil-fill me-1"></i> Edit
                      </button>

                      <!-- Button Group -->
                      <div class="btn-group">
                        <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="productsEditDropdown1" data-bs-toggle="dropdown" type="button"
                          aria-expanded="false"></button>

                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="productsEditDropdown1">
                          @if (!$propertyChild->is_active)
                            <button class="dropdown-item" id="btnRestorePropChild" data-child-restore-id="{{ $propertyChild->id }}" type="button">
                              <i class="bi-arrow-clockwise dropdown-item-icon"></i> Restore
                            </button>
                          @else
                            {{--                          <button class="dropdown-item" type="button" id="btnMoveToInventory" data-child-move-id="{{ $propertyChild->id }}"> --}}
                            {{--                            <i class="bi bi-arrow-left-right dropdown-item-icon"></i> Move to Inventory --}}
                            {{--                          </button> --}}
                            <button class="dropdown-item" id="btnDeletePropChild" data-child-delete-id="{{ $propertyChild->id }}" type="button">
                              <i class="bi-trash dropdown-item-icon"></i> Delete
                            </button>
                          @endif
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
                  <select class="js-select form-select form-select-borderless" id="propertyStockDatatableEntries"
                    data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "hideSearch": true
                          }' autocomplete="off">
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                  </select>
                </div>
                <!-- End Select -->

                <span class="text-secondary me-2">of</span>

                <!-- Pagination Quantity -->
                <span id="propertyStockDatatableWithPaginationInfoTotalQty"></span>
              </div>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <!-- Pagination -->
                <nav id="propertyStockDatatablePagination" aria-label="Activity pagination"></nav>
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
  <x-property-asset.stock.add-children :propertyParents="$propertyParents" />
  <x-property-asset.stock.edit-children :propertyParents="$propertyParents" :propertyChildren="$propertyChildren" :conditions="$conditions" :acquisitions="$acquisitions" />
  {{--  <x-modals.edit-property-child :propertyParents="$propertyParents" :conditions="$conditions" :acquisitions="$acquisitions" :propertyChildren="$propertyChildren" /> --}}
  {{--  <x-modals.move-property :designations="$designations" :departments="$departments" :statuses="$statuses"/> --}}

  <!-- Product Filter Modal -->
  <div class="offcanvas offcanvas-end" id="propertyStockFilter" aria-labelledby="propertyStockFilterLabel" tabindex="-1">
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
  <!-- JS Other Plugins -->
  <script src="{{ Vite::asset('resources/js/modules/properties-assets/property-child-crud.js') }}"></script>

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

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <script>
    $(document).on('ready', function() {
      // INITIALIZATION OF DATATABLES
      // =======================================================
      HSCore.components.HSDatatables.init($('#propertyChildDatatable'), {
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
            checkAll: '#propertyStockDatatableCheckAll',
            counter: '#propertyStockDatatableCounter',
            counterInfo: '#propertyStockDatatableCounterInfo'
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
        new HSSideNav('.js-navbar-vertical-aside').init();


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        new HSFormSearch('.js-form-search');
      }
    })()
  </script>
@endpush
