$(document).ready(function () {
  const consumableDatatable = $('#consumableOverviewDatatable').DataTable();
  // ============ Create a Item Consumable ============ //
  const consumableAddModal = $('#addConsumableModal');
  const consumableAddForm = $('#frmAddConsumable');
  const consumableAddSaveBtn = $('#btnAddSaveConsumable');

  handleUnsavedChanges(consumableAddModal, consumableAddForm, consumableAddSaveBtn);

  consumableAddForm.on('submit', function (e) {
    e.preventDefault();

    const addFormData = new FormData(consumableAddForm[0]);

    $.ajax({
      url: '/properties-assets/consumable',
      method: 'POST',
      data: addFormData,
      dataType: 'json',
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success',consumableAddModal, consumableAddForm);
        } else {
          toggleButtonState(consumableAddSaveBtn, false);
          if (response.errors.consumableName) {
            $('#txtConsumableName').addClass('is-invalid');
            $('#valAddConsumable').text(response.errors.consumableName[0]);
          }
          if (response.errors.consumableDesc) {
            $('#txtConsumableDesc').addClass('is-invalid');
            $('#valAddConsumableDesc').text(response.errors.consumableDesc[0]);
          }
          if (response.errors.unitType) {
            $("#cbxUnitType").next(".ts-wrapper").addClass("is-invalid");
            $("#valAddUnitType").text(response.errors.unitType[0]);
          }
          if (response.errors.consumableQuantity) {
            $('#txtConsumableQuantity').addClass('is-invalid');
            $('#valAddConsumableQty').text(response.errors.consumableQuantity[0]);
          }
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', consumableAddModal, consumableAddForm);
      },
    });
  });
  // ============ End Create a Item Consumable ============ //

  // ============ Edit a Item Consumable ============ //
  const consumableEditModal = $('#editConsumableModal');

  consumableDatatable.on('click', '.btnEditConsumable', function () {
    const consumeId = $(this).closest('tr').find('td[data-consumable-id]').data('consumable-id');

    $.ajax({
      url: '/properties-assets/consumable/edit',
      method: 'GET',
      data: { id: consumeId },
      success: function (response) {
        consumableEditModal.modal('toggle');

        $('#txtEditConsumableId').val(response.id);
        $('#txtEditConsumableName').val(response.consumableName);
        $('#txtEditConsumableDesc').val(response.consumableDesc);
        $('#cbxEditUnitType')[0].tomselect.setValue(response.unitType);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit a Item Consumable ============ //

  // ============ Update a Item Consumable ============ //
  const consumableEditForm = $('#frmEditConsumable');
  const consumableEditSaveBtn = $('#btnEditSaveConsumable');

  handleUnsavedChanges(consumableEditModal, consumableEditForm, consumableEditSaveBtn);

  consumableEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(consumableEditSaveBtn, true);

    const editFormData = new FormData(consumableEditForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('id', $('#txtEditConsumableId').val());
    editFormData.append('consumableName', $('#txtEditConsumableName').val());
    editFormData.append('consumableDesc', $('#txtEditConsumableDesc').val());
    editFormData.append('unitType', $('#cbxEditUnitType').val());

    $.ajax({
      url: '/properties-assets/consumable',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', consumableEditModal, consumableEditForm);
        } else {
          toggleButtonState(consumableEditSaveBtn, false);
          if (response.errors.consumableName) {
            $('#txtEditConsumableName').addClass('is-invalid');
            $('#valEditConsumableName').text(response.errors.consumableName[0]);
          }
          if (response.errors.consumableDesc) {
            $('#txtEditConsumableDesc').addClass('is-invalid');
            $('#valEditConsumableDesc').text(response.errors.consumableDesc[0]);
          }
          if (response.errors.unitType) {
            $("#cbxEditUnitType").next(".ts-wrapper").addClass("is-invalid");
            $("#valEditUnitType").text(response.errors.unitType[0]);
          }
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', consumableEditModal, consumableEditForm);
      },
    });
  });

  consumableDatatable.on('click', '.btnStatusConsumable', function () {
    const consumeId = $(this).closest('tr').find('td[data-consumable-id]').data('consumable-id');
    const consumableSetStatus = $(this).data('status');
    let statusName;

    if (consumableSetStatus === 1) {
      statusName = 'active';
    } else {
      statusName = 'inactive';
    }

    Swal.fire({
      title: 'Change status?',
      text: 'Are you sure you want to set it to ' + statusName + '?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, set it to ' + statusName + '!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/properties-assets/consumable",
          method: 'PATCH',
          data: {
            id: consumeId,
            status: consumableSetStatus,
          },
          success: function (response) {
            showResponseAlert(response, 'success');
          },
          error: function (response) {
            showResponseAlert(response, 'error');
          },
        });
      }
    });
  });
  // ============ End Update a Item Consumable ============ //
});

document.addEventListener('DOMContentLoaded', function() {

  new TomSelect('#cbxUnitType', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
  });

  new TomSelect('#cbxEditUnitType', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    dropdownParent: 'body',
  });

  document.querySelectorAll('.tom-select input[type="text"]').forEach(function(input) {
    input.addEventListener('keydown', function(event) {
      event.preventDefault();
    });
  });
});
