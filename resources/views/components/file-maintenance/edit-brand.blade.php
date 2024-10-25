<!-- Edit Brand Modal -->
<div class="modal fade" id="modalEditBrand" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Brand</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditBrand" method="post" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditBrandId" name="id" type="hidden">

          <!-- Brand Name -->
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditBrand">Brand Name</label>
            <input class="form-control" id="txtEditBrand" name="brand" type="text" placeholder="Enter a brand">
            <span class="invalid-feedback" id="valEditBrand"></span>
          </div>
          <!-- End Brand Name -->

          <!-- Brand Subcategories -->
          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="selEditSubcategories">Brand Subcategories</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selEditSubcategories" name="subcategories[]"
                data-hs-tom-select-options='{
                  "hideSelected": false,
                  "placeholder": "Select subcategories",
                  "singleMultiple": true
                }'
                autocomplete="off" multiple>
                @foreach ($subcategories as $subcategory)
                  @if ($subcategory->is_active)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                  @endif
                @endforeach
              </select>
              <span class="invalid-feedback" id="valEditSubcategories"></span>
            </div>
          </div>
          <!-- End Brand Subcategories -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col-sm mb-2 mb-sm-0"></div>
          <div class="col-sm-auto">
            <div class="d-flex gap-2">
              <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
              <button class="btn btn-primary" id="btnEditSaveBrand" form="frmEditBrand" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Edit Brand Modal -->
