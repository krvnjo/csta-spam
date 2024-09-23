<!-- View User Modal -->
<div class="modal fade" id="modalViewUser" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
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
          <div class="row">
            <div class="profile-cover" style="height: 7.5rem;">
              <div class="profile-cover-img-wrapper" style="height: 4.5rem;">
                <img class="profile-cover-img" src="{{ Vite::asset('resources/img/1920x400/img1.jpg') }}" alt="Profile Cover" style="height: 4.5rem;">
              </div>
            </div>
            <div>
              <div class="avatar avatar-xl avatar-circle avatar-uploader profile-cover-avatar">
                <img class="avatar-img" id="imgViewUserImage" src="" alt="Profile Image">
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">User Name:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewUsername"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">First Name:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewUserFname"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Middle Name:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewUserMname"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Last Name:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewUserLname"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Role:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewUserRole"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Department:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewUserDept"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Email Address:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewUserEmail"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Phone Number:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewUserPhone"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Status:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewStatus"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Date Created:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewDateCreated"></p>
            </div>
          </div>

          <div class="row">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Date Updated:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewDateUpdated"></p>
            </div>
          </div>
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
<!-- End View User Modal -->
