<!-- Edit User Modal -->
<div class="modal fade" id="modalEditUser" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditUser" method="POST" enctype="multipart/form-data" novalidate>
          @csrf
          <!-- Profile Cover -->
          <div class="profile-cover" style="height: 7rem;">
            <div class="profile-cover-img-wrapper" style="height: 7rem;">
              <img class="profile-cover-img" src="{{ Vite::asset('resources/img/1920x400/img1.jpg') }}" alt="Profile Cover" style="height: 7rem;">
              <div class="profile-cover-content profile-cover-uploader p-3">
                <button class="js-file-attach-reset-img profile-cover-uploader-label btn btn-sm btn-danger avatar-img-remove" id="btnRemoveUserImage" type="button">
                  <i class="bi-trash-fill"></i>
                  <span class="d-none d-sm-inline-block ms-1">Remove Avatar</span>
                </button>
              </div>
            </div>
          </div>
          <!-- End Profile Cover -->

          <!-- User Image -->
          <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar" for="imgEditImage">
            <img class="avatar-img" id="imgDisplayImage" src="{{ asset('storage/img/user-images/default.jpg') }}" alt="User Image">
            <input class="js-file-attach avatar-uploader-input avatar-img-user" id="imgEditImage" name="image"
              data-hs-file-attach-options='{
                "textTarget": "#imgDisplayImage",
                "mode": "image",
                "targetAttr": "src",
                "resetTarget": "#btnRemoveUserImage",
                "resetImg": "{{ asset('storage/img/user-images/default.jpg') }}",
                "allowTypes": [".jpg", ".jpeg", ".png"]
              }'
              type="file" accept=".jpg, .jpeg, .png">
            <span class="avatar-uploader-trigger"><i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i></span>
          </label>
          <div class="alert alert-soft-danger avatar-img-val d-none" id="valEditImage"></div>
          <!-- End User Image -->

          <!-- Username -->
          <div class="row mb-4 mt-4">
            <label class="col-sm-3 col-form-label form-label" for="txtEditUser">Username</label>
            <div class="col-sm-9">
              <input class="js-input-mask form-control" id="txtEditUsername" name="user" data-hs-mask-options='{
                  "mask": "00-00000"
                }' type="text"
                placeholder="##-#####">
              <span class="invalid-feedback" id="valEditUser"></span>
            </div>
          </div>
          <!-- End Username -->

          <!-- First Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtEditFname">First Name</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtEditFname" name="fname" type="text" placeholder="Enter first name">
              <span class="invalid-feedback" id="valEditFname"></span>
            </div>
          </div>
          <!-- End First Name -->

          <!-- Middle Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtEditMname">Middle Name <span class="form-label-secondary">(Optional)</span></label>
            <div class="col-sm-9">
              <input class="form-control" id="txtEditMname" name="mname" type="text" placeholder="Enter middle name">
              <span class="invalid-feedback" id="valEditMname"></span>
            </div>
          </div>
          <!-- End Middle Name -->

          <!-- Last Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtEditLname">Last Name</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtEditLname" name="lname" type="text" placeholder="Enter last name">
              <span class="invalid-feedback" id="valEditLname"></span>
            </div>
          </div>
          <!-- End Last Name -->

          <!-- Role -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="selEditRole">Role</label>
            <div class="col-sm-9">
              <div class="tom-select-custom">
                <select class="js-select form-select" id="selEditRole" name="role"
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
                <span class="invalid-feedback" id="valEditRole"></span>
              </div>
            </div>
          </div>
          <!-- End Role -->

          <!-- Department -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="selEditDept">Department</label>
            <div class="col-sm-9">
              <div class="tom-select-custom">
                <select class="js-select form-select" id="selEditDept" name="dept"
                  data-hs-tom-select-options='{
                    "hideSearch": "true",
                    "placeholder": "Select a department"
                  }'>
                  <option value=""></option>
                  @foreach ($depts as $dept)
                    @if ($dept->is_active)
                      <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endif
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valEditDept"></span>
              </div>
            </div>
          </div>
          <!-- End Department -->

          <!-- Email -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtEditEmail">Email</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtEditEmail" name="email" type="email" placeholder="sample@site.com">
              <span class="invalid-feedback" id="valEditEmail"></span>
            </div>
          </div>
          <!-- End Email -->

          <!-- Phone -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtEditPhone">Phone <span class="form-label-secondary">(Optional)</span></label>
            <div class="col-sm-9">
              <div class="input-group">
                <input class="js-input-mask form-control" id="txtEditPhone" name="phone" data-hs-mask-options='{
                    "mask": "0900-000-0000"
                  }' type="text"
                  placeholder="####-###-####">
                <span class="invalid-feedback" id="valEditPhone"></span>
              </div>
            </div>
          </div>
          <!-- End Phone -->
        </form>
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <div class="row align-items-sm-center flex-grow-1 mx-n2">
          <div class="col d-flex justify-content-end gap-2">
            <button class="btn btn-white" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" id="btnEditSaveUser" form="frmEditUser" type="submit" disabled>
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
<!-- End Edit User Modal -->
