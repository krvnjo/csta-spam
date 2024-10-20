<!-- Modal -->
<div class="modal fade" id="addPropertyModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="New Item Modal"
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
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtPropertyName">Item Name:
                  <span class="text-danger">*</span></label>
                <input class="form-control" id="txtPropertyName" name="propertyName" type="text" placeholder="Stock Name" autocomplete="off" />
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
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
          <button class="btn btn-primary" id="btnAddSaveProperty" form="frmAddProperty" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let categorySelect = new TomSelect('#cbxCategory', {
      controlInput: false,
      hideSearch: true,
      allowEmptyOption: true,
      onChange: function(value) {
        if (value) {
          $.ajax({
            url: '{{ route('prop-asset.getSubcategoryBrands') }}',
            type: 'GET',
            data: {
              subcategory_id: value
            },
            success: function(data) {
              brandSelect.clear();
              brandSelect.clearOptions();
              brandSelect.addOption({
                value: '',
                text: 'Select Brand...'
              });
              data.forEach(function(item) {
                brandSelect.addOption({
                  value: item.id,
                  text: item.name
                });
              });
              brandSelect.refreshOptions();
            }
          });
        } else {
          brandSelect.clear();
          brandSelect.clearOptions();
          brandSelect.addOption({
            value: '',
            text: 'Select Brand...'
          });
          brandSelect.refreshOptions();
        }
      }
    });

    let selectedCategory = categorySelect.getValue();
    console.log(selectedCategory);

    let brandSelect = new TomSelect('#cbxBrand', {
      controlInput: false,
      hideSearch: true,
      allowEmptyOption: true
    });


    new TomSelect('#cbxCondition', {
      controlInput: false,
      hideSearch: true,
      allowEmptyOption: true
    });

    new TomSelect('#cbxAcquiredType', {
      controlInput: false,
      hideSearch: true,
      allowEmptyOption: true,
      onChange: function(value) {
        const warrantyDateInput = document.getElementById('dtpWarranty');

        const PURCHASED_ID = "1";
        const DONATION_ID = "2";

        if (value === DONATION_ID) {
          warrantyDateInput.disabled = true;
          warrantyDateInput.value = '';
          warrantyDateInput.classList.add('bg-light');
        } else if (value === PURCHASED_ID) {
          warrantyDateInput.disabled = false;
          warrantyDateInput.classList.remove('bg-light');
        }
      }
    });

    document.querySelectorAll('.tom-select input[type="text"]').forEach(function(input) {
      input.addEventListener('keydown', function(event) {
        event.preventDefault();
      });
    });
  });
</script>

{{-- <script> --}}
{{--  document.addEventListener('DOMContentLoaded', function() { --}}
{{--    const form = document.getElementById('frmAddProperty'); --}}
{{--    let isDirty = false; --}}

{{--    const inputs = form.querySelectorAll('input, select, textarea'); --}}

{{--    // Function to check if form is dirty --}}
{{--    function checkFormDirty() { --}}
{{--      let formIsDirty = false; --}}
{{--      inputs.forEach(input => { --}}
{{--        if (input.value !== "" && input.value !== input.defaultValue) { --}}
{{--          formIsDirty = true; --}}
{{--        } --}}
{{--      }); --}}
{{--      return formIsDirty || dropzone.files.length > 0; --}}
{{--    } --}}

{{--    // Function to clear validation error classes and messages --}}
{{--    function clearValidationErrors() { --}}
{{--      form.querySelectorAll('input, select, textarea').forEach((input) => { --}}
{{--        input.classList.remove('is-invalid'); --}}
{{--        const feedback = input.nextElementSibling; --}}
{{--        if (feedback && feedback.classList.contains('invalid-feedback')) { --}}
{{--          feedback.textContent = ''; --}}
{{--        } --}}
{{--      }); --}}
{{--    } --}}

{{--    // Check input changes --}}
{{--    inputs.forEach(input => { --}}
{{--      input.addEventListener('change', () => { --}}
{{--        isDirty = checkFormDirty(); --}}
{{--      }); --}}
{{--    }); --}}

{{--    const dropzone = Dropzone.forElement("#addPropertyDropzone"); --}}

{{--    dropzone.on("addedfile", function() { --}}
{{--      isDirty = true; --}}
{{--    }); --}}

{{--    dropzone.on("removedfile", function() { --}}
{{--      isDirty = checkFormDirty(); --}}
{{--    }); --}}

{{--    const closeButtons = document.querySelectorAll('.btn-close, .btn-secondary'); --}}
{{--    closeButtons.forEach(button => { --}}
{{--      button.addEventListener('click', function(e) { --}}
{{--        if (isDirty) { --}}
{{--          e.preventDefault(); --}}
{{--          Swal.fire({ --}}
{{--            title: "Unsaved Changes!", --}}
{{--            text: "You have unsaved changes. Are you sure you want to close the modal?", --}}
{{--            icon: "warning", --}}
{{--            showCancelButton: true, --}}
{{--            confirmButtonText: "Yes, close it!", --}}
{{--            cancelButtonText: "No, keep editing", --}}
{{--            customClass: { --}}
{{--              confirmButton: "btn btn-danger", --}}
{{--              cancelButton: "btn btn-secondary", --}}
{{--            }, --}}
{{--            backdrop: true, --}}
{{--            allowOutsideClick: false, --}}
{{--            allowEscapeKey: false --}}
{{--          }).then((result) => { --}}
{{--            if (result.isConfirmed) { --}}
{{--              clearValidationErrors(); --}}

{{--              form.reset(); --}}

{{--              // Reset select inputs --}}
{{--              const categorySelect = document.querySelector('#cbxCategory').tomselect; --}}
{{--              const brandSelect = document.querySelector('#cbxBrand').tomselect; --}}
{{--              const acquiredSelect = document.querySelector('#cbxAcquiredType').tomselect; --}}
{{--              const conditionSelect = document.querySelector('#cbxCondition').tomselect; --}}

{{--              categorySelect.clear(); --}}
{{--              categorySelect.setValue(''); --}}
{{--              brandSelect.clear(); --}}
{{--              brandSelect.setValue(''); --}}
{{--              acquiredSelect.clear(); --}}
{{--              acquiredSelect.setValue(''); --}}
{{--              conditionSelect.clear(); --}}
{{--              conditionSelect.setValue(''); --}}

{{--              dropzone.removeAllFiles(true); --}}

{{--              isDirty = false; --}}

{{--              $('#addPropertyModal').modal('hide'); --}}
{{--            } else { --}}
{{--              Swal.close(); --}}
{{--            } --}}
{{--          }); --}}
{{--        } else { --}}
{{--          clearValidationErrors(); --}}
{{--          $('#addPropertyModal').modal('hide'); --}}
{{--        } --}}
{{--      }); --}}
{{--    }); --}}
{{--  }); --}}
{{-- </script> --}}
