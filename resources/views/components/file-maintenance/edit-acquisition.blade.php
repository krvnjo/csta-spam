<!-- Edit Acquisition Modal -->
<div class="modal fade" id="editAcquisitionModal" data-bs-backdrop="static" role="dialog" aria-labelledby="editAcquisitionModalLabel" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="editAcquisitionModalLabel">Edit Acquisition</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <!-- Form -->
        <form id="frmEditAcquisition" method="post" novalidate>
          @csrf
          <input id="txtEditAcquisitionId" type="hidden">
          <label class="col col-form-label form-label" for="txtEditAcquisition">Acquisition Name</label> <span class="font-13 red-mark">*</span>
          <input class="form-control" id="txtEditAcquisition" name="acquisition" type="text" placeholder="Enter a Acquisition" required>
          <span class="invalid-feedback" id="valEditAcquisition"></span>
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
            <div class="d-flex gap-2">
              <button class="btn btn-white" data-bs-dismiss="modal" type="button" aria-label="Close">Cancel</button>
              <button class="btn btn-primary" form="frmEditAcquisition" type="submit">Save</button>
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
<!-- End Edit Acquisition Modal -->
