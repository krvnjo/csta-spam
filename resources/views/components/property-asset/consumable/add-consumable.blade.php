<!-- Modal -->
<div class="modal fade" id="addConsumableModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="New Consumable Modal" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center w-100" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
        <div>
          <h4 class="modal-title" id="" style="color: whitesmoke; margin-bottom: 0.5rem;">
            Item Consumable Information
          </h4>
          <span class="font-13 text-muted" style="opacity: 80%; padding-left: 0.5rem;">
            All required fields are marked with (*)
          </span>
        </div>
        <div class="modal-close" style="position: absolute; top: 1rem; right: 1rem;">
          <button class="btn-close btn-close-light" data-bs-dismiss="modal" type="button"></button>
        </div>
      </div>
      <form id="frmAddConsumable" method="post" novalidate enctype="multipart/form-data">
        @csrf
        <div class="modal-body custom-modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtConsumableName">Item Name:
                  <span class="text-danger">*</span></label>
                <input class="form-control" id="txtConsumableName" name="consumableName" type="text" placeholder="Item Name" autocomplete="off" />
                <span class="invalid-feedback" id="valAddConsumable"></span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtConsumableDesc">Description:</label>
                <input class="form-control" id="txtConsumableDesc" name="consumableDesc" type="text" placeholder="Description" autocomplete="off" />
                <span class="invalid-feedback" id="valAddConsumableDesc"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxUnitType">
                  Unit Type:
                  <span class="text-danger">*</span></label>
                <select class="js-select form-select" id="cbxUnitType" name="unitType" autocomplete="off">
                  <option value="" disabled selected>Select Unit Type...</option>
                  @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddUnitType"></span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtConsumableQuantity">Quantity: <span class="text-danger">*</span></label>
                <input class="form-control" id="txtConsumableQuantity" name="consumableQuantity" type="number" placeholder="0" min="1" max="10000" />
                <span class="invalid-feedback" id="valAddConsumableQty"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
          <button class="btn btn-primary" id="btnAddSaveConsumable" form="frmAddConsumable" type="submit" disabled>
            <span class="spinner-label">Save</span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->
