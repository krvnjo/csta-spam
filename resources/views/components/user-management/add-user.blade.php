<!-- Add User Modal -->
<div class="modal fade" id="modalAddUser" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title">Add User</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddUser" method="POST" enctype="multipart/form-data" novalidate>
          @csrf

          <!-- User Profile Cover -->
          <div class="profile-cover cover-size">
            <div class="profile-cover-img-wrapper cover-resize">
              <img class="profile-cover-img cover-resize" src="{{ Vite::asset('resources/img/1920x400/img1.jpg') }}" alt="User Profile Cover">
              <div class="profile-cover-content profile-cover-uploader p-sm-3 p-2">
                <button class="js-file-attach-reset-img profile-cover-uploader-label btn btn-sm btn-danger avatar-img-remove" id="btnAddRemoveDisplayImage" type="button">
                  <i class="bi-trash-fill"></i><span class="d-none d-sm-inline-block ms-1">Remove Avatar</span>
                </button>
              </div>
            </div>
          </div>
          <!-- End User Profile Cover -->

          <!-- User Image -->
          <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar" for="imgAddImage">
            <img class="avatar-img" id="imgAddDisplayImage" src="{{ asset('storage/img/user-images/default.jpg') }}" alt="User Image">
            <input class="js-file-attach avatar-uploader-input avatar-img-user" id="imgAddImage" name="image"
              data-hs-file-attach-options='{
                "textTarget": "#imgAddDisplayImage",
                "mode": "image",
                "targetAttr": "src",
                "resetTarget": "#btnAddRemoveDisplayImage",
                "resetImg": "{{ asset('storage/img/user-images/default.jpg') }}",
                "allowTypes": [".jpg", ".jpeg", ".png"]
              }'
              type="file" accept=".jpg, .jpeg, .png">
            <span class="avatar-uploader-trigger"><i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i></span>
          </label>
          <div class="alert alert-soft-danger avatar-img-val d-none" id="valAddImage"></div>
          <!-- End User Image -->

          <!-- First Name -->
          <div class="row mb-4 mt-sm-4 mt-1">
            <label class="col-sm-3 col-form-label form-label" for="txtAddFname">First Name</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtAddFname" name="fname" type="text" placeholder="Enter first name">
              <span class="invalid-feedback" id="valAddFname"></span>
            </div>
          </div>
          <!-- End First Name -->

          <!-- Middle Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtAddMname">Middle Name <span class="form-label-secondary">(Optional)</span></label>
            <div class="col-sm-9">
              <input class="form-control" id="txtAddMname" name="mname" type="text" placeholder="Enter middle name">
              <span class="invalid-feedback" id="valAddMname"></span>
            </div>
          </div>
          <!-- End Middle Name -->

          <!-- Last Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtAddLname">Last Name</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtAddLname" name="lname" type="text" placeholder="Enter last name">
              <span class="invalid-feedback" id="valAddLname"></span>
            </div>
          </div>
          <!-- End Last Name -->

          <!-- Role -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="selAddRole">Role</label>
            <div class="col-sm-9">
              <div class="tom-select-custom">
                <select class="js-select form-select" id="selAddRole" name="role"
                  data-hs-tom-select-options='{
                    "hideSearch": "true",
                    "placeholder": "Select a role"
                  }'>
                  <option value=""></option>
                  @foreach ($roles as $role)
                    @if ($role->is_active)
                      <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endif
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddRole"></span>
              </div>
            </div>
          </div>
          <!-- End Role -->

          <!-- Department -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="selAddDepartment">Department</label>
            <div class="col-sm-9">
              <div class="tom-select-custom">
                <select class="js-select form-select" id="selAddDepartment" name="department"
                  data-hs-tom-select-options='{
                    "hideSearch": "true",
                    "placeholder": "Select a department"
                  }'>
                  <option value=""></option>
                  @foreach ($departments as $department)
                    @if ($department->is_active)
                      <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endif
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddDepartment"></span>
              </div>
            </div>
          </div>
          <!-- End Department -->

          <!-- Email -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtAddEmail">Email</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtAddEmail" name="email" type="email" placeholder="sample@site.com">
              <span class="invalid-feedback" id="valAddEmail"></span>
            </div>
          </div>
          <!-- End Email -->

          <!-- Phone -->
          <div class="row">
            <label class="col-sm-3 col-form-label form-label" for="txtAddPhone">Phone <span class="form-label-secondary">(Optional)</span></label>
            <div class="col-sm-9">
              <div class="input-group">
                <input class="js-input-mask form-control" id="txtAddPhone" name="phone" data-hs-mask-options='{
                    "mask": "0900-000-0000"
                  }' type="text"
                  placeholder="####-###-####">
                <span class="invalid-feedback" id="valAddPhone"></span>
              </div>
            </div>
          </div>
          <!-- End Phone -->

          <hr>

          <!-- Username -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtAddUser">Username</label>
            <div class="col-sm-9">
              <input class="js-input-mask form-control" id="txtAddUser" name="user" data-hs-mask-options='{
                  "mask": "00-00000"
                }' type="text"
                placeholder="##-#####">
              <span class="invalid-feedback" id="valAddUser"></span>
            </div>
          </div>
          <!-- End Username -->

          <!-- Password -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtAddPass">Password</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input class="js-toggle-password form-control" id="txtAddPass" name="pass"
                  data-hs-toggle-password-options='{
                    "target": "#togglePassTarget",
                    "defaultClass": "bi-eye-slash",
                    "showClass": "bi-eye",
                    "classChangeTarget": "#togglePassIcon"
                  }'
                  type="password" placeholder="Enter your password" />
                <a class="input-group-text" id="togglePassTarget"><i class="bi-eye" id="togglePassIcon"></i></a>
                <span class="invalid-feedback" id="valAddPass"></span>
              </div>
            </div>
          </div>
          <!-- End Password -->

          <!-- Confirm Password -->
          <div class="row">
            <label class="col-sm-3 col-form-label form-label" for="txtAddConfirm">Confirm Password</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input class="js-toggle-password form-control" id="txtAddConfirm" name="confirm"
                  data-hs-toggle-password-options='{
                    "target": "#togglePassConTarget",
                    "defaultClass": "bi-eye-slash",
                    "showClass": "bi-eye",
                    "classChangeTarget": "#toggleConPassIcon"
                  }'
                  type="password" placeholder="Confirm your password" />
                <a class="input-group-text" id="togglePassConTarget"><i class="bi-eye" id="toggleConPassIcon"></i></a>
                <span class="invalid-feedback" id="valAddConfirm"></span>
              </div>
            </div>
          </div>
          <!-- End Confirm Password -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnAddSaveUser" form="frmAddUser" type="submit" disabled>
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
<!-- End Add User Modal -->
