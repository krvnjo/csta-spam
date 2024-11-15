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
  const propertyEditSaveBtn = $('#btnEditSaveProperty');

  handleUnsavedChanges(propertyEditModal, propertyEditForm, propertyEditSaveBtn);

  propertyDatatable.on('click', '.btnEditPropParent', function () {
    const propertyId = $(this).closest('tr').find('td[data-property-id]').data('property-id');

    $.ajax({
      url: '/properties-assets/stocks/edit',
      method: 'GET',
      data: { id: propertyId },
      success: function (response) {
        $('#editPropertyModal').modal('toggle');
        $('#txtEditPropertyId').val(response.id);
        $('#txtEditProperty').val(response.name);
        $('#txtEditDescription').val(response.description);
        $('#txtEditSpecification').val(response.specification);
        $('#txtEditPrice').val(response.purchase_price);
        $('#selEditUnit')[0].tomselect.setValue(response.unit_id);
        $('#txtEditQuantity').val(response.quantity).prop('disabled', true);

        const itemType = response.item_type;

        if (itemType === 'consumable') {
          $('#selEditType').val('consumable').prop('disabled', true);
          $('#nonConsumableFields').hide();

          $('#txtEditResidual').val('');
          $('#txtEditUseful').val('');
          $('#selEditCategory')[0].tomselect.clear();
          $('#selEditBrand')[0].tomselect.clear();
        } else {
          $('#selEditType').val('non-consumable').prop('disabled', true);
          $('#nonConsumableFields').show();

          $('#txtEditResidual').val(response.residual_value);
          $('#txtEditUseful').val(response.useful_life);
          $('#selEditCategory')[0].tomselect.setValue(response.categ_id);
          $('#selEditBrand')[0].tomselect.setValue(response.brand_id);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });

  const propertyDropzoneEdit = Dropzone.forElement('#editPropertyDropzone');

  propertyEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(propertyEditSaveBtn, true);

    const editFormData = new FormData(propertyEditForm[0]);

    if (propertyDropzoneEdit.files.length > 0) {
      editFormData.append("image", propertyDropzoneEdit.files[0]);
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
          handleValidationErrors(response, 'Edit');
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
        $('#lblViewSpecification').text(response.specification);
        $('#lblViewUnit').text(response.unit);
        $('#lblViewPrice').text(response.purchasePrice);
        $('#lblViewResidualValue').text(response.residualValue);
        $('#lblViewUsefulLife').text(response.usefulLife);
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

  new TomSelect('#selEditUnit', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
  });

  new TomSelect('#selEditCategory', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
  });

  new TomSelect('#selEditBrand', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
  });

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
    render: {
      option: (item, escape) => {
        return `
        <div class="d-flex align-items-start">
          <div class="flex-grow-1 ms-2">
            <span class="d-block fw-semibold">${item.name || 'Select Condition...'}</span>
            <span class="d-block small">${item.description || 'Select Condition...'}</span>
          </div>
        </div>
      `;
      },
      placeholder: (data) => {
        return 'Select Condition...';
      }
    }
  });

  const tomSelectAcquiredType = new TomSelect('#cbxAcquiredType', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
    onChange: function (value) {
      const warrantyDateInput = document.getElementById('dtpWarranty');
      const priceInput = document.getElementById('txtPurchasePrice');
      const residualValueInput = document.getElementById('txtResidualValue');
      const usefulLifeInput = document.getElementById('txtUsefulLife');
      const PURCHASED_ID = '1';
      const DONATION_ID = '2';

      if (value === DONATION_ID) {
        warrantyDateInput.disabled = true;
        warrantyDateInput.value = '';
        warrantyDateInput.classList.add('bg-light');
        priceInput.disabled = true;
        priceInput.value = '';
        priceInput.classList.add('bg-light');
        residualValueInput.disabled = true;
        residualValueInput.value = '';
        residualValueInput.classList.add('bg-light');
        usefulLifeInput.disabled = true;
        usefulLifeInput.value = '';
        usefulLifeInput.classList.add('bg-light');
      } else if (value === PURCHASED_ID) {
        warrantyDateInput.disabled = false;
        warrantyDateInput.classList.remove('bg-light');
        priceInput.disabled = false;
        priceInput.classList.remove('bg-light');
        residualValueInput.disabled = false;
        residualValueInput.classList.remove('bg-light');
        usefulLifeInput.disabled = false;
        usefulLifeInput.classList.remove('bg-light');
      }
    },
  });

  function resetNonConsumableFields() {
    const inputs1 = nonConsumableFields1.querySelectorAll('input');
    const inputs2 = nonConsumableFields2.querySelectorAll('input');

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
