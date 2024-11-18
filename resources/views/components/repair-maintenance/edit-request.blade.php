<!-- Edit Request Modal -->
<div class="modal fade" id="modalEditRequest" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Ticket Request: <span id="lblTicketNumber"></span></h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditRequest" method="POST" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditId" name="id" type="hidden">

          <div class="row">
            <!-- Ticket Name -->
            <div class="col-md-7">
              <div class="form-group mb-2">
                <label class="col col-form-label form-label" for="txtEditTicket">Ticket Name</label>
                <input class="form-control" id="txtEditTicket" name="ticket" type="text" placeholder="Enter a ticket Name">
                <span class="invalid-feedback" id="valEditTicket"></span>
              </div>
            </div>
            <!-- End Ticket Name -->

            <!-- Estimated Cost -->
            <div class="col-md-5">
              <div class="form-group mb-2">
                <label class="col col-form-label form-label" for="txtEditCost">Estimated Cost</label>
                <div class="input-group">
                  <span class="input-group-text">₱</span>
                  <input class="form-control text-end" id="txtEditCost" name="cost" type="number" min="0" placeholder="Enter estimated cost">
                  <span class="invalid-feedback" id="valEditCost"></span>
                </div>
              </div>
            </div>
            <!-- End Estimated Cost -->
          </div>

          <!-- Description -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="txtEditDescription">Description</label>
            <textarea class="form-control" id="txtEditDescription" name="description" rows="4" placeholder="Type ticket description"></textarea>
            <span class="invalid-feedback" id="valEditDescription"></span>
          </div>
          <!-- End Description -->

          <!-- Items -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="selEditItems">Items</label>
            <div class="tom-select-custom tom-select-custom-with-tags">
              <select class="js-select form-select" id="selEditItems" name="items[]"
                data-hs-tom-select-options='{
                  "hideSelected": true,
                  "placeholder": "Select an item"
                }' autocomplete="off" multiple>
              </select>
              <span class="invalid-feedback" id="valEditItems"></span>
            </div>
          </div>
          <!-- End Items -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnEditSaveRequest" form="frmEditRequest" type="submit" disabled>
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
<!-- End Edit Request Modal -->
