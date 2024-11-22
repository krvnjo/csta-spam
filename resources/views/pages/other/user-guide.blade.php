@extends('layouts.resource')

@section('title')
  User Guide
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/hs-img-compare/hs-img-compare.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <!-- FAQ -->
    <div class="container-lg content-space-t-2 content-space-t-lg-3">
      <!-- Heading -->
      <div class="w-lg-75 text-center mx-lg-auto mb-7 mb-md-10">
        <h2 class="display-4">Frequently Asked <span class="text-primary">Questions</span></h2>
      </div>
      <!-- End Heading -->

      <div class="w-md-75 mx-md-auto">
        <!-- List -->
        <ul class="list-unstyled list-py-3 mb-0">
          <li>
            <h2 class="h1">How can I get a refund?</h2>
            <p class="fs-4">If you'd like a refund please reach out to us at <a class="link" href="mailto:themes@getbootstrap.com">themes@getbootstrap.com</a>. If you need technical help with
              the theme before a refund please reach out to us first.</p>
          </li>

          <li>
            <h2 class="h1">How do I get access to a theme I purchased?</h2>
            <p class="fs-4">If you lose the link for a theme you purchased, don't panic! We've got you covered. You can login to your account, tap your avatar in the upper right corner, and tap
              Purchases. If you didn't create a <a class="link" href="https://marketplace.getbootstrap.com/signin/" target="_blank">login</a> or can't remember the information, you can use our
              handy <a class="link" href="https://themes.getbootstrap.com/redownload/" target="_blank">Redownload page</a>, just remember to use the same email you originally made your
              purchases with.</p>
          </li>

          <li>
            <h2 class="h1">How do I get help with the theme I purchased?</h2>
            <p class="fs-4">Technical support for each theme is given directly by the creator of the theme. You can contact us <a class="link" href="https://htmlstream.com/contact-us"
                target="_blank">here</a></p>
          </li>

          <li>
            <h2 class="h1">Is Front Admin available on other web application platforms?</h2>
            <p class="fs-4">Since the theme is a static HTML template, we do not offer any tutorials or any other materials on how to integrate our templates with any CMS, Web Application
              framework, or any other similar technology. However, since our templates are static HTML/CSS and JS templates, then they should be compatible with any backend technology.</p>
          </li>

          <li>
            <h2 class="h1">How can I access a Figma or Sketch file?</h2>
            <p class="fs-4">Unfortunately, the design files are not available. We will consider the possibility of adding this option in the near future. However, we cannot provide any ETA
              regarding the release.</p>
          </li>
        </ul>
        <!-- End List -->

        <hr class="my-7">
      </div>
    </div>
    <!-- End FAQ -->
  </main>
@endsection

@section('sec-content')
  <a class="js-go-to go-to position-fixed"
    data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {
         "init": {
           "right": "2rem"
         },
         "show": {
           "bottom": "2rem"
         },
         "hide": {
           "bottom": "-2rem"
         }
       }
     }'
    href="javascript:" style="visibility: hidden;">
    <i class="bi-chevron-up"></i>
  </a>
@endsection

@push('scripts')
  <script src="{{ Vite::asset('resources/vendor/hs-header/dist/hs-header.min.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-img-compare/hs-img-compare.js') }}"></script>
  <script src="{{ Vite::asset('resources/vendor/hs-go-to/dist/hs-go-to.min.js') }}"></script>

  <!-- JS Themes -->
  <script src="{{ Vite::asset('resources/js/theme.min.js') }}"></script>

  <!-- JS Plugins Initialization -->
  <script>
    (function() {
      // INITIALIZATION OF NAVBAR
      // =======================================================
      new HSHeader('#header').init()


      // INITIALIZATION OF GO TO
      // =======================================================
      new HSGoTo('.js-go-to')


      // TRANSFORMATION
      // =======================================================
      const $figure = document.querySelector('.js-img-comp')

      if (window.pageYOffset) {
        $figure.style.transform = `rotateY(${-18 + window.pageYOffset}deg) rotateX(${window.pageYOffset / 5}deg)`
      }

      let y = -18 + window.pageYOffset,
        x = 55 - window.pageYOffset

      const figureTransformation = function() {
        if (-18 + window.pageYOffset / 5 > 0) {
          y = 0
        }

        if (55 - window.pageYOffset / 3 < 0) {
          x = 0
        }

        y = -18 + window.pageYOffset / 5 < 0 ? -18 + window.pageYOffset / 5 : y
        x = 55 - window.pageYOffset / 3 > 0 ? 55 - window.pageYOffset / 3 : x
        $figure.style.transform = `rotateY(${y}deg) rotateX(${x}deg)`
      }

      figureTransformation()
      window.addEventListener('scroll', figureTransformation)
    })()
  </script>
@endpush
