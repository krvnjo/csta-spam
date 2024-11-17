$(document).ready(function () {
  // ============ Create a Role ============ //
  const roleAddModal = $('#modalAddRole');
  const roleAddForm = $('#frmAddRole');
  const roleAddSaveBtn = $('#btnAddSaveRole');

  handleUnsavedChanges(roleAddModal, roleAddForm, roleAddSaveBtn);

  roleAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(roleAddSaveBtn, true);

    const addFormData = new FormData(roleAddForm[0]);

    $.ajax({
      url: '/user-management/roles',
      method: 'POST',
      data: addFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(roleAddSaveBtn, false);
          showResponseAlert(response, 'success', roleAddModal, roleAddForm);
        } else {
          handleValidationErrors(response, 'Add');
          toggleButtonState(roleAddSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', roleAddModal, roleAddForm);
      },
    });
  });
  // ============ End Create a Role ============ //

  // ============ View a Role ============ //
  $('.btnViewRole').on('click', function () {
    const roleId = $(this).closest('.row').find('span[data-role-id]').data('role-id');

    $.ajax({
      url: '/user-management/roles/view',
      method: 'GET',
      data: { id: roleId },
      success: function (response) {
        $('#modalViewRole').modal('toggle');

        const roleConfig = {
          textFields: [
            { key: 'role', selector: '#lblViewRole' },
            { key: 'description', selector: '#lblViewDescription' },
            { key: 'dashboard', selector: '#lblViewDashboard' },
            { key: 'created_by', selector: '#lblViewCreatedBy' },
            { key: 'updated_by', selector: '#lblViewUpdatedBy' },
            { key: 'created_at', selector: '#lblViewCreatedAt' },
            { key: 'updated_at', selector: '#lblViewUpdatedAt' },
          ],

          dropdownFields: [
            {
              key: 'permissions',
              container: '#dropdownMenuViewPermissions',
              countSelector: '#lblViewPermissions',
              label: 'permissions in this role',
            },
          ],

          statusFields: { key: 'status', selector: '#lblViewStatus' },

          imageFields: [
            { key: 'created_img', selector: '#imgViewCreatedBy' },
            { key: 'updated_img', selector: '#imgViewUpdatedBy' },
          ],
        };

        displayViewResponseData(response, roleConfig);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View a Role ============ //

  // ============ Edit a Role ============ //
  $('.btnEditRole').on('click', function () {
    const roleId = $(this).closest('.row').find('span[data-role-id]').data('role-id');

    $.ajax({
      url: '/user-management/roles/edit',
      method: 'GET',
      data: { id: roleId },
      success: function (response) {
        roleEditModal.modal('toggle');

        $('#countCharactersRoleDesc').text(response.description.length + ' / 80');

        if (response.auth) {
          $('#editRoleContainer').hide();
        } else {
          $('#editRoleContainer').show();
        }

        populateEditForm(response);

        $('.selEditPermission').each(function () {
          let tomSelectInstance = $(this)[0].tomselect;
          if (tomSelectInstance) {
            tomSelectInstance.clear();
          }
        });

        let permissions = response.permissions;
        permissions.forEach(function (permission) {
          let selectId = '#selEditPermission' + permission.perm_id;

          let tomSelectInstance = $(selectId)[0].tomselect;
          if (tomSelectInstance) {
            tomSelectInstance.setValue(permission.access_id);
          }
        });
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit a Role ============ //

  // ============ Update a Role ============ //
  const roleEditModal = $('#modalEditRole');
  const roleEditForm = $('#frmEditRole');
  const roleEditSaveBtn = $('#btnEditSaveRole');

  handleUnsavedChanges(roleEditModal, roleEditForm, roleEditSaveBtn);

  roleEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(roleEditSaveBtn, true);

    const editFormData = new FormData(roleEditForm[0]);

    $.ajax({
      url: '/user-management/roles',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(roleEditSaveBtn, false);
          showResponseAlert(response, 'success', roleEditModal, roleEditForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(roleEditSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', roleEditModal, roleEditForm);
      },
    });
  });

  $('.btnSetRole').on('click', function () {
    const roleId = $(this).closest('.row').find('span[data-role-id]').data('role-id');
    const roleName = $(this).closest('.row').find('h3 .btnViewRole').text().trim();
    const roleStatus = $(this).data('status');
    const statusName = roleStatus === 1 ? 'active' : 'inactive';

    Swal.fire({
      title: 'Update role status?',
      text: `Are you sure you want to set the role "${roleName}" to ${statusName}?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: `Yes, set it to ${statusName}!`,
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'text-dark fs-1',
        htmlContainer: 'text-body text-center fs-4',
        confirmButton: `btn btn-sm ${roleStatus === 1 ? 'btn-success' : 'btn-danger'}`,
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/user-management/roles',
          method: 'PATCH',
          data: {
            id: roleId,
            status: roleStatus,
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
  // ============ End Update a Role ============ //

  // ============ Delete a Role ============ //
  $('.btnDeleteRole').on('click', function () {
    const roleId = $(this).closest('.row').find('span[data-role-id]').data('role-id');
    const roleName = $(this).closest('.row').find('h3 .btnViewRole').text().trim();

    Swal.fire({
      title: 'Delete Record?',
      text: `Are you sure you want to permanently delete the role "${roleName}"? This action cannot be undone.`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'text-dark fs-1',
        htmlContainer: 'text-body text-center fs-4',
        confirmButton: 'btn btn-sm btn-danger',
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/user-management/roles',
          method: 'DELETE',
          data: { id: roleId },
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
  // ============ End Delete a Role ============ //
});
