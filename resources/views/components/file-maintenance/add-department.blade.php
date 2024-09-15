<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" data-bs-backdrop="static" role="dialog"
  aria-labelledby="addDepartmentModalLabel" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="addDepartmentModalLabel">Add Department</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddDepartment" method="post" novalidate>
          @csrf
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddDepartment">Department Name <span
                class="text-danger">*</span></label>
            <input class="form-control" id="txtAddDepartment" name="department" type="text"
              placeholder="Enter a Department" required>
            <span class="invalid-feedback" id="valAddDepartment"></span>
          </div>

          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="txtAddDeptCode">Department Code <span
                class="text-danger">*</span></label>
            <input class="form-control" id="txtAddDeptCode" name="deptcode" type="text"
              placeholder="Enter a Department Code" required>
            <span class="invalid-feedback" id="valAddDeptCode"></span>
          </div>
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col-sm mb-2 mb-sm-0"></div>
          <div class="col-sm-auto">
            <div class="d-flex gap-2">
              <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
              <button class="btn btn-primary" form="frmAddDepartment" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Department Modal -->
