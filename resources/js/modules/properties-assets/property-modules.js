$(document).ready(function () {
  const propertyDatatable = $("#propertyOverviewDatatable");

// Create a Property
  const propertyAddModal = $("#addPropertyModal");
  const propertyAddForm = $("#frmAddProperty");
  const propertyAddName = $("#txtPropertyName");
  const propertyAddSerial = $("#txtSerialNumber");
  const propertyAddCategory = $("#cbxCategory");
  const propertyAddBrand = $("#cbxBrand");
  const propertyAddQty = $("#txtQuantity");
  const propertyAddDesc = $("#txtDescription");
  const propertyAddAcquired = $("#cbxAcquiredType");
  const propertyAddDateAcq = $("#dtpAcquired");
  const propertyAddCondition = $("#cbxCondition");
  const propertyAddWarranty = $("#dtpWarranty");
  const propertyAddRemarks = $("#txtRemarks");
  const propertyAddImage = $("#propertyDropzone");

  const propAddNameValid = $("#valAddName");
  const propAddSerialValid = $("#valAddSerial");
  const propAddCategoryValid = $("#valAddCategory");
  const propAddBrandValid = $("#valAddBrand");
  const propAddQtyValid = $("#valAddQty");
  const propAddDescValid = $("#valAddDesc");
  const propAddAcquiredValid = $("#valAddAcquired");
  const propAddDtpAcqValid = $("#valAddDtpAcq");
  const propAddConditionValid = $("#valAddCondition");

  propertyAddForm.on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "/properties-assets/overview/create",
      method: "POST",
      data: {
        _token: $("input[name=_token]").val(),
        propertyName: propertyAddName.val(),
        serialNumber: propertyAddSerial.val(),
        category: propertyAddCategory.val(),
        brand: propertyAddBrand.val(),
        quantity: propertyAddQty.val(),
        description: propertyAddDesc.val(),
        acquiredType: propertyAddAcquired.val(),
        acquiredDate: propertyAddDateAcq.val(),
        condition: propertyAddCondition.val(),
        warranty: propertyAddWarranty.val(),
        remarks: propertyAddRemarks.val(),
      },
      success: function (response) {
        if (response.success) {
          // Remove any previous validation errors
          propertyAddName.removeClass("is-invalid");
          propertyAddSerial.removeClass("is-invalid");
          propertyAddCategory.removeClass("is-invalid");
          propertyAddBrand.removeClass("is-invalid");
          propertyAddQty.removeClass("is-invalid");
          propertyAddDesc.removeClass("is-invalid");
          propertyAddAcquired.removeClass("is-invalid");
          propertyAddDateAcq.removeClass("is-invalid");
          propertyAddCondition.removeClass("is-invalid");

          // Show success alert
          showSuccessAlert(response, propertyAddModal, propertyAddForm);
        } else {
          // Validate fields and display errors
          if (response.errors.propertyName) {
            propertyAddName.addClass("is-invalid");
            propAddNameValid.text(response.errors.propertyName[0]);
          }
          if (response.errors.serialNumber) {
            propertyAddSerial.addClass("is-invalid");
            propAddSerialValid.text(response.errors.serialNumber[0]);
          }
          if (response.errors.category) {
            propertyAddCategory.addClass("is-invalid");
            propAddCategoryValid.text(response.errors.category[0]);
          }
          if (response.errors.brand) {
            propertyAddBrand.addClass("is-invalid");
            propAddBrandValid.text(response.errors.brand[0]);
          }
          if (response.errors.quantity) {
            propertyAddQty.addClass("is-invalid");
            propAddQtyValid.text(response.errors.quantity[0]);
          }
          if (response.errors.description) {
            propertyAddDesc.addClass("is-invalid");
            propAddDescValid.text(response.errors.description[0]);
          }
          if (response.errors.acquiredType) {
            propertyAddAcquired.addClass("is-invalid");
            propAddAcquiredValid.text(response.errors.acquiredType[0]);
          }
          if (response.errors.acquiredDate) {
            propertyAddDateAcq.addClass("is-invalid");
            propAddDtpAcqValid.text(response.errors.acquiredDate[0]);
          }
          if (response.errors.condition) {
            propertyAddCondition.addClass("is-invalid");
            propAddConditionValid.text(response.errors.condition[0]);
          }
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
