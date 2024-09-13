$(document).ready(function () {
  const acquisitionDatatable = $("#acquisitionDatatable").DataTable();

  // Create an Acquisition
  const acquisitionAddModal = $("#addAcquisitionModal");
  const acquisitionAddForm = $("#frmAddAcquisition");
  const acquisitionAddText = $("#txtAddAcquisition");
  const acquisitionAddValid = $("#valAddAcquisition");

  handleUnsavedChanges(acquisitionAddModal, acquisitionAddForm);

  acquisitionAddForm.on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "/file-maintenance/acquisitions/create",
      method: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        acquisition: acquisitionAddText.val(),
      },
      success: function (response) {
        if (response.success) {
          acquisitionAddModal.modal("hide");
          showSuccessAlert(response, acquisitionAddModal, acquisitionAddForm);
        } else {
          acquisitionAddText.addClass("is-invalid");
          acquisitionAddValid.text(response.errors.acquisition[0]);
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, acquisitionAddModal, acquisitionAddForm);
      },
    });
  });
  // End Create an Acquisition

  // Edit an Acquisition
  const acquisitionEditModal = $("#editAcquisitionModal");
  const acquisitionEditForm = $("#frmEditAcquisition");
  const acquisitionEditId = $("#txtEditAcquisitionId");
  const acquisitionEditText = $("#txtEditAcquisition");
  const acquisitionEditValid = $("#valEditAcquisition");

  handleUnsavedChanges(acquisitionEditModal, acquisitionEditForm);

  acquisitionDatatable.on("click", "#btnEditAcquisition", function () {
    const acquisitionId = $(this).closest("tr").find("td[data-acquisition-id]").data("acquisition-id");

    $.ajax({
      url: "/file-maintenance/acquisitions/edit",
      method: "GET",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: acquisitionId,
      },
      success: function (response) {
        acquisitionEditModal.modal("toggle");
        acquisitionEditId.val(response.id);
        acquisitionEditText.val(response.name);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, acquisitionAddModal, acquisitionAddForm);
      },
    });
  });
  // End Edit an Acquisition

  // Update an Acquisition
  acquisitionEditForm.on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "/file-maintenance/acquisitions/update",
      method: "PATCH",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: acquisitionEditId.val(),
        acquisition: acquisitionEditText.val(),
      },
      success: function (response) {
        if (response.success) {
          acquisitionAddModal.modal("hide");
          showSuccessAlert(response, acquisitionEditModal, acquisitionEditForm);
        } else {
          acquisitionEditText.addClass("is-invalid");
          acquisitionEditValid.text(response.errors.acquisition[0]);
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, acquisitionAddModal, acquisitionAddForm);
      },
    });
  });

  $(".btnStatusAcquisition").on("click", function () {
    const acquisitionId = $(this).closest("tr").find("td[data-acquisition-id]").data("acquisition-id");
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
          url: "/file-maintenance/acquisitions/update",
          method: "PATCH",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: acquisitionId,
            status: status,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON, acquisitionAddModal, acquisitionAddForm);
          },
        });
      }
    });
  });
  // End Update an Acquisition

  // Delete an Acquisition
  acquisitionDatatable.on("click", "#btnDeleteAcquisition", function () {
    const acquisitionId = $(this).closest("tr").find("td[data-acquisition-id]").data("acquisition-id");

    Swal.fire({
      title: "Delete Record?",
      text: "Are you sure you want to delete the acquisition?",
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
          url: "/file-maintenance/acquisitions/delete",
          method: "DELETE",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: acquisitionId,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON, acquisitionAddModal, acquisitionAddForm);
          },
        });
      }
    });
  });

  $("#btnMultiDeleteAcquisition").on("click", function () {
    let checkedCheckboxes = acquisitionDatatable.rows().nodes().to$().find("input.form-check-input:checked");

    let ids = checkedCheckboxes
      .map(function () {
        return $(this).closest("tr").find("[data-acquisition-id]").data("acquisition-id");
      })
      .get();

    Swal.fire({
      title: "Delete Records?",
      text: "Are you sure you want to delete all the selected acquisitions?",
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
          url: "/file-maintenance/acquisitions/delete",
          method: "DELETE",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: ids,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON, acquisitionAddModal, acquisitionAddForm);
          },
        });
      }
    });
  });
  // End Delete an Acquisition
});
