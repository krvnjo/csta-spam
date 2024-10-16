@extends('layouts.app')

@section('title')
  Starting Template
@endsection

@push('styles')
  {{-- Styles --}}
@endpush

@section('main-content')
  {{-- Main Content --}}
@endsection

@section('sec-content')
  {{-- Secondary Content --}}
@endsection

@push('scripts')
  {{-- Scripts --}}

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

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
      };
    })();
  </script>
@endpush
