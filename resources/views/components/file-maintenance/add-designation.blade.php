<!-- Add Designation Modal -->
<div class="modal fade" id="modalAddDesignation" data-bs-backdrop="static" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Designation</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddDesignation" method="post" novalidate>
          @csrf
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddDesignation">Designation Name</label>
            <input class="form-control" id="txtAddDesignation" name="designation" type="text" placeholder="Enter a Designation">
            <span class="invalid-feedback" id="valAddDesignation"></span>
          </div>

          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="selAddDepartment">Main Department</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selAddDepartment" name="department"
                data-hs-tom-select-options='{
                  "placeholder": "Select a Department",
                  "hideSearch": "true"
                }'>
                <option value=""></option>
                @foreach ($departments as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
              <span class="invalid-feedback" id="valAddDepartment"></span>
            </div>
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
              <button class="btn btn-primary" id="btnAddSaveDesignation" form="frmAddDesignation" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Designation Modal -->
