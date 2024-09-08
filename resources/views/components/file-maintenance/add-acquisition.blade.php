<!-- Add Acquisition Modal -->
<div class="modal fade" id="addAcquisitionModal" data-bs-backdrop="static" role="dialog" aria-labelledby="addAcquisitionModalLabel" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="addAcquisitionModalLabel">Add Acquisition</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <!-- Form -->
        <form id="frmAddAcquisition" method="post" novalidate>
          @csrf
          <label class="col col-form-label form-label" for="txtAddAcquisition">Acquisition Name</label>
          <span class="font-13" style="color: red">*</span>
          <input class="form-control" id="txtAddAcquisition" name="acquisition" type="text" placeholder="Enter a Acquisition" required>
          <span class="invalid-feedback" id="acquisitionValidation"></span>
        </form>
        <!-- End Form -->
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col-sm mb-2 mb-sm-0"></div>
          <!-- End Col -->

          <div class="col-sm-auto">
            <div class="d-flex gap-3">
              <button class="btn btn-white" data-bs-dismiss="modal" type="button" aria-label="Close">Cancel</button>
              <button class="btn btn-primary" form="frmAddAcquisition" type="submit">Add</button>
            </div>
          </div>
          <!-- End Col -->
        </div>
        <!-- End Row -->
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add Acquisition Modal -->
