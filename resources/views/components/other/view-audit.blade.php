<!-- View Audit Modal -->
<div class="modal fade" id="modalViewAudit" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">View Audit</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <div class="col">
          <!-- Audit Name -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Audit Name:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewAudit"></p>
            </div>
          </div>
          <!-- End Audit Name -->

          <!-- Description -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Description:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewDescription"></p>
            </div>
          </div>
          <!-- End Description -->

          <!-- Event -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Event:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewEvent"></p>
            </div>
          </div>
          <!-- End Event -->

          <!-- Properties -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Properties:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewProperties"></p>
            </div>
          </div>
          <!-- End Properties -->

          <!-- Logged By -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Logged By:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <div class="avatar avatar-xs avatar-circle">
                <img class="avatar-img" id="imgViewCreatedBy" src="" alt="User Image">
              </div>
              <div class="ms-3">
                <span class="d-block fw-semibold mb-0" id="lblViewCreatedBy"></span>
                <span class="d-block fs-5 text-body" id="lblViewCreatedAt"></span>
              </div>
            </div>
          </div>
          <!-- End Logged By -->
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
<!-- End View Audit Modal -->
