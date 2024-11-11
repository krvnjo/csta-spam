<!-- Edit Category Modal -->
<div class="modal fade" id="modalEditCategory" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Category</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditCategory" method="POST" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditId" name="id" type="hidden">

          <!-- Category Name -->
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditCategory">Category Name</label>
            <input class="form-control" id="txtEditCategory" name="category" type="text" placeholder="Enter a category">
            <span class="invalid-feedback" id="valEditCategory"></span>
          </div>
          <!-- End Category Name -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnEditSaveCategory" form="frmEditCategory" type="submit" disabled>
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
<!-- End Edit Category Modal -->
