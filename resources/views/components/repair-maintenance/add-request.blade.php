<!-- Add Request Modal -->
<div class="modal fade" id="modalAddRequest" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 900px">
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

          <!-- Ticket Name -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="txtAddTicket">Ticket Name</label>
            <input class="form-control" id="txtAddTicket" name="ticket" type="text" placeholder="Enter a ticket name">
            <span class="invalid-feedback" id="valAddTicket"></span>
          </div>
          <!-- End Ticket Name -->

          <!-- Description -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="txtAddDescription">Description</label>
            <textarea class="form-control" id="txtAddDescription" name="description" rows="4" placeholder="Type ticket description"></textarea>
            <span class="invalid-feedback" id="valAddDescription"></span>
          </div>
          <!-- End Description -->

          <div class="row">
            <!-- Priority -->
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label class="col col-form-label form-label" for="selAddPriority">Priority</label>
                <div class="tom-select-custom">
                  <select class="js-select form-select" id="selAddPriority" name="priority"
                    data-hs-tom-select-options='{
                      "hideSearch": "true",
                      "placeholder": "Select a priority"
                    }'>
                    <option value=""></option>
                    @foreach ($priorities as $priority)
                      <option data-option-template='<span class="d-flex align-items-center"><span class="{{ $priority->color->class }}"></span>{{ $priority->name }}</span>'
                        value="{{ $priority->id }}">
                        {{ $priority->name }}
                      </option>
                    @endforeach
                  </select>
                  <span class="invalid-feedback" id="valAddPriority"></span>
                </div>
              </div>
            </div>
            <!-- End Priority -->

            <!-- Estimated Cost -->
            <div class="col-md-6">
              <div class="form-group mb-2">
                <label class="col col-form-label form-label" for="txtAddCost">Estimated Cost</label>
                <div class="input-group">
                  <span class="input-group-text">₱</span>
                  <input class="form-control text-end" id="txtAddCost" name="cost" type="number" min="0" placeholder="Enter estimated cost">
                  <span class="invalid-feedback" id="valAddCost"></span>
                </div>
              </div>
            </div>
            <!-- End Estimated Cost -->
          </div>

          <!-- Items -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="selAddItems">Items</label>
            <div class="tom-select-custom tom-select-custom-with-tags">
              <select class="js-select form-select" id="selAddItems" name="items[]"
                data-hs-tom-select-options='{
                  "hideSelected": true,
                  "placeholder": "Select an item"
                }' autocomplete="off" multiple>
                @foreach ($items as $item)
                  @if ($item->is_active && $item->ticket_id == null)
                    <option value="{{ $item->id }}">
                      {{ $item->prop_code . ' | ' . $item->property->name . ' | ' . $item->property->category->name . ' | ' . $item->property->brand->name . ' | ' . $item->designation->name . ' | ' . $item->condition->name . ' | ' . $item->status->name }}
                    </option>
                  @endif
                @endforeach
              </select>
              <span class="invalid-feedback" id="valAddItems"></span>
            </div>
          </div>
          <!-- End Items -->
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
