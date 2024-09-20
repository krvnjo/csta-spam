<!-- Add Condition Modal -->
<div class="modal fade" id="modalAddCondition" data-bs-backdrop="static" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Condition</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddCondition" method="post" novalidate>
          @csrf
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtAddCondition">Condition Name</label>
            <input class="form-control" id="txtAddCondition" name="condition" type="text" placeholder="Enter a Condition">
            <span class="invalid-feedback" id="valAddCondition"></span>
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
              <button class="btn btn-primary" id="btnAddSaveCondition" form="frmAddCondition" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Condition Modal -->
