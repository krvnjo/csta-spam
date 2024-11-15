@extends('layouts.app')

@section('title')
  Item Overview
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
  <link href="{{ Vite::asset('resources/vendor/jsvectormap/dist/css/jsvectormap.min.css') }}" rel="stylesheet">
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content" role="main">
    <div class="content container-fluid">
      <!-- Page Header -->
      <div class="page-header">
        <div class="row align-items-end">
          <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-no-gutter">
                <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Overview</li>
              </ol>
            </nav>
            <h1 class="page-header-title">Item Overview</h1>
            <p class="page-header-text">Manage and organize stock records.</p>
          </div>
        </div>
        <!-- End Row -->
      </div>
      <!-- End Page Header -->

      <div class="row">
        <!-- Total Items -->
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2">Total Items</h6>
              <div class="row align-items-center gx-2">
                <div class="col">
                  <span class="display-4 text-dark">{{ $totalItems }}</span>
                </div>
                <div class="col-auto">
                  <i class="bi bi-box-seam text-success fs-1"></i> <!-- Bootstrap icon -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Items in Stock -->
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2">Items in Stock</h6>
              <div class="row align-items-center gx-2">
                <div class="col">
                  <span class="display-4 text-dark">{{ $itemsInStock }}</span>
                </div>
                <div class="col-auto">
                  <i class="bi bi-archive text-info fs-1"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Items Assigned -->
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2">Items Assigned</h6>
              <div class="row align-items-center gx-2">
                <div class="col">
                  <span class="display-4 text-dark">{{ $itemsAssigned }}</span>
                </div>
                <div class="col-auto">
                  <i class="bi bi-clipboard-check text-warning fs-1"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Low Stock Consumables -->
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-subtitle mb-2">Low Stock Consumables</h6>
              <div class="row align-items-center gx-2">
                <div class="col">
                  <span class="display-4 text-dark">{{ $lowStockConsumables }}</span>
                </div>
                <div class="col-auto">
                  <i class="bi bi-exclamation-triangle text-danger fs-1"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <style>
        .card:hover {
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
          transition: box-shadow 0.2s ease-in-out;
        }
      </style>
      <!-- Card -->
      <div class="card mb-3 mb-lg-5">
        <!-- Header -->
        <div class="card-header">
          <div class="row justify-content-between align-items-center flex-grow-1">
            <div class="col-md">
              <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-header-title">Items</h4>
              </div>
            </div>
            <!-- End Col -->

            <div class="col-auto">
              <!-- Filter -->
              <div class="row align-items-sm-center">
                <div class="col-sm-auto">
                  <div class="row align-items-center gx-0">
                    <div class="col">
                      <span class="text-secondary me-2">Status:</span>
                    </div>
                    <!-- End Col -->

                    <div class="col-auto">
                      <!-- Select -->
                      <div class="tom-select-custom">
                        <select class="js-select js-datatable-filter form-select form-select-sm form-select-borderless" data-target-column-index="2"
                          data-hs-tom-select-options='{
                                  "searchInDropdown": false,
                                  "hideSearch": true,
                                  "dropdownWidth": "10rem"
                                }'
                          autocomplete="off">
                          <option value="null" selected>All</option>
                          <option value="successful">Successful</option>
                          <option value="overdue">Overdue</option>
                          <option value="pending">Pending</option>
                        </select>
                      </div>
                      <!-- End Select -->
                    </div>
                    <!-- End Col -->
                  </div>
                  <!-- End Row -->
                </div>
                <!-- End Col -->

                <div class="col-sm-auto">
                  <div class="row align-items-center gx-0">
                    <div class="col">
                      <span class="text-secondary me-2">Signed up:</span>
                    </div>
                    <!-- End Col -->

                    <div class="col-auto">
                      <!-- Select -->
                      <div class="tom-select-custom">
                        <select class="js-select js-datatable-filter form-select form-select-sm form-select-borderless" data-target-column-index="5"
                          data-hs-tom-select-options='{
                                  "searchInDropdown": false,
                                  "hideSearch": true,
                                  "dropdownWidth": "10rem"
                                }'
                          autocomplete="off">
                          <option value="null" selected>All</option>
                          <option value="1 year ago">1 year ago</option>
                          <option value="6 months ago">6 months ago</option>
                        </select>
                      </div>
                      <!-- End Select -->
                    </div>
                    <!-- End Col -->
                  </div>
                  <!-- End Row -->
                </div>
                <!-- End Col -->

                <div class="col-md">
                  <form>
                    <!-- Search -->
                    <div class="input-group input-group-merge input-group-flush">
                      <div class="input-group-prepend input-group-text">
                        <i class="bi-search"></i>
                      </div>
                      <input class="form-control" id="itemOverviewDatatableSearch" type="search" aria-label="Search item" placeholder="Search item">
                    </div>
                    <!-- End Search -->
                  </form>
                </div>
                <!-- End Col -->
              </div>
              <!-- End Filter -->
            </div>
            <!-- End Col -->
          </div>
          <!-- End Row -->
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom">
          <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-hover  w-100" id="itemOverviewDatatable"
            data-hs-datatables-options='{
                   "columnDefs": [{
                      "targets": [0, 9],
                      "orderable": false
                    }],
                   "order": [],
                   "info": {
                     "totalQty": "#itemOverviewDatatableWithPaginationInfoTotalQty"
                   },
                   "search": "#itemOverviewDatatableSearch",
                   "entries": "#itemOverviewDatatableEntries",
                   "pageLength": 5,
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "itemOverviewDatatablePagination"
                 }'>
            <thead class="thead-light">
              <tr>
                <th class="table-column-ps-0"></th>
                <th class="table-column-ps-0">Item Number</th>
                <th>Item Name</th>
                <th>Specification</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Condition</th>
                <th>Status</th>
                <th>Time Ago</th>
                <th class="table-column-ps-0"></th>
              </tr>
            </thead>

            <tbody>
              @foreach ($propertyChildren->where('is_active', 1)->sortByDesc('updated_at') as $propertyChild)
                <tr>
                  <td class="table-column-pe-0">
                  </td>
                  <td class="table-column-pe-0">
                    {{ $propertyChild->prop_code }}
                  </td>
                  <td>
                    {{ $propertyChild->property->name }}
                  </td>
                  <td>
                    <span
                      @if (!empty($propertyChild->property->specification) && strlen($propertyChild->property->specification) > 25) data-bs-toggle="tooltip"
                          data-bs-html="true"
                          data-bs-placement="bottom"
                          title="{{ $propertyChild->property->specification }}" @endif>
                      {{ Str::limit(!empty($propertyChild->property->specification) ? $propertyChild->property->specification : 'No specification provided', 30) }}
                    </span>
                  </td>
                  <td>
                    {{ $propertyChild->department->code }}
                  </td>
                  <td>
                    {{ $propertyChild->designation->name }}
                  </td>
                  <td>
                    @if ($propertyChild->property->is_consumable)
                      <span class="badge bg-soft-secondary text-secondary">Consumable</span>
                    @else
                      <span class="{{ $propertyChild->condition->color->class ?? '' }}"></span>{{ $propertyChild->condition->name ?? '' }}
                    @endif
                  </td>
                  <td>
                    @if ($propertyChild->property->is_consumable)
                      <span class="badge bg-soft-secondary text-secondary">Consumable</span>
                    @else
                      <span class="{{ $propertyChild->status->color->class ?? '' }} fs-7">{{ $propertyChild->status->name ?? '' }}</span>
                    @endif
                  </td>
                  <td data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom"
                    @if ($propertyChild->property->is_consumable) title="Date Added: {{ \Carbon\Carbon::parse($propertyChild->stock_date)->format('F j, Y') }}"
                      @elseif($propertyChild->inventory_date != null)
                        title="Date Assigned: {{ \Carbon\Carbon::parse($propertyChild->inventory_date)->format('F j, Y') }}" @endif>
                    <i class="bi-calendar-event me-1"></i>
                    @if ($propertyChild->property->is_consumable)
                      Added {{ \Carbon\Carbon::parse($propertyChild->stock_date)->diffForHumans() }}
                    @elseif($propertyChild->inventory_date != null)
                      Assigned {{ \Carbon\Carbon::parse($propertyChild->inventory_date)->diffForHumans() }}
                    @else
                      Added {{ \Carbon\Carbon::parse($propertyChild->stock_date)->diffForHumans() }}
                    @endif
                  </td>
                  <td class="table-column-pe-0">
                  </td>
                </tr>
              @endforeach

            </tbody>
          </table>
        </div>
        <!-- End Table -->

        <!-- Footer -->
        <div class="card-footer">
          <!-- Pagination -->
          <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
            <div class="col-sm mb-2 mb-sm-0">
              <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                <span class="me-2">Showing:</span>

                <!-- Select -->
                <div class="tom-select-custom tom-page-w">
                  <select class="js-select form-select form-select-borderless" id="itemOverviewDatatableEntries"
                    data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "hideSearch": true
                          }' autocomplete="off">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                  </select>
                </div>
                <!-- End Select -->

                <span class="text-secondary me-2">of</span>

                <!-- Pagination Quantity -->
                <span id="itemOverviewDatatableWithPaginationInfoTotalQty"></span>
              </div>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <!-- Pagination -->
                <nav id="itemOverviewDatatablePagination" aria-label="Activity pagination"></nav>
              </div>
            </div>
            <!-- End Col -->
          </div>
          <!-- End Pagination -->
        </div>
        <!-- End Footer -->
      </div>
      <!-- End Card -->
    </div>
  </main>
@endsection

@section('sec-content')
  {{-- Secondary Content --}}
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
  <script src="{{ Vite::asset('resources/vendor/chart.js/dist/chart.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/moment.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.js"') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    // Initialization of Other Plugins
    (function() {
      window.onload = function() {
        // INITIALIZATION OF DATATABLES
        // =======================================================
        HSCore.components.HSDatatables.init($('#itemOverviewDatatable'), {
          language: {
            zeroRecords: `<div class="text-center p-4">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations-light/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
            <p class="mb-0">No data to show</p>
            </div>`
          }
        });

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


        // INITIALIZATION OF CHARTJS
        // =======================================================
        HSCore.components.HSChartJS.init('.js-chart')
      };
    })();
  </script>
@endpush
