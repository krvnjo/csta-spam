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

  const propertyDropzone = Dropzone.forElement("#addPropertyDropzone");

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

  // handleUnsavedChanges(propertyAddModal, propertyAddForm);

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

  // ============ Update a Stock Item ============ //
  const propertyEditModal = $("#editPropertyModal");
  const propertyEditForm = $("#frmEditProperty");
  const editDropzone = $("editPropertyDropzone");

  // handleUnsavedChanges(propertyEditModal, propertyEditForm, $("#btnEditSaveDesignation"));

  propertyDatatable.on("click", ".btnEditPropParent", function () {
    const propertyId = $(this).closest("tr").find("td[data-property-id]").data("property-id");

    $.ajax({
      url: "/properties-assets/stocks/edit",
      method: "GET",
      data: { id: propertyId },
      success: function (response) {
        // Replace this entire success function with the following code:
        propertyEditModal.modal("toggle");
        $("#txtEditPropertyId").val(response.id);
        $("#txtEditPropertyName").val(response.name);
        $("#cbxEditCategory")[0].tomselect.setValue(response.subcateg_id);
        $("#cbxEditBrand")[0].tomselect.setValue(response.brand_id);
        $("#txtEditDescription").val(response.description);

        // // Clear existing files in dropzone
        // editDropzone.removeAllFiles();
        //
        // // If there's an image, add it to dropzone
        // if (response.image) {
        //   let mockFile = { name: "Existing Image", size: 12345 };
        //   let imageUrl = '/storage/img-uploads/prop-asset/' + response.image;// Adjust this path if needed
        //   editDropzone.displayExistingFile(mockFile, imageUrl);
        // }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, propertyEditModal, propertyEditForm);
      },
    });
  });

});
