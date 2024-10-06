<!-- Edit Role Modal -->
<div class="modal fade" id="modalEditRole" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditRoleLabel">Edit Role</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditRole" method="post" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditRoleId" name="id" type="hidden">

          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditRole">Role Name</label>
            <input class="form-control" id="txtEditRole" name="role" type="text" placeholder="Enter role name">
            <span class="invalid-feedback" id="valEditRole"></span>
          </div>

          <div class="form-group mb-4">
            <div class="d-flex justify-content-between">
              <label class="col col-form-label form-label" for="txtEditDescription">Description</label>
              <span class="col-form-label text-muted" id="countCharactersRoleDesc"></span>
            </div>
            <textarea class="js-count-characters form-control" id="txtEditDescription" name="description"
              data-hs-count-characters-options='{
                "output": "#countCharactersRoleDesc"
              }' style="resize: none;"
              placeholder="Enter role description" rows="2" maxlength="120"></textarea>
            <span class="invalid-feedback" id="valEditDescription"></span>
          </div>

          <!-- Table -->
          <div class="table-responsive datatable-custom">
            <table class="table table-thead-bordered table-nowrap table-align-middle table-first-col-px-0">
              <thead class="thead-light">
                <tr>
                  <th>Permissions</th>
                  <th class="text-center pe-5">
                    <h3 class="mb-1"><i class="bi-eye"></i></h3>View
                  </th>
                  <th class="text-center pe-5">
                    <h3 class="mb-1"><i class="bi-plus-square"></i></h3>Create
                  </th>
                  <th class="text-center pe-5">
                    <h3 class="mb-1"><i class="bi-pencil"></i></h3>Edit
                  </th>
                  <th class="text-center pe-5">
                    <h3 class="mb-1"><i class="bi-trash"></i></h3>Delete
                  </th>
                </tr>
              </thead>

              <tbody>
                @foreach ($permissions as $index => $permission)
                  <tr>
                    <td class="d-none" data-permission-id="{{ $permission->id }}"></td>
                    <td>{{ $permission->name }}</td>
                    <td class="text-center">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input cbx-view" id="cbxEditViewRole{{ $permission->id }}" name="can_view[{{ $permission->id }}]"
                          type="checkbox">
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input cbx-action" id="cbxEditCreateRole{{ $permission->id }}"
                          name="can_create[{{ $permission->id }}]" type="checkbox">
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input cbx-action" id="cbxEditEditRole{{ $permission->id }}" name="can_edit[{{ $permission->id }}]"
                          type="checkbox">
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input cbx-action" id="cbxEditDeleteRole{{ $permission->id }}"
                          name="can_delete[{{ $permission->id }}]" type="checkbox">
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <span class="invalid-feedback" id="valEditPermission"></span>
          </div>
          <!-- End Table -->
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
              <button class="btn btn-primary" id="btnEditSaveRole" form="frmEditRole" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Edit Role Modal -->
