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
            { key: 'user', selector: '#lblViewUser' },
            { key: 'fname', selector: '#lblViewFname' },
            { key: 'mname', selector: '#lblViewMname' },
            { key: 'lname', selector: '#lblViewLname' },
            { key: 'role', selector: '#lblViewRole' },
            { key: 'dept', selector: '#lblViewDept' },
            { key: 'email', selector: '#lblViewEmail' },
            { key: 'phone', selector: '#lblViewPhone' },
            { key: 'login', selector: '#lblViewLogin' },
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
            { key: 'image', selector: '#imgViewUser' },
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

  // ============ Edit a User ============ //
  usersDatatable.on('click', '.btnEditUser', function () {
    const userId = $(this).closest('tr').find('td[data-user-id]').data('user-id');

    $.ajax({
      url: '/user-management/users/edit',
      method: 'GET',
      data: { id: userId },
      success: function (response) {
        $('#txtEditUserId').val(response.id);
        $('#txtEditUser').val(response.user);
        $('#txtEditFname').val(response.fname);
        $('#txtEditMname').val(response.mname);
        $('#txtEditLname').val(response.lname);
        $('#selEditRole')[0].tomselect.setValue(response.role);
        $('#selEditDept')[0].tomselect.setValue(response.dept);
        $('#txtEditEmail').val(response.email);
        $('#txtEditPhone').val(response.phone);
        $('#imgEditDisplayImage').attr('src', response.image);

        userEditModal.modal('toggle');
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit a User ============ //

  // ============ Update a User ============ //
  const userEditModal = $('#modalEditUser');
  const userEditForm = $('#frmEditUser');
  const userEditSaveBtn = $('#btnEditSaveUser');

  handleUnsavedChanges(userEditModal, userEditForm, userEditSaveBtn);

  userEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(userEditSaveBtn, true);

    const editFormData = new FormData(userEditForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('id', $('#txtEditUserId').val());
    editFormData.append('avatar', $('#imgEditDisplayImage').attr('src').split('/').pop());

    // Display the FormData content
    for (let [key, value] of editFormData.entries()) {
      console.log(`${key}: ${value}`);
    }

    $.ajax({
      url: '/user-management/users',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', userEditModal, userEditForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(userEditSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', userEditModal, userEditForm);
      },
    });
  });

  usersDatatable.on('click', '.btnSetUser', function () {
    const userId = $(this).closest('tr').find('td[data-user-id]').data('user-id');
    const userName = $(this).closest('tr').find('.user-name').text().trim();
    const userStatus = $(this).data('status');
    const statusName = userStatus === 1 ? 'active' : 'inactive';

    Swal.fire({
      title: 'Update user status?',
      text: `Are you sure you want to set the user "${userName}" to ${statusName}?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: `Yes, set it to ${statusName}!`,
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'fs-1',
        htmlContainer: 'text-muted text-center fs-4',
        confirmButton: 'btn btn-sm btn-white',
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/user-management/users',
          method: 'PATCH',
          data: {
            id: userId,
            status: userStatus,
          },
          success: function (response) {
            showResponseAlert(response, 'success');
          },
          error: function (response) {
            showResponseAlert(response, 'error');
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
