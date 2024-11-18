<!-- Modal -->
<div class="modal fade" id="modalReturnChild" tabindex="-1" role="dialog" aria-labelledby="New Stock Record" aria-hidden="true" data-bs-backdrop="static"
     data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center">
        <div style="padding-top: 2.5rem;">
          <h4 class="modal-title" id="" style="color: whitesmoke">
            Return Item Details
          </h4>
          <span class="font-13" style="color: whitesmoke;">
            Item Code:
          </span>
          <span class="font-13" style="color: whitesmoke;" id="returnPropCode">
          </span>
        </div>
        <div class="modal-close">
          <button type="button" class="btn-close btn-close-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>
      <!-- End Header -->
      <form method="post" id="frmReturnChild" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input id="txtReturnChildId" name="id" type="hidden">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg">
              <div class="tom-select-custom mb-3">
                <label for="selReturnCondition" class="form-label">
                  Condition
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select" required autocomplete="off" name="condition" id="selReturnCondition"
                        data-hs-tom-select-options='{
                    "placeholder": "Select Condition...",
                    "hideSearch": true
                  }'>
                  <option value="" disabled selected>Select Condition</option>
                  @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valReturnCondition"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label for="txtReturnRemarks" class="form-label">Remarks</label>
                <input type="text" class="form-control" placeholder="Remarks" name="remarks" id="txtReturnRemarks"/>
                <span class="invalid-feedback" id="valReturnRemarks"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="btnReturnSaveChild" form="frmReturnChild" type="submit" disabled>
            <span class="spinner-label">Return</span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->




