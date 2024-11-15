<div class="modal fade" id="addPropertyChild" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addPropertyChildLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPropertyChildLabel">
          @if($propertyParents->is_consumable)
            Restock Item
          @else
            Add Variation Quantity
          @endif
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="frmAddVarProperty" action="{{ route('prop-asset.child.store', $propertyParents->id) }}" method="POST" novalidate enctype="multipart/form-data">
      @csrf
        <input type="hidden" name="parent_id" value="{{ $propertyParents->id }}">
        <div class="modal-body">
          <div class="mb-3">
            <label for="txtVarQuantity" class="form-label">Quantity
              <span class="font-13" style="color: red">*</span></label>
            <input type="number" class="form-control" placeholder="Quantity" min="1" minlength="1" max="500" name="VarQuantity"
                   id="txtVarQuantity" required title="Only numbers are allowed" />
            <span class="invalid-feedback" id="valAddChildQty"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="btnAddSaveChild" form="frmAddVarProperty" type="submit" disabled>
            <span class="spinner-label">
              @if($propertyParents->is_consumable)
                Restock
              @else
                Save
              @endif
            </span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
