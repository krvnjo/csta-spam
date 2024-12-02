<!-- Add Request Modal -->
<div class="modal fade" id="modalAddNewTransaction" data-bs-backdrop="static" tabindex="-1" aria-label="new transaction">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create New Transaction</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddNewTransaction" method="POST">
          @csrf

          <div class="row">
            <div class="mb-3">
              <!-- Card -->
              <div class="card mb-3 mb-lg-5">
                <!-- Header -->
                <div class="card-header">
                  <h4 class="card-header-title">Item Transaction Information</h4>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body">
                  <div class="row">
                    <!-- Requester -->
                    <div class="col-sm">
                      <div class="mb-4">
                        <label class="form-label" for="selAddRequester">Requester</label>
                        <div class="tom-select-custom">
                          <select class="js-select form-select" id="selAddRequester" name="requester"
                                  data-hs-tom-select-options='{
                              "placeholder": "Select requester"
                            }' autocomplete="off">
                            <option value="" disabled selected>Select requester</option>
                            @foreach ($requesters as $requester)
                              <option value="{{ $requester->id }}"> {{ $requester->department->code }} | {{ $requester->req_num }} | {{ $requester->name }}</option>
                            @endforeach
                          </select>
                          <span class="invalid-feedback" id="valAddRequester"></span>
                        </div>
                      </div>
                    </div>
                    <!-- End Requester -->

                    <!-- Borrow Date -->
                    <div class="col-sm">
                      <div class="mb-4">
                        <label class="form-label" for="txtAddReceived">Received By</label>
                        <input class="form-control" id="txtAddReceived" name="received" type="text" placeholder="Enter Received By" />
                        <span class="invalid-feedback" id="valAddReceived"></span>
                      </div>
                    </div>
                    <!-- End Borrow Date -->
                  </div>
                  <!-- End Row -->

                  <div class="form-group">
                    <label class="form-label" for="txtAddRemarks">Remarks</label>
                    <textarea class="form-control" id="txtAddRemarks" name="remarks" style="height: 3.5rem; resize: vertical; min-height: 3.5rem; max-height: 5rem;" placeholder="Enter Remarks"></textarea>
                    <span class="invalid-feedback" id="valAddRemarks"></span>
                  </div>
                </div>
                <!-- Body -->
              </div>
              <!-- End Card -->

              <!-- Items Card -->
              <div class="card">
                <!-- Header -->
                <div class="card-header">
                  <h4 class="card-header-title">Items</h4>
                </div>
                <!-- End Header -->

                <!-- Add Items Section -->
                <div class="card-body">
                  <div class="js-add-field"
                       data-hs-add-field-options='{
                          "template": "#addItemFieldTemplate",
                          "container": "#addItemFieldContainer",
                          "defaultCreated": 0,
                          "limit": 10
                        }'>
                    <!-- Item Field -->
                    <div class="row mb-4">
                      <div class="col-sm-9">
                        <div class="tom-select-custom">
                          <select class="js-select form-select" id="selAddItems" name="items[]" data-hs-tom-select-options='{
                                "placeholder": "Select an item"
                              }' autocomplete="off" required>
                            <option value="" disabled selected>Select item</option>
                            @foreach ($items as $item)
                              <option value="{{ $item->id }}"  data-max="{{ $item->quantity }}"> {{ $item->name }} | {{ $item->specification }}  | Available: {{ $item->quantity }}-{{ $item->unit->name }}</option>
                            @endforeach
                          </select>
                          <span class="invalid-feedback" id="valAddItems"></span>
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <input class="form-control" id="txtAddQuantities" name="quantities[]" type="number" min="1"
                               max="
                               @foreach($items as $item)
                               {{ $item->quantity }}
                               @endforeach"
                               placeholder="Quantity" required />
                        <span class="invalid-feedback" id="valAddQuantities"></span>
                      </div>

                      <div class="col-sm">
                        <button class="btn btn-white js-delete-field" type="button"><i class="bi-trash"></i></button>
                      </div>
                    </div>
                    <!-- End Item Field -->

                    <!-- Add Item Field Container -->
                    <div id="addItemFieldContainer"></div>
                    <a class="js-create-field form-link" href="javascript:"><i class="bi-plus"></i> Add another item</a>
                    <!-- End Add Item Field Container -->
                  </div>

                  <!-- Add Item Field Template -->
                  <div id="addItemFieldTemplate" style="display: none;">
                    <div class="row mb-4">
                      <div class="col-sm-9">
                        <div class="tom-select-custom">
                          <select class="js-select-dynamic form-select" id="selAddItems" name="items[]" data-hs-tom-select-options='{
                                "placeholder": "Select an item"
                              }' autocomplete="off">
                            <option value="" disabled selected>Select item</option>
                            @foreach ($items as $item)
                              <option value="{{ $item->id }}" data-max="{{ $item->quantity }}">
                                {{ $item->name }} | {{ $item->specification }} | Available: {{ $item->quantity }}-{{ $item->unit->name }}
                              </option>
                            @endforeach
                          </select>
                          <span class="invalid-feedback" id="valAddItems"></span>
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <input class="form-control" id="txtAddQuantities" name="quantities[]" type="number" min="1" placeholder="Quantity" />
                        <span class="invalid-feedback" id="valAddQuantities"></span>
                      </div>

                      <div class="col-sm">
                        <button class="btn btn-white js-delete-field" type="button"><i class="bi-trash"></i></button>
                      </div>
                    </div>
                  </div>
                  <!-- End Add Item Field Template -->
                </div>
              </div>
              <!-- End Items Card -->
            </div>
          </div>
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnAddSaveNewTransaction" form="frmAddNewTransaction" type="submit" disabled>
              <span class="spinner-label">Create</span>
              <span class="spinner-border spinner-border-sm d-none"></span>
            </button>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Request Modal -->

<script>
  document.getElementById('selAddItems').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const maxQuantity = selectedOption.getAttribute('data-max');

    const quantityInput = document.getElementById('txtAddQuantities');
    quantityInput.setAttribute('max', maxQuantity);
    quantityInput.value = '';
  });

</script>
