<div class="modal fade" id="addPropertyModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="New Item Modal" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-top-cover bg-dark text-center w-100" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.5rem;">
        <div>
          <h4 class="modal-title text-white mb-2">Add New Item</h4>
          <p class="text-white-50 mb-0">
            <i class="bi bi-info-circle me-1"></i>
            Required fields are marked with (*)
          </p>
        </div>
        <div class="modal-close" style="position: absolute; top: 1rem; right: 1rem;">
          <button class="btn-close btn-close-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
      </div>

      <form id="frmAddProperty" method="post" novalidate enctype="multipart/form-data">
        @csrf
        <div class="modal-body custom-modal-body">
          <!-- Alert (Initially hidden) -->
          <div id="alertContainer" class="alert alert-info" role="alert" style="display: none;">
            <small><i class="bi bi-arrow-down-circle me-2"></i>Additional fields are available below. Please scroll down to fill them out.</small>
          </div>
          <div class="row">
            <div class="col-md-8 pe-md-4">
              <div class="card mb-4">
                <div class="card-header bg-light">
                  <h5 class="card-title mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input class="form-control" id="txtPropertyName" name="propertyName" type="text" placeholder="Item Name" autocomplete="off" required />
                        <label for="txtPropertyName">Item Name <span class="text-danger">*</span></label>
                        <span class="invalid-feedback" id="valAddName"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="tom-select-custom mb-3 form-floating">
                        <select class="js-select form-select" id="cbxItemType" name="itemType" autocomplete="off" required>
                          <option value="" disabled selected>Select Item Type...</option>
                          <option value="consumable">Consumable</option>
                          <option value="non-consumable">Non-Consumable</option>
                        </select>
                        <label for="cbxItemType">Item Type <span class="text-danger">*</span></label>
                        <span class="invalid-feedback" id="valAddItemType"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-header bg-light">
                  <h5 class="card-title mb-0">Item Details <span class="text-muted ps-2" style="font-size: 10pt">Tip: Drag the bottom-right side of the specification to resize!</span></h5>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="form-floating">
                        <textarea class="form-control" id="txtSpecification" name="specification" style="height: 3.5rem; resize: vertical; min-height: 3.5rem; max-height: 5rem;" placeholder="Specification"></textarea>
                        <label for="txtSpecification">Specifications</label>
                        <span class="invalid-feedback" id="valAddSpecification"></span>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-floating">
                        <input class="form-control" id="txtDescription" name="description" type="text" placeholder="Description" />
                        <label for="txtDescription">Description</label>
                        <span class="invalid-feedback" id="valAddDescription"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-header bg-light">
                  <h5 class="card-title mb-0">Quantity & Price</h5>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-4">
                      <div class="form-floating">
                        <input class="form-control" id="txtQuantity" name="quantity" type="number" min="1" max="500" placeholder=""/>
                        <label for="txtQuantityConsumable">Quantity</label>
                        <span class="invalid-feedback" id="valAddQuantity"></span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="tom-select-custom mb-3 form-floating">
                        <select class="js-select form-select" id="cbxUnit" name="unit">
                          <option value="" disabled selected>Select Unit...</option>
                          @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                          @endforeach
                        </select>
                        <label for="cbxUnit">Units</label>
                        <span class="invalid-feedback" id="valAddUnit"></span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <div class="form-floating">
                          <input class="form-control text-end" id="txtPurchasePrice" name="purchasePrice" type="number" step="0.01" min="0" placeholder="Purchase Price" />
                          <label for="txtPurchasePrice">Purchase Price</label>
                        </div>
                        <span class="invalid-feedback" id="valAddPurchasePrice"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4">
                <div class="card-header bg-light">
                  <h5 class="card-title mb-0">Item Image</h5>
                </div>
                <div class="card-body">
                  <div class="js-dropzone dz-dropzone dz-dropzone-card" id="addPropertyDropzone">
                    <div class="dz-message">
                      <img class="avatar avatar-lg avatar-4x3 mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-browse.svg') }}" alt="Upload illustration" style="height: 7.3rem;">
                      <h5>Drag and drop your file here</h5>
                      <p class="text-muted mb-2">or</p>
                      <button class="btn btn-primary btn-sm" type="button">Browse files</button>
                    </div>
                  </div>
                </div>
              </div>
              <div id="nonConsumableFields1" style="display: none;">
                <div class="card mb-4">
                <div class="card-header bg-light">
                  <h5 class="card-title mb-0">Residual Value & Useful Life <span class="text-muted ps-2" style="font-size: 10pt">Tip: Hover for info</span></h5>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <div class="form-floating">
                          <input class="form-control text-end" id="txtResidualValue" name="residualValue" type="number" step="0.01" min="0" placeholder="Residual Value"
                                 data-bs-toggle="tooltip" title="The residual value is the estimated value of the asset at the end of its useful life."/>
                          <label for="txtResidualValue">Residual Value</label>
                          <span class="invalid-feedback" id="valAddResidualValue"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input class="form-control" id="txtUsefulLife" name="usefulLife" type="number" min="0" placeholder="Useful Life"
                               data-bs-toggle="tooltip" title="The useful life refers to the expected number of years an asset will be in use."/>
                        <label for="txtUsefulLife">Useful Life (years)</label>
                        <span class="invalid-feedback" id="valAddUsefulLife"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
            </div>


          </div>
          <div id="nonConsumableFields2" style="display: none;">
            <div class="card mb-4">
              <div class="card-header bg-light">
                <h5 class="card-title mb-0">Additional Details for Non-Consumable Items</h5>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-4">
                    <div class="tom-select-custom mb-3 form-floating">
                      <select class="js-select form-select" id="cbxCategory" name="category" required>
                        <option value="" disabled selected>Select Category...</option>
                        @foreach ($categories as $category)
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                      </select>
                      <label for="cbxCategory">Category <span class="text-danger">*</span></label>
                      <span class="invalid-feedback" id="valAddCategory"></span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="tom-select-custom mb-3 form-floating">
                      <select class="js-select form-select" id="cbxCondition" name="condition" required>
                        <option value="" disabled selected>Select Condition...</option>
                        @foreach ($conditions as $condition)
                          <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                        @endforeach
                      </select>
                      <label for="cbxCondition">Condition <span class="text-danger">*</span></label>
                      <span class="invalid-feedback" id="valAddCondition"></span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="tom-select-custom mb-3 form-floating">
                      <select class="js-select form-select" id="cbxBrand" name="brand" required>
                        <option value="" disabled selected>Select Brand...</option>
                        @foreach ($brands as $brand)
                          <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                      </select>
                      <label for="cbxBrand">Brand <span class="text-danger">*</span></label>
                      <span class="invalid-feedback" id="valAddBrand"></span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="tom-select-custom mb-3 form-floating">
                      <select class="js-select form-select cbxAcquiredType" id="cbxAcquiredType" name="acquiredType" autocomplete="off">
                        <option value="" disabled selected>Select Acquired Type...</option>
                        @foreach ($acquisitions as $acquired)
                          <option value="{{ $acquired->id }}">{{ $acquired->name }}</option>
                        @endforeach
                      </select>
                      <label for="cbxAcquiredType">Acquired Type</label>
                      <span class="invalid-feedback" id="valAddAcquiredType"></span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-floating">
                      <input class="form-control" id="dtpAcquired" name="dateAcquired" type="date" max="{{ now()->toDateString() }}" />
                      <label for="dtpAcquired">Date Acquired</label>
                      <span class="invalid-feedback" id="valAddDateAcq"></span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-floating">
                      <input class="form-control" id="dtpWarranty" name="warranty" type="date" min="{{ now()->toDateString() }}" />
                      <label for="dtpWarranty">Warranty Date</label>
                      <span class="invalid-feedback" id="valAddWarranty"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
          <button class="btn btn-primary" id="btnAddSaveProperty" form="frmAddProperty" type="submit" disabled>
            <span class="spinner-label">Save</span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
{{--<script>--}}
{{--  document.addEventListener('DOMContentLoaded', function() {--}}
{{--    const itemTypeSelect = document.getElementById('cbxItemType');--}}
{{--    const nonConsumableFields1 = document.getElementById('nonConsumableFields1');--}}
{{--    const nonConsumableFields2 = document.getElementById('nonConsumableFields2');--}}
{{--    const alertContainer = document.getElementById('alertContainer');--}}
{{--    let alertTimeout;--}}

{{--    const tomSelect1 = new TomSelect('#cbxCategory');--}}
{{--    const tomSelect2 = new TomSelect('#cbxCondition');--}}
{{--    const tomSelect3 = new TomSelect('#cbxBrand');--}}
{{--    const tomSelect4 = new TomSelect('#cbxAcquiredType');--}}

{{--    function resetNonConsumableFields() {--}}

{{--      const inputs1 = nonConsumableFields1.querySelectorAll('input');--}}
{{--      const inputs2 = nonConsumableFields2.querySelectorAll('input');--}}

{{--      // Clear all regular inputs--}}
{{--      inputs1.forEach(input => input.value = '');--}}
{{--      inputs2.forEach(input => input.value = '');--}}

{{--      if (tomSelect1) {--}}
{{--        tomSelect1.clear()--}}
{{--      }--}}
{{--      if (tomSelect2) {--}}
{{--        tomSelect2.clear();--}}
{{--      }--}}
{{--      if (tomSelect3) {--}}
{{--        tomSelect3.clear();--}}
{{--      }--}}
{{--      if (tomSelect4) {--}}
{{--        tomSelect4.clear();--}}
{{--      }--}}
{{--      --}}
{{--    }--}}

{{--    itemTypeSelect.addEventListener('change', function() {--}}
{{--      clearTimeout(alertTimeout);--}}

{{--      if (this.value === 'non-consumable') {--}}
{{--        nonConsumableFields1.style.display = 'block';--}}
{{--        nonConsumableFields2.style.display = 'block';--}}

{{--        alertContainer.style.display = 'block';--}}
{{--        alertContainer.classList.remove('fade');--}}

{{--        alertTimeout = setTimeout(function() {--}}
{{--          alertContainer.classList.add('fade');--}}
{{--          alertContainer.addEventListener('transitionend', function() {--}}
{{--            alertContainer.style.display = 'none';--}}
{{--            alertContainer.classList.remove('fade');--}}
{{--          });--}}
{{--        }, 5000);--}}

{{--        resetNonConsumableFields();--}}

{{--      } else {--}}
{{--        nonConsumableFields1.style.display = 'none';--}}
{{--        nonConsumableFields2.style.display = 'none';--}}
{{--        alertContainer.style.display = 'none';--}}

{{--        resetNonConsumableFields();--}}
{{--      }--}}

{{--    });--}}
{{--  });--}}
{{--</script>--}}


<style>
  .modal-xl {
    max-width: 1300px;
  }

  .custom-modal-body {
    padding: 1.5rem;
  }

  @media (max-width: 768px) {
    .pe-md-4 {
      padding-right: 0 !important;
    }
  }

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


