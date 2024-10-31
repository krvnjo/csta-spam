<!-- Add Brand Modal -->
<div class="modal fade" id="modalAddBrand" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Brand</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddBrand" method="POST" novalidate>
          @csrf
          <!-- Brand Name -->
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddBrand">Brand Name</label>
            <input class="form-control" id="txtAddBrand" name="brand" type="text" placeholder="Enter a brand">
            <span class="invalid-feedback" id="valAddBrand"></span>
          </div>
          <!-- End Brand Name -->

          <!-- Brand Subcategories -->
          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="selAddSubcategories">Brand Subcategories</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selAddSubcategories" name="subcategories[]"
                data-hs-tom-select-options='{
                  "hideSelected": false,
                  "placeholder": "Select a subcategory",
                  "singleMultiple": true
                }'
                autocomplete="off" multiple>
                <option value=""></option>
                @foreach ($subcategories as $subcategory)
                  @if ($subcategory->is_active)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                  @endif
                @endforeach
              </select>
              <span class="invalid-feedback" id="valAddSubcategories"></span>
            </div>
          </div>
          <!-- End Brand Subcategories -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col-sm"></div>
          <div class="col-sm-auto">
            <div class="d-flex justify-content-end gap-2">
              <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
              <button class="btn btn-primary" id="btnAddSaveBrand" form="frmAddBrand" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Brand Modal -->
