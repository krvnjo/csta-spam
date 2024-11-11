$(document).ready(function () {
  const designationsDatatable = $('#designationsDatatable').DataTable();

  // ============ Create a Designation ============ //
  const designationAddModal = $('#modalAddDesignation');
  const designationAddForm = $('#frmAddDesignation');
  const designationAddSaveBtn = $('#btnAddSaveDesignation');

  handleUnsavedChanges(designationAddModal, designationAddForm, designationAddSaveBtn);

  designationAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(designationAddSaveBtn, true);

    const addFormData = new FormData(designationAddForm[0]);

    $.ajax({
      url: '/file-maintenance/designations',
      method: 'POST',
      data: addFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(designationAddSaveBtn, false);
          showResponseAlert(response, 'success', designationAddModal, designationAddForm);
        } else {
          handleValidationErrors(response, 'Add');
          toggleButtonState(designationAddSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', designationAddModal, designationAddForm);
      },
    });
  });
  // ============ End Create a Designation ============ //

  // ============ View a Designation ============ //
  designationsDatatable.on('click', '.btnViewDesignation', function () {
    const designationId = $(this).closest('tr').find('td[data-designation-id]').data('designation-id');

    $.ajax({
      url: '/file-maintenance/designations/show',
      method: 'GET',
      data: { id: designationId },
      success: function (response) {
        $('#modalViewDesignation').modal('toggle');

        const designationConfig = {
          textFields: [
            { key: 'designation', selector: '#lblViewDesignation' },
            { key: 'department', selector: '#lblViewDepartment' },
            { key: 'created_by', selector: '#lblViewCreatedBy' },
            { key: 'updated_by', selector: '#lblViewUpdatedBy' },
            { key: 'created_at', selector: '#lblViewCreatedAt' },
            { key: 'updated_at', selector: '#lblViewUpdatedAt' },
          ],

          statusFields: { key: 'status', selector: '#lblViewStatus' },

          imageFields: [
            { key: 'created_img', selector: '#imgViewCreatedBy' },
            { key: 'updated_img', selector: '#imgViewUpdatedBy' },
          ],
        };

        displayViewResponseData(response, designationConfig);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View a Designation ============ //

  // ============ Edit a Designation ============ //
  designationsDatatable.on('click', '.btnEditDesignation', function () {
    const designationId = $(this).closest('tr').find('td[data-designation-id]').data('designation-id');

    $.ajax({
      url: '/file-maintenance/designations/edit',
      method: 'GET',
      data: { id: designationId },
      success: function (response) {
        designationEditModal.modal('toggle');
        populateEditForm(response);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit a Designation ============ //

  // ============ Update a Designation ============ //
  const designationEditModal = $('#modalEditDesignation');
  const designationEditForm = $('#frmEditDesignation');
  const designationEditSaveBtn = $('#btnEditSaveDesignation');

  handleUnsavedChanges(designationEditModal, designationEditForm, designationEditSaveBtn);

  designationEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(designationEditSaveBtn, true);

    const editFormData = new FormData(designationEditForm[0]);

    $.ajax({
      url: '/file-maintenance/designations',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(designationEditSaveBtn, false);
          showResponseAlert(response, 'success', designationAddModal, designationAddForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(designationEditSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', designationAddModal, designationAddForm);
      },
    });
  });

  designationsDatatable.on('click', '.btnSetDesignation', function () {
    const designationId = $(this).closest('tr').find('td[data-designation-id]').data('designation-id');
    const designationName = $(this).closest('tr').find('a.btnViewDesignation').text().trim();
    const designationStatus = $(this).data('status');
    const statusName = designationStatus === 1 ? 'active' : 'inactive';

    Swal.fire({
      title: 'Update designation status?',
      text: `Are you sure you want to set the designation "${designationName}" to ${statusName}?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: `Yes, set it to ${statusName}!`,
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'text-dark fs-1',
        htmlContainer: 'text-body text-center fs-4',
        confirmButton: `btn btn-sm ${designationStatus === 1 ? 'btn-success' : 'btn-danger'}`,
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/file-maintenance/designations',
          method: 'PATCH',
          data: {
            id: designationId,
            status: designationStatus,
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
  // ============ End Update a Designation ============ //

  // ============ Delete a Designation ============ //
  designationsDatatable.on('click', '.btnDeleteDesignation', function () {
    const designationId = $(this).closest('tr').find('td[data-designation-id]').data('designation-id');
    const designationName = $(this).closest('tr').find('a.btnViewDesignation').text().trim();

    Swal.fire({
      title: 'Delete Record?',
      text: `Are you sure you want to permanently delete the designation "${designationName}"? This action cannot be undone.`,
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
          url: '/file-maintenance/designations',
          method: 'DELETE',
          data: { id: designationId },
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
  // ============ End Delete a Designation ============ //
});
