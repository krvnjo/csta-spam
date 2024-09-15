<!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal" data-bs-backdrop="static" role="dialog" aria-labelledby="editStatusModalLabel"
  aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="editStatusModalLabel">Edit Status</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditStatus" method="post" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditStatusId" type="hidden">

          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditStatus">Status Name <span
                class="text-danger">*</span></label>
            <input class="form-control" id="txtEditStatus" name="status" type="text" placeholder="Enter a Status"
              required>
            <span class="invalid-feedback" id="valEditStatus"></span>
          </div>

          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="txtEditStatusDesc">Description <span
                class="text-danger">*</span></label>
            <textarea class="form-control" id="txtEditStatusDesc" name="description" type="text" placeholder="Status Description"
              rows="3" required></textarea>
            <span class="invalid-feedback" id="valEditStatusDesc"></span>
          </div>

          <div class="form-group">
            <label class="col col-form-label form-label mt-2" for="selEditStatusColor">Status Color <span
                class="text-danger">*</span></label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selEditStatusColor" name="color"
                data-hs-tom-select-options='{
                  "placeholder": "Select a Status Color",
                  "hideSearch": true
                }'
                required>
                <option value=""></option>
                @foreach ($colors as $color)
                  <option
                    data-option-template='<span class="d-flex align-items-center {{ $color->color_class }}">{{ $color->name }}</span>'
                    value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
              </select>
              <span class="invalid-feedback" id="valEditStatusColor"></span>
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
              <button class="btn btn-primary" form="frmEditStatus" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Edit Department Modal -->
