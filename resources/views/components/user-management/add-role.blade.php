<!-- Add Role Modal -->
<div class="modal fade" id="modalAddRole" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddRoleLabel">Add Role</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddRole" method="POST" novalidate>
          @csrf

          <!-- Role Name -->
          <div class="form-group mb-2">
            <label class="col col-form-label form-label" for="txtAddRole">Role Name</label>
            <input class="form-control" id="txtAddRole" name="role" type="text" placeholder="Enter a role name">
            <span class="invalid-feedback" id="valAddRole"></span>
          </div>
          <!-- End Role Name -->

          <!-- Role Description -->
          <div class="form-group mb-2">
            <div class="d-flex justify-content-between">
              <label class="col col-form-label form-label" for="txtAddDescription">Description</label>
              <span class="col-form-label text-muted" id="maxLengthCountCharacters"></span>
            </div>
            <textarea class="js-count-characters form-control" id="txtAddDescription" name="description" data-hs-count-characters-options='{
                "output": "#maxLengthCountCharacters"
              }'
              style="resize: none;" placeholder="Enter role description" rows="2" maxlength="80"></textarea>
            <span class="invalid-feedback" id="valAddDescription"></span>
          </div>
          <!-- End Role Description -->

          <!-- Main Dashboard -->
          <div class="form-group mb-4">
            <label class="col col-form-label form-label" for="selAddDashboard">Main Dashboard</label>
            <div class="tom-select-custom">
              <select class="js-select form-select" id="selAddDashboard" name="dashboard"
                data-hs-tom-select-options='{
                    "hideSearch": "true",
                    "placeholder": "Select a main dashboard"
                  }'>
                <option value=""></option>
                @foreach ($dashboards as $dashboard)
                  @if ($dashboard->is_active)
                    <option
                      data-option-template='<div class="d-flex align-items-start"><div class="flex-shrink-0"></div><div class="flex-grow-1"><span class="d-block fw-semibold">{{ $dashboard->name }}</span><span class="tom-select-custom-hide small">{{ $dashboard->description }}</span></div></div>'
                      value="{{ $dashboard->id }}">{{ $dashboard->name }}</option>
                  @endif
                @endforeach
              </select>
              <span class="invalid-feedback" id="valAddDashboard"></span>
            </div>
          </div>
          <!-- End Main Dashboard -->

          <!-- Table -->
          <div class="table-responsive datatable-custom">
            <table class="table table-thead-bordered table-nowrap table-align-middle table-first-col-px-0">
              <thead class="thead-light">
                <tr>
                  <th style="width: 40%;">Permissions</th>
                  <th class="text-center pe-5" style="width: 60%;">
                    <h3 class="mb-1"><i class="bi-person-lock"></i></h3>Access Level
                  </th>
                </tr>
              </thead>
              @php
                $groupedPermissions = $permissions->groupBy('group');
                $displayedBasePermissions = [];
              @endphp
              <tbody>
                @php
                  $counter = 1;
                @endphp

                <div class="alert alert-soft-danger avatar-img-val d-none" id="valAddPermission"></div>
                @foreach ($groupedPermissions as $groupName => $permissions)
                  <tr>
                    <th colspan="5">{{ ucwords($groupName) }}</th>
                  </tr>
                  @foreach ($permissions as $permission)
                    <tr>
                      <td>{{ $permission->name }}</td>
                      <td>
                        <div class="form-group">
                          <div class="tom-select-custom">
                            <select class="js-select form-select" id="selAddPermission{{ $counter }}" name="permission{{ $counter }}"
                              data-hs-tom-select-options='{
                                "hideSearch": "true",
                                "placeholder": "No access to this permission"
                              }'>
                              <option value=""></option>
                              @foreach ($accesses as $access)
                                <option
                                  data-option-template='<div class="d-flex align-items-start"><div class="flex-shrink-0"></div><div class="flex-grow-1"><span class="d-block fw-semibold">{{ $access->name }}</span><span class="tom-select-custom-hide small">{{ $access->description }}</span></div></div>'
                                  value="{{ $access->id }}">{{ $access->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @php
                      $counter++;
                    @endphp
                  @endforeach
                @endforeach
              </tbody>
            </table>
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
            <button class="btn btn-primary" id="btnAddSaveRole" form="frmAddRole" type="submit" disabled>
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
<!-- End Add Role Modal -->
