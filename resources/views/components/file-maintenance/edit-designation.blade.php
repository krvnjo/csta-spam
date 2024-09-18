<!-- Edit Designation Modal -->
<div class="modal fade" id="modalEditDesignation" data-bs-backdrop="static" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Designation</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditDesignation" method="post" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditDesignationId" name="id" type="hidden">

          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditDesignation">Designation Name</label>
            <input class="form-control" id="txtEditDesignation" name="designation" type="text" placeholder="Enter a Designation">
            <span class="invalid-feedback" id="valEditDesignation"></span>
          </div>

          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="selEditDepartment">Main Department</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selEditDepartment" name="department"
                data-hs-tom-select-options='{
                  "placeholder": "Select a department",
                  "hideSearch": "true"
                }'>
                <option value=""></option>
                @foreach ($departments as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
              <span class="invalid-feedback" id="valEditDepartment"></span>
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
              <button class="btn btn-primary" id="btnEditSaveDesignation" form="frmEditDesignation" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Edit Designation Modal -->
