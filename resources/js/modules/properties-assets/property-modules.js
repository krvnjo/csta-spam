$(document).ready(function () {
  const propertyDatatable = $("#propertyOverviewDatatable");

  // Create a Property
  const propertyAddModal = $("#addPropertyModal");
  const propertyAddForm = $("#frmAddProperty");

  const requiredFields = {
    propertyName: $("#txtPropertyName"),
    category: $("#cbxCategory"),
    brand: $("#cbxBrand"),
    quantity: $("#txtQuantity"),
    acquiredType: $("#cbxAcquiredType"),
    acquiredDate: $("#dtpAcquired"),
    condition: $("#cbxCondition")
  };

  const nonRequiredFields = {
    description: $("#txtDescription"),
    warranty: $("#dtpWarranty"),
    remarks: $("#txtRemarks")
  };

  const propertyDropzone = Dropzone.forElement("#propertyDropzone");

  const validationMessages = {
    propertyName: $("#valAddName"),
    category: $("#valAddCategory"),
    brand: $("#valAddBrand"),
    quantity: $("#valAddQty"),
    description: $("#valAddDesc"),
    acquiredType: $("#valAddAcquired"),
    acquiredDate: $("#valAddDtpAcq"),
    condition: $("#valAddCondition"),
    warranty: $("#valAddWarranty")
  };

  handleUnsavedChanges(propertyAddModal, propertyAddForm);

  propertyAddForm.on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData();

    formData.append('_token', $('meta[name="csrf-token"]').attr("content"));

    // Append form fields to FormData
    Object.entries(requiredFields).forEach(([key, field]) => {
      if (field[0].tomselect) {
        formData.append(key, field[0].tomselect.getValue());
      } else {
        formData.append(key, field.val());
      }
    });

    Object.entries(nonRequiredFields).forEach(([key, field]) => formData.append(key, field.val()));

    if (propertyDropzone.files.length > 0) {
      formData.append("propertyImage", propertyDropzone.files[0]);
    }

    $.ajax({
      url: "/properties-assets/stocks/create",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, propertyAddModal, propertyAddForm);
          propertyDropzone.removeAllFiles();
        } else {
          Object.keys(response.errors).forEach(function(fieldName) {
            const field = requiredFields[fieldName] || nonRequiredFields[fieldName];
            const validationMessage = validationMessages[fieldName];

            if (field && validationMessage) {
              field.addClass("is-invalid");

              if (field[0].tomselect) {
                $(field[0].tomselect.wrapper).addClass("is-invalid");
              }

              validationMessage.text(response.errors[fieldName][0]);
            }
          });
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, propertyAddModal, propertyAddForm);
      },
    });
  });
  // End Create a Property
});
