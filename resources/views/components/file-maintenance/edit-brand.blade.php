<!-- Edit Brand Modal -->
<div class="modal fade" id="modalEditBrand" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Brand</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditBrand" method="POST" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditId" name="id" type="hidden">

          <!-- Brand Name -->
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditBrand">Brand Name</label>
            <input class="form-control" id="txtEditBrand" name="brand" type="text" placeholder="Enter a brand">
            <span class="invalid-feedback" id="valEditBrand"></span>
          </div>
          <!-- End Brand Name -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnEditSaveBrand" form="frmEditBrand" type="submit" disabled>
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
<!-- End Edit Brand Modal -->
