$(document).ready(function () {
  const acquisitionDatatable = $("#acquisitionDatatable");

  // Create an Acquisition
  const acquisitionAddModal = $("#addAcquisitionModal");
  const acquisitionAddForm = $("#frmAddAcquisition");
  const acquisitionAddText = $("#txtAddAcquisition");
  const acquisitionAddValid = $("#valAddAcquisition");

  let unsavedChanges = false;

  acquisitionAddForm.on("input change", function () {
    unsavedChanges = true;
  });

  acquisitionAddModal.on("hide.bs.modal", function (e) {
    if (unsavedChanges) {
      e.preventDefault();
      Swal.fire({
        title: "Unsaved Changes!",
        text: "You have unsaved changes. Are you sure you want to close the modal?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, close it!",
        cancelButtonText: "No, keep editing",
      }).then((result) => {
        if (result.isConfirmed) {
          unsavedChanges = false;
          acquisitionAddText.removeClass("is-invalid");
          acquisitionAddForm[0].reset();
          acquisitionAddModal.modal("hide");
        }
      });
    }
  });

  acquisitionAddForm.on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "/file-maintenance/acquisitions/create",
      method: "POST",
      data: {
        acquisition: acquisitionAddText.val(),
        _token: $("input[name=_token]").val(),
      },
      success: function (response) {
        if (response.success) {
          unsavedChanges = false;
          acquisitionAddText.removeClass("is-invalid");
          showSuccessAlert(response, acquisitionAddModal, acquisitionAddForm);
        } else {
          acquisitionAddText.addClass("is-invalid");
          acquisitionAddValid.text(response.errors.acquisition[0]);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        showErrorAlert(
          "An unexpected error occurred when adding the record. Please try again later.",
          jqXHR,
          textStatus,
          errorThrown,
          acquisitionAddModal,
          acquisitionAddForm,
        );
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

  acquisitionDatatable.on("click", "#btnEditAcquisition", function () {
    const acquisitionId = $(this).closest("tr").find("td[data-acquisition-id]").data("acquisition-id");

    $.ajax({
      url: "/file-maintenance/acquisitions/edit/" + acquisitionId,
      method: "GET",
      dataType: "json",
      success: function (response) {
        acquisitionEditModal.modal("toggle");
        acquisitionEditId.val(response.id);
        acquisitionEditText.val(response.name);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        showErrorAlert(
          "An unexpected error occurred when editing the record. Please try again later.",
          jqXHR,
          textStatus,
          errorThrown,
          acquisitionAddModal,
          acquisitionAddForm,
        );
      },
    });
  });
  // End Edit an Acquisition

  // Update an Acquisition
  acquisitionEditForm.on("input change", function () {
    unsavedChanges = true;
  });

  acquisitionEditModal.on("hide.bs.modal", function (e) {
    if (unsavedChanges) {
      e.preventDefault();
      Swal.fire({
        title: "Unsaved Changes!",
        text: "You have unsaved changes. Are you sure you want to close the modal?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, close it!",
        cancelButtonText: "No, keep editing",
      }).then((result) => {
        if (result.isConfirmed) {
          unsavedChanges = false;
          acquisitionEditValid.removeClass("is-invalid");
          acquisitionEditModal.modal("hide");
        }
      });
    }
  });

  acquisitionEditForm.on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "/file-maintenance/acquisitions/update/" + acquisitionEditId.val(),
      method: "PATCH",
      data: {
        id: acquisitionEditId.val(),
        acquisition: acquisitionEditText.val(),
        _token: $("input[name=_token]").val(),
      },
      success: function (response) {
        if (response.success) {
          unsavedChanges = false;
          acquisitionEditText.removeClass("is-invalid");
          showSuccessAlert(response, acquisitionEditModal, acquisitionEditForm);
        } else {
          acquisitionEditText.addClass("is-invalid");
          acquisitionEditValid.text(response.errors.acquisition[0]);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        showErrorAlert(
          "An unexpected error occurred when editing the record. Please try again later.",
          jqXHR,
          textStatus,
          errorThrown,
          acquisitionEditModal,
          acquisitionEditForm,
        );
      },
    });
  });
  // End Update an Acquisition

  $(".btnStatusAcquisition").on("click", function () {
    const acquisitionId = $(this).closest("tr").find("td[data-acquisition-id]").data("acquisition-id");
    const status = $(this).data("status");

    Swal.fire({
      title: "Set to Inactive?",
      text: "Are you sure you want to set it to inactive?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/acquisitions/update/" + acquisitionId,
          method: "PATCH",
          data: {
            status: status,
            _token: $("input[name=_token]").val(),
          },
          dataType: "json",
          success: function () {
            Swal.fire({
              title: "Deleted Successfully!",
              text: "Acquisition has been deleted.",
              icon: "success",
              confirmButtonText: "OK",
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
            });
          },
          error: function (jqXHR, textStatus, errorThrown) {
            showErrorAlert(
              "An unexpected error occurred when deleting the record. Please try again later.",
              jqXHR,
              textStatus,
              errorThrown,
              acquisitionEditModal,
              acquisitionEditForm,
            );
          },
        });
      }
    });
  });

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
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/acquisitions/delete/" + acquisitionId,
          method: "DELETE",
          data: { _token: $("input[name=_token]").val() },
          dataType: "json",
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            showErrorAlert(
              "An unexpected error occurred when deleting the record. Please try again later.",
              jqXHR,
              textStatus,
              errorThrown,
              acquisitionEditModal,
              acquisitionEditForm,
            );
          },
        });
      }
    });
  });
  // End Delete an Acquisition
});
