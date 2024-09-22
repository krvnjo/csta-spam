<!-- Edit Status Modal -->
<div class="modal fade" id="modalEditStatus" data-bs-backdrop="static" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Status</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditStatus" method="post" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditStatusId" name="id" type="hidden">

          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditStatus">Status Name</label>
            <input class="form-control" id="txtEditStatus" name="statusname" type="text" placeholder="Enter a Status">
            <span class="invalid-feedback" id="valEditStatus"></span>
          </div>

          <div class="form-group">
            <div class="d-flex justify-content-between">
              <label class="col col-form-label form-label" for="txtAddDescription">Description</label>
              <span class="col-form-label text-muted" id="countCharactersStatusDesc"></span>
            </div>
            <textarea class="js-count-characters form-control" id="txtEditDescription" name="description"
              data-hs-count-characters-options='{
                "output": "#countCharactersStatusDesc"
              }' style="resize: none;"
              placeholder="Enter a Description" rows="3" maxlength="80"></textarea>
            <span class="invalid-feedback" id="valEditDescription"></span>
          </div>

          <div class="form-group">
            <label class="col col-form-label form-label" for="selEditStatusColor">Status Color</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selEditStatusColor" name="color"
                data-hs-tom-select-options='{
                  "placeholder": "Select a Status Color",
                  "hideSearch": true
                }'>
                <option value=""></option>
                @foreach ($colors as $color)
                  <option data-option-template='<span class="d-flex align-items-center fs-6 m-1 {{ $color->class }}">{{ $color->name }}</span>'
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
              <button class="btn btn-primary" id="btnEditSaveStatus" form="frmEditStatus" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Edit Status Modal -->
