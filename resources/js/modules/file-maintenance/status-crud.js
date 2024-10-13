$(document).ready(function () {
  const statusesDatatable = $('#statusesDatatable').DataTable();

  // ============ Create a Status ============ //
  const statusAddModal = $('#modalAddStatus');
  const statusAddForm = $('#frmAddStatus');

  handleUnsavedChanges(statusAddModal, statusAddForm, $('#btnAddSaveStatus'));

  statusAddForm.on('submit', function (e) {
    e.preventDefault();

    const addFormData = new FormData(statusAddForm[0]);

    $.ajax({
      url: '/file-maintenance/statuses',
      method: 'POST',
      data: addFormData,
      dataType: 'json',
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, statusAddModal, statusAddForm);
        } else {
          if (response.errors.status) {
            $('#txtAddStatus').addClass('is-invalid');
            $('#valAddStatus').text(response.errors.status[0]);
          }

          if (response.errors.description) {
            $('#txtAddDescription').addClass('is-invalid');
            $('#valAddDescription').text(response.errors.description[0]);
          }

          if (response.errors.color) {
            $('#selAddStatusColor').next('.ts-wrapper').addClass('is-invalid');
            $('#valAddStatusColor').text(response.errors.color[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, statusAddModal, statusAddForm);
      },
    });
  });
  // ============ End Create a Status ============ //

  // ============ View a Status ============ //
  statusesDatatable.on('click', '.btnViewStatus', function () {
    const statusId = $(this).closest('tr').find('td[data-status-id]').data('status-id');

    $.ajax({
      url: '/file-maintenance/statuses/show',
      method: 'GET',
      data: { id: statusId },
      success: function (response) {
        $('#modalViewStatus').modal('toggle');

        $('#lblViewStatusName')
          .text(response.statusname)
          .attr('class', response.color + ' fs-6');
        $('#lblViewDescription').text(response.description);

        const statusStatus =
          response.status === 1
            ? `<span class="badge bg-soft-success text-success justif"><span class="legend-indicator bg-success"></span>Active</span>`
            : `<span class="badge bg-soft-danger text-danger"><span class="legend-indicator bg-danger"></span>Inactive</span>`;

        $('#lblViewStatus').html(statusStatus);
        $('#lblViewDateCreated').text(response.created);
        $('#lblViewDateUpdated').text(response.updated);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End View a Status ============ //

  // ============ Update a Status ============ //
  const statusEditModal = $('#modalEditStatus');
  const statusEditForm = $('#frmEditStatus');

  handleUnsavedChanges(statusEditModal, statusEditForm, $('#btnEditSaveStatus'));

  statusesDatatable.on('click', '.btnEditStatus', function () {
    const statusId = $(this).closest('tr').find('td[data-status-id]').data('status-id');

    $.ajax({
      url: '/file-maintenance/statuses/edit',
      method: 'GET',
      data: { id: statusId },
      success: function (response) {
        statusEditModal.modal('toggle');

        $('#txtEditStatusId').val(response.id);
        $('#txtEditStatus').val(response.status);
        $('#txtEditDescription').val(response.description);
        $('#countCharactersStatusDesc').text(response.description.length + ' / 80');
        $('#selEditStatusColor')[0].tomselect.setValue(response.color);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, statusEditModal, statusEditForm);
      },
    });
  });

  statusEditForm.on('submit', function (e) {
    e.preventDefault();

    const editFormData = new FormData(statusEditForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('id', $('#txtEditStatusId').val());
    editFormData.append('statusname', $('#txtEditStatus').val());
    editFormData.append('description', $('#txtEditDescription').val());
    editFormData.append('color', $('#selEditStatusColor').val());

    $.ajax({
      url: '/file-maintenance/statuses',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, statusEditModal, statusEditForm);
        } else {
          if (response.errors.status) {
            $('#txtEditStatus').addClass('is-invalid');
            $('#valEditStatus').text(response.errors.status[0]);
          }

          if (response.errors.description) {
            $('#txtEditDescription').addClass('is-invalid');
            $('#valEditDescription').text(response.errors.description[0]);
          }

          if (response.errors.color) {
            $('#selEditStatusColor').next('.ts-wrapper').addClass('is-invalid');
            $('#valEditStatusColor').text(response.errors.color[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, statusEditModal, statusEditForm);
      },
    });
  });

  statusesDatatable.on('click', '.btnStatusStatus', function () {
    const statusId = $(this).closest('tr').find('td[data-status-id]').data('status-id');
    const statusSetStatus = $(this).data('status');
    let statusName;

    if (statusSetStatus === 1) {
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
          url: '/file-maintenance/statuses',
          method: 'PATCH',
          data: {
            id: statusId,
            status: statusSetStatus,
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
  // ============ End Update a Status ============ //

  // ============ Delete a Status ============ //
  statusesDatatable.on('click', '.btnDeleteStatus', function () {
    const statusId = $(this).closest('tr').find('td[data-status-id]').data('status-id');

    Swal.fire({
      title: 'Delete Record?',
      text: 'Are you sure you want to delete the status?',
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
          url: '/file-maintenance/statuses',
          method: 'DELETE',
          data: { id: statusId },
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

  $('#btnMultiDeleteStatus').on('click', function () {
    let checkedCheckboxes = statusesDatatable.rows().nodes().to$().find('input.form-check-input:checked');

    let statusIds = checkedCheckboxes
      .map(function () {
        return $(this).closest('tr').find('[data-status-id]').data('status-id');
      })
      .get();

    Swal.fire({
      title: 'Delete Records?',
      text: 'Are you sure you want to delete all the selected statuses?',
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
          url: '/file-maintenance/statuses',
          method: 'DELETE',
          data: { id: statusIds },
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
  // ============ End Delete a Status ============ //
});
