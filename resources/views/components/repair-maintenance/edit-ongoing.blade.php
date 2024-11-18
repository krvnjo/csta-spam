<!-- Edit Ongoing Modal -->
<div class="modal fade" id="modalEditOngoing" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Ticket Number: <span id="lblEditTicketNumber"></span></h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditOngoing" method="POST">
          @csrf
          @method('PATCH')
          <input id="txtEditId" name="id" type="hidden">

          <!-- Items -->
          <div id="itemsContainer">
          </div>
          <!-- End Items -->

          <!-- Remarks -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="txtEditRemarks">Remarks</label>
            <textarea class="form-control" id="txtEditRemarks" name="remarks" rows="8" placeholder="Type maintenance remarks"></textarea>
            <span class="invalid-feedback" id="valEditRemarks"></span>
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
            <button class="btn btn-primary" id="btnEditSaveOngoing" form="frmEditOngoing" type="submit" disabled>
              <span class="spinner-label">Save</span>
              <span class="spinner-border spinner-border-sm d-none"></span>
            </button>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Edit Ongoing Modal -->
