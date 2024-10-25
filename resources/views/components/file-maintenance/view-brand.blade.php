<!-- View Brand Modal -->
<div class="modal fade" id="modalViewBrand" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">View Brand</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <div class="col">
          <!-- Brand Name -->
          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Brand Name:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="text-inherit h5 mb-0" id="lblViewBrand"></p>
            </div>
          </div>
          <!-- End Brand Name -->

          <!-- Brand Subcategories -->
          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Brand Subcategories:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <div class="btn-group w-100">
                <button class="btn btn-sm btn-white dropdown-toggle" id="lblViewTotalSubcategories" data-bs-toggle="dropdown" type="button"></button>
                <div class="dropdown-menu w-100 scrollable-dropdown-menu" id="subcategoriesDropdownMenu"></div>
              </div>
            </div>
          </div>
          <!-- End Brand Subcategories -->

          <!-- Status -->
          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Status:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewStatus"></p>
            </div>
          </div>
          <!-- End Status -->

          <!-- Date Created -->
          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Date Created:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <div class="avatar avatar-xs avatar-circle">
                <img class="avatar-img" id="imgViewCreatedByImage" src="" alt="User Image">
              </div>
              <div class="ms-3">
                <span class="d-block h5 text-inherit mb-0" id="lblViewCreatedBy"></span>
                <span class="d-block fs-5 text-body" id="lblViewDateCreated"></span>
              </div>
            </div>
          </div>
          <!-- End Date Created -->

          <!-- Date Updated -->
          <div class="row">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Date Updated:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <div class="avatar avatar-xs avatar-circle">
                <img class="avatar-img" id="imgViewUpdatedByImage" src="" alt="User Image">
              </div>
              <div class="ms-3">
                <span class="d-block h5 text-inherit mb-0" id="lblViewUpdatedBy"></span>
                <span class="d-block fs-5 text-body" id="lblViewDateUpdated"></span>
              </div>
            </div>
          </div>
          <!-- End Date Updated -->
        </div>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col-sm mb-2 mb-sm-0"></div>
          <div class="col-sm-auto">
            <div class="d-flex gap-2">
              <button class="btn btn-primary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End View Brand Modal -->
