<!-- Edit Department Modal -->
<div class="modal fade" id="modalEditDepartment" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Department</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditDepartment" method="POST" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditId" name="id" type="hidden">

          <!-- Department Name -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="txtEditDepartment">Department Name</label>
            <input class="form-control" id="txtEditDepartment" name="department" type="text" placeholder="Enter a department">
            <span class="invalid-feedback" id="valEditDepartment"></span>
          </div>
          <!-- End Department Name -->

          <!-- Department Code -->
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditCode">Department Code</label>
            <input class="form-control" id="txtEditCode" name="code" type="text" placeholder="Enter a department code">
            <span class="invalid-feedback" id="valEditCode"></span>
          </div>
          <!-- End Department Code -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnEditSaveDepartment" form="frmEditDepartment" type="submit" disabled>
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
<!-- End Edit Department Modal -->
