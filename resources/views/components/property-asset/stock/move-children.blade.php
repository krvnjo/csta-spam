<!-- Modal -->
<div class="modal fade" id="movePropChildModal" tabindex="-1" role="dialog" aria-labelledby="New Stock Record" aria-hidden="true" data-bs-backdrop="static"
     data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center w-100">
        <div class="pt-6">
          <h4 class="modal-title" id="" style="color: whitesmoke">
            Inventory Items
          </h4>
          <span class="font-13" style="color: whitesmoke;">
            Items:
          </span>
          <span class="font-13" style="color: whitesmoke;" id="movePropIds">
          </span>
        </div>

        <div class="modal-close">
          <button type="button" class="btn-close btn-close-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>
      <!-- End Header -->
      <form method="post" id="frmMovePropChild" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PATCH')
        <input type="hidden" id="movePropIds">
        <div class="modal-body">

          <div class="row">
            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label for="cbxMoveDesignation" class="form-label">
                  Designation
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select"  autocomplete="off" name="designation" id="cbxMoveDesignation"
                        data-hs-tom-select-options='{
                    "placeholder": "Select Designation...",
                    "hideSearch": true
                  }'>
                  <option value="">Select Designation...</option>
                  @foreach ($designations as $designation)
                    <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valMoveDesignation"></span>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label for="cbxMoveStatus" class="form-label">
                  Status
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select" autocomplete="off" name="status" id="cbxMoveStatus"
                        data-hs-tom-select-options='{
                    "placeholder": "Select Status...",
                    "hideSearch": true
                  }'>
                  <option value="">Select Status...</option>
                  @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valMoveStatus"></span>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="btnMoveChildSave" form="frmMovePropChild" type="submit" disabled>
            <span class="spinner-label">Move</span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
