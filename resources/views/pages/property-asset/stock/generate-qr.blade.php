@extends('layouts.app')

@section('title')
  Generate QR Code
@endsection

@push('styles')
  {{-- Styles --}}
@endpush

@section('main-content')
  <main class="main" id="content" role="main">
    <style>
      @media print {
        body * {
          visibility: hidden;
        }

        .print-container * {
          visibility: visible;
        }
      }
    </style>
    <!-- Content -->
    <div class="content container-fluid">

      <div class="print-container">
        <!-- Page Header -->
        <div class="page-header">

          <div class="row align-items-end">
            <div class="col-sm mb-sm-0 mb-2">
              <div class="row">
                <div class="col-auto">
                  <!-- QR Code Section -->
                  <div class="avatar avatar-xl" style="padding-right: 10rem; padding-bottom: 10rem">
                    <span class="avatar-img">{!! $qr !!}</span>
                  </div>
                </div>
                <div class="col">
                  <img src="{{ Vite::asset('resources/svg/logos/logo.svg') }}" alt="item-logo" class="img-fluid" style="max-height: 3rem; object-fit: cover;">
                  <h3 class="page-header-title position-relative">
                    Item Number: {{ $propertyChild->prop_code }}
                  </h3>
                  <h4>
                    <span>Item Name: {{ $propertyChild->property->name }}</span>
                  </h4>
                  <span>Designation: {{ $propertyChild->designation->name }}</span><br>
                  <span>Department: {{ $propertyChild->designation->department->name }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- End Page Header -->
      </div>

      <!-- Back Button -->
      <div class="col-sm-auto mt-3">
        <button type="button" class="btn btn-secondary" onclick="window.history.back();">
          <i class="bi bi-arrow-left me-1"></i>Back
        </button>
        <button type="button" class="btn btn-primary" onclick="printContainer('.print-container');">
          <i class="bi bi-printer me-1"></i>Print
        </button>
      </div>

    </div>
    <!-- End Content -->
  </main>
@endsection

@section('sec-content')
  {{-- Secondary Content --}}
@endsection

@push('scripts')
  <script>
    function printContainer(container) {
      var printContents = document.querySelector(container).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }
  </script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
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
      };
    })();
  </script>
@endpush
