$(document).ready(function () {
  const requestersDatatable = $('#requestersDatatable').DataTable();

  // ============ Create a Requester ============ //
  const requesterAddModal = $('#modalAddRequester');
  const requesterAddForm = $('#frmAddRequester');
  const requesterAddSaveBtn = $('#btnAddSaveRequester');

  handleUnsavedChanges(requesterAddModal, requesterAddForm, requesterAddSaveBtn);

  requesterAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(requesterAddSaveBtn, true);

    const addFormData = new FormData(requesterAddForm[0]);

    $.ajax({
      url: '/file-maintenance/requesters',
      method: 'POST',
      data: addFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(requesterAddSaveBtn, false);
          showResponseAlert(response, 'success', requesterAddModal, requesterAddForm);
        } else {
          handleValidationErrors(response, 'Add');
          toggleButtonState(requesterAddSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', requesterAddModal, requesterAddForm);
      },
    });
  });
  // ============ End Create a Requester ============ //

  // ============ View a Requester ============ //
  requestersDatatable.on('click', '.btnViewRequester', function () {
    const requesterId = $(this).closest('tr').find('td[data-requester-id]').data('requester-id');

    $.ajax({
      url: '/file-maintenance/requesters/view',
      method: 'GET',
      data: { id: requesterId },
      success: function (response) {
        $('#modalViewRequester').modal('toggle');

        const requesterConfig = {
          textFields: [
            { key: 'requester', selector: '#lblViewRequester' },
            { key: 'lname', selector: '#lblViewLname' },
            { key: 'fname', selector: '#lblViewFname' },
            { key: 'mname', selector: '#lblViewMname' },
            { key: 'department', selector: '#lblViewDepartment' },
            { key: 'email', selector: '#lblViewEmail' },
            { key: 'phone', selector: '#lblViewPhone' },
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

        displayViewResponseData(response, requesterConfig);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View a Requester ============ //

  // ============ Edit a Requester ============ //
  requestersDatatable.on('click', '.btnEditRequester', function () {
    const requesterId = $(this).closest('tr').find('td[data-requester-id]').data('requester-id');

    $.ajax({
      url: '/file-maintenance/requesters/edit',
      method: 'GET',
      data: { id: requesterId },
      success: function (response) {
        requesterEditModal.modal('toggle');
        populateEditForm(response);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit a Requester ============ //

  // ============ Update a Requester ============ //
  const requesterEditModal = $('#modalEditRequester');
  const requesterEditForm = $('#frmEditRequester');
  const requesterEditSaveBtn = $('#btnEditSaveRequester');

  handleUnsavedChanges(requesterEditModal, requesterEditForm, requesterEditSaveBtn);

  requesterEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(requesterEditSaveBtn, true);

    const editFormData = new FormData(requesterEditForm[0]);

    $.ajax({
      url: '/file-maintenance/requesters',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(requesterEditSaveBtn, false);
          showResponseAlert(response, 'success', requesterEditModal, requesterEditForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(requesterEditSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', requesterEditModal, requesterEditForm);
      },
    });
  });

  requestersDatatable.on('click', '.btnSetRequester', function () {
    const requesterId = $(this).closest('tr').find('td[data-requester-id]').data('requester-id');
    const requesterName = $(this).closest('tr').find('a.btnViewRequester').text().trim();
    const requesterStatus = $(this).data('status');
    const statusName = requesterStatus === 1 ? 'active' : 'inactive';

    Swal.fire({
      title: 'Update requester status?',
      text: `Are you sure you want to set the requester "${requesterName}" to ${statusName}?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: `Yes, set it to ${statusName}!`,
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'text-dark fs-1',
        htmlContainer: 'text-body text-center fs-4',
        confirmButton: `btn btn-sm ${requesterName === 1 ? 'btn-success' : 'btn-danger'}`,
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/file-maintenance/requesters',
          method: 'PATCH',
          data: {
            id: requesterId,
            status: requesterStatus,
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
  // ============ End Update a Requester ============ //

  // ============ Delete a Requester ============ //
  requestersDatatable.on('click', '.btnDeleteRequester', function () {
    const requesterId = $(this).closest('tr').find('td[data-requester-id]').data('requester-id');
    const requesterName = $(this).closest('tr').find('a.btnViewRequester').text().trim();

    Swal.fire({
      title: 'Delete Record?',
      text: `Are you sure you want to permanently delete the requester "${requesterName}"? This action cannot be undone.`,
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
          url: '/file-maintenance/requesters',
          method: 'DELETE',
          data: { id: requesterId },
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
  // ============ End Delete a Requester ============ //
});
