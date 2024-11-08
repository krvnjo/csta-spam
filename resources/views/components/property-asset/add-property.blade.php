<!-- Modal -->
<div class="modal fade" id="addPropertyModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="New Item Modal" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center w-100" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
        <div>
          <h4 class="modal-title" id="" style="color: whitesmoke; margin-bottom: 0.5rem;">
            Item Information
          </h4>
          <span class="font-13 text-muted" style="opacity: 80%; padding-left: 0.5rem;">
            All required fields are marked with (*)
          </span>
        </div>
        <div class="modal-close" style="position: absolute; top: 1rem; right: 1rem;">
          <button class="btn-close btn-close-light" data-bs-dismiss="modal" type="button"></button>
        </div>
      </div>
      <form id="frmAddProperty" method="post" novalidate enctype="multipart/form-data">
        @csrf
        <div class="modal-body custom-modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtPropertyName">Item Name:
                  <span class="text-danger">*</span></label>
                <input class="form-control" id="txtPropertyName" name="propertyName" type="text" placeholder="Item Name" autocomplete="off" />
                <span class="invalid-feedback" id="valAddName"></span>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxCondition">
                  Condition:
                  <span class="text-danger">*</span></label>
                <select class="js-select form-select" id="cbxCondition" name="condition" autocomplete="off">
                  <option value="" disabled selected>Select Condition...</option>
                  @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddCondition"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxCategory">
                  Category:
                  <span class="text-danger">*</span>
                </label>
                <select class="js-select form-select" id="cbxCategory" name="category" autocomplete="off">
                  <option value="" disabled selected>Select Category...</option>
                  @foreach ($subcategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddCategory"></span>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxBrand">
                  Brand:
                  <span class="text-danger">*</span></label>
                <select class="js-select form-select" id="cbxBrand" name="brand" autocomplete="off">
                  <option value="" disabled selected>Select Brand...</option>
                  @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddBrand"></span>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="mb-3">
                <label class="form-label" for="txtQuantity">Quantity: <span class="text-danger">*</span></label>
                <input class="form-control" id="txtQuantity" name="quantity" type="number" placeholder="0" min="1" max="500" />
                <span class="invalid-feedback" id="valAddQty"></span>
              </div>
            </div>
          </div>
          <hr style="color: #020249">
          <div class="row">
            <div class="col-lg-4">
              <div class="mb-3">
                <label class="form-label" for="txtPurchasePrice">Purchase Price:
                  <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">₱</span>
                  <input class="form-control text-end" id="txtPurchasePrice" name="purchasePrice" type="number" step="0.01" min="0" placeholder="Purchase Price" autocomplete="off" required />
                  <span class="invalid-feedback" id="valAddPurchasePrice"></span>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="mb-3">
                <label class="form-label" for="txtResidualValue">Residual Value:
                  <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">₱</span>
                  <input class="form-control text-end" id="txtResidualValue" name="residualValue" type="number" step="0.01" min="0" placeholder="Residual Value" autocomplete="off" required />
                  <span class="invalid-feedback" id="valAddResidualValue"></span>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="mb-3">
                <label class="form-label" for="txtUsefulLife">Useful Life (in years):
                  <span class="text-danger">*</span></label>
                <input class="form-control" id="txtUsefulLife" name="usefulLife" type="number" placeholder="Useful Life" min="0" autocomplete="off" required />
                <span class="invalid-feedback" id="valAddUsefulLife"></span>
              </div>
            </div>
          </div>

          <hr style="color: #020249">
          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label class="form-label" for="txtDescription">Description:</label>
                <textarea class="form-control" id="txtDescription" name="description" style="resize: none" placeholder="Description"></textarea>
                <span class="invalid-feedback" id="valAddDesc"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxAcquiredType">
                  Acquired Type:
                  <span class="text-danger">*</span></label>
                <select class="js-select form-select cbxAcquiredType" id="cbxAcquiredType" name="acquiredType" autocomplete="off">
                  <option value="" disabled selected>Select Acquired Type...</option>
                  @foreach ($acquisitions as $acquired)
                    <option value="{{ $acquired->id }}">{{ $acquired->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddAcquired"></span>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="mb-3">
                <label class="form-label" for="dtpAcquired">
                  Date Acquired:
                  <span class="text-danger">*</span></label>
                <input class="form-control" id="dtpAcquired" name="dateAcquired" type="date" max="{{ now()->toDateString() }}" />
                <span class="invalid-feedback" id="valAddDtpAcq"></span>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="mb-3">
                <label class="form-label" for="dtpWarranty"> Warranty Date: </label>
                <input class="form-control" id="dtpWarranty" name="warranty" type="date" min="{{ now()->toDateString() }}" />
                <span class="invalid-feedback" id="valAddWarranty"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label class="form-label" for="addPropertyDropzone">Image:</label>
                <div style="padding-left: 1.4rem">
                  <!-- Dropzone -->
                  <div class="js-dropzone row dz-dropzone dz-dropzone-card" id="addPropertyDropzone">
                    <div class="dz-message">
                      <img class="avatar avatar-xl avatar-4x3 mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-browse.svg') }}" alt="Image Description">
                      <h5>Drag and drop your file here</h5>
                      <p class="mb-2">or</p>
                      <span class="btn btn-white btn-sm">Browse files</span>
                    </div>
                  </div>
                  <!-- End Dropzone -->
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
<!-- End Modal -->
<script>
  const subcategoryBrandsUrl = "{{ route('prop-asset.getSubcategoryBrands') }}";
</script>
