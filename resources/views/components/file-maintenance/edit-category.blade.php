<!-- Edit Category Modal -->
<div class="modal fade" id="modalEditCategory" data-bs-backdrop="static" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Category</h4>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditCategory" method="post" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditCategoryId" name="id" type="hidden">

          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditCategory">Category Name</label>
            <input class="form-control" id="txtEditCategory" name="category" type="text" placeholder="Enter a Category">
            <span class="invalid-feedback" id="valEditCategory"></span>
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
              <button class="btn btn-primary" id="btnEditSaveCategory" form="frmEditCategory" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Edit Category Modal -->
