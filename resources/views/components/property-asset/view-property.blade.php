<!-- Modal -->
<div class="modal fade" id="viewPropertyModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="New Item Modal"
  aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center w-100"
        style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
        <div>
          <h4 class="modal-title" id="" style="color: whitesmoke; margin-bottom: 0.5rem;">
            Full Item Information
          </h4>
        </div>
        <div class="modal-close" style="position: absolute; top: 1rem; right: 1rem;">
          <button class="btn-close btn-close-light" data-bs-dismiss="modal" type="button"></button>
        </div>
      </div>
      <!-- End Header -->
      <!-- Body -->
      <div class="modal-body">
        <div class="col">
          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Item Name:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewItemName"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Specification:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewSpecification"></p>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Description:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewDescription"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Brand:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewBrand"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Category:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewCategory"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Unit:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewUnit"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Purchase Price:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              ₱<p class="mb-0" id="lblViewPrice"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Residual Value:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewResidualValue"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Useful Life:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewUsefulLife"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">In Stock:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewInStock"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Quantity On Site:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewInventory"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Total Quantity:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewTotalQty"></p>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Date Added:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewDateAdded"></p>
            </div>
          </div>

          <div class="row">
            <div class="col-5 d-flex align-items-center">
              <p class="form-label fw-semibold mb-0">Date Updated:</p>
            </div>
            <div class="col-7 d-flex align-items-center">
              <p class="mb-0" id="lblViewDateUpdated"></p>
            </div>
          </div>
        </div>
      </div>
      <!-- End Body -->

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
      </div>
    </div>
  </div>
</div>
