<!-- Modal -->
<div class="modal fade" id="editPropertyModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="New Item Modal"
     aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-top-cover bg-dark text-center w-100"
           style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
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

      <!-- End Header -->
      <form id="frmAddProperty" method="post" novalidate enctype="multipart/form-data">
        @csrf

        <div class="modal-body custom-modal-body">
          <input id="txtEditPropertyId" name="id" type="hidden">
          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label class="form-label" for="txtPropertyName">Item Name:
                  <span class="text-danger">*</span></label>
                <input class="form-control" id="txtEditPropertyName" name="propertyName" type="text" placeholder="Stock Name" autocomplete="off" />
                <span class="invalid-feedback" id="valAddName"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxCategory">
                  Category:
                  <span class="text-danger">*</span>
                </label>
                <select class="js-select form-select" id="cbxEditCategory" name="category" autocomplete="off">
                  <option value="" disabled selected>Select Category...</option>
                  @foreach ($subcategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddCategory"></span>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxBrand">
                  Brand:
                  <span class="text-danger">*</span></label>
                <select class="js-select form-select" id="cbxEditBrand" name="brand" autocomplete="off">
                  <option value="" disabled selected>Select Brand...</option>
                  @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddBrand"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label class="form-label" for="txtDescription">Description:</label>
                <textarea class="form-control" id="txtEditDescription" name="description" style="resize: none" placeholder="Description"></textarea>
                <span class="invalid-feedback" id="valAddDesc"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label class="form-label" for="propertyDropzone">Image:</label>
                <div style="padding-left: 1.4rem">
                  <!-- Dropzone -->
                  <div class="js-dropzone row dz-dropzone dz-dropzone-card" id="editPropertyDropzone">
                    <div class="dz-message">
                      <img class="avatar avatar-xl avatar-4x3 mb-3" src="{{ Vite::asset('resources/svg/illustrations/oc-browse.svg') }}"
                           alt="Image Description">
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
          <button class="btn btn-secondary" type="button">Close</button>
          <button class="btn btn-primary" form="frmAddProperty" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let categoryEditSelect, brandEditSelect;

    function initializeSelects() {
      categoryEditSelect = new TomSelect('#cbxEditCategory', {
        controlInput: false,
        hideSearch: true,
        allowEmptyOption: true,
        onChange: function(value) {
          if (value) {
            fetchBrands(value);
          } else {
            resetBrandSelect();
          }
        }
      });

      brandEditSelect = new TomSelect('#cbxEditBrand', {
        controlInput: false,
        hideSearch: true,
        allowEmptyOption: true
      });
    }

    function fetchBrands(categoryId) {
      $.ajax({
        url: '{{ route("prop-asset.getSubcategoryBrands") }}',
        type: 'GET',
        data: { subcategory_id: categoryId },
        success: function(data) {
          updateBrandOptions(data);
        }
      });
    }

    function updateBrandOptions(data) {
      let currentValue = brandEditSelect.getValue();
      brandEditSelect.clear(true);
      brandEditSelect.clearOptions();
      data.forEach(function(item) {
        brandEditSelect.addOption({ value: item.id, text: item.name });
      });
      brandEditSelect.refreshOptions(false);
      if (currentValue && data.some(item => item.id == currentValue)) {
        brandEditSelect.setValue(currentValue, true);
      }
    }

    function resetBrandSelect() {
      brandEditSelect.clear(true);
      brandEditSelect.clearOptions();
      brandEditSelect.refreshOptions(false);
    }

    initializeSelects();

    $('#editPropertyModal').on('show.bs.modal', function (e) {
      let existingCategoryId = $('#cbxEditCategory').val();
      let existingBrandId = $('#cbxEditBrand').val();

      if (existingCategoryId) {
        categoryEditSelect.setValue(existingCategoryId, true);
        fetchBrands(existingCategoryId);

        setTimeout(() => {
          if (existingBrandId) {
            brandEditSelect.setValue(existingBrandId, true);
            brandEditSelect.refreshOptions(false);
          }
        }, 200);
      }
    });

    $(document).on('keydown', '.tom-select input[type="text"]', function(event) {
      event.preventDefault();
    });
  });
</script>

