<!-- View Item Transaction Modal -->
<div class="modal fade" id="modalViewItemTransaction" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">View Item Transaction</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <div class="col">
          <!-- Transaction Number -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Transaction Number:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="fw-semibold mb-0" id="lblViewTransaction"></p>
            </div>
          </div>
          <!-- End Transaction Number -->

          <!-- Items -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Items:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewItems"></p>
            </div>
          </div>
          <!-- End Items -->

          <!-- Requester -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Requester:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewRequester"></p>
            </div>
          </div>
          <!-- End Requester -->

          <!-- Received By -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Received By:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewReceived"></p>
            </div>
          </div>
          <!-- End Received By -->

          <!-- Remarks -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Remarks:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewRemarks"></p>
            </div>
          </div>
          <!-- End Remarks -->

          <!-- Date Created -->
          <div class="row mb-4">
            <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
              <p class="form-label fw-semibold mb-0">Date Created:</p>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewDateCreated"></p>
            </div>
          </div>
          <!-- End Date Created -->
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
<!-- End View Item Transaction Modal -->
