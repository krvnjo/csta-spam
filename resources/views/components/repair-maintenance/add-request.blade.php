<!-- Add Request Modal -->
<div class="modal fade" id="modalAddRequest" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create Ticket Request</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddRequest" method="POST" novalidate>
          @csrf

          <div class="row">
            <div class="mb-3">
              <!-- Card -->
              <div class="card mb-3 mb-lg-5">
                <!-- Header -->
                <div class="card-header">
                  <h4 class="card-header-title">Ticket Information</h4>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body">
                  <div class="row">
                    <!-- Name -->
                    <div class="col-sm-5">
                      <div class="mb-4">
                        <label class="form-label" for="txtAddTicket">Name</label>
                        <input class="form-control" id="txtAddTicket" name="ticket" type="text" placeholder="Enter ticket name">
                        <span class="invalid-feedback" id="valAddTicket"></span>
                      </div>
                    </div>
                    <!-- End Name -->

                    <!-- Estimated Cost -->
                    <div class="col-sm">
                      <div class="mb-4">
                        <label class="form-label" for="txtAddCost">Estimated Cost</label>
                        <div class="input-group">
                          <span class="input-group-text">₱</span>
                          <input class="form-control text-end" id="txtAddCost" name="cost" type="number" min="0" placeholder="Enter estimated cost">
                          <span class="invalid-feedback" id="valAddCost"></span>
                        </div>
                      </div>
                    </div>
                    <!-- End Estimated Cost -->

                    <!-- Priority -->
                    <div class="col-sm">
                      <div class="mb-4">
                        <label class="form-label" for="selAddPriority">Priority</label>
                        <div class="tom-select-custom">
                          <select class="js-select form-select" id="selAddPriority" name="priority"
                            data-hs-tom-select-options='{
                              "hideSearch": true,
                              "placeholder": "Select priority level"
                            }'
                            autocomplete="off">
                            <option value=""></option>
                            @foreach ($priorities as $priority)
                              <option data-option-template='<span class="d-flex align-items-center"><span class="{{ $priority->color->class }}"></span>{{ $priority->name }}</span>'
                                value="{{ $priority->id }}">
                              </option>
                            @endforeach
                          </select>
                          <span class="invalid-feedback" id="valAddPriority"></span>
                        </div>
                      </div>
                    </div>
                    <!-- End Priority -->
                  </div>
                  <!-- End Row -->

                  <div class="form-group">
                    <label class="form-label" for="txtAddDescription">Description</label>
                    <textarea class="form-control" id="txtAddDescription" name="description" rows="4" placeholder="Enter ticket description"></textarea>
                    <span class="invalid-feedback" id="valAddDescription"></span>
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

                <!-- Body -->
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
                      <div class="col-sm-11">
                        <div class="tom-select-custom">
                          <select class="js-select form-select" id="selAddItem1"
                            data-hs-tom-select-options='{
                              "placeholder": "Select an item"
                            }' autocomplete="off">
                            <option value=""></option>
                            @foreach ($items as $item)
                              <option value="{{ $item->id }}">
                                {{ $item->prop_code . ' | ' . $item->property->name . ' | ' . $item->department->name . ' | ' . $item->designation->name . ' | ' . $item->condition->name . ' | ' . $item->status->name }}
                              </option>
                            @endforeach
                          </select>
                          <span class="invalid-feedback" id="valAddItem1"></span>
                        </div>
                      </div>
                      <div class="col-sm"><button class="btn btn-white" type="button"><i class="bi-trash"></i></button></div>
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
                      <div class="col-sm-11">
                        <div class="tom-select-custom">
                          <select class="js-select-dynamic form-select" data-hs-tom-select-options='{
                              "placeholder": "Select an item"
                            }'
                            autocomplete="off">
                            <option value=""></option>
                            @foreach ($items as $item)
                              <option value="{{ $item->id }}">{{ $item->property->name . ' | ' . $item->prop_code }}</option>
                            @endforeach
                          </select>
                          <span class="invalid-feedback"></span>
                        </div>
                      </div>
                      <div class="col-sm"><button class="btn btn-white js-delete-field" type="button"><i class="bi-trash"></i></button></div>
                    </div>
                  </div>
                  <!-- End Add Item Field Template -->
                </div>
                <!-- End Body -->
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
            <button class="btn btn-primary" id="btnAddSaveRequest" form="frmAddRequest" type="submit" disabled>
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
