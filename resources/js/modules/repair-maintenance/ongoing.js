$(document).ready(function () {
  const ongoingsDatatable = $('#ongoingsDatatable').DataTable();

  // ============ View Ongoing Request ============ //
  ongoingsDatatable.on('click', '.btnViewRequest', function () {
    const ongoingId = $(this).closest('tr').find('td[data-ongoing-id]').data('ongoing-id');

    $.ajax({
      url: '/repair-maintenance/ticket-ongoings/view',
      method: 'GET',
      data: { id: ongoingId },
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

          dropdownFields: [
            {
              key: 'items',
              container: '#dropdownMenuViewItems',
              countSelector: '#lblViewItems',
              label: 'items in this ticket',
            },
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

  // ============ Edit Ticket Request ============ //
  ongoingsDatatable.on('click', '.btnEditRequest', function () {
    const ongoingId = $(this).closest('tr').find('td[data-ongoing-id]').data('ongoing-id');

    $.ajax({
      url: '/repair-maintenance/ticket-ongoings/edit',
      method: 'GET',
      data: { id: ongoingId },
      success: function (response) {
        ongoingEditModal.modal('toggle');
        $('#lblTicketNumber').text(response.num);
        populateEditForm(response);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit Ticket Request ============ //

  // ============ Update a Ticket Request ============ //
  const ongoingEditModal = $('#modalEditRequest');
  const ongoingEditForm = $('#frmEditRequest');
  const ongoingEditSaveBtn = $('#btnEditSaveRequest');

  handleUnsavedChanges(ongoingEditModal, ongoingEditForm, ongoingEditSaveBtn);

  ongoingEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(ongoingEditSaveBtn, true);

    const editFormData = new FormData(ongoingEditForm[0]);

    $.ajax({
      url: '/repair-maintenance/ticket-ongoings',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(ongoingEditSaveBtn, false);
          showResponseAlert(response, 'success', ongoingEditModal, ongoingEditForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(ongoingEditSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', ongoingEditModal, ongoingEditForm);
      },
    });
  });

  ongoingsDatatable.on('click', '.btnSetStatus', function () {
    const ongoingId = $(this).closest('tr').find('td[data-ongoing-id]').data('ongoing-id');
    const ongoingName = $(this).closest('tr').find('.ongoing-name').text().trim();
    const ongoingStatus = $(this).data('status');

    Swal.fire({
      title: 'Mark as complete?',
      text: `Are you sure you want to mark "${ongoingName}" as complete?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: `Yes, mark it as complete!`,
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
          url: '/repair-maintenance/ongoing-maintenance',
          method: 'PATCH',
          data: {
            id: ongoingId,
            status: ongoingStatus,
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
});
