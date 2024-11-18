<!-- View Request Modal -->
<div class="modal fade" id="modalViewHistory" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">View Ticket Request</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <div class="col">
          <!-- Ticket Number -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Ticket Number:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewNum"></p>
            </div>
          </div>
          <!-- End Ticket Number -->

          <!-- Ticket Name -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Ticket Name:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewTicket"></p>
            </div>
          </div>
          <!-- End Ticket Name -->

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

          <!-- Estimated Cost -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Estimated Cost:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewCost"></p>
            </div>
          </div>
          <!-- End Estimated Cost -->

          <!-- Items -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Items:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <div class="btn-group w-100">
                <button class="btn btn-sm btn-white dropdown-toggle" id="lblViewItems" data-bs-toggle="dropdown" type="button"></button>
                <div class="dropdown-menu w-100 scrollable-dropdown-menu" id="dropdownMenuViewItems"></div>
              </div>
            </div>
          </div>
          <!-- End Items -->

          <!-- Remarks -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Remarks:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewRemarks"></p>
            </div>
          </div>
          <!-- End Remarks -->

          <!-- Status -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Status:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewProgress"></p>
            </div>
          </div>

          <!-- Created By -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Created By:</p>
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
          <!-- End Created By -->

          <!-- Updated By -->
          <div class="row">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Updated By:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
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
<!-- End View Request Modal -->
