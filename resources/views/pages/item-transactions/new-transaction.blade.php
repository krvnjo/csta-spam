@extends('layouts.app')

@section('title')
  New Transaction
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
  <link href="{{ Vite::asset('resources/vendor/jsvectormap/dist/css/jsvectormap.min.css') }}" rel="stylesheet">
  <link href="{{ Vite::asset('resources/vendor/tom-select/dist/css/tom-select.bootstrap5.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <div class="content container-fluid">
      <!-- Ticket Requests Header -->
      <div class="page-header">
        <div class="row align-items-center">
          <div class="col-sm mb-2 mb-sm-0">
            <ol class="breadcrumb breadcrumb-no-gutter">
              <li class="breadcrumb-item"><a class="breadcrumb-link" data-route="dashboard.index" href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item active">Item Transactions</li>
            </ol>
            <h1 class="page-header-title">Item Transactions</h1>
            <p class="page-header-text">Create and monitor item transactions.</p>
          </div>

          <div class="col-sm-auto mt-2 mt-sm-0">
            <button class="btn btn-primary w-100 w-sm-auto" id="btnAddNewTransactionModal" data-bs-toggle="modal" data-bs-target="#modalAddNewTransaction">
              <i class="bi-plus-lg me-1"></i> Create Transaction
            </button>
          </div>
        </div>
      </div>
      <!-- End Ticket Requests Header -->

      <!-- Requests DataTable Card -->
      <div class="card">
        <!-- Header -->
        <div class="card-header card-header-content-md-between">
          <div class="mb-2 mb-md-0">
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend input-group-text"><i class="bi-search"></i></div>
              <input class="form-control" id="newTransactionDatatableSearch" type="search" placeholder="Search">
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
                <button class="dropdown-item" id="newTransactionExportCopy" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/copy-icon.svg') }}" alt="Copy Icon"> Copy
                </button>
                <button class="dropdown-item" id="newTransactionExportPrint" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/illustrations/print-icon.svg') }}" alt="Print Icon"> Print
                </button>
                <div class="dropdown-divider"></div>
                <span class="dropdown-header">Download</span>
                <button class="dropdown-item" id="newTransactionExportExcel" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/excel-icon.svg') }}" alt="Excel Icon"> Excel
                </button>
                <button class="dropdown-item" id="newTransactionExportPdf" type="button">
                  <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ Vite::asset('resources/svg/brands/pdf-icon.svg') }}" alt="PDF Icon"> PDF
                </button>
              </div>
            </div>
            <!-- End Export Dropdown -->

            <!-- Filter Collapse Trigger -->
            <a class="btn btn-white btn-sm dropdown-toggle" data-bs-toggle="collapse" href="#newTransactionFilterSearchCollapse">
              <i class="bi-funnel me-1"></i> Filters <span class="badge bg-soft-dark text-dark rounded-circle ms-1" id="newTransactionFilterCount"></span>
            </a>
            <!-- End Filter Collapse Trigger -->
          </div>
        </div>
        <!-- End Header -->

        <!-- Filter Search Collapse -->
        <div class="collapse" id="newTransactionFilterSearchCollapse">
          <div class="card-body">
            <div class="row">

              <!-- Users -->
              <div class="col-sm-12 col-md-4">
                <div class="mb-3">
                  <label class="form-label" for="newTransactionRequestersFilter">Requesters</label>
                  <div class="tom-select-custom">
                    <select class="js-select js-datatable-filter form-select" id="newTransactionRequestersFilter" data-target-column-index="2"
                            data-hs-tom-select-options='{
                        "singleMultiple": true,
                        "hideSelected": false,
                        "placeholder": "All Requesters"
                      }'
                            autocomplete="off" multiple>
                      @foreach ($requesters as $request)
                        <option value="{{ $request->name }}">{{ $request->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <!-- End Users -->

              <!-- Date Range -->
              <div class="col-sm-12 col-md-4">
                <div class="mb-3">
                  <label class="form-label" for="newTransactionDateRangeFilter">Date Range Transaction</label>
                  <input class="js-daterangepicker-clear js-datatable-filter form-control daterangepicker-custom-input" data-target-column-index="6"
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

              <!-- Date Range -->
              <div class="col-sm-12 col-md-4">
                <div class="mb-3">
                  <label class="form-label" for="newTransactionDateRangeFilter">Date Range Created</label>
                  <input class="js-daterangepicker-clear js-datatable-filter form-control daterangepicker-custom-input" data-target-column-index="7"
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
            </div>
          </div>
        </div>
        <!-- End Filter Search Collapse -->

        <!-- Body -->
        <div class="table-responsive datatable-custom">
          <table class="table table-lg table-borderless table-thead-bordered table-hover table-nowrap table-align-middle card-table w-100" id="newTransactionDatatable"
                 data-hs-datatables-options='{
              "columnDefs": [{
                 "targets": [8],
                 "orderable": false
               }],
              "info": {
                "totalQty": "#newTransactionDatatableWithPagination"
              },
              "search": "#newTransactionDatatableSearch",
              "entries": "#newTransactionDatatableEntries",
              "pageLength": 10,
              "isResponsive": false,
              "isShowPaging": false,
              "pagination": "newTransactionDatatablePagination"
            }'>
            <thead class="thead-light">
            <tr>
              <th class="d-none"></th>
              <th>Transaction No.</th>
              <th>Requester</th>
              <th>Requested Items</th>
              <th>Quantity</th>
              <th>Remarks</th>
              <th>Received By</th>
              <th>Transaction Date</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($transactions->sortByDesc('created_at') as $transaction)
              <tr>
                <td class="d-none" data-transaction-id="{{ Crypt::encryptString($transaction->id) }}"></td>
                <td>{{ $transaction->transaction_num }}</td>
                <td>{{ $transaction->requester->department->code }} | {{ $transaction->requester->name }}</td>
                <td>
                  @foreach ($transaction->transactionItems as $item)
                    <span style="color:gray"
                          @if (!empty($transaction->remarks) && strlen($item->property->name) > 25) data-bs-toggle="tooltip"
                          data-bs-html="true"
                          data-bs-placement="top"
                          title="{{ $item->property->name }}" @endif>
                        {{ Str::limit(!empty($item->property->name) ? $item->property->name : 'No remarks provided', 30) }}
                      </span><br>
                  @endforeach
                </td>
                <td>
                  @foreach ($transaction->transactionItems as $item)
                    {{ $item->quantity }} - {{ $item->property->unit->name }}<br>
                  @endforeach
                </td>
                <td>
                    <span style="color:gray"
                          @if (!empty($transaction->remarks) && strlen($transaction->remarks) > 20) data-bs-toggle="tooltip"
                          data-bs-html="true"
                          data-bs-placement="top"
                          title="{{ $transaction->remarks }}" @endif>
                      {{ Str::limit(!empty($transaction->remarks) ? $transaction->remarks : 'No remarks provided', 20) }}
                    </span>
                </td>
                <td>{{ $transaction->received_by }}</td>
                <td><i class="bi-calendar-event me-1"></i>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('F j, Y') }}</td>
                <td>
                  <div class="btn-group position-static">
                    <button class="btn btn-white btn-sm btnViewItem" type="button"><i class="bi-eye"></i> View</button>
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
                  <select class="js-select form-select form-select-borderless" id="newTransactionDatatableEntries"
                          data-hs-tom-select-options='{
                      "hideSearch": true,
                      "searchInDropdown": false
                    }'>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                  </select>
                </div>
                <span class="text-secondary me-2">of</span>
                <span id="newTransactionDatatableWithPagination"></span>
                <span class="text-secondary ms-2">records</span>
              </div>
            </div>
            <div class="col-sm-auto">
              <div class="d-flex justify-content-center justify-content-sm-end">
                <nav id="newTransactionDatatablePagination"></nav>
              </div>
            </div>
          </div>
        </div>
        <!-- End Footer -->
      </div>
      <!-- End Requests DataTable Card -->
    </div>
  </main>
@endsection

@section('sec-content')
<x-item-transactions.add-transaction :requesters="$requesters" :items="$items" />
<x-item-transactions.view-transaction />
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/js/modules/item-transactions/new-transaction.js') }}"></script>

  <script src="{{ Vite::asset('resources/vendor/tom-select/dist/js/tom-select.complete.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-add-field/dist/hs-add-field.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/moment.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/daterangepicker/daterangepicker.js') }}"></script>
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

  <!-- JS Plugins Initialization -->
  <script>
    // Initialization of DataTable
    $(document).on("ready", function() {
      HSCore.components.HSDaterangepicker.init('.js-daterangepicker-clear');

      const daterangepickerClear = $('.js-daterangepicker-clear');

      daterangepickerClear.on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        filterDatatableAndCount(newTransactionDatatable, "#newTransactionFilterCount");
      });

      daterangepickerClear.on('cancel.daterangepicker', function() {
        $(this).val('');
        filterDatatableAndCount(newTransactionDatatable, "#newTransactionFilterCount");
      });

      HSCore.components.HSDatatables.init($("#newTransactionDatatable"), {
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

      const newTransactionDatatable = HSCore.components.HSDatatables.getItem(0);

      const exportButtons = {
        "#newTransactionExportCopy": ".buttons-copy",
        "#newTransactionExportPrint": ".buttons-print",
        "#newTransactionExportExcel": ".buttons-excel",
        "#newTransactionExportPdf": ".buttons-pdf"
      };

      $.each(exportButtons, function(exportId, exportClass) {
        $(exportId).click(function() {
          newTransactionDatatable.button(exportClass).trigger();
        });
      });

      $(".js-datatable-filter").on("change", function() {
        filterDatatableAndCount(newTransactionDatatable, "#newTransactionFilterCount");
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

        // INITIALIZATION OF ADD FIELD
        // =======================================================
        new HSAddField('.js-add-field', {
          addedField: field => {

            HSCore.components.HSTomSelect.init(field.querySelector('.js-select-dynamic'));

            const selectElement = field.querySelector('select[name="items[]"]');
            const inputElement = field.querySelector('input[name="quantities[]"]');

            if (selectElement) {
              selectElement.setAttribute('required', 'true');
            }

            if (inputElement) {
              inputElement.setAttribute('required', 'true');
            }

            selectElement.addEventListener('change', function () {
              const selectedOption = selectElement.selectedOptions[0];
              const maxQuantity = selectedOption ? selectedOption.getAttribute('data-max') : 0;

              inputElement.setAttribute('max', maxQuantity);
            });
          }
        });


      };
    })();

    $(document).ready(function() {
      const itemSelects = $(".js-select-dynamic");

      itemSelects.on("change", function() {
        const selectedItems = [];

        itemSelects.each(function() {
          const value = $(this).val();
          if (value) {
            selectedItems.push(value);
          }
        });

        itemSelects.each(function() {
          const currentItemValue = $(this).val();
          $(this).find("option").each(function() {
            const optionValue = $(this).val();
            if (selectedItems.includes(optionValue) && optionValue !== currentItemValue) {
              $(this).attr("disabled", "disabled");
            } else {
              $(this).removeAttr("disabled");
            }
          });
        });
      });
    });
  </script>
@endpush
