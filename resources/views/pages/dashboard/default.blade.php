@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
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
        </div>
      </div>
      <!-- End Page Header -->
    </div>
    <!-- End Content -->

    <div class="content container-fluid" style="margin-top: -17rem;">
      <!-- Card -->
      <div class="card card-body mb-3 mb-lg-5">
        <div class="row col-lg-divider gx-lg-6">
          <div class="col-lg-3">
            <!-- Media -->
            <div class="d-flex">
              <div class="flex-grow-1">
                <h6 class="card-subtitle mb-3">Total Items in CSTA</h6>
                <h3 class="card-title">{{ $totalItems }}</h3>

                <div class="d-flex align-items-center">
                  <a class="nav-link" data-route="prop-overview.index" href="{{ route('prop-overview.index') }}">Overview</a>
                </div>
              </div>

              <span class="icon icon-soft-secondary icon-sm icon-circle ms-3">
                <i class="bi bi-archive"></i>
              </span>
            </div>
            <!-- End Media -->
          </div>
          <!-- End Col -->

          <div class="col-lg-3">
            <!-- Media -->
            <div class="d-flex">
              <div class="flex-grow-1">
                <h6 class="card-subtitle mb-3">Items on Site</h6>
                <h3 class="card-title">{{ $itemsAssigned }}</h3>

              </div>

              <span class="icon icon-soft-secondary icon-sm icon-circle ms-3">
                <i class="bi bi-building"></i>
              </span>
            </div>
            <!-- End Media -->
          </div>
          <!-- End Col -->

          <div class="col-lg-3">
            <!-- Media -->
            <div class="d-flex">
              <div class="flex-grow-1">
                <h6 class="card-subtitle mb-3">Total Repair Tickets</h6>
                <h3 class="card-title">{{ $totalRepairTickets }}</h3>

              </div>

              <span class="icon icon-soft-secondary icon-sm icon-circle ms-3">
                <i class="bi bi-calendar-check"></i>
              </span>
            </div>
            <!-- End Media -->
          </div>
          <!-- End Col -->

          <div class="col-lg-3">
            <!-- Media -->
            <div class="d-flex">
              <div class="flex-grow-1">
                <h6 class="card-subtitle mb-3">Total Borrow Requests</h6>
                <h3 class="card-title">{{ $totalBorrowRequests }}</h3>

              </div>

              <span class="icon icon-soft-secondary icon-sm icon-circle ms-3">
                <i class="bi bi-box"></i>
              </span>
            </div>
            <!-- End Media -->
          </div>
          <!-- End Col -->
        </div>
        <!-- End Row -->
      </div>
      <!-- End Card -->

{{--      <!-- Card -->--}}
{{--      <div class="card mb-3 mb-lg-5">--}}
{{--        <!-- Header -->--}}
{{--        <div class="card-header card-header-content-sm-between">--}}
{{--          <h4 class="card-header-title mb-2 mb-sm-0">Items Requisition Tracker<i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top"--}}
{{--              title="(Borrowing Trend) Indicates the timely item borrowing movements. "></i></h4>--}}

{{--          <div class="d-grid d-sm-flex gap-2">--}}
{{--            <!-- Daterangepicker -->--}}
{{--            <button class="btn btn-white btn-sm dropdown-toggle" id="js-daterangepicker-predefined">--}}
{{--              <i class="bi-calendar-week"></i>--}}
{{--              <span class="js-daterangepicker-predefined-preview ms-1"></span>--}}
{{--            </button>--}}
{{--            <!-- End Daterangepicker -->--}}
{{--          </div>--}}
{{--        </div>--}}
{{--        <!-- End Header -->--}}

{{--        <!-- Body -->--}}
{{--        <div class="card-body">--}}
{{--          <div class="row col-lg-divider">--}}
{{--            <div class="col-lg-9 mb-5 mb-lg-0">--}}
{{--              <!-- Bar Chart -->--}}
{{--              <div class="chartjs-custom mb-4">--}}
{{--                <canvas class="js-chart" id="ecommerce-sales"--}}
{{--                  data-hs-chartjs-options='{--}}
{{--                          "type": "bar",--}}
{{--                          "data": {--}}
{{--                            "labels": ["8AM","9AM","10AM","11AM","1PM","2PM","3PM","4PM","5PM"],--}}
{{--                            "datasets": [{--}}
{{--                              "data": [200, 300, 290, 350, 150, 350, 300, 100, 125, 220, 200, 300, 290, 350, 150, 350, 300, 100, 125, 220, 225],--}}
{{--                              "backgroundColor": "#377dff",--}}
{{--                              "hoverBackgroundColor": "#377dff",--}}
{{--                              "borderColor": "#377dff",--}}
{{--                              "maxBarThickness": "10"--}}
{{--                            },--}}
{{--                            {--}}
{{--                              "data": [150, 230, 382, 204, 169, 290, 300, 100, 300, 225, 120, 150, 230, 382, 204, 169, 290, 300, 100, 300, 140],--}}
{{--                              "backgroundColor": "#e7eaf3",--}}
{{--                              "borderColor": "#e7eaf3",--}}
{{--                              "maxBarThickness": "10"--}}
{{--                            }]--}}
{{--                          },--}}
{{--                          "options": {--}}
{{--                            "scales": {--}}
{{--                              "y": {--}}
{{--                                "grid": {--}}
{{--                                  "color": "#e7eaf3",--}}
{{--                                  "drawBorder": false,--}}
{{--                                  "zeroLineColor": "#e7eaf3"--}}
{{--                                },--}}
{{--                                "ticks": {--}}
{{--                                  "beginAtZero": true,--}}
{{--                                  "stepSize": 100,--}}
{{--                                  "color": "#97a4af",--}}
{{--                                    "font": {--}}
{{--                                      "size": 12,--}}
{{--                                      "family": "Open Sans, sans-serif"--}}
{{--                                    },--}}
{{--                                  "padding": 10--}}
{{--                                }--}}
{{--                              },--}}
{{--                              "x": {--}}
{{--                                "grid": {--}}
{{--                                  "display": false,--}}
{{--                                  "drawBorder": false--}}
{{--                                },--}}
{{--                                "ticks": {--}}
{{--                                  "color": "#97a4af",--}}
{{--                                    "font": {--}}
{{--                                      "size": 12,--}}
{{--                                      "family": "Open Sans, sans-serif"--}}
{{--                                    },--}}
{{--                                  "padding": 5--}}
{{--                                },--}}
{{--                                "categoryPercentage": 0.5,--}}
{{--                                "maxBarThickness": "10"--}}
{{--                              }--}}
{{--                            },--}}
{{--                            "cornerRadius": 2,--}}
{{--                            "plugins": {--}}
{{--                              "tooltip": {--}}
{{--                                "hasIndicator": true,--}}
{{--                                "mode": "index",--}}
{{--                                "intersect": false--}}
{{--                              }--}}
{{--                            },--}}
{{--                            "hover": {--}}
{{--                              "mode": "nearest",--}}
{{--                              "intersect": true--}}
{{--                            }--}}
{{--                          }--}}
{{--                        }'--}}
{{--                  style="height: 15rem;"></canvas>--}}
{{--              </div>--}}
{{--              <!-- End Bar Chart -->--}}

{{--              <div class="row justify-content-center">--}}
{{--                <div class="col-auto">--}}
{{--                  <span class="legend-indicator"></span> Consumables--}}
{{--                </div>--}}
{{--                <!-- End Col -->--}}

{{--                <div class="col-auto">--}}
{{--                  <span class="legend-indicator bg-primary"></span> Non-Consumables--}}
{{--                </div>--}}
{{--                <!-- End Col -->--}}
{{--              </div>--}}
{{--              <!-- End Row -->--}}
{{--            </div>--}}

{{--            <div class="col-lg-3">--}}
{{--              <div class="row">--}}
{{--                <div class="col-sm-6 col-lg-12">--}}
{{--                  <!-- Stats -->--}}
{{--                  <div class="d-flex justify-content-center flex-column" style="min-height: 9rem;">--}}
{{--                    <h6 class="card-subtitle">Non Consumables Dispatched</h6>--}}
{{--                    <span class="d-block display-4 text-dark mb-1 me-3">4</span>--}}
{{--                    <span class="d-block text-success">--}}
{{--                      <i class="bi-graph-up me-1"></i> 2,401.02 (3.7%)--}}
{{--                    </span>--}}
{{--                  </div>--}}
{{--                  <!-- End Stats -->--}}

{{--                  <hr class="d-none d-lg-block my-0">--}}
{{--                </div>--}}
{{--                <!-- End Col -->--}}

{{--                <div class="col-sm-6 col-lg-12">--}}
{{--                  <!-- Stats -->--}}
{{--                  <div class="d-flex justify-content-center flex-column" style="min-height: 9rem;">--}}
{{--                    <h6 class="card-subtitle">Consumables Dispatched</h6>--}}
{{--                    <span class="d-block display-4 text-dark mb-1 me-3">10</span>--}}
{{--                    <span class="d-block text-danger">--}}
{{--                      <i class="bi-graph-down me-1"></i> +3,301 (1.2%)--}}
{{--                    </span>--}}
{{--                  </div>--}}
{{--                  <!-- End Stats -->--}}
{{--                </div>--}}
{{--                <!-- End Col -->--}}
{{--              </div>--}}
{{--              <!-- End Row -->--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <!-- End Row -->--}}
{{--        </div>--}}
{{--        <!-- End Body -->--}}
{{--      </div>--}}
{{--      <!-- End Card -->--}}

      <div class="row">
        <div class="col-lg-6 mb-3 mb-lg-5">
          <!-- Card -->
          <div class="card h-100">
            <!-- Header -->
            <div class="card-header card-header-content-between">
              <h4 class="card-header-title">In Progress Repair Tickets</h4>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body card-body-height">
              <!-- Tab Content -->
              <div class="tab-content" id="eventsTabContent">
                <div class="tab-pane fade show active" id="this-week" role="tabpanel" aria-labelledby="this-week-tab">
                  <!-- List Group -->
                  <ul class="list-group list-group-flush list-group-start-bordered">

                    @foreach($progressRepair as $repair)
                      <!-- Item -->
                      <li class="list-group-item">
                        <a class="list-group-item-action border-primary" href="{{ route('ongoing.index') }}">
                          <div class="row">
                            <div class="col-sm mb-2 mb-sm-0">
                              <h3 class="fw-normal mb-1">{{ $repair->ticket_num }}</h3>
                              <h5 class="text-inherit mb-0">{{ $repair->name }}</h5>
                              <span class="text-body small">Started at {{ \Carbon\Carbon::parse($repair->started_at)->format('F j, Y') }}</span>
                            </div>

                            <div class="col-sm-auto align-self-sm-end">

                            </div>
                          </div>
                          <!-- End Row -->
                        </a>
                      </li>
                      <!-- End Item -->
                    @endforeach
                  </ul>
                  <!-- End List Group -->
                </div>

              </div>
              <!-- End Tab Content -->
            </div>
            <!-- End Body -->
          </div>
          <!-- End Card -->
        </div>
        <!-- End Col -->

        <!-- Body -->
        <div class="col-lg-6 mb-3 mb-lg-5">
          <!-- Card -->

          <div class="card h-100">
            <!-- Header -->
            <div class="card-header card-header-content-between">
              <h4 class="card-header-title">Approved Borrow Requests for Release</h4>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body card-body-height">
              <!-- Tab Content -->
              <div class="tab-content" id="eventsTabContent">
                <div class="tab-pane fade show active" id="this-week" role="tabpanel" aria-labelledby="this-week-tab">
                  <!-- List Group -->
                  <ul class="list-group list-group-flush list-group-start-bordered">

                    @foreach($releaseBorrow as $borrow)
                      <!-- Item -->
                      <li class="list-group-item">
                        <a class="list-group-item-action border-success" href="{{ route('new-request.index') }}">
                          <div class="row">
                            <div class="col-sm mb-2 mb-sm-0">
                              <h3 class="fw-normal mb-1">{{ $borrow->borrow_num }}</h3>
                              <h5 class="text-inherit mb-0">{{ $borrow->requester->department->code }} | {{ $borrow->requester->name }}</h5>
                              <span class="text-body small">Approved at {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('F j, Y') }}</span>
                            </div>

                            <div class="col-sm-auto align-self-sm-end">

                            </div>
                          </div>
                          <!-- End Row -->
                        </a>
                      </li>
                      <!-- End Item -->
                    @endforeach
                  </ul>
                  <!-- End List Group -->
                </div>

              </div>
              <!-- End Tab Content -->
            </div>
            <!-- End Body -->
          </div>
          <!-- End Card -->
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
    </div>
  </main>
@endsection

@section('sec-content')
  {{-- Secondary Content --}}
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/moment.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/tom-select/dist/js/tom-select.complete.min.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/js/hs.theme-appearance-charts.') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    $(document).on('ready', function() {
      // INITIALIZATION OF DATERANGEPICKER
      // =======================================================
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
        HSCore.components.HSChartJS.init('.js-chart')


        HSCore.components.HSChartJS.init('#updatingDoughnutChart')
        const updatingDoughnutChart = HSCore.components.HSChartJS.getItem('updatingDoughnutChart')

        // Datasets for chart, can be loaded from AJAX request
        const updatingDoughnutChartDatasets = [
          [
            [45, 25, 30]
          ],
          [
            [35, 50, 15]
          ]
        ]

        // Set datasets for chart when page is loaded
        const setDataChart = function() {
          updatingDoughnutChart.data.datasets.forEach(function(dataset, key) {
            dataset.data = updatingDoughnutChartDatasets[0][key];
          })

          updatingDoughnutChart.update()
        }

        setDataChart()

        window.addEventListener('on-hs-appearance-change', e => {
          setDataChart()
        })

        // Call when tab is clicked
        document.querySelectorAll('[data-bs-toggle="chart-doughnut"]').forEach(item => {
          item.addEventListener('click', e => {
            let keyDataset = e.currentTarget.getAttribute('data-datasets')

            // Update datasets for chart
            updatingDoughnutChart.data.datasets.forEach(function(dataset, key) {
              dataset.data = updatingDoughnutChartDatasets[keyDataset][key]
            })
            updatingDoughnutChart.update()
          })
        })


        // INITIALIZATION OF SELECT
        // =======================================================
        HSCore.components.HSTomSelect.init('.js-select')
      };
    })();
  </script>
@endpush
