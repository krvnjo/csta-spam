<!-- Edit Subcategory Modal -->
<div class="modal fade" id="modalEditSubcategory" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Subcategory</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditSubcategory" method="POST" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditSubcategoryId" name="id" type="hidden">

          <!-- Subcategory Name -->
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditSubcategory">Subcategory Name</label>
            <input class="form-control" id="txtEditSubcategory" name="subcategory" type="text" placeholder="Enter a subcategory">
            <span class="invalid-feedback" id="valEditSubcategory"></span>
          </div>
          <!-- End Subcategory Name -->

          <!-- Subcategory Categories -->
          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="selEditCategories">Subcategory Categories</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selEditCategories" name="categories[]"
                data-hs-tom-select-options='{
                  "placeholder": "Select a category",
                  "singleMultiple": true
                }' autocomplete="off" multiple>
                @foreach ($categories as $category)
                  @if ($category->is_active)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endif
                @endforeach
              </select>
              <span class="invalid-feedback" id="valEditCategories"></span>
            </div>
          </div>
          <!-- End Subcategory Categories -->

          <!-- Subcategory Brands -->
          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="selEditBrands">Subcategory Brands</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selEditBrands" name="brands[]"
                data-hs-tom-select-options='{
                  "placeholder": "Select a brand",
                  "singleMultiple": true
                }' autocomplete="off" multiple>
                @foreach ($brands as $brand)
                  @if ($brand->is_active)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                  @endif
                @endforeach
              </select>
              <span class="invalid-feedback" id="valEditBrands"></span>
            </div>
          </div>
          <!-- End Subcategory Brands -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnEditSaveSubcategory" form="frmEditSubcategory" type="submit" disabled>
              <span class="spinner-label">Save</span>
              <span class="spinner-border spinner-border-sm d-none"></span>
            </button>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Edit Subcategory Modal -->
