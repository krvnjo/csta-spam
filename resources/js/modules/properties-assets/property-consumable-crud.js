$(document).ready(function () {
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

});

document.addEventListener('DOMContentLoaded', function() {

  new TomSelect('#cbxUnitType', {
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
