$(document).ready(function () {
  // ============ Create a Role ============ //
  const roleAddModal = $('#modalAddRole');
  const roleAddForm = $('#frmAddRole');

  handleUnsavedChanges(roleAddModal, roleAddForm, $('#btnAddSaveRole'));

  roleAddForm.on('submit', function (e) {
    e.preventDefault();

    const addFormData = new FormData(roleAddForm[0]);

    $.ajax({
      url: '/user-management/roles',
      method: 'POST',
      data: addFormData,
      dataType: 'json',
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, roleAddModal, roleAddForm);
        } else {
          if (response.errors.role) {
            $('#txtAddRole').addClass('is-invalid');
            $('#valAddRole').text(response.errors.role[0]);
          }

          if (response.errors.description) {
            $('#txtAddDescription').addClass('is-invalid');
            $('#valAddDescription').text(response.errors.description[0]);
          }

          if (response.errors.can_view) {
            const valPerm = $('#valAddPermission');
            valPerm.text(response.errors.can_view[0]);
            valPerm.show();
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, roleAddModal, roleAddForm);
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

        $('#lblViewRole').text(response.role);
        $('#lblViewDescription').text(response.description);

        console.log(response.permissions);

        let permissionsHtml = '';
        response.permissions.forEach(function (permission) {
          const actions = [];
          if (permission.can_view) actions.push('View');
          if (permission.can_create) actions.push('Create');
          if (permission.can_edit) actions.push('Edit');
          if (permission.can_delete) actions.push('Delete');
          permissionsHtml += `<li class="list-pointer-item">${permission.name}: ${actions.join(', ')}</li>`;
        });
        $('#lblViewPermission').html(`<ul class="list-pointer list-pointer-primary">${permissionsHtml}</ul>`);

        const roleStatus =
          response.status === 1
            ? `<span class="badge bg-soft-success text-success"><span class="legend-indicator bg-success"></span>Active</span>`
            : `<span class="badge bg-soft-danger text-danger"><span class="legend-indicator bg-danger"></span>Inactive</span>`;

        $('#lblViewStatus').html(roleStatus);
        $('#lblViewDateCreated').text(response.created);
        $('#lblViewDateUpdated').text(response.updated);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End View a Role ============ //

  // ============ Update a Role ============ //
  const roleEditModal = $('#modalEditRole');
  const roleEditForm = $('#frmEditRole');

  handleUnsavedChanges(roleEditModal, roleEditForm, $('#btnEditSaveRole'));

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
        $('#countCharactersRoleDesc').text(response.description.length + ' / 120');

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
        showErrorAlert(response.responseJSON, roleEditModal, roleEditForm);
      },
    });
  });

  roleEditForm.on('submit', function (e) {
    e.preventDefault();

    const editFormData = new FormData(roleEditForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('id', $('#txtEditRoleId').val());
    editFormData.append('role', $('#txtEditRole').val());
    editFormData.append('description', $('#txtEditDescription').val());

    $.ajax({
      url: '/user-management/roles',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, roleEditModal, roleEditForm);
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
        showErrorAlert(response.responseJSON, roleEditModal, roleEditForm);
      },
    });
  });

  $('.btnStatusRole').on('click', function () {
    const roleId = $(this).closest('.row').find('span[data-role-id]').data('role-id');
    const roleSetStatus = $(this).data('status');
    let statusName;

    if (roleSetStatus === 1) {
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
          url: '/user-management/roles',
          method: 'PATCH',
          data: {
            id: roleId,
            status: roleSetStatus,
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
  // ============ End Update a Role ============ //

  // ============ Delete a Role ============ //
  $('.btnDeleteRole').on('click', function () {
    const roleId = $(this).closest('.row').find('span[data-role-id]').data('role-id');

    Swal.fire({
      title: 'Delete Record?',
      text: 'Are you sure you want to delete the role?',
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
          url: '/user-management/roles',
          method: 'DELETE',
          data: { id: roleId },
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
