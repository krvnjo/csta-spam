<!-- Add Request Modal -->
<div class="modal fade" id="modalReturnItem" data-bs-backdrop="static" tabindex="-1" aria-label="return item">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Return Item Form</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmReturnItem" method="POST">
          @csrf
          @method('PATCH')
          <div class="row">
            <input id="txtReturnItemId" name="id" type="hidden">
            <div class="mb-3">
              <!-- Card -->
              <div class="card mb-3">
                <!-- Header -->
                <div class="card-header">
                  <h4 class="card-header-title">Item Return Information</h4>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body">
                  <div class="row">
                    <!-- Requester -->
                    <div class="col-sm">
                      <div class="mb-4">
                        <label class="form-label" for="selReturnCondition">Condition</label>
                        <div class="tom-select-custom">
                          <select class="js-select form-select" id="selEditCondition" name="condition"
                                  data-hs-tom-select-options='{
                              "placeholder": "Select condition"
                            }' autocomplete="off">
                            <option value="" disabled selected>Select condition</option>
                            @foreach ($conditions as $condition)
                              <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                            @endforeach
                          </select>
                          <span class="invalid-feedback" id="valEditCondition"></span>
                        </div>
                      </div>
                    </div>
                    <!-- End Requester -->
                    <div class="form-group">
                      <label class="form-label" for="txtEditRemarks">Remarks</label>
                      <textarea class="form-control" id="txtEditRemarks" name="remarks" style="height: 3.5rem; resize: vertical; min-height: 3.5rem; max-height: 5rem;" placeholder="Enter Remarks"></textarea>
                      <span class="invalid-feedback" id="valEditRemarks"></span>
                    </div>
                  </div>
                  <!-- End Row -->
                </div>
                <!-- Body -->
              </div>
              <!-- End Card -->
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
            <button class="btn btn-primary" id="btnReturnSaveItem" form="frmReturnItem" type="submit" disabled>
              <span class="spinner-label">Return</span>
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
