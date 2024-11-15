<!-- Edit Requester Modal -->
<div class="modal fade" id="modalEditRequester" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title">Edit Requester</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditRequester" method="POST" enctype="multipart/form-data" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditId" name="id" type="hidden">

          <!-- First Name -->
          <div class="row mb-4">
            <label class="col-sm-4 col-form-label form-label" for="txtEditFname">First Name</label>
            <div class="col-sm-8">
              <input class="form-control" id="txtEditFname" name="fname" type="text" placeholder="Enter your first name">
              <span class="invalid-feedback" id="valEditFname"></span>
            </div>
          </div>
          <!-- End First Name -->

          <!-- Middle Name -->
          <div class="row mb-4">
            <label class="col-sm-4 col-form-label form-label" for="txtEditMname">Middle Name</label>
            <div class="col-sm-8">
              <input class="form-control" id="txtEditMname" name="mname" type="text" placeholder="Enter your middle name">
              <span class="invalid-feedback" id="valEditMname"></span>
            </div>
          </div>
          <!-- End Middle Name -->

          <!-- Last Name -->
          <div class="row mb-4">
            <label class="col-sm-4 col-form-label form-label" for="txtEditLname">Last Name</label>
            <div class="col-sm-8">
              <input class="form-control" id="txtEditLname" name="lname" type="text" placeholder="Enter your last name">
              <span class="invalid-feedback" id="valEditLname"></span>
            </div>
          </div>
          <!-- End Last Name -->

          <!-- Requester ID -->
          <div class="row mb-4">
            <label class="col-sm-4 col-form-label form-label" for="txtEditRequester">
              Requester ID <i class="bi-question-circle text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Employee/Student Number of the requester."></i>
            </label>
            <div class="col-sm-8">
              <input class="js-input-mask form-control" id="txtEditRequester" name="requester" data-hs-mask-options='{
                  "mask": "00-00000"
                }' type="text"
                placeholder="##-#####">
              <span class="invalid-feedback" id="valEditRequester"></span>
            </div>
          </div>
          <!-- End Requester ID -->

          <!-- Department -->
          <div class="row mb-4">
            <label class="col-sm-4 col-form-label form-label" for="selEditDepartment">Department</label>
            <div class="col-sm-8">
              <div class="tom-select-custom">
                <select class="js-select form-select" id="selEditDepartment" name="department"
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
                <span class="invalid-feedback" id="valEditDepartment"></span>
              </div>
            </div>
          </div>
          <!-- End Department -->

          <!-- Email Address -->
          <div class="row mb-4">
            <label class="col-sm-4 col-form-label form-label" for="txtEditEmail">Email Address</label>
            <div class="col-sm-8">
              <input class="form-control" id="txtEditEmail" name="email" type="email" placeholder="Enter your email address">
              <span class="invalid-feedback" id="valEditEmail"></span>
            </div>
          </div>
          <!-- End Email Address -->

          <!-- Phone Number -->
          <div class="row">
            <label class="col-sm-4 col-form-label form-label" for="txtEditPhone">Phone Number</label>
            <div class="col-sm-8">
              <div class="input-group">
                <input class="js-input-mask form-control" id="txtEditPhone" name="phone" data-hs-mask-options='{
                    "mask": "0900-000-0000"
                  }' type="text"
                  placeholder="####-###-####">
                <span class="invalid-feedback" id="valEditPhone"></span>
              </div>
            </div>
          </div>
          <!-- End Phone Number -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnEditSaveRequester" form="frmEditRequester" type="submit" disabled>
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
<!-- End Edit Requester Modal -->
