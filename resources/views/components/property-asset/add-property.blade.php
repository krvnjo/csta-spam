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
                      <div class="quantity-counter">
                        <div class="js-quantity-counter row align-items-center">
                          <div class="col">
                            <span class="d-block small">Quantity</span>
                            <input class="js-result form-control form-control-quantity-counter" id="txtQuantity" name="quantity" type="number" value="1" min="1" max="500">
                          </div>

                          <div class="col-auto">
                            <a class="js-minus btn btn-outline-secondary btn-xs btn-icon rounded-circle">
                              <svg width="8" height="2" viewBox="0 0 8 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 1C0 0.723858 0.223858 0.5 0.5 0.5H7.5C7.77614 0.5 8 0.723858 8 1C8 1.27614 7.77614 1.5 7.5 1.5H0.5C0.223858 1.5 0 1.27614 0 1Z" fill="currentColor"/>
                              </svg>
                            </a>
                            <a class="js-plus btn btn-outline-secondary btn-xs btn-icon rounded-circle">
                              <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 0C4.27614 0 4.5 0.223858 4.5 0.5V3.5H7.5C7.77614 3.5 8 3.72386 8 4C8 4.27614 7.77614 4.5 7.5 4.5H4.5V7.5C4.5 7.77614 4.27614 8 4 8C3.72386 8 3.5 7.77614 3.5 7.5V4.5H0.5C0.223858 4.5 0 4.27614 0 4C0 3.72386 0.223858 3.5 0.5 3.5H3.5V0.5C3.5 0.223858 3.72386 0 4 0Z" fill="currentColor"/>
                              </svg>
                            </a>
                          </div>
                        </div>
                      </div>
                      <span class="invalid-feedback d-block" id="valAddQuantity"></span>
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
                        <span class="invalid-feedback d-block" id="valAddPurchasePrice"></span>
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
                        </div>
                        <span class="invalid-feedback d-block" id="valAddResidualValue"></span>
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
                          <option value="{{ $condition->id }}" data-name="{{ $condition->name }}" data-description="{{ $condition->description }}">
                            {{ $condition->name }}
                          </option>
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


