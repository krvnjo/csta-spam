<!-- Modal -->
<div class="modal fade" id="viewChildModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="New Item Modal"
     aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center w-100"
           style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
        <div>
          <h4 class="modal-title" id="" style="color: whitesmoke; margin-bottom: 0.5rem;">
            Item Details
          </h4>
        </div>
        <div class="modal-close" style="position: absolute; top: 1rem; right: 1rem;">
          <button class="btn-close btn-close-light" data-bs-dismiss="modal" type="button"></button>
        </div>
      </div>
      <!-- End Header -->
      <!-- Body -->
      <div class="modal-body">
        <div class="col">
          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Item Code:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewPropCode"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Serial Number:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewSerialNum"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Department:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewDepartment"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Designation:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewDesignation"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Condition:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewCondition"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Item Status:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewItemStatus"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Remarks:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewRemarks"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Component Notes:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewComponentNotes"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Acquired Type:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewAcquiredType"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">System Status:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewStatus"></p>
            </div>
          </div>


          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Date Acquired:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewAcquiredDate"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Warranty Date:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewWarrantyDate"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Date Assigned:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewInvDate"></p>
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

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
      </div>
    </div>
  </div>
</div>
