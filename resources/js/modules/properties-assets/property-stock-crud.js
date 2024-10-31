$(document).ready(function () {
  const propertyDatatable = $("#propertyOverviewDatatable");

  // ============ Add a Stock Item ============ //
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

  handleUnsavedChanges(propertyAddModal, propertyAddForm, $('#btnAddSaveProperty'));

  propertyAddForm.on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData();

    formData.append('_token', $('meta[name="csrf-token"]').attr("content"));

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
      url: "/properties-assets/stocks/",
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
  // ============ End Add a Stock Item ============ //

  // ============ Update a Stock Item ============ //
  const propertyEditModal = $("#editPropertyModal");
  const propertyEditForm = $("#frmEditProperty");
  const propertyDropzoneEdit = Dropzone.forElement("#editPropertyDropzone");

  handleUnsavedChanges(propertyEditModal, propertyEditForm, $("#btnEditSaveProperty"));

  propertyDatatable.on("click", ".btnEditPropParent", function () {
    const propertyId = $(this).closest("tr").find("td[data-property-id]").data("property-id");

    $.ajax({
      url: "/properties-assets/stocks/edit",
      method: "GET",
      data: { id: propertyId },
      success: function (response) {
        propertyEditModal.modal("toggle");
        $("#txtEditPropertyId").val(response.id);
        $("#txtEditPropertyName").val(response.name);
        $("#cbxEditCategory")[0].tomselect.setValue(response.subcateg_id);
        $("#cbxEditBrand")[0].tomselect.setValue(response.brand_id);
        $("#txtEditDescription").val(response.description);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, propertyEditModal, propertyEditForm);
      },
    });
  });

  propertyEditForm.on("submit", function (e) {
    e.preventDefault();

    const editFormData = new FormData(propertyEditForm[0]);

    editFormData.append("_method", "PATCH");
    editFormData.append("id", $("#txtEditPropertyId").val());
    editFormData.append("propertyName", $("#txtEditPropertyName").val());
    editFormData.append("category", $("#cbxEditCategory").val());
    editFormData.append("brand", $("#cbxEditBrand").val());
    editFormData.append("description", $("#txtEditDescription").val());

    if (propertyDropzoneEdit.files.length > 0) {
      editFormData.append("image", propertyDropzoneEdit.files[0]);
    }

    $.ajax({
      url: "/properties-assets/stocks/",
      method: "POST",
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, propertyEditModal, propertyEditForm);
        } else {
          if (response.errors.propertyName) {
            $("#txtEditPropertyName").addClass("is-invalid");
            $("#valEditPropertyName").text(response.errors.propertyName[0]);
          }
          if (response.errors.category) {
            $("#cbxEditCategory").next(".ts-wrapper").addClass("is-invalid");
            $("#valEditCategoryName").text(response.errors.category[0]);
          }
          if (response.errors.brand) {
            $("#cbxEditBrand").next(".ts-wrapper").addClass("is-invalid");
            $("#valEditBrandName").text(response.errors.brand[0]);
          }
          if (response.errors.description) {
            $("#txtEditDescription").addClass("is-invalid");
            $("#valEditDescription").text(response.errors.description[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, propertyEditModal, propertyEditForm);
      },
    });
  });

  // ============ End Update a Stock Item ============ //

  // ============ View a Stock Item ============ //
  propertyDatatable.on("click", ".btnViewProperty", function () {
    const propertyViewId = $(this).closest("tr").find("td[data-property-id]").data("property-id");

    $.ajax({
      url: "/properties-assets/stocks/show",
      method: "GET",
      data: { id: propertyViewId },
      success: function (response) {
        $("#viewPropertyModal").modal("toggle");

        $("#lblViewItemName").text(response.name);
        $("#lblViewBrand").text(response.brand);
        $("#lblViewCategory").text(response.category);
        $("#lblViewSubCategory").text(response.subcategory);
        $("#lblViewDescription").text(response.description);
        $("#lblViewInStock").text(response.inStock);
        $("#lblViewInventory").text(response.inventory);
        $("#lblViewTotalQty").text(response.quantity);
        $("#lblViewDateAdded").text(response.created);
        $("#lblViewDateUpdated").text(response.updated);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End View a Stock Item ============ //

});


document.addEventListener('DOMContentLoaded', function() {
  let categorySelect = new TomSelect('#cbxCategory', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    onChange: function(value) {
      if (value) {
        $.ajax({
          url: subcategoryBrandsUrl,
          type: 'GET',
          data: {
            subcategory_id: value
          },
          success: function(data) {
            brandSelect.clear();
            brandSelect.clearOptions();
            brandSelect.addOption({
              value: '',
              text: 'Select Brand...'
            });
            data.forEach(function(item) {
              brandSelect.addOption({
                value: item.id,
                text: item.name
              });
            });
            brandSelect.refreshOptions();
          }
        });
      } else {
        brandSelect.clear();
        brandSelect.clearOptions();
        brandSelect.addOption({
          value: '',
          text: 'Select Brand...'
        });
        brandSelect.refreshOptions();
      }
    }
  });

  let selectedCategory = categorySelect.getValue();
  console.log(selectedCategory);

  let brandSelect = new TomSelect('#cbxBrand', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true
  });


  new TomSelect('#cbxCondition', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true
  });

  new TomSelect('#propertyDatatableEntries', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true
  });

  new TomSelect('#cbxAcquiredType', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    onChange: function(value) {
      const warrantyDateInput = document.getElementById('dtpWarranty');

      const PURCHASED_ID = "1";
      const DONATION_ID = "2";

      if (value === DONATION_ID) {
        warrantyDateInput.disabled = true;
        warrantyDateInput.value = '';
        warrantyDateInput.classList.add('bg-light');
      } else if (value === PURCHASED_ID) {
        warrantyDateInput.disabled = false;
        warrantyDateInput.classList.remove('bg-light');
      }
    }
  });

  document.querySelectorAll('.tom-select input[type="text"]').forEach(function(input) {
    input.addEventListener('keydown', function(event) {
      event.preventDefault();
    });
  });
});
