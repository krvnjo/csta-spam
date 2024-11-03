$(document).ready(function () {
  const usersDatatable = $('#usersDatatable').DataTable();

  // ============ Create a User ============ //
  const userAddModal = $('#modalAddUser');
  const userAddForm = $('#frmAddUser');
  const userAddSaveBtn = $('#btnAddSaveUser');

  handleUnsavedChanges(userAddModal, userAddForm, userAddSaveBtn);

  userAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(userAddSaveBtn, true);

    const addFormData = new FormData(userAddForm[0]);

    $.ajax({
      url: '/user-management/users',
      method: 'POST',
      data: addFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', userAddModal, userAddForm);
        } else {
          handleValidationErrors(response, 'Add');
          toggleButtonState(userAddSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', userAddModal, userAddForm);
      },
    });
  });
  // ============ End Create a User ============ //

  // ============ View a User ============ //
  usersDatatable.on('click', '.btnViewUser', function () {
    const userId = $(this).closest('tr').find('td[data-user-id]').data('user-id');

    $.ajax({
      url: '/user-management/users/show',
      method: 'GET',
      data: { id: userId },
      success: function (response) {
        $('#modalViewUser').modal('toggle');

        const userConfig = {
          textFields: [
            { key: 'user', selector: '#lblViewUsername' },
            { key: 'fname', selector: '#lblViewUserFname' },
            { key: 'mname', selector: '#lblViewUserMname' },
            { key: 'lname', selector: '#lblViewUserLname' },
            { key: 'role', selector: '#lblViewUserRole' },
            { key: 'dept', selector: '#lblViewUserDept' },
            { key: 'email', selector: '#lblViewUserEmail' },
            { key: 'phone', selector: '#lblViewUserPhone' },
            { key: 'login', selector: '#lblViewLastLogin' },
            { key: 'created_by', selector: '#lblViewCreatedBy' },
            { key: 'updated_by', selector: '#lblViewUpdatedBy' },
            { key: 'created_at', selector: '#lblViewCreatedAt' },
            { key: 'updated_at', selector: '#lblViewUpdatedAt' },
          ],

          status: {
            key: 'status',
            selector: '#lblViewSetStatus',
            activeText: 'Active',
            inactiveText: 'Inactive',
          },

          imageFields: [
            { key: 'image', selector: '#imgViewUserImage' },
            { key: 'created_img', selector: '#imgViewCreatedBy' },
            { key: 'updated_img', selector: '#imgViewUpdatedBy' },
          ],
        };

        displayResponseData(response, userConfig);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View a User ============ //

  // ============ Update a User ============ //
  const userEditModal = $('#modalEditUser');
  const userEditForm = $('#frmEditUser');

  handleUnsavedChanges(userEditModal, userEditForm, $('#btnEditSaveUser'));

  usersDatatable.on('click', '.btnEditUser', function () {
    const userId = $(this).closest('tr').find('td[data-user-id]').data('user-id');

    $.ajax({
      url: '/user-management/users/edit',
      method: 'GET',
      data: { id: userId },
      success: function (response) {
        $('#txtEditUserId').val(response.id);
        $('#txtEditUsername').val(response.user);
        $('#txtEditUserFname').val(response.fname);
        $('#txtEditUserMname').val(response.mname);
        $('#txtEditUserLname').val(response.lname);
        $('#selEditUserRole')[0].tomselect.setValue(response.role);
        $('#selEditUserDept')[0].tomselect.setValue(response.dept);
        $('#txtEditUserEmail').val(response.email);
        $('#txtEditUserPhone').val(response.phone);
        $('#imgEditDisplayUserImage').attr('src', response.image);

        userEditModal.modal('toggle');
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, userEditModal, userEditForm);
      },
    });
  });

  userEditForm.on('submit', function (e) {
    e.preventDefault();

    const editFormData = new FormData(userEditForm[0]);
    editFormData.append('_method', 'PATCH');
    editFormData.append('avatar', $('#imgEditDisplayUserImage').attr('src').split('/').pop());

    $.ajax({
      url: '/user-management/users',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, userEditModal, userEditForm);
        } else {
          if (response.errors.user) {
            $('#txtEditUsername').addClass('is-invalid');
            $('#valEditUsername').text(response.errors.user[0]);
          }

          if (response.errors.fname) {
            $('#txtEditUserFname').addClass('is-invalid');
            $('#valEditUserFname').text(response.errors.fname[0]);
          }

          if (response.errors.mname) {
            $('#txtEditUserMname').addClass('is-invalid');
            $('#valEditUserMname').text(response.errors.mname[0]);
          }

          if (response.errors.lname) {
            $('#txtEditUserLname').addClass('is-invalid');
            $('#valEditUserLname').text(response.errors.lname[0]);
          }

          if (response.errors.role) {
            $('#selEditUserRole').next('.ts-wrapper').addClass('is-invalid');
            $('#valEditUserRole').text(response.errors.role[0]);
          }

          if (response.errors.dept) {
            $('#selEditUserDept').next('.ts-wrapper').addClass('is-invalid');
            $('#valEditUserDept').text(response.errors.dept[0]);
          }

          if (response.errors.email) {
            $('#txtEditUserEmail').addClass('is-invalid');
            $('#valEditUserEmail').text(response.errors.email[0]);
          }

          if (response.errors.phone) {
            $('#txtEditUserPhone').addClass('is-invalid');
            $('#valEditUserPhone').text(response.errors.phone[0]);
          }

          if (response.errors.image) {
            $('#valEditUserImage').removeClass('d-none').text(response.errors.image[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, userEditModal, userEditForm);
      },
    });
  });

  usersDatatable.on('click', '.btnStatusUser', function () {
    const userId = $(this).closest('tr').find('td[data-user-id]').data('user-id');
    const userSetStatus = $(this).data('status');
    let statusName;

    if (userSetStatus === 1) {
      statusName = 'active';
    } else {
      statusName = 'inactive';
    }

    Swal.fire({
      title: 'Change status?',
      text: 'Are you sure you want to set it to ' + statusName + '?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, set it to ' + statusName + '!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/user-management/users',
          method: 'PATCH',
          data: {
            id: userId,
            status: userSetStatus,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON);
          },
        });
      }
    });
  });
  // ============ End Update a User ============ //

  // ============ Delete a User ============ //
  usersDatatable.on('click', '.btnDeleteUser', function () {
    const userId = $(this).closest('tr').find('td[data-user-id]').data('user-id');

    Swal.fire({
      title: 'Delete Record?',
      text: 'Are you sure you want to delete the user?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        confirmButton: 'btn btn-danger',
        cancelButton: 'btn btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/user-management/users',
          method: 'DELETE',
          data: { id: userId },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON);
          },
        });
      }
    });
  });

  $('#btnMultiDeleteUser').on('click', function () {
    let checkedCheckboxes = usersDatatable.rows().nodes().to$().find('input.form-check-input:checked');

    let userIds = checkedCheckboxes
      .map(function () {
        return $(this).closest('tr').find('[data-user-id]').data('user-id');
      })
      .get();

    Swal.fire({
      title: 'Delete Records?',
      text: 'Are you sure you want to delete all the selected users?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        confirmButton: 'btn btn-danger',
        cancelButton: 'btn btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/user-management/users',
          method: 'DELETE',
          data: { id: userIds },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON);
          },
        });
      }
    });
  });
  // ============ End Delete a User ============ //
});
