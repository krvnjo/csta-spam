$(document).ready(function () {
  const requestsDatatable = $('#requestsDatatable').DataTable();

  // ============ Create a Ticket Request ============ //
  const requestAddModal = $('#modalAddRequest');
  const requestAddForm = $('#frmAddRequest');
  const requestAddSaveBtn = $('#btnAddSaveRequest');

  handleUnsavedChanges(requestAddModal, requestAddForm, requestAddSaveBtn);

  requestAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(requestAddSaveBtn, true);

    const addFormData = new FormData(requestAddForm[0]);

    $.ajax({
      url: '/repair-maintenance/ticket-requests',
      method: 'POST',
      data: addFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(requestAddSaveBtn, false);
          showResponseAlert(response, 'success', requestAddModal, requestAddForm);
        } else {
          handleValidationErrors(response, 'Add');
          toggleButtonState(requestAddSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', requestAddModal, requestAddForm);
      },
    });
  });
  // ============ End Create a Ticket Request ============ //

  // ============ View Ticket Request ============ //
  requestsDatatable.on('click', '.btnViewRequest', function () {
    const requestId = $(this).closest('tr').find('td[data-request-id]').data('request-id');

    $.ajax({
      url: '/repair-maintenance/ticket-requests/view',
      method: 'GET',
      data: { id: requestId },
      success: function (response) {
        $('#modalViewRequest').modal('toggle');

        const userConfig = {
          textFields: [
            { key: 'num', selector: '#lblViewNum' },
            { key: 'ticket', selector: '#lblViewTicket' },
            { key: 'description', selector: '#lblViewDescription' },
            { key: 'cost', selector: '#lblViewCost' },
            { key: 'created_by', selector: '#lblViewCreatedBy' },
            { key: 'updated_by', selector: '#lblViewUpdatedBy' },
            { key: 'created_at', selector: '#lblViewCreatedAt' },
            { key: 'updated_at', selector: '#lblViewUpdatedAt' },
          ],

          priorityFields: { key: 'priority', selector: '#lblViewPriority' },
          progressFields: { key: 'progress', selector: '#lblViewProgress' },

          imageFields: [
            { key: 'image', selector: '#imgViewUser' },
            { key: 'created_img', selector: '#imgViewCreatedBy' },
            { key: 'updated_img', selector: '#imgViewUpdatedBy' },
          ],
        };

        displayViewResponseData(response, userConfig);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View Ticket Request ============ //

  // // ============ Edit a User ============ //
  // usersDatatable.on('click', '.btnEditUser', function () {
  //   const userId = $(this).closest('tr').find('td[data-user-id]').data('user-id');
  //
  //   $.ajax({
  //     url: '/user-management/users/edit',
  //     method: 'GET',
  //     data: { id: userId },
  //     success: function (response) {
  //       userEditModal.modal('toggle');
  //
  //       if (response.auth) {
  //         $('#userEditRoleContainer').hide();
  //       } else {
  //         $('#userEditRoleContainer').show();
  //       }
  //
  //       populateEditForm(response);
  //     },
  //     error: function (response) {
  //       showResponseAlert(response, 'error');
  //     },
  //   });
  // });
  // // ============ End Edit a User ============ //
  //
  // // ============ Update a User ============ //
  // const userEditModal = $('#modalEditUser');
  // const userEditForm = $('#frmEditUser');
  // const userEditSaveBtn = $('#btnEditSaveUser');
  //
  // handleUnsavedChanges(userEditModal, userEditForm, userEditSaveBtn);
  //
  // userEditForm.on('submit', function (e) {
  //   e.preventDefault();
  //   toggleButtonState(userEditSaveBtn, true);
  //
  //   const editFormData = new FormData(userEditForm[0]);
  //
  //   $.ajax({
  //     url: '/user-management/users',
  //     method: 'POST',
  //     data: editFormData,
  //     processData: false,
  //     contentType: false,
  //     success: function (response) {
  //       if (response.success) {
  //         toggleButtonState(userEditSaveBtn, false);
  //         showResponseAlert(response, 'success', userEditModal, userEditForm);
  //       } else {
  //         handleValidationErrors(response, 'Edit');
  //         toggleButtonState(userEditSaveBtn, false);
  //       }
  //     },
  //     error: function (response) {
  //       showResponseAlert(response, 'error', userEditModal, userEditForm);
  //     },
  //   });
  // });

  requestsDatatable.on('click', '.btnSetStatus', function () {
    const requestId = $(this).closest('tr').find('td[data-request-id]').data('request-id');
    const requestStatus = $(this).data('status');

    Swal.fire({
      title: 'Approve the Ticket Request?',
      text: `Are you sure you want to approve the request?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: `Yes, set I approve it!`,
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'text-dark fs-1',
        htmlContainer: 'text-body text-center fs-4',
        confirmButton: `btn btn-sm btn-success`,
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/repair-maintenance/ticket-requests',
          method: 'PATCH',
          data: {
            id: requestId,
            status: requestStatus,
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
  // ============ End Update Ticket Request ============ //

  // ============ Delete a User ============ //
  requestsDatatable.on('click', '.btnDeleteRequest', function () {
    const requestId = $(this).closest('tr').find('td[data-request-id]').data('request-id');
    const requestName = $(this).closest('tr').find('.request-name').text().trim();

    Swal.fire({
      title: 'Delete Record?',
      text: `Are you sure you want to delete the ticket request "${requestName}"? This action cannot be undone.`,
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
          url: '/repair-maintenance/ticket-requests',
          method: 'DELETE',
          data: { id: requestId },
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
  // ============ End Delete a User ============ //
});
