<!-- Modal -->
<div class="modal fade" id="editConsumableModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="Edit Consumable Modal" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center w-100" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
        <div>
          <h4 class="modal-title" id="" style="color: whitesmoke; margin-bottom: 0.5rem;">
            Edit Item Consumable Information
          </h4>
          <span class="font-13 text-muted" style="opacity: 80%; padding-left: 0.5rem;">
            All required fields are marked with (*)
          </span>
        </div>
        <div class="modal-close" style="position: absolute; top: 1rem; right: 1rem;">
          <button class="btn-close btn-close-light" data-bs-dismiss="modal" type="button"></button>
        </div>
      </div>
      <form id="frmEditConsumable" method="post" novalidate enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input id="txtEditConsumableId" name="id" type="hidden">
        <div class="modal-body custom-modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtEditConsumableName">Item Name:
                  <span class="text-danger">*</span></label>
                <input class="form-control" id="txtEditConsumableName" name="consumableName" type="text" placeholder="Item Name" autocomplete="off" />
                <span class="invalid-feedback" id="valEditConsumableName"></span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxEditUnitType">
                  Unit Type:
                  <span class="text-danger">*</span></label>
                <select class="js-select form-select" id="cbxEditUnitType" name="unitType" autocomplete="off">
                  <option value="" disabled selected>Select Unit Type...</option>
                  @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valEditUnitType"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label class="form-label" for="txtEditConsumableDesc">Description:</label>
                <input class="form-control" id="txtEditConsumableDesc" name="consumableDesc" type="text" placeholder="Description" autocomplete="off" />
                <span class="invalid-feedback" id="valEditConsumableDesc"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
          <button class="btn btn-primary" id="btnEditSaveConsumable" form="frmEditConsumable" type="submit" disabled>
            <span class="spinner-label">Update</span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->
