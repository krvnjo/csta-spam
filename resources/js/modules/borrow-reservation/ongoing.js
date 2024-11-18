$(document).ready(function () {
  const ongoingBorrowDatatable = $('#ongoingBorrowDatatable').DataTable();

  // ============ Return a Item ============ //
  const returnItemModal = $('#modalReturnItem');
  const returnItemForm = $('#frmReturnItem');
  const returnItemSaveBtn = $('#btnReturnSaveItem');

  handleUnsavedChanges(returnItemModal, returnItemForm, returnItemSaveBtn);

  ongoingBorrowDatatable.on('click', '.btnReturnItem', function () {
    const borrowId = $(this).closest('tr').find('td[data-borrow-id]').data('borrow-id');

    $.ajax({
      url: '/borrow-reservation/ongoing-borrows/edit',
      method: 'GET',
      data: { id: borrowId },
      success: function (response) {
        returnItemModal.modal('toggle');
        $('#txtReturnItemId').val(response.id);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });

  handleUnsavedChanges(returnItemModal, returnItemForm, returnItemSaveBtn);

  returnItemForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(returnItemSaveBtn, true);

    const editFormData = new FormData(returnItemForm[0]);

    $.ajax({
      url: '/borrow-reservation/ongoing-borrows/',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(returnItemSaveBtn, false);
          showResponseAlert(response, 'success', returnItemModal, returnItemForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(returnItemSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', returnItemModal, returnItemForm);
      },
    });
  });

  // ============ End Return a Item ============ //

});
