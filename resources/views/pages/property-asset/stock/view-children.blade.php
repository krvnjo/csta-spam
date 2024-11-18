@extends('layouts.app')

@section('title')
  P & A Masterlist
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
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('prop-asset.index') }}">Item Masterlist</a></li>
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
                <h4>
                  <span class="badge bg-primary">{{ $propertyParents->brand->name ?? '' }}</span>
                  <span class="badge bg-secondary">{{ $propertyParents->category->name ?? '' }}</span>
                </h4>
                <p>Specifications: {{ $propertyParents->specification }}</p>
              </div>
            </div>
            <p class="page-header-text">Manage and organize stock item records.</p>
          </div>
          <!-- End Col -->

          @access('Item Management', 'Read and Write, Full Access')
            <div class="col-sm-auto">
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPropertyChild" type="button">
                <i class="bi bi-plus-lg me-1"></i>
                @if ($propertyParents->is_consumable)
                  Restock
                @else
                  Add Variation
                @endif
              </button>
            </div>
          @endaccess
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
                  <span class="js-counter display-4 text-dark">
                    @if ($propertyParents->is_consumable)
                      {{ $propertyParents->quantity }}
                    @else
                      {{ $propertyQuantity }}
                    @endif
                  </span>
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
              <h6 class="card-subtitle mb-2">Quantity In Stock</h6>

              <div class="row align-items-center gx-2">
                <div class="col">
                  <span class="js-counter display-4 text-dark">
                    @if ($propertyParents->is_consumable)
                      {{ $propertyParents->quantity }}
                    @else
                      {{ $propertyActiveStock }}
                    @endif
                  </span>
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
              <h6 class="card-subtitle mb-2">Quantity On Site</h6>

              <div class="row align-items-center gx-2">
                <div class="col">
                  <span class="js-counter display-4 text-dark">
                    @if ($propertyParents->is_consumable)
                      <span class="badge text-secondary p-1">
                        Consumable Item
                      </span>
                    @else
                      {{ $propertyInInventory }}
                    @endif
                  </span>
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
                  <span id="propertyStockDatatableCounter">0</span>
                  Selected
                </span>
                <button class="btn btn-outline-info btn-md me-2" id="btnMoveToInventory" type="button" style="display: none;">
                  <i class="bi bi-arrow-left-right"></i> Assign Item
                </button>
                <button class="btn btn-outline-danger btn-md" id="btnMultiDeleteChild" type="button" style="display: none;">
                  <i class="bi-trash3-fill"></i> Delete
                </button>
              </div>
            </div>
            <!-- End Datatable Info -->

            <!-- Export Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" data-bs-toggle="dropdown" data-bs-auto-close="outside" type="button">
                <i class="bi-download me-2"></i> Export
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end w-100">
                <span class="dropdown-header">Options</span>
                <button class="dropdown-item" id="propertyChildExportCopy" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Copy Icon"> Copy
                </button>
                <button class="dropdown-item" id="propertyChildExportPrint" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Print Icon"> Print
                </button>
                <div class="dropdown-divider"></div>
                <span class="dropdown-header">Download</span>
                <button class="dropdown-item" id="propertyChildExportExcel" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Excel Icon"> Excel
                </button>
                <button class="dropdown-item" id="propertyChildExportPdf" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="PDF Icon"> PDF
                </button>
              </div>
            </div>
            <!-- End Export Dropdown -->

            <!-- Filter Dropdown -->
            <div class="dropdown">
              <button class="btn btn-white btn-sm dropdown-toggle w-100" data-bs-toggle="dropdown" data-bs-auto-close="outside" type="button">
                <i class="bi-filter me-2"></i> Filter <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="propertyChildFilterCount"></span>
              </button>

              <div class="dropdown-menu dropdown-menu-sm-end custom-dropdown">
                <div class="card">
                  <div class="card-header card-header-content-between">
                    <h5 class="card-header-title">Item Filters</h5>
                  </div>
                  <div class="card-body">
                    <!-- Departments Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Departments</small>
                      <div class="tom-select-custom">
                        <select class="js-select js-datatable-filter form-select" data-target-column-index="4"
                          data-hs-tom-select-options='{
                            "singleMultiple": true,
                            "hideSearch": true,
                            "hideSelected": false,
                            "placeholder": "All Departments"
                          }'
                          multiple>
                          @foreach ($departments as $department)
                            <option value="{{ $department->name }}">{{ $department->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <!-- End Departments Filter -->

                    <!-- Designations Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Designations</small>
                      <div class="tom-select-custom">
                        <select class="js-select js-datatable-filter form-select" data-target-column-index="3"
                          data-hs-tom-select-options='{
                            "singleMultiple": true,
                            "hideSearch": true,
                            "hideSelected": false,
                            "placeholder": "All Designations"
                          }'
                          multiple>
                          @foreach ($designations as $designation)
                            <option value="{{ $designation->name }}">{{ $designation->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <!-- End Designations Filter -->

                    <!-- Conditions Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Conditions</small>
                      <div class="tom-select-custom">
                        <select class="js-select js-datatable-filter form-select" data-target-column-index="5"
                          data-hs-tom-select-options='{
                            "singleMultiple": true,
                            "hideSearch": true,
                            "hideSelected": false,
                            "placeholder": "All Conditions"
                          }'
                          multiple>
                          @foreach ($conditions as $condition)
                            <option data-option-template='<span class="d-flex align-items-center"><span class="{{ $condition->color->class }}"></span>{{ $condition->name }}</span>'
                              value="{{ $condition->name }}"></option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <!-- End Conditions Filter -->

                    <!-- Statuses Filter -->
                    <div class="mb-4">
                      <small class="text-cap text-body">Statuses</small>
                      <div class="tom-select-custom">
                        <select class="js-select js-datatable-filter form-select" data-target-column-index="6"
                          data-hs-tom-select-options='{
                            "singleMultiple": true,
                            "hideSearch": true,
                            "hideSelected": false,
                            "placeholder": "All Statuses"
                          }'
                          multiple>
                          @foreach ($statuses as $status)
                            <option data-option-template='<span class="d-flex align-items-center fs-6 m-1 {{ $status->color->class }}">{{ $status->name }}</span>' value="{{ $status->name }}">
                              {{ $status->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <!-- End Statuses Filter -->
                  </div>
                </div>
              </div>
            </div>
            <!-- End Filter Dropdown -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom">
          <table class="table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table table table-hover w-100" id="propertyChildDatatable"
            data-hs-datatables-options='{
                   "columnDefs": [{
                      "targets": [0, 7, 9],
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
                @if ($propertyParents->is_consumable)
                  <th class="table-column-pe-0"></th>
                @else
                  <th class="table-column-pe-0">
                    <div class="form-check">
                      <input class="form-check-input" id="propertyStockDatatableCheckAll" type="checkbox" value="">
                      <label class="form-check-label" for="propertyStockDatatableCheckAll"></label>
                    </div>
                  </th>
                @endif
                <th class="d-none w-auto">Child Id</th>
                <th>Item Number</th>
                <th>Designation</th>
                <th>Department</th>
                @if ($propertyParents->is_consumable)
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                @else
                  <th>Condition</th>
                  <th>Status</th>
                @endif
                <th>Remarks</th>
                <th>Time Ago</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @php
                $focusedChildId = request('focus');
              @endphp
              @foreach ($propertyChildren->sortByDesc('updated_at') as $propertyChild)
                <tr class="{{ $focusedChildId == $propertyChild->id ? 'table-success' : '' }}" id="child-{{ $propertyChild->id }}" data-stats-id="{{ $propertyChild->status->id ?? '0' }}"
                  data-inventory-date="{{ $propertyChild->inventory_date ? \Carbon\Carbon::parse($propertyChild->inventory_date)->format('Y-m-d') : '' }}">

                  @if ($propertyParents->is_consumable)
                    <td class="table-column-pe-0"></td>
                  @else
                    <td class="table-column-pe-0">
                      <div class="form-check">
                        <input class="form-check-input child-checkbox" id="propertyStockDatatableCheck{{ $propertyChild->id }}" type="checkbox" value="{{ $propertyChild->id }}">
                        <label class="form-check-label" for="propertyStockDatatableCheck{{ $propertyChild->id }}"></label>
                      </div>
                    </td>
                  @endif
                  <td class="d-none" data-child-id="{{ Crypt::encryptString($propertyChild->id) }}"></td>
                  <td>
                    @if ($propertyChild->created_at == $propertyChild->updated_at)
                      <span class="badge bg-success">New</span>
                      {{ $propertyChild->prop_code }}
                    @elseif ($propertyChild->created_at->diffInDays(\Carbon\Carbon::now()) >= 7)
                      {{ $propertyChild->prop_code }}
                    @else
                      {{ $propertyChild->prop_code }}
                    @endif
                  </td>
                  <td>{{ $propertyChild->designation->name ?? 'No designation provided' }}</td>
                  <td data-full-value="{{ $propertyChild->designation->department->name ?? 'No designation provided' }}">{{ $propertyChild->designation->department->code ?? 'No department provided' }}</td>
                  @if ($propertyParents->is_consumable)
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                  @else
                    <td>
                      <span class="{{ $propertyChild->condition->color->class ?? '' }}"></span>{{ $propertyChild->condition->name ?? 'No condition yet' }}
                    </td>
                    <td>
                      <span class="{{ $propertyChild->status->color->class ?? '' }} fs-6">{{ $propertyChild->status->name ?? '' }}</span>
                    </td>
                  @endif
                  <td>
                    <span style="color:gray"
                      @if (!empty($propertyChild->remarks) && strlen($propertyChild->remarks) > 20) data-bs-toggle="tooltip"
                          data-bs-html="true"
                          data-bs-placement="bottom"
                          title="{{ $propertyChild->remarks }}" @endif>
                      {{ Str::limit(!empty($propertyChild->remarks) ? $propertyChild->remarks : 'No remarks provided', 20) }}
                    </span>
                  </td>
                  <td>
                    <div data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="Date Acquired: {{ \Carbon\Carbon::parse($propertyChild->acq_date)->format('F j, Y') }}">
                      <i class="bi-calendar-event me-1"></i>
                      @php
                        $stockDate = \Carbon\Carbon::parse($propertyChild->stock_date);
                        $inventoryDate = $propertyChild->inventory_date ? \Carbon\Carbon::parse($propertyChild->inventory_date) : null;
                      @endphp
                      {{ $propertyChild->is_consumable ? "Added {$stockDate->diffForHumans()}" : ($inventoryDate ? "Assigned {$inventoryDate->diffForHumans()}" : "Added {$stockDate->diffForHumans()}") }}
                    </div>
                  </td>
                  <td>
                    <div class="btn-group position-static">
                      <button class="btn btn-white btn-sm btnViewChild" type="button">
                        <i class="bi-eye me-1"></i> View
                      </button>
                      <!-- Button Group -->
                      @access('Item Management', 'Read and Write, Full Access')
                        <div class="btn-group position-static">
                          <button class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="childEditDropdown" data-bs-toggle="dropdown" type="button"
                            aria-expanded="false"></button>

                          <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="childEditDropdown">
                            @if ($propertyChild->property->is_consumable)
                              <button class="dropdown-item btnStatusChild" data-status="{{ $propertyChild->is_active ? 0 : 1 }}" type="button">
                                <i class="bi {{ $propertyChild->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                                {{ $propertyChild->is_active ? 'Set to Inactive' : 'Set to Active' }}
                              </button>
                            @else
                              <button class="dropdown-item btnEditPropChild" type="button">
                                <i class="bi-pencil-fill me-1 dropdown-item-icon"></i>Edit
                              </button>
                              @if($propertyChild->status->id == 9)
                                <button class="dropdown-item btnDisposed" data-dispose-id="{{ $propertyChild->id }}" type="button">
                                  <i class="bi bi-database-exclamation dropdown-item-icon text-danger"></i> Dispose
                                </button>
                              @endif
                              @if ($propertyChild->status->id == 1 && $propertyChild->is_active == 1 && $propertyChild->inventory_date == null)
                                <button class="dropdown-item btnMoveToInventory" data-childmove-id="{{ $propertyChild->id }}" type="button">
                                  <i class="bi bi-arrow-left-right dropdown-item-icon text-info"></i> Move to Inventory
                                </button>
                                <button class="dropdown-item btnStatusChild" data-status="{{ $propertyChild->is_active ? 0 : 1 }}" type="button">
                                  <i class="bi {{ $propertyChild->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                                  {{ $propertyChild->is_active ? 'Set to Inactive' : 'Set to Active' }}
                                </button>
                                <button class="dropdown-item text-danger btnDeleteChild" data-childdel-id="{{ $propertyChild->id }}" type="button">
                                  <i class="bi bi-trash3-fill dropdown-item-icon text-danger"></i> Delete
                                </button>
                              @elseif($propertyChild->status->id == 1 && $propertyChild->is_active == 0 && $propertyChild->inventory_date == null)
                                <button class="dropdown-item btnStatusChild" data-status="{{ $propertyChild->is_active ? 0 : 1 }}" type="button">
                                  <i class="bi {{ $propertyChild->is_active ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} dropdown-item-icon fs-7"></i>
                                  {{ $propertyChild->is_active ? 'Set to Inactive' : 'Set to Active' }}
                                </button>
                                @access('Item Management', 'Full Access')
                                  <button class="dropdown-item text-danger btnDeleteChild" data-childdel-id="{{ $propertyChild->id }}" type="button">
                                    <i class="bi bi-trash3-fill dropdown-item-icon text-danger"></i> Delete
                                  </button>
                                @endaccess
                              @elseif($propertyChild->status->id == 2 && $propertyChild->is_active == 1 && $propertyChild->inventory_date != null)
                                @php
                                  $encryptedId = \Illuminate\Support\Facades\Crypt::encryptString($propertyChild->id);
                                @endphp
                                <a class="dropdown-item" href="{{ route('prop-asset.child.generate', ['propertyParent' => $propertyParents->id, 'id' => $encryptedId]) }}">
                                  <i class="bi bi-qr-code dropdown-item-icon"></i> Generate QR
                                </a>
                                <button class="dropdown-item btnMissing" type="button">
                                  <i class="bi bi-question-octagon dropdown-item-icon text-danger"></i> Missing
                                </button>
                                <button class="dropdown-item btnReturn" type="button">
                                  <i class="bi bi-box-arrow-in-right dropdown-item-icon text-info"></i> Return
                                </button>
                              @endif
                            @endif
                          </div>
                        </div>
                      @endaccess
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
                <span class="text-secondary me-2">of</span>
                <span id="propertyStockDatatableWithPaginationInfoTotalQty"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
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
  <x-property-asset.stock.view-details-children />
  <x-property-asset.stock.move-children :designations="$designations" />
  <x-property-asset.stock.return-children :conditions="$conditions"  />

  {{--  <x-modals.edit-property-child :propertyParents="$propertyParents" :conditions="$conditions" :acquisitions="$acquisitions" :propertyChildren="$propertyChildren" /> --}}
  {{--  <x-modals.move-property :designations="$designations" :departments="$departments" :statuses="$statuses"/> --}}
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
    document.addEventListener("DOMContentLoaded", function() {
      const focusedRowId = "{{ request('focus') }}";
      if (focusedRowId) {
        const focusedRow = document.getElementById(`child-${focusedRowId}`);
        if (focusedRow) {
          focusedRow.scrollIntoView({
            behavior: "smooth",
            block: "center"
          });
          focusedRow.classList.add("table-warning");
          setTimeout(() => focusedRow.classList.remove("table-warning"), 10000);
        }
      }
    });
  </script>

  <script>
    $(document).ready(function() {
      const btnMoveToInventory = $("#btnMoveToInventory");
      const btnMultiDeleteChild = $("#btnMultiDeleteChild");

      function updateButtonVisibility() {
        let showButtons = true;

        $(".child-checkbox:checked").each(function() {
          const row = $(this).closest("tr");
          const usageStatus = parseInt(row.data("stats-id"), 10);
          const inventoryDate = row.data("inventory-date");

          if (usageStatus !== 1 || (inventoryDate && inventoryDate !== "")) {
            showButtons = false;
            return false;
          }
        });

        if (showButtons) {
          btnMoveToInventory.show();
          btnMultiDeleteChild.show();
          console.log("Buttons shown");
        } else {
          btnMoveToInventory.hide();
          btnMultiDeleteChild.hide();
          console.log("Buttons hidden");
        }
      }

      $(".child-checkbox, #propertyStockDatatableCheckAll").on('change', function() {
        updateButtonVisibility();
      });

      updateButtonVisibility();
    });
  </script>

  <script>
    $(document).on('ready', function() {
      // INITIALIZATION OF DATATABLES
      // =======================================================
      HSCore.components.HSDatatables.init($('#propertyChildDatatable'), {
        dom: 'Bfrtip',
        buttons: [{
            extend: 'copy',
            className: 'd-none',
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(9)):not(:nth-child(10))'
            }
          },
          {
            extend: 'excel',
            className: 'd-none',
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(9)):not(:nth-child(10))'
            }
          },
          {
            extend: 'pdf',
            className: 'd-none',
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(9)):not(:nth-child(10))'
            }
          },
          {
            extend: 'print',
            className: 'd-none',
            exportOptions: {
              columns: ':not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(9)):not(:nth-child(10))'
            }
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

      const propertyChildDatatable = HSCore.components.HSDatatables.getItem(0)

      const exportButtons = {
        "#propertyChildExportCopy": ".buttons-copy",
        "#propertyChildExportPrint": ".buttons-print",
        "#propertyChildExportExcel": ".buttons-excel",
        "#propertyChildExportPdf": ".buttons-pdf"
      };

      $.each(exportButtons, function(exportId, exportClass) {
        $(exportId).click(function() {
          propertyChildDatatable.button(exportClass).trigger();
        });
      });

      $(".js-datatable-filter").on("change", function() {
        filterDatatableAndCount(propertyChildDatatable, "#propertyChildFilterCount");
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


        // INITIALIZATION OF BOOTSTRAP DROPDOWN
        // =======================================================
        HSBsDropdown.init();


        // INITIALIZATION OF SELECT
        // =======================================================
        HSCore.components.HSTomSelect.init(".js-select");
      }
    })()
  </script>
@endpush
