<!-- Edit User Modal -->
<div class="modal fade" id="modalEditUser" data-bs-backdrop="static" role="dialog" aria-labelledby="modalEditUserLabel" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditUserLabel">Edit User</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="frmEditUser" method="post" enctype="multipart/form-data" novalidate>
          @csrf
          @method('PATCH')
          <input id="txtEditUserId" name="id" type="hidden">

          <!-- Profile Cover -->
          <div class="profile-cover" style="height: 8rem;">
            <div class="profile-cover-img-wrapper" style="height: 8rem;">
              <img class="profile-cover-img" src="{{ Vite::asset('resources/img/1920x400/img1.jpg') }}" alt="Profile Cover" style="height: 8rem;">

              <div class="profile-cover-content profile-cover-uploader p-3">
                <button class="js-file-attach-reset-img btn btn-sm btn-danger" id="btnEditRemoveUserImage" type="button">
                  <i class="bi-trash-fill"></i> Remove Avatar
                </button>
              </div>
            </div>
          </div>
          <!-- End Profile Cover -->

          <!-- User Image -->
          <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar mb-5" for="imgEditImage">
            <img class="avatar-img" id="imgEditDisplayUserImage" src="" alt="Profile Image">

            <input class="js-file-attach avatar-uploader-input" id="imgEditImage" name="image"
              data-hs-file-attach-options='{
                 "textTarget": "#imgEditDisplayUserImage",
                 "mode": "image",
                 "targetAttr": "src",
                 "resetTarget": "#btnEditRemoveUserImage",
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
            <label class="col-sm-3 col-form-label form-label" for="txtEditUsername">Username</label>
            <div class="col-sm-9">
              <input class="js-input-mask form-control" id="txtEditUsername" name="user"
                data-hs-mask-options='{
                    "mask": "00-00000"
                  }' type="text" placeholder="##-#####">
              <span class="invalid-feedback" id="valEditUsername"></span>
            </div>
          </div>
          <!-- End Username -->

          <!-- First Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtEditUserFname">First Name</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtEditUserFname" name="fname" type="text" placeholder="Enter First Name">
              <span class="invalid-feedback" id="valEditUserFname"></span>
            </div>
          </div>
          <!-- End First Name -->

          <!-- Middle Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtEditUserMname">Middle Name <span
                class="form-label-secondary">(Optional)</span></label>
            <div class="col-sm-9">
              <input class="form-control" id="txtEditUserMname" name="mname" type="text" placeholder="Enter Middle Name">
              <span class="invalid-feedback" id="valEditUserMname"></span>
            </div>
          </div>
          <!-- End Middle Name -->

          <!-- Last Name -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtEditUserLname">Last Name</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtEditUserLname" name="lname" type="text" placeholder="Enter Last Name">
              <span class="invalid-feedback" id="valEditUserLname"></span>
            </div>
          </div>
          <!-- End Last Name -->

          <!-- Role -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="selEditUserRole">Role</label>
            <div class="col-sm-9">
              <div class="tom-select-custom">
                <select class="js-select form-select" id="selEditUserRole" name="role"
                  data-hs-tom-select-options='{
                    "placeholder": "Select a role",
                    "hideSearch": "true"
                  }'>
                  <option value=""></option>
                  @foreach ($roles as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valEditUserRole"></span>
              </div>
            </div>
          </div>
          <!-- End Role -->

          <!-- Department -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="selEditUserDept">Department</label>
            <div class="col-sm-9">
              <div class="tom-select-custom">
                <select class="js-select form-select" id="selEditUserDept" name="dept"
                  data-hs-tom-select-options='{
                    "placeholder": "Select a department",
                    "hideSearch": "true"
                  }'>
                  <option value=""></option>
                  @foreach ($depts as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
                <span class="invalid-feedback" id="valEditUserDept"></span>
              </div>
            </div>
          </div>
          <!-- End Department -->

          <!-- Email -->
          <div class="row mb-4">
            <label class="col-sm-3 col-form-label form-label" for="txtEditUserEmail">Email</label>
            <div class="col-sm-9">
              <input class="form-control" id="txtEditUserEmail" name="email" type="email" placeholder="sample@site.com">
              <span class="invalid-feedback" id="valEditUserEmail"></span>
            </div>
          </div>
          <!-- End Email -->

          <!-- Phone -->
          <div class="row">
            <label class="col-sm-3 col-form-label form-label" for="txtEditUserPhone">Phone <span
                class="form-label-secondary">(Optional)</span></label>
            <div class="col-sm-9">
              <div class="input-group">
                <input class="js-input-mask form-control" id="txtEditUserPhone" name="phone"
                  data-hs-mask-options='{
                    "mask": "0900-000-0000"
                  }' type="text"
                  placeholder="####-###-####">
                <span class="invalid-feedback" id="valEditUserPhone"></span>
              </div>
            </div>
          </div>
          <!-- End Phone -->

          {{--          <!-- Password --> --}}
          {{--          <div class="row"> --}}
          {{--            <label class="col-sm-3 col-form-label form-label" for="txtEditUserPass">Password</label> --}}
          {{--            <div class="col-sm-9"> --}}
          {{--              <div class="input-group"> --}}
          {{--                <input class="js-toggle-password form-control" id="txtEditUserPass" name="pass" --}}
          {{--                  data-hs-toggle-password-options='{ --}}
          {{--                    "target": "#togglePassTarget", --}}
          {{--                    "defaultClass": "bi-eye-slash", --}}
          {{--                    "showClass": "bi-eye", --}}
          {{--                    "classChangeTarget": "#togglePassIcon" --}}
          {{--                  }' --}}
          {{--                  type="password" placeholder="Enter Password" /> --}}
          {{--                <a class="input-group-text" id="togglePassTarget"><i class="bi-eye" id="togglePassIcon"></i></a> --}}
          {{--                <span class="invalid-feedback" id="valEditUserPass"></span> --}}
          {{--              </div> --}}
          {{--            </div> --}}
          {{--          </div> --}}
          {{--          <!-- End Password --> --}}

          {{--          <!-- Confirm Password --> --}}
          {{--          <div class="row mb-4"> --}}
          {{--            <label class="col-sm-3 col-form-label form-label" for="txtEditUserConPass">Confirm Password</label> --}}
          {{--            <div class="col-sm-9"> --}}
          {{--              <div class="input-group"> --}}
          {{--                <input class="js-toggle-password form-control" id="txtEditUserConPass" name="confirmpass" --}}
          {{--                  data-hs-toggle-password-options='{ --}}
          {{--                    "target": "#togglePassConTarget", --}}
          {{--                    "defaultClass": "bi-eye-slash", --}}
          {{--                    "showClass": "bi-eye", --}}
          {{--                    "classChangeTarget": "#toggleConPassIcon" --}}
          {{--                  }' --}}
          {{--                  type="password" placeholder="Confirm Password" /> --}}
          {{--                <a class="input-group-text" id="togglePassConTarget"><i class="bi-eye" id="toggleConPassIcon"></i></a> --}}
          {{--                <span class="invalid-feedback" id="valEditUserConPass"></span> --}}
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
              <button class="btn btn-primary" form="frmEditUser" type="submit">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</div>
<!-- End Edit User Modal -->
