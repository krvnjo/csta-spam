<!-- View User Modal -->
<div class="modal fade" id="modalViewUser" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">View User</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <div class="col">
          <!-- User Image -->
          <div class="row">
            <div class="profile-cover cover-size">
              <div class="profile-cover-img-wrapper cover-resize">
                <img class="profile-cover-img cover-resize" src="{{ Vite::asset('resources/img/1920x400/img1.jpg') }}" alt="Profile Cover">
              </div>
            </div>
            <div>
              <div class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar">
                <img class="avatar-img" id="imgViewUser" src="" alt="User Image">
              </div>
            </div>
          </div>
          <!-- End User Image -->

          <!-- User Name -->
          <div class="row mb-4 mt-3">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">User Name:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewUser"></p>
            </div>
          </div>
          <!-- End User Name -->

          <!-- First Name -->
          <div class="row mb-4">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">First Name:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewFname"></p>
            </div>
          </div>
          <!-- End First Name -->

          <!-- Middle Name -->
          <div class="row mb-4">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">Middle Name:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewMname"></p>
            </div>
          </div>
          <!-- End Middle Name -->

          <!-- Last Name -->
          <div class="row mb-4">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">Last Name:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewLname"></p>
            </div>
          </div>
          <!-- End Last Name -->

          <!-- Role -->
          <div class="row mb-4">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">Role:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewRole"></p>
            </div>
          </div>
          <!-- End Role -->

          <!-- Department -->
          <div class="row mb-4">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">Department:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewDepartment"></p>
            </div>
          </div>
          <!-- End Department -->

          <!-- Email Address -->
          <div class="row mb-4">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">Email Address:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewEmail"></p>
            </div>
          </div>
          <!-- End Email Address -->

          <!-- Phone Number -->
          <div class="row mb-4">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">Phone:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewPhone"></p>
            </div>
          </div>
          <!-- End Phone Number -->

          <!-- Last Login -->
          <div class="row mb-4">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">Last Login:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewLogin"></p>
            </div>
          </div>
          <!-- End Last Login -->

          <!-- Status -->
          <div class="row mb-4">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">Status:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewStatus"></p>
            </div>
          </div>
          <!-- End Status -->

          <!-- Created By -->
          <div class="row mb-4">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">Created By:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <div class="avatar avatar-xs avatar-circle">
                <img class="avatar-img" id="imgViewCreatedBy" src="" alt="User Image">
              </div>
              <div class="ms-3">
                <span class="d-block fw-semibold mb-0" id="lblViewCreatedBy"></span>
                <span class="d-block fs-5 text-body" id="lblViewCreatedAt"></span>
              </div>
            </div>
          </div>
          <!-- End Created By -->

          <!-- Updated By -->
          <div class="row">
            <div class="col-12 col-sm-5 d-flex align-items-center mb-2 mb-sm-0">
              <p class="form-label fw-semibold mb-0">Updated By:</p>
            </div>
            <div class="col-12 col-sm-7 d-flex align-items-center">
              <div class="avatar avatar-xs avatar-circle">
                <img class="avatar-img" id="imgViewUpdatedBy" src="" alt="User Image">
              </div>
              <div class="ms-3">
                <span class="d-block fw-semibold mb-0" id="lblViewUpdatedBy"></span>
                <span class="d-block fs-5 text-body" id="lblViewUpdatedAt"></span>
              </div>
            </div>
          </div>
          <!-- End Updated By -->
        </div>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end">
            <button class="btn btn-primary" data-bs-dismiss="modal" type="button">Close</button>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End View User Modal -->
