<!-- Add Status Modal -->
<div class="modal fade" id="modalAddStatus" data-bs-backdrop="static" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Status</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddStatus" method="post" novalidate>
          @csrf
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddStatus">Status Name</label>
            <input class="form-control" id="txtAddStatus" name="status" type="text" placeholder="Enter a Status">
            <span class="invalid-feedback" id="valAddStatus"></span>
          </div>

          <div class="form-group">
            <div class="d-flex justify-content-between">
              <label class="col col-form-label form-label" for="txtAddDescription">Description</label>
              <span class="col-form-label text-muted" id="maxLengthCountCharacters"></span>
            </div>
            <textarea class="js-count-characters form-control" id="txtAddDescription" name="description"
              data-hs-count-characters-options='{
                "output": "#maxLengthCountCharacters"
              }' style="resize: none;"
              placeholder="Enter a Description" rows="3" maxlength="80"></textarea>
            <span class="invalid-feedback" id="valAddDescription"></span>
          </div>

          <div class="form-group">
            <label class="col col-form-label form-label" for="selAddStatusColor">Status Color</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selAddStatusColor" name="color"
                data-hs-tom-select-options='{
                  "placeholder": "Select a Status Color",
                  "hideSearch": true
                }'
                required>
                <option value=""></option>
                @foreach ($colors as $color)
                  <option data-option-template='<span class="d-flex align-items-center fs-6 m-1 {{ $color->class }}">{{ $color->name }}</span>'
                    value="{{ $color->id }}">{{ $color->name }}</option>
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
              <button class="btn btn-primary" id="btnAddSaveStatus" form="frmAddStatus" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Status Modal -->
