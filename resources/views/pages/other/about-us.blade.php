@extends('layouts.resource')

@section('title')
  About Us
@endsection

@push('styles')
  <link href="{{ Vite::asset('resources/vendor/hs-img-compare/hs-img-compare.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <main class="main" id="content">
    <!-- Hero -->
    <div class="overflow-hidden gradient-radial-sm-primary">
      <div class="container-lg content-space-t-3 content-space-t-lg-4 content-space-b-2">
        <div class="w-lg-75 text-center mx-lg-auto mx-auto">
          <div class="mb-7 animated fadeInUp">
            <h1 class="display-2 mb-3">Project SPAM: <span class="text-primary text-highlight-warning">for Colegio de Sta. Teresa de Avila</span></h1>
            <p class="fs-2">A capstone project that aims to create a management solution that improves the efficiency and accuracy
              of tracking the institution’s
              property and assets.</p>
          </div>
        </div>

        <div class="animated fadeInUp">
          <figure class="js-img-comp device-browser device-browser-lg">
            <div class="device-browser-header">
              <div class="device-browser-header-btn-list">
                <span class="device-browser-header-btn-list-btn"></span>
                <span class="device-browser-header-btn-list-btn"></span>
                <span class="device-browser-header-btn-list-btn"></span>
              </div>
              <div class="device-browser-header-browser-bar">www.htmlstream.com/front/</div>
            </div>

            <div class="position-relative">
              <div class="js-img-comp-loader position-absolute d-flex align-items-center justify-content-center bg-white w-100 h-100 zi-999">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
              <div class="device-browser-frame">
                <div class="js-img-comp-container hs-img-comp-container">
                  <img class="hs-img-comp hs-img-comp-a" src="{{ Vite::asset('resources/img/1618x1010/img1.jpg') }}" alt="Image Description">
                  <div class="js-img-comp-wrapper hs-img-comp-wrapper">
                    <img class="hs-img-comp hs-img-comp-b" src="{{ Vite::asset('resources/img/1618x1010/img2.jpg') }}" alt="Image Description">
                  </div>
                </div>
              </div>
            </div>
          </figure>
        </div>
      </div>
    </div>
    <!-- End Hero -->

    <!-- Card Grid -->
    <div class="container-lg content-space-2">
      <!-- Heading -->
      <div class="w-lg-75 text-center mx-lg-auto mb-7 mb-md-10">
        <h2 class="display-4">System <span class="text-primary">Features</span></h2>
        <p class="lead">Explore key features designed to simplify workflows and boost productivity.</p>
      </div>
      <!-- End Heading -->

      <div class="row">
        <!-- Dashboard -->
        <div class="col-md-6 mb-4">
          <a class="card card-lg card-transition h-100 bg-light border-0 shadow-none overflow-hidden" href="javascript:">
            <div class="card-body">
              <h2 class="card-title h1 text-inherit">Dashboard</h2>
              <p class="card-text lead">View key insights and system summaries at a glance. Stay informed with real-time updates and statistics.</p>
            </div>
            <div class="card-footer border-0 pt-0 mb-n4 me-n6">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/img/900x562/img1.jpg') }}" alt="Image Description">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/img/900x562/img1-dark.jpg') }}" alt="Image Description">
            </div>
          </a>
        </div>
        <!-- End Dashboard -->

        <!-- Item Management -->
        <div class="col-md-6 mb-4">
          <a class="card card-lg card-transition h-100 bg-light border-0 shadow-none overflow-hidden" href="javascript:">
            <div class="card-body">
              <h2 class="card-title h1 text-inherit">Item Management</h2>
              <p class="card-text lead">Track and organize items efficiently. Monitor inventory and item details with ease.</p>
            </div>
            <div class="card-footer border-0 pt-0 mb-n4 me-n6">
              <img class="img-fluid shadow-lg" src="{{ Vite::asset('resources/img/900x562/img6.jpg') }}" alt="Image Description">
            </div>
          </a>
        </div>
        <!-- End Item Management -->

        <!-- Borrowing & Reservation -->
        <div class="col-md-6 mb-4">
          <a class="card card-lg card-transition h-100 bg-light border-0 shadow-none overflow-hidden" href="javascript:">
            <div class="card-body">
              <h2 class="card-title h1 text-inherit">Borrowing & Reservation</h2>
              <p class="card-text lead">Manage borrowing and reservations seamlessly. Ensure availability and proper scheduling of items.</p>
            </div>
            <div class="card-footer border-0 pt-0 mb-n4 me-n6">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/img/900x562/img12.jpg') }}" alt="Image Description">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/img/900x562/img12-dark.jpg') }}" alt="Image Description">
            </div>
          </a>
        </div>
        <!-- End Borrowing & Reservation -->

        <!-- Repair & Maintenance -->
        <div class="col-md-6 mb-4">
          <a class="card card-lg card-transition h-100 bg-light border-0 shadow-none overflow-hidden" href="javascript:">
            <div class="card-body">
              <h2 class="card-title h1 text-inherit">Repair & Maintenance</h2>
              <p class="card-text lead">Oversee repair tickets and maintenance tasks effectively. Keep equipment in top condition for use.</p>
            </div>
            <div class="card-footer border-0 pt-0 mb-n4 me-n6">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/img/900x562/img11.jpg') }}" alt="Image Description">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/img/900x562/img11-dark.jpg') }}" alt="Image Description">
            </div>
          </a>
        </div>
        <!-- End Repair & Maintenance -->

        <!-- User Management -->
        <div class="col-md-6 mb-4">
          <a class="card card-lg card-transition h-100 bg-light border-0 shadow-none overflow-hidden" href="javascript:">
            <div class="card-body">
              <h2 class="card-title h1 text-inherit">User Management</h2>
              <p class="card-text lead">Manage user roles and permissions effortlessly. Keep user profiles up-to-date and organized.</p>
            </div>
            <div class="card-footer border-0 pt-0 mb-n4 me-n6">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/img/900x562/img3.jpg') }}" alt="Image Description">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/img/900x562/img3-dark.jpg') }}" alt="Image Description">
            </div>
          </a>
        </div>
        <!-- End User Management -->

        <!-- File Maintenance -->
        <div class="col-md-6 mb-4">
          <a class="card card-lg card-transition h-100 bg-light border-0 shadow-none overflow-hidden" href="javascript:">
            <div class="card-body">
              <h2 class="card-title h1 text-inherit">File Maintenance</h2>
              <p class="card-text lead">Organize and maintain essential system files. Ensure configurations are consistent and well-managed.</p>
            </div>
            <div class="card-footer border-0 pt-0 mb-n4 me-n6">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/img/900x562/img2.jpg') }}" alt="Image Description">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/img/900x562/img2-dark.jpg') }}" alt="Image Description">
            </div>
          </a>
        </div>
        <!-- End File Maintenance -->

        <!-- Audit History -->
        <div class="col-md-6 mb-4 mb-md-0">
          <a class="card card-lg card-transition h-100 bg-light border-0 shadow-none overflow-hidden" href="javascript:">
            <div class="card-body">
              <h2 class="card-title h1 text-inherit">Audit History</h2>
              <p class="card-text lead">Access a detailed audit trail with improved navigation options to track system activities efficiently.</p>
            </div>
            <div class="card-footer border-0 pt-0 mb-n4 me-n6">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/img/900x562/img13.jpg') }}" alt="Image Description">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/img/900x562/img13-dark.jpg') }}" alt="Image Description">
            </div>
          </a>
        </div>
        <!-- End Audit History -->

        <!-- System Appearance -->
        <div class="col-md-6">
          <a class="card card-lg card-transition h-100 bg-light border-0 shadow-none overflow-hidden" href="javascript:">
            <div class="card-body">
              <h2 class="card-title h1 text-inherit">System Appearance</h2>
              <p class="card-text lead">Switch between light and dark mode for a personalized and comfortable UI experience.</p>
            </div>
            <div class="card-footer border-0 pt-0 mb-n4 me-n6">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/img/900x562/img5.jpg') }}" alt="Image Description">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/img/900x562/img5-dark.jpg') }}" alt="Image Description">
            </div>
          </a>
        </div>
        <!-- End System Appearance -->
      </div>
    </div>
    <!-- End Card Grid -->

    <!-- Meet the Developers -->
    <div class="container-lg content-space-2">
      <!-- Heading -->
      <div class="w-lg-75 text-center mx-lg-auto mb-7 mb-md-10">
        <h2 class="display-4">Meet the Developers</h2>
        <p class="lead"> A capstone team dedicated to implement the system and deliver exceptional results. Our commitment is to turn ideas into reality with technology and creativity.</p>
      </div>
      <!-- End Heading -->

      <!-- Card Grid -->
      <div class="row align-items-md-center content-space-b-1 content-space-b-lg-2">
        <div class="col-md-6 order-md-2 mb-10 mb-md-0">
          <figure class="device-browser">
            <div class="device-browser-header">
              <div class="device-browser-header-btn-list">
                <span class="device-browser-header-btn-list-btn"></span>
                <span class="device-browser-header-btn-list-btn"></span>
                <span class="device-browser-header-btn-list-btn"></span>
              </div>
              <div class="device-browser-header-browser-bar"></div>
            </div>
            <div class="device-browser-frame">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/img/900x562/img7.jpg') }}" alt="Image Description">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/img/900x562/img7-dark.jpg') }}" alt="Image Description">
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 h-100 bg-soft-primary zi-n1 mb-n6 ms-n6"></div>
          </figure>
        </div>

        <div class="col-md-6">
          <div class="pe-md-7">
            <div class="mb-5">
              <div class="mb-5">
                <span class="badge border border-dark text-dark">Project Manager / Team Leader</span>
              </div>
              <h2 class="mb-3">Joshua Trazen DS. Achondo</h2>
              <p class="fs-4">Leads the team by coordinating tasks, ensuring project milestones are met, and maintaining effective communication. Responsible for overseeing the project’s progress and
                ensuring its successful delivery.</p>
            </div>
            <a class="btn btn-primary" href="https://github.com/Jay-Tee69" target="_blank">View Github Profile<i class="bi-box-arrow-up-right ms-2"></i></a>
          </div>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Card Grid -->

      <!-- Card Grid -->
      <div class="row align-items-md-center content-space-1 content-space-b-lg-2">
        <div class="col-md-6 order-md-2 mb-10 mb-md-0">
          <figure class="device-browser">
            <div class="device-browser-header">
              <div class="device-browser-header-btn-list">
                <span class="device-browser-header-btn-list-btn"></span>
                <span class="device-browser-header-btn-list-btn"></span>
                <span class="device-browser-header-btn-list-btn"></span>
              </div>
              <div class="device-browser-header-browser-bar"></div>
            </div>
            <div class="device-browser-frame">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/img/900x562/img8.jpg') }}" alt="Image Description">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/img/900x562/img8-dark.jpg') }}" alt="Image Description">
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 h-100 bg-soft-danger zi-n1 mb-n6 ms-n6"></div>
          </figure>
        </div>

        <div class="col-md-6">
          <div class="pe-md-7">
            <div class="mb-5">
              <div class="mb-5">
                <span class="badge border border-dark text-dark">Full-stack Developer</span>
              </div>
              <h2 class="mb-3">Rob Meynard P. Bunag</h2>
              <p class="fs-4">Handles both frontend and backend development, ensuring seamless functionality and a user-friendly interface. Develops robust features and integrations to bring the
                project to life.</p>
            </div>
            <a class="btn btn-primary" href="https://github.com/Roro2202" target="_blank">View Github Profile<i class="bi-box-arrow-up-right ms-2"></i></a>
          </div>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Card Grid -->

      <!-- Card Grid -->
      <div class="row align-items-md-center content-space-1 content-space-b-lg-2">
        <div class="col-md-6 order-md-2 mb-10 mb-md-0">
          <figure class="device-browser">
            <div class="device-browser-header">
              <div class="device-browser-header-btn-list">
                <span class="device-browser-header-btn-list-btn"></span>
                <span class="device-browser-header-btn-list-btn"></span>
                <span class="device-browser-header-btn-list-btn"></span>
              </div>
              <div class="device-browser-header-browser-bar"></div>
            </div>
            <div class="device-browser-frame">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="default" src="{{ Vite::asset('resources/img/900x562/img9.jpg') }}" alt="Image Description">
              <img class="img-fluid shadow-lg" data-hs-theme-appearance="dark" src="{{ Vite::asset('resources/img/900x562/img9-dark.jpg') }}" alt="Image Description">
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 h-100 bg-soft-warning zi-n1 mb-n6 ms-n6"></div>
          </figure>
        </div>

        <div class="col-md-6">
          <div class="pe-md-7">
            <div class="mb-5">
              <div class="mb-5">
                <span class="badge border border-dark text-dark">Lead Developer</span>
              </div>
              <h2 class="mb-3">Khervin John P. Quimora</h2>
              <p class="fs-4">Takes charge of complex development tasks and ensures code quality, security, and efficiency. Guides the technical aspects of the project to meet high standards of
                performance and scalability.</p>
            </div>
            <a class="btn btn-primary" href="https://github.com/krvnjo" target="_blank">View Github Profile<i class="bi-box-arrow-up-right ms-2"></i></a>
          </div>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Card Grid -->
    </div>
    <!-- End Meet the Developers -->

    <hr class="mb-7">
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
