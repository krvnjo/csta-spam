<!-- Edit Item Modal -->
<div class="modal fade" id="editPropertyModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="Edit Item Modal"
     aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-top-cover bg-dark text-center w-100"
           style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
        <div>
          <h4 class="modal-title" style="color: whitesmoke; margin-bottom: 0.5rem;">Edit Item Information</h4>
          <span class="font-13 text-muted" style="opacity: 80%; padding-left: 0.5rem;">
            All required fields are marked with (*)
          </span>
        </div>
        <div class="modal-close" style="position: absolute; top: 1rem; right: 1rem;">
          <button class="btn-close btn-close-light" data-bs-dismiss="modal" type="button"></button>
        </div>
      </div>
      <!-- End Header -->

      <!-- Edit Form -->
      <form id="frmEditProperty" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input id="txtEditPropertyId" name="id" type="hidden">
        <div class="modal-body custom-modal-body">
          <div class="row">
            <div class="col-md-8 pe-md-4">
              <!-- Basic Information -->
              <div class="card mb-4">
                <div class="card-header bg-light">
                  <h5 class="card-title mb-0">Edit Basic Information</h5>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input class="form-control" id="txtEditPropertyName" name="propertyName" type="text" placeholder="Item Name" autocomplete="off" />
                        <label for="txtEditPropertyName">Item Name <span class="text-danger">*</span></label>
                        <span class="invalid-feedback" id="valEditPropertyName"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="tom-select-custom mb-3 form-floating">
                        <select class="js-select form-select" id="cbxEditItemType" name="itemType" disabled required>
                          <option value="" disabled>Select Item Type...</option>
                          <option value="consumable">Consumable</option>
                          <option value="non-consumable">Non-Consumable</option>
                        </select>
                        <label for="cbxEditItemType">Item Type <span class="text-danger">*</span></label>
                        <span class="invalid-feedback" id="valEditItemType"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Item Details -->
              <div class="card mb-4">
                <div class="card-header bg-light">
                  <h5 class="card-title mb-0">Edit Item Details</h5>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="form-floating">
                        <textarea class="form-control" id="txtEditSpecification" name="specification" style="height: 3.5rem; resize: vertical;" placeholder="Specification"></textarea>
                        <label for="txtEditSpecification">Specifications</label>
                        <span class="invalid-feedback" id="valEditSpecification"></span>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-floating">
                        <input class="form-control" id="txtEditDescription" name="description" type="text" placeholder="Description" />
                        <label for="txtEditDescription">Description</label>
                        <span class="invalid-feedback" id="valEditDescription"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Quantity & Price -->
              <div class="card mb-4">
                <div class="card-header bg-light">
                  <h5 class="card-title mb-0">Edit Unit & Price</h5>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-4">
                      <div class="form-floating">
                        <input class="form-control" id="txtEditQuantity" name="quantity" type="number" min="1" max="500" placeholder="Quantity" />
                        <label for="txtEditQuantity">Quantity</label>
                        <span class="invalid-feedback" id="valEditQuantity"></span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="tom-select-custom mb-3 form-floating">
                        <select class="js-select form-select" id="cbxEditUnit" name="unit">
                          <option value="" disabled selected>Select Unit...</option>
                          @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                          @endforeach
                        </select>
                        <label for="cbxEditUnit">Units</label>
                        <span class="invalid-feedback" id="valEditUnit"></span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <div class="form-floating">
                          <input class="form-control text-end" id="txtEditPurchasePrice" name="purchasePrice" type="number" step="0.01" min="0" placeholder="Purchase Price" />
                          <label for="txtEditPurchasePrice">Purchase Price</label>
                        </div>
                        <span class="invalid-feedback d-block" id="valEditPurchasePrice"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <!-- Item Image -->
              <div class="card mb-4">
                <div class="card-header bg-light">
                  <h5 class="card-title mb-0">Item Image</h5>
                </div>
                <div class="card-body">
                  <div class="js-dropzone dz-dropzone dz-dropzone-card" id="editPropertyDropzone">
                    <div class="dz-message">
                      <img class="avatar avatar-lg avatar-4x3 mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-browse.svg') }}" alt="Upload illustration" style="height: 7.3rem;">
                      <h5>Drag and drop your file here</h5>
                      <p class="text-muted mb-2">or</p>
                      <button class="btn btn-primary btn-sm" type="button">Browse files</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="nonConsumableFields" style="display: none;">
              <div class="card mb-4">
                <div class="card-header bg-light">
                  <h5 class="card-title mb-0">Edit Details for Non-Consumable Items</h5>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-3">
                      <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <div class="form-floating">
                          <input class="form-control text-end" id="txtEditResidualValue" name="residualValue" type="number" step="0.01" min="0" placeholder="Residual Value" />
                          <label for="txtEditResidualValue">Residual Value</label>
                        </div>
                        <span class="invalid-feedback" id="valEditResidualValue"></span>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-floating">
                        <input class="form-control" id="txtEditUsefulLife" name="usefulLife" type="number" min="0" placeholder="Useful Life" />
                        <label for="txtEditUsefulLife">Useful Life (years)</label>
                        <span class="invalid-feedback" id="valEditUsefulLife"></span>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="tom-select-custom mb-3 form-floating">
                        <select class="js-select form-select" id="cbxEditCategory" name="category" required>
                          <option value="" disabled selected>Select Category...</option>
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @endforeach
                        </select>
                        <label for="cbxCategory">Category <span class="text-danger">*</span></label>
                        <span class="invalid-feedback" id="valEditCategory"></span>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="tom-select-custom mb-3 form-floating">
                        <select class="js-select form-select" id="cbxEditBrand" name="brand" required>
                          <option value="" disabled selected>Select Brand...</option>
                          @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                          @endforeach
                        </select>
                        <label for="cbxBrand">Brand <span class="text-danger">*</span></label>
                        <span class="invalid-feedback" id="valEditBrand"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
          <button class="btn btn-primary" id="btnEditSaveProperty" form="frmEditProperty" type="submit" disabled>
            <span class="spinner-label">Save</span>
            <span class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
