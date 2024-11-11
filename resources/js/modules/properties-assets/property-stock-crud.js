$(document).ready(function () {
  const propertyDatatable = $('#propertyOverviewDatatable');

  // ============ Add a Stock Item ============ //
  const propertyAddModal = $('#addPropertyModal');
  const propertyAddForm = $('#frmAddProperty');
  const propertyAddSaveBtn = $('#btnAddSaveProperty');

  const baseRequiredFields = {
    propertyName: $('#txtPropertyName'),
    itemType: $('#cbxItemType'),
    specification: $('#txtSpecification'),
    quantity: $('#txtQuantity'),
    unit: $('#cbxUnit'),
    purchasePrice: $('#txtPurchasePrice'),
  };

  const nonConsumableRequiredFields = {
    category: $('#cbxCategory'),
    condition: $('#cbxCondition'),
    brand: $('#cbxBrand'),
    acquiredType: $('#cbxAcquiredType'),
    acquiredDate: $('#dtpAcquired'),
    residualValue: $('#txtResidualValue'),
    usefulLife: $('#txtUsefulLife'),
  };

  const optionalFields = {
    description: $('#txtDescription'),
    warranty: $('#dtpWarranty'),
  };

  const propertyDropzone = Dropzone.forElement('#addPropertyDropzone');

  const validationMessages = {
    propertyName: $('#valAddName'),
    itemType: $('#valAddItemType'),
    specification: $('#valAddSpecification'),
    description: $('#valAddDesc'),
    quantity: $('#valAddQuantity'),
    unit: $('#valAddUnit'),
    purchasePrice: $('#valAddPurchasePrice'),
    residualValue: $('#valAddResidualValue'),
    usefulLife: $('#valAddUsefulLife'),
    category: $('#valAddCategory'),
    condition: $('#valAddCondition'),
    brand: $('#valAddBrand'),
    acquiredType: $('#valAddAcquiredType'),
    acquiredDate: $('#valAddDateAcq'),
    warranty: $('#valAddWarranty'),
    propertyImage: $('#valAddPropertyImage'),
  };

  handleUnsavedChanges(propertyAddModal, propertyAddForm, propertyAddSaveBtn);

  propertyAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(propertyAddSaveBtn, true);

    const formData = new FormData();

    const itemType = baseRequiredFields.itemType.val();
    const requiredFields = { ...baseRequiredFields };

    if (itemType === 'consumable') {
    } else {
      Object.assign(requiredFields, nonConsumableRequiredFields);
    }

    Object.entries(requiredFields).forEach(([key, field]) => {
      field.removeClass('is-invalid');
      if (field[0] && field[0].tomselect) {
        $(field[0].tomselect.wrapper).removeClass('is-invalid');
      }
    });

    Object.entries(optionalFields).forEach(([key, field]) => field.removeClass('is-invalid'));

    Object.entries(requiredFields).forEach(([key, field]) => {
      if (field[0] && field[0].tomselect) {
        formData.append(key, field[0].tomselect.getValue());
      } else {
        formData.append(key, field.val());
      }
    });

    Object.entries(optionalFields).forEach(([key, field]) => formData.append(key, field.val()));

    if (propertyDropzone.files.length > 0) {
      formData.append('propertyImage', propertyDropzone.files[0]);
    }

    $.ajax({
      url: '/properties-assets/stocks/',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', propertyAddModal, propertyAddForm);
          propertyDropzone.removeAllFiles();
        } else {
          toggleButtonState(propertyAddSaveBtn, false);
          Object.keys(response.errors).forEach(function (fieldName) {
            const field = requiredFields[fieldName] || optionalFields[fieldName];
            const validationMessage = validationMessages[fieldName];

            if (field && validationMessage) {
              field.addClass('is-invalid');

              if (field[0] && field[0].tomselect) {
                $(field[0].tomselect.wrapper).addClass('is-invalid');
              }

              validationMessage.text(response.errors[fieldName][0]);
            }
          });
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', propertyAddModal, propertyAddForm);
      },
    });
  });
  // ============ End Add a Stock Item ============ //

  // ============ Update a Stock Item ============ //
  const propertyEditModal = $('#editPropertyModal');
  const propertyEditForm = $('#frmEditProperty');
  const propertyDropzoneEdit = Dropzone.forElement('#editPropertyDropzone');
  const propertyEditSaveBtn = $('#btnEditSaveProperty');

  handleUnsavedChanges(propertyEditModal, propertyEditForm, propertyEditSaveBtn);

  propertyDatatable.on('click', '.btnEditPropParent', function () {
    const propertyId = $(this).closest('tr').find('td[data-property-id]').data('property-id');

    $.ajax({
      url: '/properties-assets/stocks/edit',
      method: 'GET',
      data: { id: propertyId },
      success: function (response) {
        propertyEditModal.modal('toggle');
        $('#txtEditPropertyId').val(response.id);
        $('#txtEditPropertyName').val(response.name);
        $('#cbxEditCategory')[0].tomselect.setValue(response.subcateg_id);
        $('#cbxEditBrand')[0].tomselect.setValue(response.brand_id);
        $('#txtEditDescription').val(response.description);
        $('#txtEditPurchasePrice').val(response.purchase_price);
        $('#txtEditResidualValue').val(response.residual_value);
        $('#txtEditUsefulLife').val(response.useful_life);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });

  propertyEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(propertyEditSaveBtn, true);

    const editFormData = new FormData(propertyEditForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('id', $('#txtEditPropertyId').val());
    editFormData.append('propertyName', $('#txtEditPropertyName').val());
    editFormData.append('category', $('#cbxEditCategory').val());
    editFormData.append('brand', $('#cbxEditBrand').val());
    editFormData.append('description', $('#txtEditDescription').val());
    editFormData.append('purchasePrice', $('#txtEditPurchasePrice').val());
    editFormData.append('residualValue', $('#txtEditResidualValue').val());
    editFormData.append('usefulLife', $('#txtEditUsefulLife').val());

    if (propertyDropzoneEdit.files.length > 0) {
      editFormData.append('image', propertyDropzoneEdit.files[0]);
    }

    $.ajax({
      url: '/properties-assets/stocks/',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', propertyEditModal, propertyEditForm);
        } else {
          toggleButtonState(propertyEditSaveBtn, false);
          if (response.errors.propertyName) {
            $('#txtEditPropertyName').addClass('is-invalid');
            $('#valEditPropertyName').text(response.errors.propertyName[0]);
          }
          if (response.errors.category) {
            $('#cbxEditCategory').next('.ts-wrapper').addClass('is-invalid');
            $('#valEditCategoryName').text(response.errors.category[0]);
          }
          if (response.errors.brand) {
            $('#cbxEditBrand').next('.ts-wrapper').addClass('is-invalid');
            $('#valEditBrandName').text(response.errors.brand[0]);
          }
          if (response.errors.description) {
            $('#txtEditDescription').addClass('is-invalid');
            $('#valEditDescription').text(response.errors.description[0]);
          }
          if (response.errors.purchasePrice) {
            $('#txtEditPurchasePrice').addClass('is-invalid');
            $('#valEditPurchasePrice').text(response.errors.purchasePrice[0]);
          }
          if (response.errors.residualValue) {
            $('#txtEditResidualValue').addClass('is-invalid');
            $('#valEditResidualValue').text(response.errors.residualValue[0]);
          }
          if (response.errors.usefulLife) {
            $('#txtEditUsefulLife').addClass('is-invalid');
            $('#valEditUsefulLife').text(response.errors.usefulLife[0]);
          }
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', propertyEditModal, propertyEditForm);
      },
    });
  });

  // ============ End Update a Stock Item ============ //

  // ============ View a Stock Item ============ //
  propertyDatatable.on('click', '.btnViewProperty', function () {
    const propertyViewId = $(this).closest('tr').find('td[data-property-id]').data('property-id');

    $.ajax({
      url: '/properties-assets/stocks/show',
      method: 'GET',
      data: { id: propertyViewId },
      success: function (response) {
        $('#viewPropertyModal').modal('toggle');

        $('#lblViewItemName').text(response.name);
        $('#lblViewBrand').text(response.brand);
        $('#lblViewCategory').text(response.category);
        $('#lblViewSubCategory').text(response.subcategory);
        $('#lblViewDescription').text(response.description);
        $('#lblViewInStock').text(response.inStock);
        $('#lblViewInventory').text(response.inventory);
        $('#lblViewTotalQty').text(response.quantity);
        $('#lblViewDateAdded').text(response.created);
        $('#lblViewDateUpdated').text(response.updated);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View a Stock Item ============ //
});

document.addEventListener('DOMContentLoaded', function () {
  const itemTypeSelect = document.getElementById('cbxItemType');
  const nonConsumableFields1 = document.getElementById('nonConsumableFields1');
  const nonConsumableFields2 = document.getElementById('nonConsumableFields2');
  const alertContainer = document.getElementById('alertContainer');
  let alertTimeout;

  const tomSelectItemType = new TomSelect('#cbxItemType', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
  });

  const tomSelectUnit = new TomSelect('#cbxUnit', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
  });

  const tomSelectCategory = new TomSelect('#cbxCategory', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
  });

  const tomSelectBrand = new TomSelect('#cbxBrand', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
  });

  const tomSelectCondition = new TomSelect('#cbxCondition', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
  });

  const tomSelectAcquiredType = new TomSelect('#cbxAcquiredType', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
    onChange: function (value) {
      const warrantyDateInput = document.getElementById('dtpWarranty');
      const PURCHASED_ID = '1';
      const DONATION_ID = '2';

      if (value === DONATION_ID) {
        warrantyDateInput.disabled = true;
        warrantyDateInput.value = '';
        warrantyDateInput.classList.add('bg-light');
      } else if (value === PURCHASED_ID) {
        warrantyDateInput.disabled = false;
        warrantyDateInput.classList.remove('bg-light');
      }
    },
  });

  function resetNonConsumableFields() {
    const inputs1 = nonConsumableFields1.querySelectorAll('input');
    const inputs2 = nonConsumableFields2.querySelectorAll('input');

    // Clear all regular inputs
    inputs1.forEach((input) => (input.value = ''));
    inputs2.forEach((input) => (input.value = ''));

    tomSelectCategory.setValue('');
    tomSelectBrand.setValue('');
    tomSelectCondition.setValue('');
    tomSelectAcquiredType.setValue('');
  }

  itemTypeSelect.addEventListener('change', function () {
    clearTimeout(alertTimeout);

    if (this.value === 'non-consumable') {
      nonConsumableFields1.style.display = 'block';
      nonConsumableFields2.style.display = 'block';

      alertContainer.style.display = 'block';
      alertContainer.classList.remove('fade');

      alertTimeout = setTimeout(function () {
        alertContainer.classList.add('fade');
        alertContainer.addEventListener('transitionend', function () {
          alertContainer.style.display = 'none';
          alertContainer.classList.remove('fade');
        });
      }, 5000);

      resetNonConsumableFields();
    } else {
      nonConsumableFields1.style.display = 'none';
      nonConsumableFields2.style.display = 'none';
      alertContainer.style.display = 'none';

      resetNonConsumableFields();
    }
  });
});
