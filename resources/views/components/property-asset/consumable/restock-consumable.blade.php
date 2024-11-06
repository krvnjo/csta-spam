<div class="modal fade" id="restockConsumableModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="restockConsumableLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="restockConsumableLabel">Restock Item Consumable:</h5>
        <span class="font-13" id="txtRestockConsumableName"></span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="frmRestockConsumable" method="POST" novalidate>
        @csrf
        @method('PATCH')
        <input type="hidden" id="txtRestockConsumableId" name="id">
        <input type="hidden" id="txtRestockPastQuantity" name="pastQuantity">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label" for="txtRestockConsumableQuantity">Quantity: <span class="text-danger">*</span></label>
            <input class="form-control" id="txtRestockConsumableQuantity" name="restockQuantity" type="number" placeholder="0" min="1" max="10000" required>
            <span class="invalid-feedback" id="valRestockConsumableQty"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="btnRestockSaveConsumable" type="submit">
            <span class="spinner-label">Restock</span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
