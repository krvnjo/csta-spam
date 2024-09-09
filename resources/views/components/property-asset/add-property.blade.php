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
          <button class="btn-close btn-close-light" type="button"></button>
        </div>
      </div>

      <!-- End Header -->
      <form id="frmAddProperty" action="/properties-assets" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-body custom-modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtPropertyName">Item Name:
                  <span class="font-13" style="color: red">*</span></label>
                <input class="form-control" id="txtPropertyName" name="propertyName" type="text"
                  title="Only alphanumeric characters are allowed, and the input cannot be all spaces" placeholder="Stock Name" minlength="5"
                  required pattern="^(?=.*[A-Za-z0-9])[A-Za-z0-9 ]+$" />
              </div>
            </div>

            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="txtSerialNumber"> Serial Number: </label>
                <input class="form-control" id="txtSerialNumber" name="serialNumber" type="text" title="Only alphanumeric characters are allowed"
                  placeholder="Serial Number" pattern="[A-Za-z0-9]*" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxCategory">
                  Category:
                  <span class="font-13" style="color: red">*</span>
                </label>
                <select class="js-select form-select" id="cbxCategory" name="category" required autocomplete="off">
                  <option value="" disabled selected>Select Category...</option>
                  @foreach ($subcategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxBrand">
                  Brand:
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select" id="cbxBrand" name="brand" required autocomplete="off">
                  <option value="" disabled selected>Select Brand...</option>
                  @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="mb-3">
                <label class="form-label" for="txtQuantity">Quantity: <span class="font-13" style="color: red">*</span></label>
                <input class="form-control" id="txtQuantity" name="quantity" type="number" placeholder="1" min="1" minlength="1"
                  max="500" required />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label class="form-label" for="txtDescription">Description:</label>
                <textarea class="form-control" id="txtDescription" name="description"
                  title="Only alphanumeric characters and the following special characters are allowed: %,-,&quot;'" style="resize: none" placeholder="Description"
                  minlength="5"></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxAcquiredType">
                  Acquired Type:
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select cbxAcquiredType" id="cbxAcquiredType" name="acquiredType" required autocomplete="off">
                  <option value="" disabled selected>Select Acquired Type...</option>
                  @foreach ($acquisitions as $acquired)
                    <option value="{{ $acquired->id }}">{{ $acquired->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="dtpAcquired">
                  Date Acquired:
                  <span class="font-13" style="color: red">*</span></label>
                <input class="form-control" id="dtpAcquired" name="dateAcquired" type="date" required max="{{ now()->toDateString() }}" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxCondition">
                  Condition:
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select" id="cbxCondition" name="condition" required autocomplete="off">
                  <option value="" disabled selected>Select Condition...</option>
                  @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label" for="dtpWarranty"> Warranty Date: </label>
                <input class="form-control" id="dtpWarranty" name="warranty" type="date" min="{{ now()->toDateString() }}" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label class="form-label" for="txtRemarks">Remarks:</label>
                <textarea class="form-control" id="txtRemarks" name="remarks"
                  title="Only alphanumeric characters and the following special characters are allowed: %,-,&quot;'" style="resize: none" placeholder="Remarks"
                  minlength="5"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <div class="mb-3">
                <label class="form-label" for="txtR">Image:</label>
                <div style="padding-left: 1.4rem">
                  <!-- Dropzone -->
                  <div class="js-dropzone row dz-dropzone dz-dropzone-card" id="propertyDropzone">
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
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById('txtDescription').addEventListener('input', function() {
    const pattern = /^(?!%+$|,+|-+|\s+$)[A-Za-z0-9%,\- ×'"]+$/;
    if (!pattern.test(this.value)) {
      this.setCustomValidity("Only alphanumeric characters and the following special characters are allowed: %,-,&quot;'");
    } else {
      this.setCustomValidity('');
    }
  });

  document.getElementById('txtRemarks').addEventListener('input', function() {
    const pattern = /^(?!%+$|,+|-+|\s+$)[A-Za-z0-9%,\- ×'"]+$/;
    if (!pattern.test(this.value)) {
      this.setCustomValidity("Only alphanumeric characters and the following special characters are allowed: %,-,&quot;'");
    } else {
      this.setCustomValidity('');
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize TomSelect for each select input
    new TomSelect('#cbxCategory', {
      controlInput: false,
      hideSearch: true,
      allowEmptyOption: true
    });

    new TomSelect('#cbxBrand', {
      controlInput: false,
      hideSearch: true,
      allowEmptyOption: true
    });

    new TomSelect('#cbxAcquiredType', {
      controlInput: false,
      hideSearch: true,
      allowEmptyOption: true
    });

    new TomSelect('#cbxCondition', {
      controlInput: false,
      hideSearch: true,
      allowEmptyOption: true
    });

    // Disable text input for all TomSelect inputs
    document.querySelectorAll('.tom-select input[type="text"]').forEach(function(input) {
      input.addEventListener('keydown', function(event) {
        event.preventDefault();
      });
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('frmAddProperty');
    let isDirty = false;

    const inputs = form.querySelectorAll('input, select, textarea');

    // Function to check if form is dirty
    function checkFormDirty() {
      let formIsDirty = false;
      inputs.forEach(input => {
        if (input.value !== "" && input.value !== input.defaultValue) {
          formIsDirty = true;
        }
      });
      return formIsDirty || dropzone.files.length > 0;
    }

    // Check input changes
    inputs.forEach(input => {
      input.addEventListener('change', () => {
        isDirty = checkFormDirty();
      });
    });

    const dropzone = Dropzone.forElement("#propertyDropzone");

    dropzone.on("addedfile", function() {
      isDirty = true;
    });

    dropzone.on("removedfile", function() {
      isDirty = checkFormDirty(); // Reset isDirty if no files are left
    });

    const closeButtons = document.querySelectorAll('.btn-close, .btn-secondary');
    closeButtons.forEach(button => {
      button.addEventListener('click', function (e) {
        if (isDirty) {
          e.preventDefault();
          Swal.fire({
            title: 'You have unsaved changes!',
            text: "Are you sure you want to close without saving?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, close it!',
            cancelButtonText: 'No, stay',
            backdrop: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
          }).then((result) => {
            if (result.isConfirmed) {
              form.reset();

              // Reset select inputs
              const categorySelect = document.querySelector('#cbxCategory').tomselect;
              const brandSelect = document.querySelector('#cbxBrand').tomselect;
              const acquiredSelect = document.querySelector('#cbxAcquiredType').tomselect;
              const conditionSelect = document.querySelector('#cbxCondition').tomselect;

              categorySelect.clear();
              categorySelect.setValue('');
              brandSelect.clear();
              brandSelect.setValue('');
              acquiredSelect.clear();
              acquiredSelect.setValue('');
              conditionSelect.clear();
              conditionSelect.setValue('');

              dropzone.removeAllFiles(true);

              isDirty = false;

              $('#addPropertyModal').modal('hide');
            } else {
              Swal.close();
            }
          });
        } else {
          $('#addPropertyModal').modal('hide');
        }
      });
    });
  });

</script>
