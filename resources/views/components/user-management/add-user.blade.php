<!-- Add User Modal -->
<div class="modal fade" id="modalAddUser" data-bs-backdrop="static" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddUserLabel">Add User</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmAddUser" method="post" enctype="multipart/form-data" novalidate>
          @csrf
          <!-- Profile Cover -->
          <div class="profile-cover" style="height: 8rem;">
            <div class="profile-cover-img-wrapper" style="height: 8rem;">
              <img class="profile-cover-img" src="{{ Vite::asset('resources/img/1920x400/img1.jpg') }}" alt="Profile Cover" style="height: 8rem;">

              <div class="profile-cover-content profile-cover-uploader p-3">
                <button class="js-file-attach-reset-img btn btn-sm btn-danger" id="btnRemoveUserImage" type="button">
                  <i class="bi-trash-fill"></i> Remove Avatar
                </button>
              </div>
            </div>
          </div>
          <!-- End Profile Cover -->

          <!-- User Image -->
          <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar mb-5" for="imgAddImage">
            <img class="avatar-img" id="imgDisplayUserImage" src="{{ Vite::asset('resources/img/uploads/user-images/default.jpg') }}"
              alt="Image Description">

            <input class="js-file-attach avatar-uploader-input" id="imgAddImage" name="image"
              data-hs-file-attach-options='{
                 "textTarget": "#imgDisplayUserImage",
                 "mode": "image",
                 "targetAttr": "src",
                 "resetTarget": "#btnRemoveUserImage",
                 "resetImg": "{{ Vite::asset('resources/img/uploads/user-images/default.jpg') }}",
                 "allowTypes": [".png", ".jpeg", ".jpg"]
              }'
              type="file" accept=".jpg, .png, .jpeg">

            <span class="avatar-uploader-trigger">
              <i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i>
            </span>
          </label>
          <!-- End User Image -->

          <!-- Username -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtAddUsername">Username</label>
            <div class="col-sm-9">
              <input class="js-input-mask form-control" id="txtAddUsername" name="user"
                data-hs-mask-options='{
                    "mask": "00-00000"
                  }' type="text" placeholder="##-#####">
              <span class="invalid-feedback" id="valAddUsername"></span>
            </div>
          </div>
          <!-- End Username -->

          <!-- First Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtAddUserFname">First Name</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtAddUserFname" name="fname" type="text" placeholder="Enter First Name">
              <span class="invalid-feedback" id="valAddUserFname"></span>
            </div>
          </div>
          <!-- End First Name -->

          <!-- Middle Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtAddUserMname">Middle Name <span
                class="form-label-secondary">(Optional)</span></label>
            <div class="col-sm-9">
              <input class="form-control" id="txtAddUserMname" name="mname" type="text" placeholder="Enter Middle Name">
              <span class="invalid-feedback" id="valAddUserMname"></span>
            </div>
          </div>
          <!-- End Middle Name -->

          <!-- Last Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtAddUserLname">Last Name</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtAddUserLname" name="lname" type="text" placeholder="Enter Last Name">
              <span class="invalid-feedback" id="valAddUserLname"></span>
            </div>
          </div>
          <!-- End Last Name -->

          <!-- Role -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="selAddUserRole">Role</label>
            <div class="col-sm-9">
              <div class="tom-select-custom">
                <select class="js-select form-select" id="selAddUserRole" name="role"
                  data-hs-tom-select-options='{
                    "placeholder": "Select a role",
                    "hideSearch": "true"
                  }'>
                  <option value=""></option>
                  @foreach ($roles as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddUserRole"></span>
              </div>
            </div>
          </div>
          <!-- End Role -->

          <!-- Department -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="selAddUserDept">Department</label>
            <div class="col-sm-9">
              <div class="tom-select-custom">
                <select class="js-select form-select" id="selAddUserDept" name="dept"
                  data-hs-tom-select-options='{
                    "placeholder": "Select a department",
                    "hideSearch": "true"
                  }'>
                  <option value=""></option>
                  @foreach ($depts as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valAddUserDept"></span>
              </div>
            </div>
          </div>
          <!-- End Department -->

          <!-- Email -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtAddUserEmail">Email</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtAddUserEmail" name="email" type="email" placeholder="sample@site.com">
              <span class="invalid-feedback" id="valAddUserEmail"></span>
            </div>
          </div>
          <!-- End Email -->

          <!-- Phone -->
          <div class="row">
            <label class="col-sm-3 col-form-label form-label" for="txtAddUserPhone">Phone <span
                class="form-label-secondary">(Optional)</span></label>
            <div class="col-sm-9">
              <div class="input-group">
                <input class="js-input-mask form-control" id="txtAddUserPhone" name="phone"
                  data-hs-mask-options='{
                    "mask": "0900-000-0000"
                  }' type="text"
                  placeholder="####-###-####">
                <span class="invalid-feedback" id="valAddUserPhone"></span>
              </div>
            </div>
          </div>
          <!-- End Phone -->

          {{--          <!-- Password --> --}}
          {{--          <div class="row mb-4"> --}}
          {{--            <label class="col-sm-3 col-form-label form-label" for="txtAddUserPass">Password</label> --}}
          {{--            <div class="col-sm-9"> --}}
          {{--              <div class="input-group"> --}}
          {{--                <input class="js-toggle-password form-control" id="txtAddUserPass" name="pass" --}}
          {{--                  data-hs-toggle-password-options='{ --}}
          {{--                    "target": "#togglePassTarget", --}}
          {{--                    "defaultClass": "bi-eye-slash", --}}
          {{--                    "showClass": "bi-eye", --}}
          {{--                    "classChangeTarget": "#togglePassIcon" --}}
          {{--                  }' --}}
          {{--                  type="password" placeholder="Enter Password" /> --}}
          {{--                <a class="input-group-text" id="togglePassTarget"><i class="bi-eye" id="togglePassIcon"></i></a> --}}
          {{--                <span class="invalid-feedback" id="valAddUserPass"></span> --}}
          {{--              </div> --}}
          {{--            </div> --}}
          {{--          </div> --}}
          {{--          <!-- End Password --> --}}

          {{--          <!-- Confirm Password --> --}}
          {{--          <div class="row mb-4"> --}}
          {{--            <label class="col-sm-3 col-form-label form-label" for="txtAddUserConPass">Confirm Password</label> --}}
          {{--            <div class="col-sm-9"> --}}
          {{--              <div class="input-group"> --}}
          {{--                <input class="js-toggle-password form-control" id="txtAddUserConPass" name="confirmpass" --}}
          {{--                  data-hs-toggle-password-options='{ --}}
          {{--                    "target": "#togglePassConTarget", --}}
          {{--                    "defaultClass": "bi-eye-slash", --}}
          {{--                    "showClass": "bi-eye", --}}
          {{--                    "classChangeTarget": "#toggleConPassIcon" --}}
          {{--                  }' --}}
          {{--                  type="password" placeholder="Confirm Password" /> --}}
          {{--                <a class="input-group-text" id="togglePassConTarget"><i class="bi-eye" id="toggleConPassIcon"></i></a> --}}
          {{--                <span class="invalid-feedback" id="valAddUserConPass"></span> --}}
          {{--              </div> --}}
          {{--            </div> --}}
          {{--          </div> --}}
          {{--          <!-- End Confirm Password --> --}}
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
              <button class="btn btn-primary" id="btnAddSaveUser" form="frmAddUser" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Add User Modal -->
