<!-- Modal -->
<div class="modal fade" id="editPropChildModal" tabindex="-1" role="dialog" aria-labelledby="New Stock Record" aria-hidden="true" data-bs-backdrop="static"
     data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center">
        <div style="padding-top: 2.5rem;">
          <h4 class="modal-title" id="" style="color: whitesmoke">
            Edit Item Details
          </h4>
          <span class="font-13" style="color: whitesmoke;">
            Item Code:
          </span>
          <span class="font-13" style="color: whitesmoke;" id="editPropCode">
          </span>
        </div>
        <div class="modal-close">
          <button type="button" class="btn-close btn-close-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>
      <!-- End Header -->
      <form method="post" id="frmEditPropChild" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input id="txtEditChildId" name="id" type="hidden">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="editPropSerialNumber" class="form-label"> Serial Number </label>
                <input type="text" class="form-control" placeholder="Serial Number" name="serialNumber" id="txtEditSerialNumber" pattern="[A-Za-z0-9]*"
                       title="Only alphanumeric characters are allowed" />
                <span class="invalid-feedback" id="valEditSerial"></span>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="mb-3">
                <label for="editPropRemarks" class="form-label">Remarks</label>
                <input type="text" class="form-control" placeholder="Remarks" name="remarks" id="txtEditRemarks"
                       pattern="^(?=.*[A-Za-z0-9])[A-Za-z0-9 ]+$" title="Only alphanumeric characters are allowed, and the input cannot be all spaces" />
                <span class="invalid-feedback" id="valEditRemarks"></span>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label for="editPropAcquiredType" class="form-label">
                  Acquired Type
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select" required autocomplete="off" name="acquiredType" id="cbxEditAcquiredType"
                        data-hs-tom-select-options='{
                    "placeholder": "Select Acquired type...",
                    "hideSearch": true
                  }'>
                  <option value=""></option>
                  @foreach ($acquisitions as $acquired)
                    <option value="{{ $acquired->id }}">{{ $acquired->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valEditAcquired"></span>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label for="editPropCondition" class="form-label">
                  Condition
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select" required autocomplete="off" name="condition" id="cbxEditCondition"
                        data-hs-tom-select-options='{
                    "placeholder": "Select Condition...",
                    "hideSearch": true
                  }'>
                  <option value=""></option>
                  @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valEditCondition"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="editPropDateAcquired" class="form-label">
                  Date Acquired
                  <span class="font-13" style="color: red">*</span></label>
                <input type="date" class="form-control" required name="dateAcquired" id="txtEditDateAcquired" max="{{ now()->toDateString() }}" />
                <span class="invalid-feedback" id="valEditDateAcq"></span>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="mb-3">
                <label for="editPropWarrantyDate" class="form-label"> Warranty Date </label>
                <input type="date" class="form-control" name="warranty" id="txtEditWarrantyDate" min="{{ now()->toDateString() }}" />
                <span class="invalid-feedback" id="valEditWarranty"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btnEditSaveChild" form="frmEditPropChild">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->




