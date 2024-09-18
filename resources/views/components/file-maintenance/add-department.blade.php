<!-- Add Department Modal -->
<div class="modal fade" id="modalAddDepartment" data-bs-backdrop="static" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Department</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddDepartment" method="post" novalidate>
          @csrf
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddDepartment">Department Name</label>
            <input class="form-control" id="txtAddDepartment" name="department" type="text" placeholder="Enter a Department">
            <span class="invalid-feedback" id="valAddDepartment"></span>
          </div>

          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddDeptCode">Department Code</label>
            <input class="form-control" id="txtAddDeptCode" name="deptcode" type="text" placeholder="Enter a Department Code">
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
              <button class="btn btn-primary" id="btnAddSaveDepartment" form="frmAddDepartment" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Department Modal -->
