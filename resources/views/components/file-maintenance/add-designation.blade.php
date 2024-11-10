<!-- Add Designation Modal -->
<div class="modal fade" id="modalAddDesignation" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Designation</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddDesignation" method="POST" novalidate>
          @csrf

          <!-- Designation Name -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="txtAddDesignation">Designation Name</label>
            <input class="form-control" id="txtAddDesignation" name="designation" type="text" placeholder="Enter a designation">
            <span class="invalid-feedback" id="valAddDesignation"></span>
          </div>
          <!-- End Designation Name -->

          <!-- Main Department -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="selAddDepartment">Main Department</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selAddDepartment" name="department"
                data-hs-tom-select-options='{
                  "hideSearch": "true",
                  "placeholder": "Select a department"
                }'>
                <option value=""></option>
                @foreach ($departments as $department)
                  @if ($department->is_active)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                  @endif
                @endforeach
              </select>
              <span class="invalid-feedback" id="valAddDepartment"></span>
            </div>
          </div>
          <!-- End Main Department -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnAddSaveDesignation" form="frmAddDesignation" type="submit" disabled>
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
<!-- End Add Designation Modal -->
