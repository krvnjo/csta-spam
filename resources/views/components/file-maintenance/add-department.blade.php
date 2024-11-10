<!-- Add Department Modal -->
<div class="modal fade" id="modalAddDepartment" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Department</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddDepartment" method="POST" novalidate>
          @csrf

          <!-- Department Name -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="txtAddDepartment">Department Name</label>
            <input class="form-control" id="txtAddDepartment" name="department" type="text" placeholder="Enter a department">
            <span class="invalid-feedback" id="valAddDepartment"></span>
          </div>
          <!-- End Department Name -->

          <!-- Department Code -->
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddCode">Department Code</label>
            <input class="form-control" id="txtAddCode" name="code" type="text" placeholder="Enter a department code">
            <span class="invalid-feedback" id="valAddCode"></span>
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
            <button class="btn btn-primary" id="btnAddSaveDepartment" form="frmAddDepartment" type="submit" disabled>
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
<!-- End Add Department Modal -->
