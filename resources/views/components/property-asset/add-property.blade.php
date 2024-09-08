<!-- Modal -->
<div class="modal fade" id="addPropertyModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="New Item Modal"
  aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
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
          <button class="btn-close btn-close-light" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
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
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select" id="cbxCategory" name="category"
                  data-hs-tom-select-options='{
                    "placeholder": "Select Category...",
                    "hideSearch": true
                  }'
                  required autocomplete="off">
                  <option value=""></option>
                  {{--                  @foreach ($subcategories as $category) --}}
                  {{--                    <option value="{{ $category->id }}">{{ $category->name }}</option> --}}
                  {{--                  @endforeach --}}
                </select>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="tom-select-custom mb-3">
                <label class="form-label" for="cbxBrand">
                  Brand:
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select" id="cbxBrand" name="brand"
                  data-hs-tom-select-options='{
                  "placeholder": "Select Brand...",
                  "hideSearch": true
                }'
                  required autocomplete="off">
                  <option value=""></option>
                  {{--                  @foreach ($brands as $brand) --}}
                  {{--                    <option value="{{ $brand->id }}">{{ $brand->name }}</option> --}}
                  {{--                  @endforeach --}}
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
                <select class="js-select form-select cbxAcquiredType" id="cbxAcquiredType" name="acquiredType"
                  data-hs-tom-select-options='{"placeholder": "Select Acquired Type...","hideSearch": true}' required autocomplete="off">
                  <option value=""></option>
                  {{--                  @foreach ($acquisitions as $acquired) --}}
                  {{--                    <option value="{{ $acquired->id }}">{{ $acquired->name }}</option> --}}
                  {{--                  @endforeach --}}
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
                  Condition
                  <span class="font-13" style="color: red">*</span></label>
                <select class="js-select form-select" id="cbxCondition" name="condition"
                  data-hs-tom-select-options='{
                  "placeholder": "Select Condition...",
                  "hideSearch": true
                }'
                  required autocomplete="off">
                  <option value=""></option>
                  {{--                  @foreach ($conditions as $condition) --}}
                  {{--                    <option value="{{ $condition->id }}">{{ $condition->name }}</option> --}}
                  {{--                  @endforeach --}}
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
                  <div class="js-dropzone row dz-dropzone dz-dropzone-card" id="basicExampleDropzone">
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
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var moneyInput = document.getElementById('txtPriceAcquired');
    var selectInput = document.querySelector('.cbxAcquiredType');
    var warrantyInput = document.getElementById('dtpWarranty');

    moneyInput.addEventListener('input', function() {
      var value = moneyInput.value.replace(/[^0-9.]/g, '');

      if (/^0+$/.test(value)) {
        moneyInput.value = '';
        return;
      }

      var parts = value.split('.');
      var wholeNumber = parts[0];
      var fractionalPart = parts[1] ? '.' + parts[1] : '';

      wholeNumber = wholeNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

      moneyInput.value = wholeNumber + fractionalPart;
    });

    selectInput.addEventListener('change', function() {
      var selectedOption = selectInput.options[selectInput.selectedIndex];
      var selectedText = selectedOption.textContent || selectedOption.innerText;

      if (selectedText.trim() === 'Donation') {
        moneyInput.disabled = true;
        moneyInput.value = '';
        warrantyInput.disabled = true;
        warrantyInput.value = '';
      } else {
        moneyInput.disabled = false;
        warrantyInput.disabled = false;
      }
    });

    document.querySelector('form').addEventListener('submit', function() {
      moneyInput.value = moneyInput.value.replace(/,/g, '');
    });
  });
</script>

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
