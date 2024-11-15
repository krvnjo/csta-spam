<!-- Modal -->
<div class="modal fade" id="movePropChildModal" tabindex="-1" role="dialog" aria-labelledby="move-item" aria-hidden="true" data-bs-backdrop="static"
     data-bs-keyboard="false">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center w-100">
        <div class="pt-6">
          <h4 class="modal-title" id="" style="color: whitesmoke">
            Assign Items
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
      <form method="post" id="frmMovePropChild" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input type="hidden" id="movePropIds">
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <div class="tom-select-custom mb-3 form-floating">
                <select class="js-select form-select" name="designation" id="cbxMoveDesignation" required>
                  <option value="" disabled selected>Select Designation...</option>
                  @foreach ($designations as $designation)
                    @if ($designation->id != 1)
                    <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                    @endif
                  @endforeach
                </select>
                <label for="cbxMoveDesignation">Designation</label>
                <span class="invalid-feedback" id="valMoveDesignation"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-floating">
                <textarea class="form-control" id="txtMoveRemarks" name="remarks" style="height: 5rem; resize: vertical; min-height: 5rem; max-height: 10rem;" placeholder="remarks"></textarea>
                <label for="txtMoveRemarks">Remarks</label>
                <span class="invalid-feedback" id="valMoveRemarks"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="btnMoveChildSave" form="frmMovePropChild" type="submit" disabled>
            <span class="spinner-label">Assign</span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<style>
  .form-floating {
    .ts-wrapper.form-control,
    .ts-wrapper.form-select {
      height: auto !important;
    }

    .ts-wrapper.form-control .ts-control,
    .ts-wrapper.form-select .ts-control {
      padding-top: 1.625rem;
      padding-bottom: 0.625rem;
    }

    .ts-wrapper.form-control ~ label,
    .ts-wrapper.form-select ~ label {
      transform: scale(1) translateY(0) translateX(0);
      color: rgba(var(--bs-body-color-rgb), 1);
    }

    .ts-wrapper.form-control.focus ~ label,
    .ts-wrapper.form-control.full ~ label,
    .ts-wrapper.form-select.focus ~ label,
    .ts-wrapper.form-select.full ~ label,
    .ts-wrapper.form-select.has-items ~ label {
      transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
      color: rgba(var(--bs-body-color-rgb), 0.65);
    }

    .ts-wrapper.form-select:not(.focus) .ts-control ::placeholder {
      opacity: 0;
    }
  }
</style>
