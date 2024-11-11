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
        <form id="frmEditRole" method="POST" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditId" name="id" type="hidden">

          <!-- Role Name -->
          <div class="form-group">
            <label class="col col-form-label form-label" for="txtEditRole">Role Name</label>
            <input class="form-control" id="txtEditRole" name="role" type="text" placeholder="Enter a role name">
            <span class="invalid-feedback" id="valEditRole"></span>
          </div>
          <!-- End Role Name -->

          <!-- Role Description -->
          <div class="form-group mb-4">
            <div class="d-flex justify-content-between">
              <label class="col col-form-label form-label" for="txtEditDescription">Description</label>
              <span class="col-form-label text-muted" id="maxLengthCountCharacters"></span>
            </div>
            <textarea class="js-count-characters form-control" id="txtEditDescription" name="description" data-hs-count-characters-options='{
                "output": "#maxLengthCountCharacters"
              }'
              style="resize: none;" placeholder="Enter role description" rows="2" maxlength="80"></textarea>
            <span class="invalid-feedback" id="valEditDescription"></span>
          </div>
          <!-- End Role Description -->

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

              @php
                $groupedPermissions = $permissions->groupBy('group_name');
                $displayedBasePermissions = [];
              @endphp

              <tbody>
                @foreach ($groupedPermissions as $groupName => $permissions)
                  <tr>
                    <th colspan="5">{{ ucwords($groupName) }}</th>
                  </tr>

                  @foreach ($permissions as $permission)
                    @php
                      $basePermission = preg_replace('/^(view|create|update|delete)\s+/', '', $permission->name);
                    @endphp

                    @if (!in_array($basePermission, $displayedBasePermissions))
                      <tr>
                        <td>{{ ucwords($basePermission) }}</td>
                        <td class="text-center">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" id="cbxViewRole{{ $loop->parent->index }}-{{ $loop->index }}" name="can_view[{{ $permission->id }}]" type="checkbox">
                          </div>
                        </td>
                        <td class="text-center">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" id="cbxCreateRole{{ $loop->parent->index }}-{{ $loop->index }}" name="can_create[{{ $permission->id }}]" type="checkbox">
                          </div>
                        </td>
                        <td class="text-center">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" id="cbxEditRole{{ $loop->parent->index }}-{{ $loop->index }}" name="can_edit[{{ $permission->id }}]" type="checkbox">
                          </div>
                        </td>
                        <td class="text-center">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" id="cbxDeleteRole{{ $loop->parent->index }}-{{ $loop->index }}" name="can_delete[{{ $permission->id }}]" type="checkbox">
                          </div>
                        </td>
                      </tr>
                      @php
                        $displayedBasePermissions[] = $basePermission;
                      @endphp
                    @endif
                  @endforeach
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
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnEditSaveRole" form="frmEditRole" type="submit" disabled>
              <span class="spinner-label">Save</span>
              <span class="spinner-border spinner-border-sm d-none"></span>
            </button>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Edit Role Modal -->
