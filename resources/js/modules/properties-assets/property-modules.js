$(document).ready(function () {
  const propertyDatatable = $("#propertyOverviewDatatable");

  // Create a Property
  const propertyAddModal = $("#addPropertyModal");
  const propertyAddForm = $("#frmAddProperty");

  // Required fields
  const requiredFields = {
    propertyName: $("#txtPropertyName"),
    category: $("#cbxCategory"),
    brand: $("#cbxBrand"),
    quantity: $("#txtQuantity"),
    acquiredType: $("#cbxAcquiredType"),
    acquiredDate: $("#dtpAcquired"),
    condition: $("#cbxCondition")
  };

  // Non-required fields
  const nonRequiredFields = {
    description: $("#txtDescription"),
    warranty: $("#dtpWarranty"),
    remarks: $("#txtRemarks")
  };

  // Dropzone instance
  const propertyDropzone = Dropzone.forElement("#propertyDropzone");

  // Validation message elements
  const validationMessages = {
    propertyName: $("#valAddName"),
    category: $("#valAddCategory"),
    brand: $("#valAddBrand"),
    quantity: $("#valAddQty"),
    description: $("#valAddDesc"),
    acquiredType: $("#valAddAcquired"),
    acquiredDate: $("#valAddDtpAcq"),
    condition: $("#valAddCondition")
  };

  // Function to clear validation errors
  function clearValidationErrors() {
    propertyAddForm.find(".is-invalid").removeClass("is-invalid");
    propertyAddForm.find(".tom-select-invalid").removeClass("tom-select-invalid");
    Object.values(validationMessages).forEach(el => el.text(""));
  }

  // Function to check if a field has been modified
  function isFieldModified(field) {
    return field.data('modified') === true;
  }

  // Mark fields as modified when they change
  propertyAddForm.find("input, select, textarea").on("input change", function() {
    $(this).data('modified', true);
    $(this).removeClass("is-invalid");
    const fieldName = $(this).attr('name');
    if (validationMessages[fieldName]) {
      validationMessages[fieldName].text("");
    }
  });

  // Special handling for tom-select dropdowns
  [requiredFields.category, requiredFields.brand, requiredFields.acquiredType, requiredFields.condition].forEach(function(select) {
    if (select[0].tomselect) {
      select[0].tomselect.on('change', function() {
        select.data('modified', true);
        select.removeClass("is-invalid");
        select[0].tomselect.wrapper.classList.remove("tom-select-invalid");
        const fieldName = select.attr('name');
        if (validationMessages[fieldName]) {
          validationMessages[fieldName].text("");
        }
      });
    }
  });

  // Special handling for date inputs
  [requiredFields.acquiredDate, nonRequiredFields.warranty].forEach(function(dateInput) {
    dateInput.on('changeDate', function() {
      dateInput.data('modified', true);
      dateInput.removeClass("is-invalid");
      const fieldName = dateInput.attr('name');
      if (validationMessages[fieldName]) {
        validationMessages[fieldName].text("");
      }
    });
  });

  propertyAddForm.on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData();

    formData.append('_token', $('meta[name="csrf-token"]').attr("content"));

    // Append form fields to FormData
    Object.entries(requiredFields).forEach(([key, field]) => {
      // Check if the field is a tom-select dropdown
      if (field[0].tomselect) {
        // Use tom-select's getValue() method to get the selected value
        formData.append(key, field[0].tomselect.getValue());
      } else {
        // Otherwise, use the usual .val() method for other input types
        formData.append(key, field.val());
      }
    });

    Object.entries(nonRequiredFields).forEach(([key, field]) => formData.append(key, field.val()));

    // Append the file if it exists in Dropzone
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
          clearValidationErrors();
          showSuccessAlert(response, propertyAddModal, propertyAddForm);
          propertyDropzone.removeAllFiles();
        } else {
          Object.keys(response.errors).forEach(function(fieldName) {
            const field = requiredFields[fieldName] || nonRequiredFields[fieldName];
            const validationMessage = validationMessages[fieldName];

            if (field && validationMessage) {
              // Always show error for required fields, regardless of modification status
              if (requiredFields[fieldName] || isFieldModified(field)) {
                field.addClass("is-invalid");
                // Special handling for tom-select dropdowns
                if (field[0].tomselect) {
                  field[0].tomselect.wrapper.classList.add("tom-select-invalid");
                }
                validationMessage.text(response.errors[fieldName][0]);
              }
            }
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        showErrorAlert(
          "An unexpected error occurred when adding the record. Please try again later.",
          jqXHR,
          textStatus,
          errorThrown,
          propertyAddModal,
          propertyAddForm,
        );
      },
    });
  });
  // End Create a Property
});
