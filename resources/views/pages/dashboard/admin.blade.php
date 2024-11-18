@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content" role="main">
    <!-- Content -->
    <div class="content container-fluid bg-custom-image">
      <!-- Page Header -->
      <div class="page-header page-header-light">
        <div class="row align-items-center">
          <div class="col">
            @php
              $hour = date('G');
              $greeting =
                  $hour >= 6 && $hour < 11
                      ? 'Good morning'
                      : ($hour >= 11 && $hour < 15
                          ? 'Good afternoon'
                          : ($hour >= 15 && $hour < 18
                              ? 'Greetings'
                              : ($hour >= 18 && $hour < 24
                                  ? 'Good evening'
                                  : 'Hello there')));
            @endphp
            <h1 class="page-header-title">{{ $greeting }}, {{ Auth::user()->fname }}.</h1>
            <p class="page-header-text">Here's what's happening in CSTA - SPAM.</p>
          </div>
          <!-- End Col -->
        </div>
        <!-- End Row -->
      </div>
      <!-- End Page Header -->
    </div>
    <!-- End Content -->

    <!-- Content -->
    <div class="content container-fluid" style="margin-top: -17rem;">
      <!-- Card -->
      <div class="card mb-3 mb-lg-5">
        <!-- Header -->
        <div class="card-header card-header-content-sm-between">
          <h4 class="card-header-title mb-2 mb-sm-0">Recent Statistics</h4>

          {{--          <!-- Nav --> --}}
          {{--          <ul class="nav nav-segment nav-fill" id="projectsTab" role="tablist"> --}}
          {{--            <li class="nav-item" data-bs-toggle="chart" data-datasets="0" data-trigger="click" data-action="toggle"> --}}
          {{--              <a class="nav-link active" data-bs-toggle="tab" href="javascript:">This week</a> --}}
          {{--            </li> --}}
          {{--            <li class="nav-item" data-bs-toggle="chart" data-datasets="1" data-trigger="click" data-action="toggle"> --}}
          {{--              <a class="nav-link" data-bs-toggle="tab" href="javascript:">Last week</a> --}}
          {{--            </li> --}}
          {{--          </ul> --}}
          {{--          <!-- End Nav --> --}}
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="card-body">
          <div class="row align-items-sm-center mb-4">
            <div class="col-sm mb-3 mb-sm-0">
              <div class="d-flex align-items-center">
                <span
                  class="h1 mb-0">₱{{ number_format(
                      $propertyParents->sum(function ($property) {
                          return $property->purchase_price * $property->quantity;
                      }),
                      2,
                  ) }}
                  PHP</span>
                <span class="{{ $percentageChange > 0 ? 'text-danger' : 'text-success' }} ms-2">
                  @if ($percentageChange > 0)
                    <i class="bi-graph-up text-danger"></i> {{ number_format($percentageChange, 2) }}%
                  @elseif ($percentageChange < 0)
                    <i class="bi-graph-down text-success"></i> {{ number_format(abs($percentageChange), 2) }}%
                  @else
                    <i class="bi-graph-up text-muted"></i> 0%
                  @endif
                </span>
              </div>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
              <!-- Legend Indicators -->
              <div class="row fs-6">
                <div class="col-auto">
                  <span class="legend-indicator bg-primary"></span> Non-consumable Items
                </div>
                <div class="col-auto">
                  <span class="legend-indicator bg-info"></span> Consumable Items
                </div>
              </div>
              <!-- End Legend Indicators -->
            </div>
            <!-- End Col -->
          </div>
          <!-- End Row -->

          <!-- Bar Chart -->
          <div class="chartjs-custom" style="height: 18rem;">
            <canvas id="updatingLineChart"
              data-hs-chartjs-options='{
                "type": "line",
                "data": {
                   "labels": ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                   "datasets": [{
                    "backgroundColor": ["rgba(55,125,255, .5)", "rgba(255, 255, 255, .2)"],
                    "borderColor": "#377dff",
                    "borderWidth": 2,
                    "pointRadius": 0,
                    "hoverBorderColor": "#377dff",
                    "pointBackgroundColor": "#377dff",
                    "pointBorderColor": "#fff",
                    "pointHoverRadius": 0,
                    "tension": 0.4
                  },
                  {
                    "backgroundColor": ["rgba(0, 201, 219, .5)", "rgba(255, 255, 255, .2)"],
                    "borderColor": "#00c9db",
                    "borderWidth": 2,
                    "pointRadius": 0,
                    "hoverBorderColor": "#00c9db",
                    "pointBackgroundColor": "#00c9db",
                    "pointBorderColor": "#fff",
                    "pointHoverRadius": 0,
                    "tension": 0.4
                  }]
                },
                "options": {
                  "gradientPosition": {"y1": 200},
                   "scales": {
                      "y": {
                        "grid": {
                          "color": "#e7eaf3",
                          "drawBorder": false,
                          "zeroLineColor": "#e7eaf3"
                        },
                        "ticks": {
                          "min": 0,
                          "max": 100,
                          "stepSize": 20,
                          "fontColor": "#97a4af",
                          "fontFamily": "Open Sans, sans-serif",
                          "padding": 10,
                          "postfix": " PHP"
                        }
                      },
                      "x": {
                        "grid": {
                          "display": false,
                          "drawBorder": false
                        },
                        "ticks": {
                          "fontSize": 12,
                          "fontColor": "#97a4af",
                          "fontFamily": "Open Sans, sans-serif",
                          "padding": 5
                        }
                      }
                  },
                  "plugins": {
                    "tooltip": {
                      "postfix": " PHP",
                      "hasIndicator": true,
                      "mode": "index",
                      "intersect": false,
                      "lineMode": true,
                      "lineWithLineColor": "rgba(19, 33, 68, 0.075)"
                    }
                  },
                  "hover": {
                    "mode": "nearest",
                    "intersect": true
                  }
                }
              }'>
            </canvas>
          </div>
          <!-- End Bar Chart -->
        </div>
        <!-- End Body -->

        <!-- Table -->
        <div class="table-responsive">
          <table class="table table-borderless table-thead-bordered table-align-middle card-table table-hover">
            <thead class="thead-light">
              <tr>
                <th>Highest Purchase Value Items</th>
                <th>Specification & Description</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Item Type</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($propertyParents as $property)
                <tr>
                  <td>
                    <a class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <img class="avatar avatar-sm" src="{{ asset('storage/img/prop-asset/' . $property->image) }}" alt="Item Image">
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <span class="d-block h5 text-inherit mb-0">{{ $property->name }}</span>
                      </div>
                    </a>
                  </td>
                  <td>
                    <span class="d-block h5 mb-0">{{ $property->specification }}</span>
                    <span class="d-block fs-5">{{ $property->description ?? 'N/A' }}</span>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="mb-0">{{ $property->brand->name ?? 'GENERIC' }}</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="mb-0">{{ $property->category->name ?? 'GENERIC' }}</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="mb-0">{{ $property->quantity ?? '₱0 PHP' }}</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="mb-0">₱{{ number_format($property->purchase_price, 2) }} PHP</span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="mb-0">
                        <span class="legend-indicator {{ $property->is_consumable == 1 ? 'bg-info' : 'bg-primary' }}"></span>
                        {{ $property->is_consumable == 1 ? 'Consumable' : 'Non-consumable' }}
                      </span>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- End Table -->

        <!-- Card Footer -->
        <a class="card-footer text-center" data-route="prop-asset.index" href="{{ route('prop-asset.index') }}">View all items <i class="bi-chevron-right"></i></a>
        <!-- End Card Footer -->
      </div>
      <!-- End Card -->

      <div class="row">
        <div class="col-lg-4 mb-3 mb-lg-5">
          <div class="d-grid gap-2 gap-lg-4">
            <!-- Card -->
            <a class="card card-hover-shadow" data-route="prop-overview.index" href="{{ route('prop-overview.index') }}">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <img class="avatar avatar-lg avatar-4x3" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/illustrations/oc-megaphone.svg') }}" alt="Image Description"
                      style="min-height: 5rem;">
                    <img class="avatar avatar-lg avatar-4x3" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/illustrations-light/oc-megaphone.svg') }}" alt="Image Description"
                      style="min-height: 5rem;">
                  </div>

                  <div class="flex-grow-1 ms-4">
                    <h3 class="text-inherit mb-1">Item Management</h3>
                    <span class="text-body">Create a new item</span>
                  </div>

                  <div class="ms-2 text-end">
                    <i class="bi-chevron-right text-body text-inherit"></i>
                  </div>
                </div>
              </div>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a class="card card-hover-shadow" data-route="new-request.index" href="{{ route('new-request.index') }}">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <img class="avatar avatar-lg avatar-4x3" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/illustrations/oc-collection.svg') }}" alt="Image Description"
                      style="min-height: 5rem;">
                    <img class="avatar avatar-lg avatar-4x3" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/illustrations-light/oc-collection.svg') }}" alt="Image Description"
                      style="min-height: 5rem;">
                  </div>

                  <div class="flex-grow-1 ms-4">
                    <h3 class="text-inherit mb-1">Borrowing & Reservation</h3>
                    <span class="text-body">Create a new borrowing request</span>
                  </div>

                  <div class="ms-2 text-end">
                    <i class="bi-chevron-right text-body text-inherit"></i>
                  </div>
                </div>
              </div>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a class="card card-hover-shadow" data-route="user.index" href="{{ route('user.index') }}">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <img class="avatar avatar-lg avatar-4x3" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/svg/illustrations/oc-hi-five.svg') }}" alt="Image Description"
                      style="min-height: 5rem;">
                    <img class="avatar avatar-lg avatar-4x3" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/svg/illustrations-light/oc-hi-five.svg') }}" alt="Image Description"
                      style="min-height: 5rem;">
                  </div>

                  <div class="flex-grow-1 ms-4">
                    <h3 class="text-inherit mb-1">Repair & Maintenance</h3>
                    <span class="text-body">Create a new ticket request</span>
                  </div>

                  <div class="ms-2 text-end">
                    <i class="bi-chevron-right text-body text-inherit"></i>
                  </div>
                </div>
              </div>
            </a>
            <!-- End Card -->
          </div>
        </div>
        <!-- End Col -->

        <div class="col-lg-8 mb-3 mb-lg-5">
          <!-- Card -->
          <div class="card h-100">
            <!-- Header -->
            <div class="card-header card-header-content-between">
              <h4 class="card-header-title">Low on Stock Items</h4>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body-height">
              <!-- Table -->
              <div class="table-responsive">
                <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Items</th>
                      <th scope="col">Specification</th>
                      <th scope="col">Description</th>
                      <th scope="col">Price</th>
                      <th scope="col">Quantity</th>
                      <th scope="col">Unit</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach ($lowStockConsumables as $lowStockConsumable)
                      <tr>
                        <td>
                          <span class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img class="avatar" src="{{ asset('storage/img/prop-asset/' . $lowStockConsumable->image) }}" alt="Image Description">
                            </div>
                            <div class="flex-grow-1 ms-3">
                              <h5 class="text-inherit mb-0">{{ $lowStockConsumable->name }}</h5>
                            </div>
                          </span>
                        </td>
                        <td>{{ $lowStockConsumable->specification }}</td>
                        <td>{{ $lowStockConsumable->description ?? 'N/A' }}</td>
                        <td>
                          <h4 class="mb-0">₱{{ number_format($lowStockConsumable->purchase_price, 2) }} PHP</h4>
                        </td>
                        <td>
                          <h4 class="mb-0">{{ $lowStockConsumable->quantity }}</h4>
                        </td>
                        <td>{{ $lowStockConsumable->unit->name }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- End Table -->
            </div>
            <!-- End Body -->
          </div>
          <!-- End Card -->
        </div>
        <!-- End Col -->
      </div>
    </div>
    <!-- End Content -->
  </main>
@endsection

@section('sub-content')
  {{-- Sub Content --}}
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/moment.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/js/hs.theme-appearance-charts.js') }}"></script>

  <!-- JS Plugins Init. -->
  <script>
    // Initialization of Daterangepicker
    $(document).on('ready', function() {
      $('.js-daterangepicker').daterangepicker();

      $('.js-daterangepicker-times').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
          format: 'M/DD hh:mm A'
        }
      });

      var start = moment();
      var end = moment();

      function cb(start, end) {
        $('#js-daterangepicker-predefined .js-daterangepicker-predefined-preview').html(start.format('MMM D') + ' - ' + end.format('MMM D, YYYY'));
      }

      $('#js-daterangepicker-predefined').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
      }, cb);

      cb(start, end);
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


        // INITIALIZATION OF CHARTJS
        // =======================================================
        const updatingChartDatasets = @json($updatingChartDatasets);
        const currentDate = new Date();
        const currentMonth = currentDate.toLocaleString('default', {
          month: 'short'
        });
        const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

        const currentMonthLabels = [];
        $.each(Array.from({
          length: daysInMonth
        }, (_, i) => i + 1), function(index, day) {
          currentMonthLabels.push(currentMonth + ' ' + day);
        });

        // Add missing days if there is no data for consumable or non-consumable for that day
        const nonConsumableData = updatingChartDatasets[0][0].map((total, index) => total || 0);
        const consumableData = updatingChartDatasets[0][1].map((total, index) => total || 0);

        // Find the highest total price from both non-consumable and consumable data
        const allData = [...nonConsumableData, ...consumableData];
        const maxDataValue = Math.max(...allData);

        // Define an excess factor (e.g., 10% increase over the max value)
        const excessFactor = 0.1; // This means a 10% excess
        const chartMaxValue = maxDataValue * (1 + excessFactor);

        // INITIALIZATION OF CHARTJS
        // =======================================================
        HSCore.components.HSChartJS.init($('#updatingLineChart')[0], {
          data: {
            labels: currentMonthLabels,
            datasets: [{
                label: "Non-Consumable",
                data: nonConsumableData // Non-consumable total prices per day
              },
              {
                label: "Consumable",
                data: consumableData // Consumable total prices per day
              }
            ]
          },
          options: {
            scales: {
              y: {
                suggestedMax: chartMaxValue, // Set the y-axis maximum based on the calculated excess value
                beginAtZero: true // Ensure the chart starts from 0
              }
            }
          }
        });

        const updatingLineChart = HSCore.components.HSChartJS.getItem(0);

        $('[data-bs-toggle="chart"]').on('click', function(e) {
          const keyDataset = $(this).data('datasets');
          $.each(updatingLineChart.data.datasets, function(key, dataset) {
            dataset.data = updatingChartDatasets[keyDataset][key];
          });
          updatingLineChart.update();
        });
      };
    })();
  </script>
@endpush
