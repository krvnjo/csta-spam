<!-- Add Status Modal -->
<div class="modal fade" id="addStatusModal" data-bs-backdrop="static" role="dialog" aria-labelledby="addStatusModalLabel"
  aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="addStatusModalLabel">Add Status</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddStatus" method="post" novalidate>
          @csrf
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddStatus">Status Name <span
                class="text-danger">*</span></label>
            <input class="form-control" id="txtAddStatus" name="status" type="text" placeholder="Enter a Status"
              required>
            <span class="invalid-feedback" id="valAddStatus"></span>
          </div>

          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="txtAddStatusDesc">Description <span
                class="text-danger">*</span></label>
            <textarea class="form-control" id="txtAddStatusDesc" name="description" type="text" placeholder="Status Description"
              rows="3" required></textarea>
            <span class="invalid-feedback" id="valAddStatusDesc"></span>
          </div>

          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="selAddStatusColor">Status Color <span
                class="text-danger">*</span></label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selAddStatusColor" name="color"
                data-hs-tom-select-options='{
                  "placeholder": "Select a Status Color",
                  "hideSearch": true
                }'
                required>
                <option value=""></option>
                @foreach ($colors as $color)
                  <option
                    data-option-template='<span class="d-flex align-items-center {{ $color->color_class }}">{{ $color->name }}</span>'
                    value="{{ Crypt::encryptString($color->id) }}">{{ $color->name }}</option>
                @endforeach
              </select>
              <span class="invalid-feedback" id="valAddStatusColor"></span>
            </div>
          </div>
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
              <button class="btn btn-primary" form="frmAddStatus" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Department Modal -->
