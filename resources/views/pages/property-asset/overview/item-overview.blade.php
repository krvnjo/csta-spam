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
      <!-- Audits DataTable Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>
              <input class="form-control" id="itemOverviewDatatableSearch" type="search" placeholder="Search item">
            </div>
          </div>

          <div class="d-grid d-sm-flex justify-content-sm-center justify-content-md-end align-items-sm-center gap-2">

            <!-- Filter Collapse Trigger -->
            <a class="btn btn-white btn-sm dropdown-toggle" data-bs-toggle="collapse" href="#itemOverviewFilterSearchCollapse">
              <i class="bi-funnel me-1"></i> Filters <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="itemOverviewFilterCount"></span>
            </a>
            <!-- End Filter Collapse Trigger -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Filter Search Collapse -->
        <div class="collapse" id="itemOverviewFilterSearchCollapse">
          <div class="card-body">
            <div class="row">
              <!-- Designations -->
              <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="mb-3">
                  <label class="form-label" for="itemOverviewDesignationFilter">Designation</label>
                  <div class="tom-select-custom">
                    <select class="js-select js-datatable-filter form-select" id="itemOverviewDesignationFilter" data-target-column-index="5"
                      data-hs-tom-select-options='{
                        "singleMultiple": true,
                        "hideSelected": false,
                        "placeholder": "All Designation"
                      }'
                      autocomplete="off" multiple>
                      @foreach ($designations as $designation)
                        <option value="{{ $designation->name }}">{{ $designation->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <!-- End Designations -->

              <!-- Departments -->
              <div class="col-sm-12 col-md-6 col-lg-2">
                <div class="mb-3">
                  <label class="form-label" for="itemOverviewDepartmentsFilter">Departments</label>
                  <div class="tom-select-custom">
                    <select class="js-select js-datatable-filter form-select" id="itemOverviewDepartmentsFilter" data-target-column-index="4"
                      data-hs-tom-select-options='{
                        "singleMultiple": true,
                        "hideSelected": false,
                        "placeholder": "All Departments"
                      }'
                      autocomplete="off" multiple>
                      @foreach ($departments as $department)
                        <option value="{{ $department->code }}">{{ $department->code }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <!-- End Departments -->

              <!-- Condition -->
              <div class="col-sm-12 col-md-6 col-lg-2">
                <div class="mb-3">
                  <label class="form-label" for="itemOverviewConditionFilter">Condition</label>
                  <div class="tom-select-custom">
                    <select class="js-select js-datatable-filter form-select" id="itemOverviewConditionFilter" data-target-column-index="6"
                      data-hs-tom-select-options='{
                        "singleMultiple": true,
                        "hideSelected": false,
                        "placeholder": "All Conditions"
                      }'
                      autocomplete="off" multiple>
                      @foreach ($conditions as $condition)
                        <option data-option-template='<span class="d-flex align-items-center"><span class="{{ $condition->color->class }}"></span>{{ $condition->name }}</span>'
                          value="{{ $condition->name }}">
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <!-- End Condition -->

              <!-- Status -->
              <div class="col-sm-12 col-md-6 col-lg-2">
                <div class="mb-3">
                  <label class="form-label" for="itemOverviewStatusFilter">Status</label>
                  <div class="tom-select-custom">
                    <select class="js-select js-datatable-filter form-select" id="itemOverviewStatusFilter" data-target-column-index="7"
                      data-hs-tom-select-options='{
                        "singleMultiple": true,
                        "hideSelected": false,
                        "placeholder": "All Status"
                      }'
                      autocomplete="off" multiple>
                      @foreach ($statuses as $status)
                        <option value="{{ $status->name }}">{{ $status->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <!-- End Status -->

              <!-- Date Range -->
              <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="mb-3">
                  <label class="form-label" for="itemOverviewDateRangeFilter">Assign Date</label>
                  <input class="js-daterangepicker-clear js-datatable-filter form-control daterangepicker-custom-input" data-target-column-index="8"
                    data-hs-daterangepicker-options='{
                      "autoUpdateInput": false,
                      "locale": {
                        "cancelLabel": "Clear"
                      }
                    }'
                    type="text" placeholder="Select date range">
                </div>
              </div>
              <!-- End Date Range -->

              <!-- Item Type -->
              {{--              <div class="col-sm-12 col-md-6 col-lg-2"> --}}
              {{--                <div class="mb-3"> --}}
              {{--                  <label class="form-label" for="itemOverviewDepartmentsFilter">Item Type</label> --}}
              {{--                  <div class="tom-select-custom"> --}}
              {{--                    <select class="js-select js-datatable-filter form-select" id="itemOverviewDepartmentsFilter" data-target-column-index="4" --}}
              {{--                      data-hs-tom-select-options='{ --}}
              {{--                        "singleMultiple": true, --}}
              {{--                        "hideSelected": false, --}}
              {{--                        "placeholder": "All Subjects" --}}
              {{--                      }' --}}
              {{--                      autocomplete="off" multiple> --}}
              {{--                      @foreach ($departments as $department) --}}
              {{--                        <option value="{{ $department->code }}">{{ $department->code }}</option> --}}
              {{--                      @endforeach --}}
              {{--                    </select> --}}
              {{--                  </div> --}}
              {{--                </div> --}}
              {{--              </div> --}}
              <!-- End Item Type -->
            </div>
          </div>
        </div>
        <!-- End Filter Search Collapse -->

        <!-- Body -->
        <div class="table-responsive datatable-custom">
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="itemOverviewDatatable"
            data-hs-datatables-options='{
              "columnDefs": [{
                 "targets": [0, 9],
                 "orderable": false
               }],
              "order": [8, "desc"],
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
              @php
                $focusedChildId = request('focus');
              @endphp
              @foreach ($propertyChildren->where('is_active', 1)->sortByDesc('updated_at') as $propertyChild)
                <tr>
                  <td class="table-column-pe-0">
                  </td>
                  <td class="table-column-pe-0">
                    <a href="{{ route('prop-asset.child.index', ['propertyParent' => $propertyChild->property->id, 'focus' => $propertyChild->id]) }}">
                      {{ $propertyChild->prop_code }}
                    </a>
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
                  <td data-full-value="{{ $propertyChild->condition->name ?? '' }}">
                    @if ($propertyChild->property->is_consumable)
                      <span class="badge bg-soft-secondary text-secondary">Consumable</span>
                    @else
                      <span class="{{ $propertyChild->condition->color->class ?? '' }}"></span>{{ $propertyChild->condition->name ?? 'No condition yet' }}
                    @endif
                  </td>
                  <td data-full-value="{{ $propertyChild->status->name ?? '' }}">
                    @if ($propertyChild->property->is_consumable)
                      <span class="badge bg-soft-secondary text-secondary">Consumable</span>
                    @else
                      <span class="{{ $propertyChild->status->color->class ?? '' }} fs-7">{{ $propertyChild->status->name ?? '' }}</span>
                    @endif
                  </td>
                  <td data-full-value="{{ \Carbon\Carbon::parse($propertyChild->inventory_date)->format('m/d/Y') }}" data-order="{{ $propertyChild->inventory_date }}" data-bs-toggle="tooltip"
                    data-bs-html="true" data-bs-placement="bottom"
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
        <!-- End Body -->

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
      <!-- End Audits DataTable Card -->

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
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    $(document).on("ready", function() {
      HSCore.components.HSDaterangepicker.init('.js-daterangepicker-clear');

      const daterangepickerClear = $('.js-daterangepicker-clear');

      daterangepickerClear.on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        filterDatatableAndCount(itemOverviewDatatable, "#itemOverviewFilterCount");
      });

      daterangepickerClear.on('cancel.daterangepicker', function() {
        $(this).val('');
        filterDatatableAndCount(itemOverviewDatatable, "#itemOverviewFilterCount");
      });

      HSCore.components.HSDatatables.init($('#itemOverviewDatatable'), {
        language: {
          zeroRecords: `<div class="text-center p-4">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
              <img class="mb-3" src="{{ Vite::asset('resources/svg/illustrations-light/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
            <p class="mb-0">No data to show</p>
            </div>`
        }
      });

      const itemOverviewDatatable = HSCore.components.HSDatatables.getItem(0);


      $(".js-datatable-filter").on("change", function() {
        filterDatatableAndCount(itemOverviewDatatable, "#itemOverviewFilterCount");
      });
    });
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
