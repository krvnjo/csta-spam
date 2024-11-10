$(document).ready(function () {
  const departmentsDatatable = $('#departmentsDatatable').DataTable();

  // ============ Create a Department ============ //
  const departmentAddModal = $('#modalAddDepartment');
  const departmentAddForm = $('#frmAddDepartment');
  const departmentAddSaveBtn = $('#btnAddSaveDepartment');

  handleUnsavedChanges(departmentAddModal, departmentAddForm, departmentAddSaveBtn);

  departmentAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(departmentAddSaveBtn, true);

    const addFormData = new FormData(departmentAddForm[0]);

    $.ajax({
      url: '/file-maintenance/departments',
      method: 'POST',
      data: addFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(departmentAddSaveBtn, false);
          showResponseAlert(response, 'success', departmentAddModal, departmentAddForm);
        } else {
          handleValidationErrors(response, 'Add');
          toggleButtonState(departmentAddSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', departmentAddModal, departmentAddForm);
      },
    });
  });
  // ============ End Create a Department ============ //

  // ============ View a Department ============ //
  departmentsDatatable.on('click', '.btnViewDepartment', function () {
    const departmentId = $(this).closest('tr').find('td[data-department-id]').data('department-id');

    $.ajax({
      url: '/file-maintenance/departments/show',
      method: 'GET',
      data: { id: departmentId },
      success: function (response) {
        $('#modalViewDepartment').modal('toggle');

        const departmentConfig = {
          textFields: [
            { key: 'department', selector: '#lblViewDepartment' },
            { key: 'code', selector: '#lblViewCode' },
            { key: 'created_by', selector: '#lblViewCreatedBy' },
            { key: 'updated_by', selector: '#lblViewUpdatedBy' },
            { key: 'created_at', selector: '#lblViewCreatedAt' },
            { key: 'updated_at', selector: '#lblViewUpdatedAt' },
          ],

          dropdownFields: [
            {
              key: 'designations',
              container: '#dropdownMenuViewDesignations',
              countSelector: '#lblViewDesignations',
              label: 'designations in this department',
            },
          ],

          statusFields: { key: 'status', selector: '#lblViewStatus' },

          imageFields: [
            { key: 'created_img', selector: '#imgViewCreatedBy' },
            { key: 'updated_img', selector: '#imgViewUpdatedBy' },
          ],
        };

        displayViewResponseData(response, departmentConfig);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View a Department ============ //

  // ============ Edit a Department ============ //
  departmentsDatatable.on('click', '.btnEditDepartment', function () {
    const departmentId = $(this).closest('tr').find('td[data-department-id]').data('department-id');

    $.ajax({
      url: '/file-maintenance/departments/edit',
      method: 'GET',
      data: { id: departmentId },
      success: function (response) {
        departmentEditModal.modal('toggle');
        populateEditForm(response);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit a Department ============ //

  // ============ Update a Department ============ //
  const departmentEditModal = $('#modalEditDepartment');
  const departmentEditForm = $('#frmEditDepartment');
  const departmentEditSaveBtn = $('#btnEditSaveDepartment');

  handleUnsavedChanges(departmentEditModal, departmentEditForm, departmentEditSaveBtn);

  departmentEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(departmentEditSaveBtn, true);

    const editFormData = new FormData(departmentEditForm[0]);

    $.ajax({
      url: '/file-maintenance/departments',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(departmentEditSaveBtn, false);
          showResponseAlert(response, 'success', departmentAddModal, departmentAddForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(departmentEditSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', departmentAddModal, departmentAddForm);
      },
    });
  });

  departmentsDatatable.on('click', '.btnSetDepartment', function () {
    const departmentId = $(this).closest('tr').find('td[data-department-id]').data('department-id');
    const departmentName = $(this).closest('tr').find('a.btnViewDepartment').text().trim();
    const departmentStatus = $(this).data('status');
    const statusName = departmentStatus === 1 ? 'active' : 'inactive';

    Swal.fire({
      title: 'Update department status?',
      text: `Are you sure you want to set the department "${departmentName}" to ${statusName}?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: `Yes, set it to ${statusName}!`,
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'text-dark fs-1',
        htmlContainer: 'text-body text-center fs-4',
        confirmButton: `btn btn-sm ${departmentStatus === 1 ? 'btn-success' : 'btn-danger'}`,
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/file-maintenance/departments',
          method: 'PATCH',
          data: {
            id: departmentId,
            status: departmentStatus,
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
  // ============ End Update a Department ============ //

  // ============ Delete a Department ============ //
  departmentsDatatable.on('click', '.btnDeleteDepartment', function () {
    const departmentId = $(this).closest('tr').find('td[data-department-id]').data('department-id');
    const departmentName = $(this).closest('tr').find('a.btnViewDepartment').text().trim();

    Swal.fire({
      title: 'Delete Record?',
      text: `Are you sure you want to permanently delete the department "${departmentName}"? This action cannot be undone.`,
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
          url: '/file-maintenance/departments',
          method: 'DELETE',
          data: { id: departmentId },
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
  // ============ End Delete a Department ============ //
});
