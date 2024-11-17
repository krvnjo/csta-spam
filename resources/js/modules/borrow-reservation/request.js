$(document).ready(function () {
  const newRequestsDatatable = $('#newRequestsDatatable').DataTable();

  // ============ Create a Request ============ //
  const requestAddModal = $('#modalAddNewRequest');
  const requestAddForm = $('#frmAddNewRequest');
  const requestAddSaveBtn = $('#btnAddSaveNewRequest');

  handleUnsavedChanges(requestAddModal, requestAddForm, requestAddSaveBtn);

  requestAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(requestAddSaveBtn, true);

    const addFormData = new FormData(requestAddForm[0]);

    $.ajax({
      url: '/borrow-reservation/new-requests',
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

  // ============ End Create a Request ============ //

  // ============ Approve a Request ============ //

  newRequestsDatatable.on('click', '.btnApproveRequest', function () {
    const borrowId = $(this).closest('tr').find('td[data-borrow-id]').data('borrow-id');

    Swal.fire({
      title: 'Approve borrow request?',
      text: `Are you sure you want to approve this borrow request?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: `Yes, approve it!`,
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
          url: '/borrow-reservation/new-requests',
          method: 'PATCH',
          data: {
            id: borrowId,
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

  // ============ End Approve a Request ============ //

  // ============ Release a Request ============ //

  newRequestsDatatable.on('click', '.btnReleaseRequest', function () {
    const borrowId = $(this).closest('tr').find('td[data-borrow-id]').data('borrow-id');

    Swal.fire({
      title: 'Release borrow request?',
      text: `Are you sure you want to release this borrow request?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: `Yes, release it!`,
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
          url: '/borrow-reservation/new-requests/release',
          method: 'PATCH',
          data: {
            id: borrowId,
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

  // ============ End Release a Request ============ //

});
