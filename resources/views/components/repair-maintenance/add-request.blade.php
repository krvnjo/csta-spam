<!-- Add Request Modal -->
<div class="modal fade" id="modalAddRequest" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create Ticket Request</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddRequest" method="POST" novalidate>
          @csrf

          <!-- Description -->
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddDescription">Description</label>
            <textarea class="form-control" id="txtAddDescription" placeholder="Enter a description" rows="3"></textarea>
            <span class="invalid-feedback" id="valAddDescription"></span>
          </div>
          <!-- End Description -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnAddSaveRequest" form="frmAddRequest" type="submit" disabled>
              <span class="spinner-label">Create</span>
              <span class="spinner-border spinner-border-sm d-none"></span>
            </button>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Request Modal -->
