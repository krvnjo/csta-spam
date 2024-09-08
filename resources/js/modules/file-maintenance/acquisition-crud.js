$(document).ready(function () {
  const acquisitionDatatable = $("#acquisitionDatatable");

  // Store an Acquisition
  $("#frmAddAcquisition").on("submit", function (event) {
    event.preventDefault();

    const addAcquisitionFormElements = {
      form: $(this),
      acquisition: $("#txtAddAcquisition"),
      acquisitionValidation: $("#acquisitionValidation"),
    };

    const addAcquisitionFormData = {
      _token: $("input[name=_token]").val(),
      acquisition: addAcquisitionFormElements.acquisition.val(),
    };

    $.ajax({
      url: "/file-maintenance/acquisitions",
      method: "post",
      data: addAcquisitionFormData,
      success: function (response) {
        if (response.success) {
          addAcquisitionFormElements.acquisition.val("");
          $("#addAcquisitionModal").modal("hide");
          Swal.fire({
            title: "Added Successfully!",
            text: "Acquisition has been added.",
            icon: "success",
            confirmButtonText: "OK",
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        } else {
          if (response.errors.acquisition) {
            addAcquisitionFormElements.acquisition.addClass("is-invalid");
            addAcquisitionFormElements.acquisitionValidation.text(response.errors.acquisition[0]);
          }
        }
      },
      error: function () {
        Swal.fire("Oops! An error has occurred!", "There's an error while adding the acquisition. Please try again.", "error").then((r) => {});
      },
    });
  });
});
