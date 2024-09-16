$(document).ready(function () {
  const statusDatatable = $("#statusDatatable").DataTable();

  // Create a Status
  const statusAddModal = $("#addStatusModal");
  const statusAddForm = $("#frmAddStatus");
  const statusAddText = $("#txtAddStatus");
  const statusAddValid = $("#valAddStatus");
  const statusDescAddText = $("#txtAddStatusDesc");
  const statusDescAddValid = $("#valAddStatusDesc");
  const statusColorAddSel = $("#selAddStatusColor");
  const statusColorAddValid = $("#valAddStatusColor");

  handleUnsavedChanges(statusAddModal, statusAddForm);

  statusAddForm.on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "/file-maintenance/statuses/create",
      method: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        status: statusAddText.val(),
        description: statusDescAddText.val(),
        color: statusColorAddSel.val(),
      },
      success: function (response) {
        if (response.success) {
          statusAddModal.modal("hide");
          showSuccessAlert(response, statusAddModal, statusAddForm);
        } else {
          if (response.errors.status) {
            statusAddText.addClass("is-invalid");
            statusAddValid.text(response.errors.status[0]);
          }

          if (response.errors.description) {
            statusDescAddText.addClass("is-invalid");
            statusDescAddValid.text(response.errors.description[0]);
          }

          if (response.errors.color) {
            statusColorAddSel.addClass("is-invalid");
            statusColorAddValid.text(response.errors.color[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, statusAddModal, statusAddForm);
      },
    });
  });
  // End Create a Status

  // Edit a Status
  const statusEditModal = $("#editStatusModal");
  const statusEditForm = $("#frmEditStatus");
  const statusEditId = $("#txtEditStatusId");
  const statusEditText = $("#txtEditStatus");
  const statusEditValid = $("#valEditStatus");
  const statusDescEditText = $("#txtEditStatusDesc");
  const statusDescEditValid = $("#valEditStatusDesc");
  const statusColorEditSel = $("#selEditStatusColor");
  const statusColorEditValid = $("#valEditStatusColor");

  handleUnsavedChanges(statusEditModal, statusEditForm);

  statusDatatable.on("click", "#btnEditStatus", function () {
    const statusId = $(this).closest("tr").find("td[data-status-id]").data("status-id");

    $.ajax({
      url: "/file-maintenance/statuses/edit",
      method: "GET",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: statusId,
      },
      success: function (response) {
        statusEditModal.modal("toggle");
        statusEditId.val(response.id);
        statusEditText.val(response.name);
        statusDescEditText.val(response.description);
        statusColorEditSel[0].tomselect.setValue(response.color_id);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, statusAddModal, statusAddForm);
      },
    });
  });
  // End Edit a Status

  // Update a Status
  statusEditForm.on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "/file-maintenance/statuses/update",
      method: "PATCH",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: statusEditId.val(),
        status: statusEditText.val(),
        description: statusDescEditText.val(),
        color: statusColorEditSel.val(),
      },
      success: function (response) {
        if (response.success) {
          statusEditModal.modal("hide");
          showSuccessAlert(response, statusEditModal, statusEditForm);
        } else {
          if (response.errors.status) {
            statusEditText.addClass("is-invalid");
            statusEditValid.text(response.errors.status[0]);
          }

          if (response.errors.description) {
            statusDescEditText.addClass("is-invalid");
            statusDescEditValid.text(response.errors.description[0]);
          }

          if (response.errors.color) {
            statusColorEditSel.addClass("is-invalid");
            statusColorEditValid.text(response.errors.color[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, statusAddModal, statusAddForm);
      },
    });
  });

  $(".btnStatusStatus").on("click", function () {
    const statusId = $(this).closest("tr").find("td[data-status-id]").data("status-id");
    const status = $(this).data("status");
    let statusName;

    if (status === 1) {
      statusName = "active";
    } else {
      statusName = "inactive";
    }

    Swal.fire({
      title: "Change status?",
      text: "Are you sure you want to set it to " + statusName + "?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, set it to " + statusName + "!",
      cancelButtonText: "No, cancel!",
      customClass: {
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-secondary",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/statuses/update",
          method: "PATCH",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: statusId,
            statuses: status,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON, statusAddModal, statusAddForm);
          },
        });
      }
    });
  });
  // End Update a Status

  // Delete a Status
  statusDatatable.on("click", "#btnDeleteStatus", function () {
    const statusId = $(this).closest("tr").find("td[data-status-id]").data("status-id");

    Swal.fire({
      title: "Delete Record?",
      text: "Are you sure you want to delete the status?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      customClass: {
        confirmButton: "btn btn-danger",
        cancelButton: "btn btn-secondary",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/statuses/delete",
          method: "DELETE",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: statusId,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON, statusAddModal, statusAddForm);
          },
        });
      }
    });
  });

  $("#btnMultiDeleteStatus").on("click", function () {
    let checkedCheckboxes = statusDatatable.rows().nodes().to$().find("input.form-check-input:checked");

    let ids = checkedCheckboxes
      .map(function () {
        return $(this).closest("tr").find("[data-status-id]").data("status-id");
      })
      .get();

    Swal.fire({
      title: "Delete Records?",
      text: "Are you sure you want to delete all the selected statuses?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      customClass: {
        confirmButton: "btn btn-danger",
        cancelButton: "btn btn-secondary",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/statuses/delete",
          method: "DELETE",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: ids,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON, statusAddModal, statusAddForm);
          },
        });
      }
    });
  });
  // End Delete a Status
});
