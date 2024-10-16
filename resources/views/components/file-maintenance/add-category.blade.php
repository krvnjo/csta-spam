<!-- Add Category Modal -->
<div class="modal fade" id="modalAddCategory" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Category</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddCategory" method="post" novalidate>
          @csrf
          <!-- Category Name -->
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddCategory">Category Name</label>
            <input class="form-control" id="txtAddCategory" name="category" type="text" placeholder="Enter a Category">
            <span class="invalid-feedback" id="valAddCategory"></span>
          </div>
          <!-- End Category Name -->

          <!-- Category Subcategories -->
          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="selAddCategorySubcategories">Category Subcategories</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selAddCategorySubcategories" name="subcategories[]"
                data-hs-tom-select-options='{
                  "singleMultiple": true,
                  "hideSelected": false,
                  "placeholder": "Select subcategories"
                }'
                autocomplete="off" multiple>
                <option value=""></option>
                @foreach ($subcategories as $subcategory)
                  @if ($subcategory->is_active)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                  @endif
                @endforeach
              </select>
              <span class="invalid-feedback" id="valAddCategorySubcategories"></span>
            </div>
          </div>
          <!-- End Category Subcategories -->
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
              <button class="btn btn-primary" id="btnAddSaveCategory" form="frmAddCategory" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Category Modal -->
