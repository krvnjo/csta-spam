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

  // ============ Delete a Item Consumable ============ //
  consumableDatatable.on('click', '.btnDeleteConsumable', function () {
    const consumeDelId = $(this).data('consume-del-id');

    Swal.fire({
      title: 'Delete Record?',
      text: 'Are you sure you want to delete the item?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'fs-1',
        htmlContainer: 'text-muted text-center fs-4',
        confirmButton: 'btn btn-sm btn-danger',
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/properties-assets/consumable",
          method: 'DELETE',
          data: { id: [consumeDelId] },
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

  $('#btnMultiDeleteConsumable').on('click', function () {
    let checkedCheckboxes = consumableDatatable.rows().nodes().to$().find('input.form-check-input:checked');

    let consumeDelIds = checkedCheckboxes
      .map(function () {
        return $(this).closest('tr').find('[data-consume-del-id]').data('consume-del-id');
      })
      .get();

    if (consumeDelIds.length === 0) {
      Swal.fire({
        title: 'No Items Selected',
        text: 'Please select at least one item to delete.',
        icon: 'info',
        confirmButtonText: 'OK',
        customClass: {
          popup: 'bg-light rounded-3 shadow fs-4',
          title: 'fs-1',
          htmlContainer: 'text-muted text-center fs-4',
          confirmButton: 'btn btn-sm btn-info',
        },
      });
      return;
    }

    Swal.fire({
      title: 'Delete Records?',
      text: 'Are you sure you want to delete all the selected items?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'fs-1',
        htmlContainer: 'text-muted text-center fs-4',
        confirmButton: 'btn btn-sm btn-danger',
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/properties-assets/consumable',
          method: 'DELETE',
          data: { id: consumeDelIds },
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
  // ============ End Delete a Item Consumable ============ //

  // ============ Restock an Item Consumable ============ //
  const consumableRestockModal = $("#restockConsumableModal");
  const consumableRestockForm = $("#frmRestockConsumable");
  const consumableRestockSaveBtn = $("#btnRestockSaveConsumable");
  let pastQuantity = 0;

  handleUnsavedChanges(consumableRestockModal, consumableRestockForm, consumableRestockSaveBtn);

  consumableDatatable.on('click', '.btnRestockConsumable', function () {
    const childId = $(this).data('restock-id');
    const consumableName = $(this).data('consumable-name');
    pastQuantity = $(this).data('past-quantity');

    $("#txtRestockConsumableId").val(childId);
    $("#txtRestockPastQuantity").val(pastQuantity);
    $("#txtRestockConsumableName").text(consumableName);

    consumableRestockModal.modal("show");
  });

  consumableRestockForm.on("submit", function (e) {
    e.preventDefault();
    toggleButtonState(consumableRestockSaveBtn, true);

    const restockQuantity = parseInt($("#txtRestockConsumableQuantity").val(), 10);
    const totalQuantity = pastQuantity + restockQuantity;

    const editFormData = new FormData(this);
    editFormData.append("_method", "PATCH");
    editFormData.append("totalQuantity", totalQuantity);

    $.ajax({
      url: "/properties-assets/consumable/restock",
      method: "POST",
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', consumableRestockModal, consumableRestockForm);
        } else {
          toggleButtonState(consumableRestockSaveBtn, false);
          if (response.errors.restockQuantity) {
            $('#txtRestockConsumableQuantity').addClass('is-invalid');
            $('#valRestockConsumableQty').text(response.errors.restockQuantity[0]);
          }
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', consumableRestockModal, consumableRestockForm);
      }
    });
  });

  // ============ End Restock an Item Consumable ============ //
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
