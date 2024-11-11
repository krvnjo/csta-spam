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

          if (response.errors.can_view) {
            const valPerm = $('#valAddPermission');
            valPerm.text(response.errors.can_view[0]);
            valPerm.show();
          }

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
      url: '/user-management/roles/show',
      method: 'GET',
      data: { id: roleId },
      success: function (response) {
        $('#modalViewRole').modal('toggle');

        const roleConfig = {
          textFields: [
            { key: 'role', selector: '#lblViewRole' },
            { key: 'description', selector: '#lblViewDescription' },
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

        $('#txtEditRoleId').val(response.id);
        $('#txtEditRole').val(response.role);
        $('#txtEditDescription').val(response.description);
        $('#countCharactersRoleDesc').text(response.description.length + ' / 80');

        $('.form-check-input').prop('checked', false);
        response.permissions.forEach(function (permission) {
          let permissionIndex = permission.id;
          if (permission.can_view) {
            $('#cbxEditViewRole' + permissionIndex).prop('checked', true);
          }
          if (permission.can_create) {
            $('#cbxEditCreateRole' + permissionIndex).prop('checked', true);
          }
          if (permission.can_edit) {
            $('#cbxEditEditRole' + permissionIndex).prop('checked', true);
          }
          if (permission.can_delete) {
            $('#cbxEditDeleteRole' + permissionIndex).prop('checked', true);
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
          if (response.errors.role) {
            $('#txtEditRole').addClass('is-invalid');
            $('#valEditRole').text(response.errors.role[0]);
          }

          if (response.errors.description) {
            $('#txtEditDescription').addClass('is-invalid');
            $('#valEditDescription').text(response.errors.description[0]);
          }

          if (response.errors.can_view) {
            const valPerm = $('#valEditPermission');
            valPerm.text(response.errors.can_view[0]);
            valPerm.show();
          }
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

  $('.cbx-action').on('change', function () {
    const row = $(this).closest('tr');
    const viewCheckbox = row.find('.cbx-view');

    if ($(this).is(':checked')) {
      viewCheckbox.prop('checked', true);
    } else {
      const allUnchecked = row.find('.cbx-action:checked').length === 0;
      if (allUnchecked) {
        viewCheckbox.prop('checked', false);
      }
    }
    $('#valAddPermission').html('');
  });

  $('.cbx-view').on('change', function () {
    const row = $(this).closest('tr');
    const actionCheckboxes = row.find('.cbx-action');

    if (!$(this).is(':checked')) {
      actionCheckboxes.prop('checked', false);
    }

    $('#valAddPermission').html('');
  });
});
