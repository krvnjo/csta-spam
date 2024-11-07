<!-- Modal -->
<div class="modal fade" id="useConsumableModal" tabindex="-1" role="dialog" aria-labelledby="useConsumableLabel" aria-hidden="true" data-bs-backdrop="static"
     data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center w-100">
        <div class="pt-6">
          <h5 class="modal-title" id="useConsumableLabel" style="color: whitesmoke">Use Item Consumable:</h5>
          <span class="font-13" id="txtUseConsumableName" style="color: whitesmoke"></span>
        </div>

        <div class="modal-close">
          <button type="button" class="btn-close btn-close-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>
      <form method="post" id="frmUseConsumable" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PATCH')
        <input type="hidden" id="txtUseConsumableId" name="id">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtUseConsumedBy">Consumer Name:
                  <span class="text-danger">*</span></label>
                <input class="form-control" id="txtUseConsumedBy" name="useConsumedBy" type="text" placeholder="Consumer Name" autocomplete="off" />
                <span class="invalid-feedback" id="valUseConsumedBy"></span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtUsePurpose">Purpose:</label>
                <input class="form-control" id="txtUsePurpose" name="usePurpose" type="text" placeholder="Purpose" autocomplete="off" />
                <span class="invalid-feedback" id="valUsePurpose"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label for="cbxUseDepartment" class="form-label">
                  Department
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select"  autocomplete="off" name="useDepartment" id="cbxUseDepartment"
                        data-hs-tom-select-options='{
                    "placeholder": "Select Department...",
                    "hideSearch": true
                  }'>
                  <option value="">Select Department...</option>
                  @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valUseDepartment"></span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtUseQuantity">Quantity Used:
                  <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">
                    Available:
                    <span id="txtUseAvailableQty" style="padding-left: 0.5rem"></span>
                  </span>
                  <input class="form-control text-end" id="txtUseQuantity" name="useQuantity" type="number" min="0"  max="10000" placeholder="0" autocomplete="off" required />
                  <span class="input-group-text" id="txtUseUnit"></span>
                  <span class="invalid-feedback" id="valUseQuantity"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label for="txtUseRemarks" class="form-label">Remarks:</label>
                <input type="text" class="form-control" placeholder="Remarks" name="useRemarks" id="txtUseRemarks"/>
                <span class="invalid-feedback" id="valUseRemarks"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="btnUseSaveConsumable" form="frmUseConsumable" type="submit" disabled>
            <span class="spinner-label">Save</span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
